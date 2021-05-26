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

function checkvalue()
{
      var totalrow=parseInt(document.frmEmployeeEntry.txtTotalrow.value);

      for(i=0;i<totalrow;i++)
      {
            if(document.frmEmployeeEntry.elements["cboloan["+i+"]"].value!='-1')
            {
                  if(document.frmEmployeeEntry.elements["txtloanamount["+i+"]"].value=='')
                  {
                        alert("Loan amount can't be blank");
                        document.frmEmployeeEntry.elements["txtloanamount["+i+"]"].focus();
                        return false;
                        continue;
                  }
                  else if(document.frmEmployeeEntry.elements["txtinstallment["+i+"]"].value=='')
                  {
                        alert("Installment can't be blank");
                        document.frmEmployeeEntry.elements["txtinstallment["+i+"]"].focus();
                        return false;
                        continue;
                  }
                  else if(document.frmEmployeeEntry.elements["txtissueDay["+i+"]"].value=='')
                  {
                        alert("Issue day can't be blank");
                        document.frmEmployeeEntry.elements["txtissueDay["+i+"]"].focus();
                        return false;
                        continue;
                  }
                  else if(document.frmEmployeeEntry.elements["txtissueMonth["+i+"]"].value=='')
                  {
                        alert("Issue Month can't be blank");
                        document.frmEmployeeEntry.elements["txtissueMonth["+i+"]"].focus();
                        return false;
                        continue;
                  }
                  else if(document.frmEmployeeEntry.elements["txtissueYear["+i+"]"].value=='')
                  {
                        alert("Issue Year can't be blank");
                        document.frmEmployeeEntry.elements["txtissueYear["+i+"]"].focus();
                        return false;
                        continue;
                  }

                  else if(document.frmEmployeeEntry.elements["txtstartDay["+i+"]"].value=='')
                  {
                        alert("Effct day can't be blank");
                        document.frmEmployeeEntry.elements["txtstartDay["+i+"]"].focus();
                        return false;
                        continue;
                  }
                  else if(document.frmEmployeeEntry.elements["txtstartMonth["+i+"]"].value=='')
                  {
                        alert("Effect Month can't be blank");
                        document.frmEmployeeEntry.elements["txtstartMonth["+i+"]"].focus();
                        return false;
                        continue;
                  }
                  else if(document.frmEmployeeEntry.elements["txtstartYear["+i+"]"].value=='')
                  {
                        alert("Effect Year can't be blank");
                        document.frmEmployeeEntry.elements["txtstartYear["+i+"]"].focus();
                        return false;
                        continue;
                  }
            }
      }
      return true;
}

function Submitfrom()
{

            document.frmEmployeeEntry.submit();


}



</script>

</head>

<body class='body_e'>




<form name='frmEmployeeEntry' method='post' action='emploandetails.php' target='EmpLoanIssueBottom1'>


<?PHP
      //echo "<input type='hidden' name='mkdecession' value=''>";
      echo "<input type='hidden' name='employee' value='$cboEmployee'>";
      if($cboDepartment!='' && $cboDepartment!='-1')
      {
      $employeequery="  SELECT
                              trn_employees.emp_id,
                              mas_employees.employee_name,
                              mas_designation.description,
                              date_format(mas_employees.date_of_join_hr,'%d-%m-%Y') as joindate,
                              mas_emp_loan.loan_id,
                              mas_emp_loan.loan_amount,
                              mas_emp_loan.loan_issue_date,
                              mas_emp_loan.loan_start_date,
                              mas_emp_loan.number_of_installment
                        FROM
                              trn_employees
                              LEFT JOIN mas_employees ON mas_employees.employeeobjectid = trn_employees.emp_id and trn_employees.jobstatus='1'
                              left join mas_designation on mas_employees.designationid=mas_designation.designationid
                              left join mas_emp_loan on mas_emp_loan.emp_id=trn_employees.emp_id

                        where
                              trn_employees.department_id='$cboDepartment'
                              and mas_employees.employeeobjectid='$cboEmployee'


                        ";
      }

      //echo $employeequery;
      $rsemployee=mysql_query($employeequery) or die(mysql_error());
      $numrows=mysql_num_rows($rsemployee);
      if($numrows>0)
      {

            $i=0;
            echo "
                   <table border='0' width='100%'  cellspacing='0' cellpadding='0'>

                              <TR>

                                    <Td class='title_cell_e'>Employee Name</Td>
                                    <Td class='title_cell_e'>Designation</Td>
                                    <Td class='title_cell_e'>Loan Name</td>
                                    <Td class='title_cell_e'>Loan Amount</td>
                                    <Td class='title_cell_e'>Installment amount</td>
                                    <Td class='title_cell_e'>Issue Date</td>
                                    <Td class='title_cell_e'>Effctive Date</td>
                              </TR>

                  ";
            while($rows=mysql_fetch_array($rsemployee))
            {
                  extract($rows);
                  if($i%2==0)
                        $cls='even_td_e';
                  else
                        $cls='odd_td_e';
                  $issue_date=explode("-",$loan_issue_date);
                  $start_date=explode("-",$loan_start_date);

                   echo"
                              <TR  id=set1_row1  style=\"cursor: hand;\">
                                    <input type='hidden' value='$emp_id' name='txtEmployeeid'>




                                    <TD class='$cls' >$employee_name</TD>
                                    <TD class='$cls' >$description</TD>


                                    <TD class='$cls'  align='right'>
                                          <select name='cboloan' class='select_e'>";
                                                createCombo("Loan","mas_loan","loan_id","loan_description","","$loan_id");
                                    echo" </select>
                                    </td>



                                    <TD class='$cls'  align='center'>
                                          <input type='text' name='txtloanamount' value='$loan_amount' class='input_e' size='8'>
                                    </td>
                                    <TD class='$cls'  align='center'>
                                          <input type='text' name='txtinstallment' value='$number_of_installment' class='input_e' size='8'>
                                    </td>
                                    
                                    <TD class='$cls'  align='center'>";


                                     echo"
                                          d<input type='text' name='txtissueMonth' value='$issue_date[2]' size='2' maxlength='2' class='input_e'>
                                          m<input type='text' name='txtissueMonth' value='$issue_date[1]' size='2' maxlength='2' class='input_e'>
                                          y<input type='text' name='txtissueYear' value='$issue_date[0]' size='4' maxlength='4' class='input_e'>
                                    ";

                                    echo"</td>
                                    <TD class='$cls'  align='center'>";


                                     echo"
                                          d<input type='text' name='txtstartDay' value='$start_date[2]' size='2' maxlength='2' class='input_e'>
                                          m<input type='text' name='txtstartMonth' value='$start_date[1]' size='2' maxlength='2' class='input_e'>
                                          y<input type='text' name='txtstartYear' value='$start_date[0]' size='4' maxlength='4' class='input_e'>
                                    ";
                                    echo"</td>
                                    </TR>
                        ";
                        $i++;
                  
                  



            }
            echo  "
                  <td  colspan='15' align='center' class='button_cell_e'>
                   <input type='button' value='Submit' class='forms_Button_e' onclick='Submitfrom()'>
                </td>
                  </TABLE>";

      }
?>




</form>



</body>

</html>
