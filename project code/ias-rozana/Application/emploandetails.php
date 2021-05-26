<?PHP
session_start();

        include_once("Library/dbconnect.php");
        include_once("Library/Library.php");

?>
<html xmlns:ycode>

<style>
        yCode\:combobox {behavior: url(combobox.htc); }
</style>

<head>
<link rel='stylesheet' type='text/css' href='Style/eng_form.css'>
<link rel='stylesheet' type='text/css' href='Style/generic_form.css'>
<link rel='stylesheet' type='text/css' href='Style/interface_styles.css' />

</head>
<body class='body_e'>
<form name='frmEmployeeEntry' method='post' action='AddToEmpLoanIssue.php' target='EmpLoanIssueBottom1'>
<?PHP
$issudate=$txtissueYear."-".$txtissueMonth."-".$txtissueMonth;
$effectdate=$txtstartYear."-".$txtstartMonth."-".$txtstartDay;
echo "<input type='hidden' name='loanamount' value='$txtloanamount'>";
echo "<input type='hidden' name='txtinstallment' value='$txtinstallment'>";
echo "<input type='hidden' name='txtissudate' value='$issudate'>";
echo "<input type='hidden' name='txteffectdate' value='$effectdate'>";
echo "<input type='hidden' value='$txtEmployeeid' name='txtEmployeeid'>";
echo "<input type='hidden' value='$cboloan' name='cboloan'>";
//echo "<input type='hidden' value='$txtinstallment' name='txtinstallment'>";

$startmonth=$txtstartMonth;
$startyear=$txtstartYear;
$cboloan                 ;

$queryrate="select
                inerest_rate/100 as inerest_rate
        from
                mas_loan
        where
                loan_id='$cboloan'
        ";
$rsrate=mysql_query($queryrate)or die(mysql_error());
while($rowrate=mysql_fetch_array($rsrate))
{
        extract($rowrate);
}
$noofinstallment=round($txtloanamount/$txtinstallment)+1;



echo "<table border='0' width='100%'  cellspacing='0' cellpadding='0'>
        <tr>
                        <td class='title_cell_e'>No.</td>
                        <td class='title_cell_e'>Month</td>
                        <td class='title_cell_e'>Installment</td>
                        <td class='title_cell_e'>Interest</td>
                        <td class='title_cell_e'>Principal</td>
                        <td class='title_cell_e'>Balance</td>
                        <td class='title_cell_e'>Remarks</td>
                </tr>";
$j=0;
$balance=$txtloanamount;
$principal=0;
$inerest=0;


while($balance>0)
{
        if(($j%2)==0)
                $class="even_td_e";

        else
                $class="odd_td_e";


        if($startmonth>12)
        {
                $startmonth=1;
                $startyear++;
        }
        $query_num_of_days="select last_day(str_to_date('1-$startmonth-$startyear','%d-%m-%Y')) as finalday from dual";
        $rsday=mysql_query($query_num_of_days)or die(mysql_error());
        while($rowday=mysql_fetch_array($rsday))
        {
                extract($rowday);
                $lastday=explode("-",$finalday);
        }

        $inerest= round((($balance* $inerest_rate)/365)*$lastday[2]);
        if($balance-$txtinstallment<0)
        {
                $principal=$balance-$inerest;
                $txtinstallment=$balance;
                $balance=0;
        }
        else
        {
                $principal=$txtinstallment-$inerest;
                $balance=$balance-$principal;
        }




        echo "<tr>
                        <td class='$class'>".($j+1)."</td>
                        <td class='$class'>".date("F, Y", mktime(0, 0, 0, $startmonth,1,$startyear))."</td>
                        <td class='$class' align='right'>$txtinstallment</td>
                        <td class='$class' align='right'>$inerest</td>
                        <td class='$class' align='right'>$principal</td>
                        <td class='$class' align='right'>$balance</td>
                        <td class='$class' align='center'><input type='text' value='' name='txtremarks[$j]' class='input_e'></td>
                        <input type='hidden' name='installmentmonth[$j]' value='$startmonth'>
                        <input type='hidden' name='installmentyear[$j]' value='$startyear'>
                        <input type='hidden' name='intallment[$j]' value='$txtinstallment'>
                        <input type='hidden' name='interest[$j]' value='$inerest'>
                        <input type='hidden' name='principal[$j]' value='$principal'>
                        <input type='hidden' name='Balance[$j]' value='$balance'>
                </tr>
                ";
        $startmonth=$startmonth+1;
        $j++;
        
}

echo "<tr><input type='hidden' name='Totalrow' value='$j'><td class='button_cell_e' align='center' colspan='7'><input type='submit' value='Submit' class='forms_button_e'></td></tr></table>";
?>

</form>

</body>
</html>
