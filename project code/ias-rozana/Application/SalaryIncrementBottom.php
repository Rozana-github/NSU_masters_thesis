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




<form name='frmEmployeeEntry' method='post' action='AddToSalaryIncrement.php'>


<?PHP
      echo "<input type='hidden' name='mkdecession' value=''>";
      if($cboDepartment!='' && $cboDepartment!='-1')
      {
      $employeequery="  SELECT
                              trn_employees.emp_id,
                              mas_employees.employee_name,
                              trn_employees.sal_grad_id,
                              ifnull(basic_salary,0) basic_salary ,
                              ifnull(house_allowance,0) house_allowance,
                              ifnull(medical_allowance,0) medical_allowance,
                              ifnull(convance,0) convance,
                              ifnull(utility_allowance,0) utility_allowance,
                              ifnull(special_allowance,0) special_allowance,
                              ifnull(maintenance_allowance,0) maintenance_allowance,
                              ifnull(inflation_allowance,0) inflation_allowance,
                              ifnull(transport,0) transport,
                              ifnull(others_allowance,0) amount,
                              mas_designation.description,
                              date_format(mas_employees.date_of_join_hr,'%d-%m-%Y') as joindate
                        FROM
                              trn_employees
                              inner join mas_emp_sal_info ON mas_emp_sal_info.employee_id = trn_employees.emp_id and trn_employees.jobstatus='1'
                              LEFT JOIN mas_employees ON mas_employees.employeeobjectid = trn_employees.emp_id
                              left join mas_designation on mas_employees.designationid=mas_designation.designationid

                        where
                              trn_employees.department_id='$cboDepartment'


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
                              ifnull(utility_allowance,0) utility_allowance,
                              ifnull(special_allowance,0) special_allowance,
                              ifnull(maintenance_allowance,0) maintenance_allowance,
                              ifnull(inflation_allowance,0) inflation_allowance,
                              ifnull(transport,0) transport,
                              ifnull(others_allowance,0) amount,
                              mas_designation.description,
                              date_format(mas_employees.date_of_join_hr,'%d-%m-%Y') as joindate
                        FROM
                              trn_employees
                              inner join mas_emp_sal_info ON mas_emp_sal_info.employee_id = trn_employees.emp_id and trn_employees.jobstatus='1'
                              LEFT JOIN mas_employees ON mas_employees.employeeobjectid = trn_employees.emp_id
                              left join mas_designation on mas_employees.designationid=mas_designation.designationid
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
                                    <Td class='title_cell_e'>Sl.No</Td>
                                    <Td class='title_cell_e'>Employee Name</Td>
                                    <Td class='title_cell_e'>Designation</Td>
                                    <Td class='title_cell_e'>Join Date</Td>
                                    <Td class='title_cell_e'>Basic</TD>

                                    <Td class='title_cell_e'>Increment Amount</td>
                                    <Td class='title_cell_e'>Increment Date</td>
                              </TR>

                  ";
            while($rows=mysql_fetch_array($rsemployee))
            {
                  extract($rows);
                  if($i%2==0)
                        $cls='even_td_e';
                  else
                        $cls='odd_td_e';

                   echo"
                              <TR  id=set1_row1  >
                                    <input type='hidden' value='$emp_id' name='txtEmployeeid[$i]'>

                                    <input type='hidden' value='$basic_salary' name='txtbasic[$i]'>
                                    <input type='hidden' value='$house_allowance' name='txthouse[$i]'>
                                    <input type='hidden' value='$medical_allowance' name='txtmedical[$i]'>
                                    <input type='hidden' value='$convance' name='txtconvance[$i]'>
                                    <input type='hidden' value='$utility_allowance' name='txtutility[$i]'>
                                    <input type='hidden' value='$special_allowance' name='txtspecial[$i]'>
                                    <input type='hidden' value='$maintenance_allowance' name='txtmaintenance[$i]'>
                                    <input type='hidden' value='$inflation_allowance' name='txtiflation[$i]'>
                                    <input type='hidden' value='$amount' name='txtothers[$i]'>
                                    <input type='hidden' value='$transport' name='txttransport[$i]'>

                                    <TD class='$cls' >".($i+1)."</TD>
                                    <TD class='$cls' >$employee_name</TD>
                                    <TD class='$cls' >$description</TD>
                                    <TD class='$cls'  align='center'>$joindate</TD>

                                    <TD class='$cls'  align='right'>$basic_salary</td>



                                    <TD class='$cls'  align='center'>
                                          <input type='text' name='txtIncrement[$i]' value='' class='input_e' size='8'>
                                    </td>
                                    <TD class='$cls'  align='center'>";


                                     echo"
                                          dd<input type='text' name='txtDay[$i]' value='' size='2' maxlength='2' class='input_e'>
                                          mm<input type='text' name='txtMonth[$i]' value='' size='2' maxlength='2' class='input_e'>
                                          yyyy<input type='text' name='txtYear[$i]' value='' size='4' maxlength='4' class='input_e'>
                                    ";
                                    
                                    

                                    echo"</td>





                        </TR>
                        ";
                        $i++;
                  
                  



            }
            echo  " <input type='hidden' value='$i' name='txtTotalrow'>
                  <td  colspan='15' align='center' class='button_cell_e'>
                   <input type='button' value='Submit' class='forms_Button_e' onclick='Submitfrom()'>
                </td>
                  </TABLE>";

      }
?>




</form>



</body>

</html>
