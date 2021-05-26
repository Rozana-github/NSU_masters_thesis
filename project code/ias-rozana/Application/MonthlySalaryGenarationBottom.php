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
      /*$ratequery="Select
                        pf_rate/100 as pf_rate,
                        interest_on_loan/100 as interest_rate,
                        welfare_rate/100  as welfare_rate
                  from
                        tbl_setup
                  ";

      $rsrate=mysql_query($ratequery)or die(mysql_error());
      while($rowrate=mysql_fetch_array($rsrate))
      {
            extract($rowrate);
      }*/
      if($cboDepartment!='-1')
      {
      $employeequery="  SELECT
                              trn_employees.emp_id,
                              mas_employees.employee_name,
                              trn_employees.sal_grad_id,
                              ifnull(basic_salary,0) basic_salary ,
                              ifnull(house_allowance,0) house_allowance,
                              ifnull(medical_allowance,0) medical_allowance,
                              ifnull(convance,0) convance,
                              ifnull(food_allowance,0) as food_allowance,
                              ifnull(utility_allowance,0) utility_allowance,
                              ifnull(special_allowance,0) special_allowance,
                              ifnull(maintenance_allowance,0) maintenance_allowance,
                              ifnull(inflation_allowance,0) inflation_allowance,
                              ifnull(transport,0) transport,
                              ifnull(others_allowance,0) amount,
                              ifnull(income_tax,0) as income,
                              ifnull(welf_fair,0) as welfare,
                              pf_status,
                              mas_designation.description,
                              datediff(LAST_DAY(STR_TO_DATE('1-$cboMonth-$cboYear','%e-%c-%Y')),mas_employees.date_of_join_hr) as workingdays,
                              date_format(mas_employees.date_of_join_hr,'%d-%m-%Y') as joindate,
                              ifnull(trn_emp_loan.principal_amount,0) as monthly_loan_amount,
                              ifnull(trn_emp_loan.interest_amount,0) as interest_amount,
                              trn_emp_loan.loan_id
                              
                        FROM
                              trn_employees
                              inner join mas_emp_sal_info ON mas_emp_sal_info.employee_id = trn_employees.emp_id and trn_employees.jobstatus='1'
                              LEFT JOIN mas_employees ON mas_employees.employeeobjectid = trn_employees.emp_id
                              left join mas_designation on mas_employees.designationid=mas_designation.designationid
                              left join trn_emp_loan on trn_emp_loan.emp_id=trn_employees.emp_id and trn_emp_loan.status='0' and trn_emp_loan.installment_year='$cboYear' and trn_emp_loan.installment_month='$cboMonth'

                        where

                              mas_employees.date_of_join_hr < STR_TO_DATE('1-$cboMonth-$cboYear','%e-%c-%Y')
                              and trn_employees.department_id='$cboDepartment'

                  ";
      }
      else
      {
       $employeequery="  SELECT
                              trn_employees.emp_id,
                              mas_employees.employee_name,
                              trn_employees.sal_grad_id,
                              ifnull(basic_salary,0) basic_salary ,
                              ifnull(house_allowance,0) house_allowance,
                              ifnull(medical_allowance,0) medical_allowance,
                              ifnull(convance,0) convance,
                              ifnull(food_allowance,0) as food_allowance,
                              ifnull(utility_allowance,0) utility_allowance,
                              ifnull(special_allowance,0) special_allowance,
                              ifnull(maintenance_allowance,0) maintenance_allowance,
                              ifnull(inflation_allowance,0) inflation_allowance,
                              ifnull(transport,0) transport,
                              ifnull(others_allowance,0) amount,
                              ifnull(income_tax,0) as income,
                              ifnull(welf_fair,0) as welfare,
                              pf_status,
                              mas_designation.description,
                              datediff(LAST_DAY(STR_TO_DATE('1-$cboMonth-$cboYear','%e-%c-%Y')),mas_employees.date_of_join_hr) as workingdays,
                              date_format(mas_employees.date_of_join_hr,'%d-%m-%Y') as joindate,
                              ifnull(trn_emp_loan.principal_amount,0) as monthly_loan_amount,
                              ifnull(trn_emp_loan.interest_amount,0) as interest_amount,
                              trn_emp_loan.loan_id

                        FROM
                              trn_employees
                              inner join mas_emp_sal_info ON mas_emp_sal_info.employee_id = trn_employees.emp_id and trn_employees.jobstatus='1'
                              LEFT JOIN mas_employees ON mas_employees.employeeobjectid = trn_employees.emp_id
                              left join mas_designation on mas_employees.designationid=mas_designation.designationid
                              left join trn_emp_loan on trn_emp_loan.emp_id=trn_employees.emp_id  and trn_emp_loan.installment_year='$cboYear' and trn_emp_loan.installment_month='$cboMonth'

                        where

                              mas_employees.date_of_join_hr < LAST_DAY(STR_TO_DATE('1-$cboMonth-$cboYear','%e-%c-%Y'))


                  ";
      }
      //echo $employeequery;
      $rsemployee=mysql_query($employeequery) or die(mysql_error());
      $numrows=mysql_num_rows($rsemployee);
      if($numrows>0)
      {

            $i=0;
            echo "
                   <table border='1' width='100%'  cellspacing='0' cellpadding='0'>

                              <TR>
                                    <Td class='title_cell_e' rowspan='2' width='10%'>Sl.No</Td>
                                    <Td class='title_cell_e' rowspan='2' width='10%'>Employee Name</Td>
                                    <Td class='title_cell_e' rowspan='2' width='10%'>Designa.</Td>
                                    <Td class='title_cell_e' rowspan='2' width='10%'>Join Date</Td>
                                    <Td class='title_cell_e' colspan='10' width='35%'>Gross Salary</Td>
                                    <Td class='title_cell_e' colspan='9' width='30%'>Deductions</Td>
                                    <Td class='title_cell_e' rowspan='2' width='5%'>Net Pay</Td>
                              </tr>
                              <tr>
                                    <Td class='title_cell_e'>Basic</TD>
                                    <Td class='title_cell_e'>House</TD>
                                    <Td class='title_cell_e'>Medic.</TD>
                                    <Td class='title_cell_e'>Conva.</TD>
                                    <Td class='title_cell_e'>Food.</TD>
                                    <Td class='title_cell_e'>Utili.</Td>
                                    <Td class='title_cell_e'>Speci.</Td>
                                    <Td class='title_cell_e'>Maint.</td>
                                    <Td class='title_cell_e'>Infla.</td>
                                    <Td class='title_cell_e'>Total</td>

                                    <Td class='title_cell_e'>P.F.</td>
                                    <Td class='title_cell_e'>Trans.</td>
                                    <Td class='title_cell_e'>Tax</td>
                                    <Td class='title_cell_e'>Other.</td>
                                    <Td class='title_cell_e'>Loan</td>
                                    <Td class='title_cell_e'>Inter.</td>
                                    <Td class='title_cell_e'>Welfare</td>
                                    <Td class='title_cell_e'>Without</td>
                                    <Td class='title_cell_e'>Total</td>

                              </TR>

                  ";
            while($rows=mysql_fetch_array($rsemployee))
            {
                  extract($rows);
                  $totaladdition=$basic_salary+$house_allowance+$medical_allowance+$convance+$food_allowance+$utility_allowance+$special_allowance+$maintenance_allowance+$inflation_allowance;

                  if($pf_status==1)
                  {
                        $pf_amount=$basic_salary*0.1;
                  }
                  else
                        $pf_amount=0;
                        
                  //$interest_amount=$monthly_loan_amount*$interest_rate;
                  //$welfare_amount=$basic_salary*$welfare_rate;
                  
                  $totaldeduction=$transport+$amount+$pf_amount+$interest_amount+$monthly_loan_amount+$income+$welfare;
                  
                  $netpay=$totaladdition-$totaldeduction;
                  if($workingdays<30)
                  {
                    $netpay=($netpay/31)*$workingdays;
                    $remarks="Salary has be given for ".$workingdays." days.";
                  }
                  
                  if($i%2==0)
                        $cls='even_td_e';
                  else
                        $cls='odd_td_e';

                   echo"
                              <TR  >

                                    <input type='hidden' value='$emp_id' name='txtEmployeeid[$i]'>
                                    <input type='hidden' value='$sal_grad_id' name='txtsalgrad[$i]'>
                                    <input type='hidden' value='$basic_salary' name='txtbasic[$i]'>
                                    <input type='hidden' value='$house_allowance' name='txthouse[$i]'>
                                    <input type='hidden' value='$medical_allowance' name='txtmedical[$i]'>
                                    <input type='hidden' value='$convance' name='txtconvance[$i]'>
                                    <input type='hidden' value='$food_allowance' name='txtfood[$i]'>
                                    <input type='hidden' value='$utility_allowance' name='txtutility[$i]'>
                                    <input type='hidden' value='$special_allowance' name='txtspecial[$i]'>
                                    <input type='hidden' value='$maintenance_allowance' name='txtmaintenance[$i]'>
                                    <input type='hidden' value='$inflation_allowance' name='txtiflation[$i]'>
                                    <input type='hidden' value='$amount' name='txtothers[$i]'>
                                    <input type='hidden' value='$pf_amount' name='txtprovident[$i]'>
                                    <input type='hidden' value='$income' name='txtincome[$i]'>
                                    <input type='hidden' value='$transport' name='txttransport[$i]'>
                                    <input type='hidden' value='$monthly_loan_amount' name='txtloan[$i]'>
                                    <input type='hidden' value='$interest_amount' name='txtinterest[$i]'>
                                    <input type='hidden' value='0' name='txtwithoutpay[$i]'>
                                    <input type='hidden' value='$welfare' name='txtwelfare[$i]'>
                                    <input type='hidden' value='$remarks' name='txtremarks[$i]'>
                                    <input type='hidden' value='$loan_id' name='txtloanid[$i]'>
                                    <input type='hidden' value='$netpay' name='txtnetpay[$i]'>

                                    <TD class='$cls' >".($i+1)."</TD>
                                    <TD class='$cls' >$employee_name</TD>
                                    <TD class='$cls' >$description</TD>
                                    <TD class='$cls' align='center'>$joindate</TD>
                                    <TD class='$cls' align='right'>$basic_salary</td>
                                    <TD class='$cls' align='right'>$house_allowance</td>
                                    <TD class='$cls' align='right'>$medical_allowance</td>
                                    <TD class='$cls' align='right'>$convance</td>
                                    <TD class='$cls' align='right'>$food_allowance</td>
                                    <TD class='$cls' align='right'>$utility_allowance</td>
                                    <TD class='$cls' align='right'>$special_allowance</td>
                                    <TD class='$cls' align='right'>$maintenance_allowance</td>
                                    <TD class='$cls' align='right'>$inflation_allowance</td>

                                    <TD class='$cls' align='right'>$totaladdition</td>
                                    
                                    <TD class='$cls' align='right'>$pf_amount</td>
                                    <TD class='$cls' align='right'>$transport</td>
                                    <TD class='$cls' align='right'>$income</td>
                                    <TD class='$cls' align='right'>$amount</td>
                                    <TD class='$cls' align='right'>".number_format($monthly_loan_amount,2,'.','')."</td>
                                    <TD class='$cls' align='right'>$interest_amount</td>
                                    <TD class='$cls' align='right'>$welfare</td>
                                    <TD class='$cls' align='right'>0</td>
                                    <TD class='$cls' align='right'>$totaldeduction</td>

                                    
                                    <TD class='$cls' align='right'>$netpay</td>





                        </TR>
                        ";
                        $i++;
                  
                  



            }
            echo  "     <input type='hidden' value='$cboMonth' name='cboMonth'>
                        <input type='hidden' value='$cboYear' name='cboYear'>
                        <input type='hidden' value='$i' name='txtTotalrow'>
                  <td  colspan='24' align='center' class='button_cell_e'>
                   <input type='button' value='Submit' class='forms_Button_e' onclick='Submitfrom()'>
                </td>
                  </TABLE>";

      }
?>




</form>



</body>

</html>
