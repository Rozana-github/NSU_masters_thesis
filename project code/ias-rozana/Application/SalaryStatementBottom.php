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
      if($cboDepartment!='-1')
      {
      $employeequery=" select
                              trn_emp_sal.emp_id,
                              mas_employees.designationid,
                              date_format(mas_employees.date_of_join_hr,'%d-%m-%Y') as joindate,
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
                              wellfare_fund
                        from
                              trn_emp_sal
                              inner join mas_employees on mas_employees.employeeobjectid=trn_emp_sal.emp_id
                              inner join trn_employees on trn_employees.emp_id=trn_emp_sal.emp_id and trn_employees.jobstatus='1'
                        where
                              trn_emp_sal.sal_month='$cboMonth'
                              and trn_emp_sal.sal_year='$cboYear'
                              and trn_employees.department_id='$cboDepartment'

                  ";
           }
           else
           {
               $employeequery=" select
                              trn_emp_sal.emp_id,
                              mas_employees.designationid,
                              date_format(mas_employees.date_of_join_hr,'%d-%m-%Y') as joindate,
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
                              wellfare_fund
                        from
                              trn_emp_sal
                              inner join mas_employees on mas_employees.employeeobjectid=trn_emp_sal.emp_id
                              inner join trn_employees on trn_employees.emp_id=trn_emp_sal.emp_id and trn_employees.jobstatus='1'
                        where
                              trn_emp_sal.sal_month='$cboMonth'
                              and trn_emp_sal.sal_year='$cboYear'
                        ";
           }
      //echo $employeequery;
      $rsemployee=mysql_query($employeequery) or die(mysql_error());
      $numrows=mysql_num_rows($rsemployee);
      if($numrows>0)
      {

            $i=0;
            if($cboDepartment!='-1')
                  drawCompanyInformation("Staff  Wages Statement  for the month of ".date("F, Y", mktime(0, 0, 0, $cboMonth,1,$cboYear)),"Department: ".pick("mas_cost_center","description","cost_code='$cboDepartment'"));
            else
                  drawCompanyInformation("Staff  Wages Statement  for the month of ".date("F, Y", mktime(0, 0, 0, $cboMonth,1,$cboYear)),"");
            echo "
                   <table border='0' width='100%'  cellspacing='0' cellpadding='0'>

                              <TR>
                                    <Td class='title_cell_e_l' rowspan='2' width='10%'>Employee Name</Td>
                                    <Td class='title_cell_e' rowspan='2' width='10%'>Designa.</Td>
                                    <Td class='title_cell_e' rowspan='2' width='10%'>Join Date</Td>
                                    <Td class='title_cell_e' colspan='10' width='35%'>Gross Salary</Td>
                                    <Td class='title_cell_e' colspan='9' width='30%'>Deductions</Td>
                                    <Td class='title_cell_e' rowspan='2' width='5%'>Net Pay</Td>
                              </tr>
                              <tr>
                                    <Td class='sub_title_cell_e'>Basic</TD>
                                    <Td class='sub_title_cell_e'>House</TD>
                                    <Td class='sub_title_cell_e'>Medic.</TD>
                                    <Td class='sub_title_cell_e'>Conva.</TD>
                                    <Td class='sub_title_cell_e'>Food.</TD>
                                    <Td class='sub_title_cell_e'>Utili.</Td>
                                    <Td class='sub_title_cell_e'>Speci.</Td>
                                    <Td class='sub_title_cell_e'>Maint.</td>
                                    <Td class='sub_title_cell_e'>Infla.</td>
                                    <Td class='sub_title_cell_e'>Total</td>

                                    <Td class='sub_title_cell_e'>P.F.</td>
                                    <Td class='sub_title_cell_e'>Trans.</td>
                                    <Td class='sub_title_cell_e'>Tax</td>
                                    <Td class='sub_title_cell_e'>Other.</td>
                                    <Td class='sub_title_cell_e'>Loan</td>
                                    <Td class='sub_title_cell_e'>Inter.</td>
                                    <Td class='sub_title_cell_e'>Welfare</td>
                                    <Td class='sub_title_cell_e'>Without</td>
                                    <Td class='sub_title_cell_e'>Total</td>

                              </TR>

                  ";
           $nettotal=0;
           $totalbasic=0;
           $totalhouse=0;
           $totalmedical=0;
           $totalconvance=0;
           $totalfood=0;
           $totalinflation=0;
           $totalspecial=0;
           $totalutility=0;
           $totalmaintenance=0;
           $totalprovident_fund=0;
           $totalother_allowance=0;
           $totaltransport=0;
           $totalloan=0;
           $totalinterest=0;
           $totalwithout_pay=0;
           $totalincome_tax=0;
           $totaladdition=0;
           $totaldeduction=0;
           $totalwelfare=0;
           
                  
            while($rows=mysql_fetch_array($rsemployee))
            {
                  extract($rows);
                                 //$basic_salary+$house_allowance+$medical_allowance+$convance+$food_allowance+$utility_allowance+$special_allowance+$maintenance_allowance+$inflation_allowance;
                  $addition=$basic_salary+$house_rent+$medical_allowance+$convance+$food_allowance+$inflation_allowance+$special_allowance+$utility_allowance+$maintenance_allowance;
                  $deduction=$provident_fund+$other_allowance+$transport+$loan+$interest+$without_pay+$income_tax+$wellfare_fund;
                  $netpay=$addition-$deduction;
                  
                  $nettotal=$nettotal+$netpay;
                  $totalbasic=$totalbasic+$basic_salary;
                  $totalhouse=$totalhouse+$house_rent;
                  $totalmedical=$totalmedical+$medical_allowance;
                  $totalconvance=$totalconvance+$convance;
                  $totalfood=$totalfood+$food_allowance;
                  $totalinflation=$totalinflation+$inflation_allowance;
                  $totalspecial=$totalspecial+$special_allowance;
                  $totalutility=$totalutility+$utility_allowance;
                  $totalmaintenance=$totalmaintenance+$maintenance_allowance;
                  $totalprovident_fund=$totalprovident_fund+$provident_fund;
                  $totalother_allowance=$totalother_allowance+$other_allowance;
                  $totaltransport=$totaltransport+$transport;
                  $totalloan=$totalloan+$loan;
                  $totalinterest=$totalinterest+$interest;
                  $totalwithout_pay=$totalwithout_pay+$without_pay;
                  $totalincome_tax=$totalincome_tax+$income_tax;
                  $totaladdition=$totaladdition+$addition;
                  $totaldeduction=$totaldeduction+$deduction;
                  $totalwelfare=$totalwelfare+$wellfare_fund;
                  

                              if(($i%2)==0)
                              {
                                    $cls="even_td_e";
                                    $lcls="even_left_td_e";
                              }
                              else
                              {
                                    $cls="odd_td_e";
                                    $lcls="odd_left_td_e";
                              }

                   $empname=pick("mas_employees","employee_name","employeeobjectid='$emp_id'");
                   $designationname=pick("mas_designation","description","designationid='$designationid'");
                   echo"      <tr>
                                    <TD class='$lcls' >$empname</TD>
                                    <TD class='$cls' >$designationname</TD>
                                    <TD class='$cls' align='center'>$joindate</TD>
                                    <TD class='$cls' align='right'>$basic_salary</td>
                                    <TD class='$cls' align='right'>$house_rent</td>
                                    <TD class='$cls' align='right'>$medical_allowance</td>
                                    <TD class='$cls' align='right'>$convance</td>
                                    <TD class='$cls' align='right'>$food_allowance</td>
                                    <TD class='$cls' align='right'>$utility_allowance</td>
                                    <TD class='$cls' align='right'>$special_allowance</td>
                                    <TD class='$cls' align='right'>$maintenance_allowance</td>
                                    <TD class='$cls' align='right'>$inflation_allowance</td>

                                    <TD class='$cls' align='right'>$addition</td>

                                    <TD class='$cls' align='right'>$provident_fund</td>
                                    <TD class='$cls' align='right'>$transport</td>
                                    <TD class='$cls' align='right'>$income_tax</td>
                                    <TD class='$cls' align='right'>$other_allowance</td>
                                    <TD class='$cls' align='right'>".number_format($loan,2,'.','')."</td>
                                    <TD class='$cls' align='right'>$interest</td>
                                    <TD class='$cls' align='right'>$wellfare_fund</td>
                                    <TD class='$cls' align='right'>$without_pay</td>
                                    <TD class='$cls' align='right'>$deduction</td>


                                    <TD class='$cls' align='right'>$netpay</td>
                              </tr>";


                        $i++;
                  
                  



            }
            echo "<tr>
                                    <td class='td_e_b_l' colspan='3' align='right'><b>Total</b></td>
                                    <td class='td_e_b' align='right'>".number_format($totalbasic,2,'.',',')."</td>
                                    <td class='td_e_b' align='right'>".number_format($totalhouse,2,'.',',')."</td>
                                    <td class='td_e_b' align='right' >".number_format($totalmedical,2,'.',',')."</td>
                                    <td class='td_e_b' align='right'>".number_format($totalconvance,2,'.',',')."</td>
                                    <td class='td_e_b' align='right'>".number_format($totalfood,2,'.',',')."</td>
                                    <td class='td_e_b' align='right' >".number_format($totalutility,2,'.',',')."</td>
                                    <td class='td_e_b' align='right'>".number_format($totalspecial,2,'.',',')."</td>
                                     <td class='td_e_b' align='right'>".number_format($totalmaintenance,2,'.',',')."</td>
                                    <td class='td_e_b' align='right'>".number_format($totalinflation,2,'.',',')."</td>

                                    <td class='td_e_b' align='right' >".number_format($totaladdition,2,'.',',')."</td>

                                    <td class='td_e_b' align='right'>".number_format($totalprovident_fund,2,'.',',')."</td>
                                    <td class='td_e_b' align='right' >".number_format($totaltransport,2,'.',',')."</td>
                                    <td class='td_e_b' align='right'>".number_format($totalincome_tax,2,'.',',')."</td>
                                    <td class='td_e_b' align='right'>".number_format($totalother_allowance,2,'.',',')."</td>
                                    <td class='td_e_b' align='right' >".number_format($totalloan,2,'.',',')."</td>
                                    <td class='td_e_b' align='right'>".number_format($totalinterest,2,'.',',')."</td>
                                    <td class='td_e_b' align='right'>".number_format($totalwelfare,2,'.',',')."</td>
                                    <td class='td_e_b' align='right'>".number_format($totalwithout_pay,2,'.',',')."</td>
                                    
                                    <td class='td_e_b' align='right' >".number_format($totaldeduction,2,'.',',')."</td>
                                    
                                    <td class='td_e_b' align='right' >".number_format($nettotal,2,'.',',')."</td>
                              </tr>";
            echo  "
                  </TABLE>";

      }
?>





</form>



</body>

</html>
