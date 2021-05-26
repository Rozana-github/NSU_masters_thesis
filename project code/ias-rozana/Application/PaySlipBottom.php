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
<link rel='stylesheet' type='text/css' href='Style/interface_styles.css' />
<style>
.pagebrack
{
       page-break-after: always;
}
</style>

<script language="JavaScript" src="Script/NumberFormat.js"></script>

<script language="JavaScript" src="Script/calendar1.js"></script>

<script language='JavaScript'>


function Submitfrom()
{

            document.frmEmployeeEntry.submit();

}
function CreateNewParty()
{
        var popit=window.open('EmployeeInfoEntry.php','console','status,scrollbars,width=700,height=300');
}

function EditPartyEntry(val)
{
        var popit=window.open("EmpInfoUpdate.php?EmployeeID="+val+"",'console','status,scrollbars,width=700,height=300');
}


</script>

</head>

<body class='body_e'>




<form name='frmEmployeeEntry' method='post' action='AddToMonthlySalary.php'>


<?PHP
      echo "<input type='hidden' name='mkdecession' value=''>";
      $employeequery=" select
                              trn_emp_sal.emp_id,
                              mas_employees.designationid
                        from
                              trn_emp_sal
                              inner join mas_employees on mas_employees.employeeobjectid=trn_emp_sal.emp_id
                              inner join trn_employees on trn_employees.emp_id=trn_emp_sal.emp_id and trn_employees.jobstatus='1'
                        where
                              trn_emp_sal.sal_month='$cboMonth'
                              and trn_emp_sal.sal_year='$cboYear'
                              and trn_employees.department_id='$cboDepartment'
                  ";
      //echo $employeequery;
      $rsemployee=mysql_query($employeequery) or die(mysql_error());
      $numrows=mysql_num_rows($rsemployee);
      if($numrows>0)
      {

            $i=0;
            echo "
                   <table border='1' width='100%'  cellspacing='0' cellpadding='0'>



                  ";
            while($rows=mysql_fetch_array($rsemployee))
            {
                  extract($rows);
                  $totaladdition=$basic_salary+$house_allowance+$medical_allowance+$convance+$utility_allowance+$special_allowance+$maintenance_allowance+$inflation_allowance+$amount;
                  $totaldeduction=$transport;
                  $netpay=$totaladdition-$totaldeduction;
                  if($i%2==0)
                        $cls='even_td_e';
                  else
                        $cls='odd_td_e';

                   $empname=pick("mas_employees","employee_name","employeeobjectid='$emp_id'");
                   $designationname=pick("mas_designation","description","designationid='$designationid'");

                   echo"
                              <TR>
                                    <Td class='title_cell_e_l' >Office Copy</Td>

                                    <Td class='title_cell_e'>Person Copy</Td>
                              </tr>
                              <tr>
                                    <Td class='title_cell_e_l'>";
                                    drawheader("Pay slip for the month of ".date("F, Y", mktime(0, 0, 0, $cboMonth,1,$cboYear)),"Name:$empname<br>Designation:$designationname");

                              echo"</TD>

                                    <Td class='title_cell_e'>";
                                    drawheader("Pay slip for the month of ".date("F, Y", mktime(0, 0, 0, $cboMonth,1,$cboYear)),"Name:$empname<br>Designation:$designationname");
                              echo"</td>

                              </TR>
                              <TR  >

                                    <TD class='$cls'  align='center'>";
                                          createpaysleap($emp_id,$cboMonth,$cboYear);
                              echo"</td>

                                    <TD class='$cls'  align='center'>";
                                          createpaysleap($emp_id,$cboMonth,$cboYear);
                              echo "</td>

                        </TR>
                        ";




                        $i++;
                  
                  



            }
            echo  "
                  </TABLE>";

      }
?>

