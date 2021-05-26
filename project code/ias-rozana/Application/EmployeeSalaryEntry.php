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
        document.frmEmployeeEntry.action="EmployeeSalaryEntry.php";
            document.frmEmployeeEntry.submit();

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
function gosetsalary(employeeobjectid,sal_grad_id)
{
      window.location="Setempsalary.php?empid="+employeeobjectid+"&grad="+sal_grad_id+"";
}


</script>

</head>

<body class='body_e'>




<form name='frmEmployeeEntry' method='post' action='AddToEmpJobInfoEntry.php'>
<table width='100%' id='table1' cellspacing='0' cellpadding='0' align='center'>
                  <tr>
                        <td class='top_left_curb'></td>
                        <td colspan='2' class='header_cell_e' align='center'>Department</td>
                        <td class='top_right_curb'></td>
                  </tr>
                  <tr>
                        <td class='lb'></td>

                        <td class='caption_e'>Department</td>
                        <td class='td_e'>
                              <select name='cbomainDepartment' class='select_e' onchange='exiqutequery()'>
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

                  </tr>
                  <tr>
                        <td class='bottom_l_curb'></td>
                        <td class='bottom_f_cell' colspan='2'></td>
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
                              trn_employees.department_id,
                              trn_employees.manager_id,
                              trn_employees.sal_grad_id,
                              mas_designation.description,
                              mas_designation.designationid,
                              mas_cost_center.description as department
                              
                        from
                              mas_employees
                              left join trn_employees on trn_employees.emp_id=mas_employees.employeeobjectid
                              left join mas_designation on mas_employees.designationid=mas_designation.designationid
                              left join mas_cost_center on mas_cost_center.cost_code=trn_employees.department_id
                        where
                              mas_employees.department_id ='$cbomainDepartment'


                  ";
      //echo $employeequery;
      $rsemployee=mysql_query($employeequery) or die(mysql_error());
      $numrows=mysql_num_rows($rsemployee);
      if($numrows>0)
      {

            $i=0;
            echo "
                   <table border='0' width='100%'  cellspacing='0' cellpadding='0'>

                              <TR>
                                    <td class='title_cell_e'>Sl.No</td>
                                    <Td class='title_cell_e'>Employee Name</Td>
                                    <Td class='title_cell_e'>Designation</Td>
                                    <Td class='title_cell_e'>Join Date</Td>
                                    <Td class='title_cell_e'>Department</Td>

                                    <Td class='title_cell_e'>Salary Grad</Td>

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
                              <TR  id=set1_row1  style=\"cursor: hand;\" onclick='gosetsalary(\"$employeeobjectid\",\"$sal_grad_id\")'>
                                    <input type='hidden' value='$employeeobjectid' name='txtEmployeeid[$i]'>
                                    <td class='$cls'>".($i+1)."</td>
                                    <TD class='$cls' style=\"cursor: hand;\">$employee_name</TD>
                                    <TD class='$cls' style=\"cursor: hand;\">$description</TD>
                                    <TD class='$cls' style=\"cursor: hand;\" align='center'>$joindate</TD>
                                    <TD class='$cls' style=\"cursor: hand;\" align='center'>
                                     $department
                                    </TD>
                                    <TD class='$cls' style=\"cursor: hand;\" align='center'>
                                     ".pick("mas_sal_info","grad_name","sal_grad_id='$sal_grad_id'")."
                                    </TD>



                        </TR>
                        ";
                        $i++;
                  
                  



            }


      }
      }
?>




</form>



</body>

</html>
