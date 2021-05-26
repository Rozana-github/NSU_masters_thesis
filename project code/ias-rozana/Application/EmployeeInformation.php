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
      if(document.frmEmployeeEntry.txtempno.value=='' )
      {
            alert("You Must Enter Employee No");
            document.frmEmployeeEntry.txtempno.focus();
      }
      else if(document.frmEmployeeEntry.txtempname.value=='' )
      {
            alert("You Must Enter Employee Name");
            document.frmEmployeeEntry.txtempname.focus();
      }
      else
      {
            document.frmEmployeeEntry.submit();
      }
}
 function ReportPrint()
            {
                  print();
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




<form name='frmEmployeeEntry' method='post' action='AddToEmployeeEntry.php'>



<?PHP
       echo "
      <table width='100%' id='table1' cellspacing='0' cellpadding='0' align='center'>
            <tr>
                  <td align='center' HEIGHT='20'>
                        <div class='hide'>
                              <input type='button' name='btnPrint' value='Print' onclick='ReportPrint()'>
                        </div>
                  </td>
            </tr>
      </table>";
      $employeequery="
                        select
                              mas_employees.employeeobjectid,
                              mas_employees.employeeno,
                              mas_employees.employee_name,
                              mas_employees.fathers_name,
                              DATE_FORMAT(mas_employees.date_of_birth, '%d-%m-%Y') As birthdate,
                              DATE_FORMAT(mas_employees.date_of_join_hr, '%d-%m-%Y') As joindate,
                              mas_designation.description,
                              mas_designation.designationid,
                              trn_employees.department_id,
                              mas_cost_center.description as department,
                              date_format(ifnull(mas_emp_sal_info.increment_date,mas_emp_sal_info.entry_date ),'%d-%m-%Y') as incement_date,
                              mas_emp_sal_info.basic_salary
                              
                              
                              
                        from
                              mas_employees
                              left join mas_designation on mas_employees.designationid=mas_designation.designationid
                              left join trn_employees on trn_employees.emp_id=mas_employees.employeeobjectid and trn_employees.jobstatus='1'
                              left join mas_cost_center on mas_cost_center.cost_code=trn_employees.department_id
                              left join mas_emp_sal_info on mas_emp_sal_info.employee_id=mas_employees.employeeobjectid

                  ";
       //echo $employeequery;
      $rsemployee=mysql_query($employeequery) or die();
      $numrows=mysql_num_rows($rsemployee);
      if($numrows>0)
      {

            $i=0;
            drawCompanyInformation("Basic Employee Information","");
            echo "
                   <table border='0' width='100%'  cellspacing='0' cellpadding='0'>

                              <TR>
                                    <Td class='title_cell_e_l'>Employee Name</Td>
                                    <Td class='title_cell_e'>Employee No.</Td>
                                    <Td class='title_cell_e'>Designation</Td>
                                    <Td class='title_cell_e'>Join Date</Td>
                                    <Td class='title_cell_e'>Department</Td>
                                    <Td class='title_cell_e'>Basic Salary</Td>
                                    <Td class='title_cell_e'>Increment Date</Td>
                                    
                                    
                              </TR>

                  ";
            while($rows=mysql_fetch_array($rsemployee))
            {
                  extract($rows);
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

                   echo"
                              <TR >
                                    <TD class='$lcls' >$employee_name&nbsp;</TD>
                                    <TD class='$cls'  align='center'>$employeeno&nbsp;</TD>
                                    <TD class='$cls' >$description&nbsp;</TD>
                                    
                                    <TD class='$cls'  align='center'>$joindate&nbsp;</TD>
                                    <TD class='$cls'  align='center'>$department&nbsp;</TD>
                                    <TD class='$cls'  align='right'>$basic_salary&nbsp;</TD>
                                    <TD class='$cls'  align='center'>$incement_date&nbsp;</TD>

                              </TR>
                        ";
                        $i++;
                  
                  



            }
            echo  "
                  </TABLE>";

      }
?>




</form>



</body>

</html>