<?PHP
function createpaysleap($emp_id,$cboMonth,$cboYear)
{
      $query="select
                  basic_salary,
                  house_rent,
                  medical_allowance,
                  convance,
                  food_allowance,
                  utility_allowance,
                  special_allowance,
                  maintenance_allowance,
                  inflation_allowance,
                  other_allowance,
                  provident_fund,
                  income_tax,
                  wellfare_fund,
                  transport,
                  loan,
                  interest,
                  without_pay,
                  wellfare_fund,
                  net_pay,
                  remarks
            from
                  trn_emp_sal
            where
                  emp_id='$emp_id'
                  and sal_month='$cboMonth'
                  and sal_year='$cboYear'
            ";
      $rs=mysql_query($query)or die(mysql_error());
      if(mysql_num_rows($rs)>0)
      {
            echo"<table border='1' width='100%'  cellspacing='0' cellpadding='0'>
                  <tr>
                              <td class='title_cell_e_l'>Salary</td>
                              <td class='title_cell_e'>Tk</td>
                              <td class='title_cell_e'>Deductions</td>
                              <td class='title_cell_e'>Tk</td>
                        </tr>";
            $i=0;
            while($row=mysql_fetch_array($rs))
            {
                  extract($row);
                  if(($i%2)==0)
                              {
                                    $class="even_td_e";
                                    $lclass="even_left_td_e";
                              }
                              else
                              {
                                    $class="odd_td_e";
                                    $lclass="odd_left_td_e";
                              }
                  $totaladdition=$basic_salary+$house_rent+$medical_allowance+$convance+$food_allowance+$inflation_allowance+$special_allowance+$utility_allowance+$maintenance_allowance;
                  $totaldeduction=$provident_fund+$other_allowance+$transport+$loan+$interest+$without_pay+$income_tax+$wellfare_fund;
                  $netpay=$totaladdition-$totaldeduction;
                  echo "<tr>
                              <td class='odd_left_td_e'>Basic Salary</td><td class='odd_td_e' align='right'>".number_format($basic_salary,2,'.','')."</td><td class='odd_td_e'>Provident fund</td><td class='odd_td_e' align='right'>".number_format($provident_fund,2,'.','')."</td>
                        </tr>
                        <tr>
                              <td class='even_left_td_e'>House Rent</td><td class='even_td_e' align='right'>".number_format($house_rent,2,'.','')."</td><td class='even_td_e'>Others</td><td class='even_td_e' align='right'>".number_format($other_allowance,2,'.','')."</td>
                        </tr>
                        <tr>
                              <td class='odd_left_td_e'>Medical</td><td class='odd_td_e' align='right'>".number_format($medical_allowance,2,'.','')."</td><td class='odd_td_e'>Transport</td><td class='odd_td_e' align='right'>".number_format($transport,2,'.','')."</td>
                        </tr>
                        <tr>
                              <td class='even_left_td_e'>Conveyance</td><td class='even_td_e' align='right'>".number_format($convance,2,'.','')."</td><td class='even_td_e'>Loan</td><td class='even_td_e' align='right'>".number_format($loan,2,'.','')."</td>
                        </tr>
                        <tr>
                              <td class='odd_left_td_e'>Inflation</td><td class='odd_td_e' align='right'>".number_format($inflation_allowance,2,'.','')."</td><td class='odd_td_e'>Interest</td><td class='odd_td_e' align='right'>".number_format($interest,2,'.','')."</td>
                        </tr>
                        <tr>
                              <td class='even_left_td_e'>Special Allowance</td><td class='even_td_e' align='right'>".number_format($special_allowance,2,'.','')."</td><td class='even_td_e'>Without pay (7 Days)</td><td class='even_td_e' align='right'>".number_format($without_pay,2,'.','')."</td>
                        </tr>
                        <tr>
                              <td class='odd_left_td_e'>Utility Allowance</td><td class='odd_td_e' align='right'>".number_format($utility_allowance,2,'.','')."</td><td class='odd_td_e'>Income Tax</td><td class='odd_td_e' align='right'>".number_format($income_tax,2,'.','')."</td>
                        </tr>
                        <tr>
                              <td class='even_left_td_e'>Food Allowance</td><td class='even_td_e' align='right'>".number_format($food_allowance,2,'.','')."</td><td class='even_td_e'>Welfare</td><td class='even_td_e' align='right'>".number_format($wellfare_fund,2,'.','')."</td>
                        </tr>
                        <tr>
                              <td class='odd_left_td_e'>Total</td><td class='odd_td_e' align='right'>".number_format($totaladdition,2,'.','')."</td><td class='odd_td_e'>Total</td><td class='odd_td_e' align='right'>".number_format($totaldeduction,2,'.','')."</td>
                        </tr>
                        <tr>
                              <td class='td_e_b_l'>&nbsp;</td><td class='td_e_b'>Net Pay</td><td class='td_e_b' align='right'>".number_format($net_pay,2,'.','')."</td><td class='td_e_b'>&nbsp;</td>
                        </tr>

                        <tr>
                              <td class='td_e_b_l' colspan='4'>Issued By</td>
                        </tr>

                        ";
                  if($remarks!='')
                  {
                        echo"<tr>
                              <td class='td_e_b_l' colspan='4'>$remarks</td>
                        </tr>";
                  }
            }
            echo"</table>
            <br>
            <br>
            <table border='1' width='100%'  cellspacing='0' cellpadding='0'>

                  <tr>
                              <td class='td_e_b'>Issued By</td>

                              <td class='td_e_b'>Employee</td>

                        </tr>
            </table>";
      }
}
function drawheader($ReportName,$ReporDetail=null)
      {
            echo "<table align='center' border='0' cellspacing='0' cennpadding='0'>";
            echo "      <tr><td align='center'><font size='4px'><b>BRAC Printing Pack</b><font></td></tr>";
            echo "      <tr><td align='center'><font size='3px'><b>$ReportName</b><font></td></tr>";
            echo "      <tr><td align='left'><font size='2px'>&nbsp;<font></td></tr>";
            echo "      <tr><td align='left'><font size='2px'>$ReporDetail<font></td></tr>";
            echo "</table>";
            echo "<br>";
      }



?>




</form>



</body>

</html>
