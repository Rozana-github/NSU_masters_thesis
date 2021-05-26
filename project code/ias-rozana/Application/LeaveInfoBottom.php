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
      echo "<input type='hidden' name='mkdecession' value=''>";
      $employeequery="
                       SELECT
                              mas_employees.employee_name,
                              mas_designation.description,
                              mas_emp_leave.leave_id,
                              mas_emp_leave.opening_balance,
                              mas_emp_leave.current_allocation,
                              mas_emp_leave.balance

                        FROM
                              mas_emp_leave
                              left join mas_employees on mas_employees.employeeobjectid=mas_emp_leave.emp_id
                              left join  mas_designation on mas_designation.designationid=mas_employees.designationid
                              where
                              mas_employees.department_id ='$cboDepartment'

                  ";
       //echo $employeequery;
      $rsemployee=mysql_query($employeequery) or die();
      $numrows=mysql_num_rows($rsemployee);
      if($numrows>0)
      {

            $i=0;
            drawCompanyInformation("Leave Information");
            echo "
                   <table border='0' width='100%'  cellspacing='0' cellpadding='0'>

                              <TR>
                                    <Td class='title_cell_e_l'>Employee Name</Td>
                                    <Td class='title_cell_e_l'>Designation</Td>
                                     <Td class='title_cell_e'>Opening Balance</Td>
                                     <Td class='title_cell_e'>Current Allocation</Td>
                                     <Td class='title_cell_e'>Balance</Td>

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
                                    <TD class='$lcls' >$employee_name</TD>
                                    <TD class='$lcls' >$description</TD>
                                    <TD class='$cls'  align='center'>$opening_balance</TD>
                                    <TD class='$cls'  align='center'>$current_allocation</TD>
                                    <TD class='$cls'  align='center'>$balance</TD>



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
