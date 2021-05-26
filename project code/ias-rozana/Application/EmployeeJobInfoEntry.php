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

function exiqutequery()
{
        document.frmEmployeeEntry.action="EmployeeJobInfoEntry.php";
            document.frmEmployeeEntry.submit();
        //window.location="EmployeeJobInfoEntry.php";
        //document.frmEmployeeEntry.submit();
}
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




<form name='frmEmployeeEntry' method='post' action='AddToEmpJobInfoEntry.php'>
<table width='100%' id='table1' cellspacing='0' cellpadding='0' align='center'>
                  <tr>
                        <td class='top_left_curb'></td>
                        <td colspan='3' class='header_cell_e' align='center'>Department</td>
                        <td class='top_right_curb'></td>
                  </tr>
                  <tr>
                        <td class='lb'></td>

                        <td class='caption_e'>Department</td>
                        <td class='td_e'>
                              <select name='cbomainDepartment' class='select_e' >
                              <?PHP
                                    $query="select
                                                cost_code,
                                                description
                                            from
                                                mas_cost_center

                                            order by
                                                description
                                           ";
                                    createQueryCombo("Department",$query,"-1","$cbomainDepartment");
                              ?>
                              </select>
                        </td>
                        <td   align='center' class='button_cell_e'>
                                <input type='button' value='Show' class='forms_Button_e' onclick='exiqutequery()'>
                        </td>
                        <td class='rb'></td>

                  </tr>
                  <tr>
                        <td class='bottom_l_curb'></td>
                        <td class='bottom_f_cell' colspan='3'></td>
                        <td class='bottom_r_curb'></td>
                  </tr>
            </table>


<?PHP

      echo "<input type='hidden' name='mkdecession' value=''>";
      if(isset($cbomainDepartment))
      {
      $employeequery="
                        select
                              mas_employees.employeeobjectid,
                              mas_employees.employeeno,
                              mas_employees.employee_name,
                              mas_employees.fathers_name,
                              DATE_FORMAT(mas_employees.date_of_birth, '%d-%m-%Y') As birthdate,
                              DATE_FORMAT(mas_employees.date_of_join_hr, '%d-%m-%Y') As joindate,
                              mas_employees.department_id,
                              trn_employees.manager_id,
                              trn_employees.sal_grad_id,
                              mas_designation.description,
                              mas_designation.designationid
                              
                        from
                              mas_employees
                              left join trn_employees on trn_employees.emp_id=mas_employees.employeeobjectid
                              left join mas_designation on mas_employees.designationid=mas_designation.designationid
                        where
                              mas_employees.department_id in ('-1','$cbomainDepartment','2','1')

                  ";
      //echo $employeequery;
      $rsemployee=mysql_query($employeequery) or die(mysql_error());
      $numrows=mysql_num_rows($rsemployee);
      if($numrows>0)
      {

            $i=0;
            echo "
                   <table border='0' width='98%' align='center' cellspacing='0' cellpadding='0'>

                              <TR>
                                    <td class='title_cell_e'>&nbsp;</td>
                                    <td class='title_cell_e'>Sl.No</td>

                                    <Td class='title_cell_e'>Employee Name</Td>
                                    <Td class='title_cell_e'>Designation</Td>
                                    <Td class='title_cell_e'>Join Date</Td>
                                    <td class='title_cell_e'>Department</td>

                                    <Td class='title_cell_e'>Salary Grad</Td>
                                    <Td class='title_cell_e'>Status</Td>
                              </TR>

                  ";
            while($rows=mysql_fetch_array($rsemployee))
            {
                  extract($rows);
                  $department=pick("mas_cost_center","description","cost_code='$department_id'");
                  if($i%2==0)
                        $cls='even_td_e';
                  else
                        $cls='odd_td_e';

                   echo"
                              <TR  id=set1_row1  >
                                    <input type='hidden' value='$employeeobjectid' name='txtEmployeeid[$i]'>
                                    <TD class='$cls' >";
                                    if($cbomainDepartment==$department_id)
                                    {
                                        echo "<input type='checkbox' name='C1[$i]' checked> ";
                                     }
                                     else
                                     {
                                        echo "<input type='checkbox' name='C1[$i]' >";
                                     }
                                echo "</TD>
                                    <td class='$cls'>".($i+1)."</td>
                                    <TD class='$cls' >$employee_name</TD>

                                    <TD class='$cls' >$description</TD>
                                    <TD class='$cls'  align='center'>$joindate</TD>
                                    <TD class='$cls' >$department</TD>

                                    </TD>

                                    <TD class='$cls'  align='center'>
                                          <select name='cboSalGrad[$i]' class='select_e'>";
                                                createCombo("Grad","mas_sal_info","sal_grad_id","grad_name","","$sal_grad_id");
                   echo"                  </select>
                                    </TD>
                                    <TD class='$cls'  align='center'>
                                    <select name='cboStatus[$i]' class='select_e'>";
                                          if($status=='1')
                                          {
                                                echo "<option value='1' selected>Active</option>
                                                      <option value='0'>Inactive</option>";
                                          }
                                          else if($status=='0')
                                          {
                                                echo "
                                                      <option value='1'>Active</option>
                                                      <option value='0' selected>Inactive</option>
                                                      ";
                                          }
                                          else
                                          {
                                                echo "<option value='1'>Active</option>
                                                      <option value='0'>Inactive</option>";
                                          }



                  echo "      </select>
                              </TD>

                        </TR>
                        ";
                        $i++;
                  
                  



            }
            echo  " <input type='hidden' value='$i' name='txtTotalrow'>
                  <td  colspan='8' align='center' class='button_cell_e'>
                   <input type='button' value='Submit' class='forms_Button_e' onclick='Submitfrom()'>
                </td>
                  </TABLE>";

      }
      }
?>




</form>



</body>

</html>
