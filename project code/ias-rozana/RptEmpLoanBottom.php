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
<link rel='stylesheet' type='text/css' href='Style/eng_report.css' />
<link rel='stylesheet' type='text/css' href='Style/generic_form.css'>
<link rel='stylesheet' type='text/css' href='Style/interface_styles.css' />

</head>
<body class='body_e'>
<form name='frmEmployeeEntry' method='post' >
<?PHP
$queryloaninfo="Select
                    mas_loan.loan_id,
                    emp_id,
                    loan_description,
                    loan_amount
               from
                    mas_emp_loan
                    left join mas_loan on mas_loan.loan_id=mas_emp_loan.loan_id
                where
                     emp_id='$cboEmployee'
                     and mas_emp_loan.status='1'
                     ";
$rsloaninfo=mysql_query($queryloaninfo)or die(mysql_error());
while($rowloaninfo=mysql_fetch_array($rsloaninfo))
{
        extract($rowloaninfo);
}

$queryloan="SELECT
                loan_id,
                installment_year ,
                installment_month ,
                installment_amount ,
                interest_amount ,
                principal_amount ,
                balance ,
                remarks ,
                status
           FROM
                trn_emp_loan
           WHERE
                emp_id = '$cboEmployee'
        ";

$rsloan=mysql_query($queryloan)or die(mysql_error());
if(mysql_num_rows($rsloan)>0)
{

        drawCompanyInformation("Loan Payment Details ","Enployee Name:".pick("mas_employees","employee_name","employeeobjectid='$cboEmployee'")."<br>Loan Name: $loan_description <br>Loan Amount:$loan_amount");
        echo "<table border='0' width='98%' align='center'  cellspacing='0' cellpadding='0'>
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

                $totalprincipal=0;
                $totalinerest=0;


                while($rowloan=mysql_fetch_array($rsloan))
                {
                        extract($rowloan);
                        if(($j%2)==0)
                        {
                                $class="even_td_e";
                                $lclass="even_left_td_e";
                        }
                        else
                        {
                                $class="odd_td_e";
                                $lclass="odd_left_td_e";
                        }



                        $totalprincipal=$totalprincipal+$principal_amount;
                        $totalinerest=$totalinerest+$interest_amount;


                        echo "<tr>
                                <td class='$lclass'>".($j+1)."</td>
                                <td class='$class'>".date("F, Y", mktime(0, 0, 0, $installment_month,1,$installment_year))."</td>
                                <td class='$class' align='right'>$installment_amount</td>
                                <td class='$class' align='right'>$interest_amount</td>
                                <td class='$class' align='right'>$principal_amount</td>
                                <td class='$class' align='right'>$balance</td>
                                <td class='$class' align='center'>$remarks&nbsp;</td>

                       </tr>
                        ";

                        $j++;
        
                }

                echo "<tr>
                        <td class='$lclass' align='right' colspan='3'>Total</td>
                        <td class='$class' align='right'>$totalinerest</td>
                        <td class='$class' align='right'>$totalprincipal</td>
                        <td class='$class' align='right'>&nbsp;</td>
                        <td class='$class' align='center'>&nbsp;</td>
                     </tr>
                     </table>";
}
?>

</form>

</body>
</html>
