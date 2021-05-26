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


function sendData()
{

           /* if(document.frmEmployeeEntry.cboDepartment.value == '-1')
            {
                  alert("Select Department");
                  document.frmEmployeeEntry.cboDepartment.focus();
            }
            else */
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




<form name='frmEmployeeEntry' method='post' action='EmpLeaveBottom.php' target='EmpLeaveIssueBottom'>


<table width='100%' id='table1' cellspacing='0' cellpadding='0' align='center'>
                  <tr>
                        <td class='top_left_curb'></td>
                        <td colspan='3' class='header_cell_e' align='center'>Employee Leave Entry</td>
                        <td class='top_right_curb'></td>
                  </tr>
                  <tr>
                        <td class='lb'></td>

                        <td class='caption_e'>Department</td>
                        <td class='td_e'>
                              <select name='cboDepartment' class='select_e'>
                              <?PHP
                                    $query="select
                                                cost_code,
                                                description
                                            from
                                                mas_cost_center

                                            order by
                                                description
                                           ";
                                    createQueryCombo("Department",$query,"-1","");
                              ?>
                              </select>
                        </td>
                        <td class='button_cell_e' align='center'>
                              <input value='Submit' type='button' name='btnsubmit' class='forms_button_e' onclick='sendData()'></td>
                        <td class='rb'></td>
                  </tr>
                  <tr>
                        <td class='bottom_l_curb'></td>
                        <td class='bottom_f_cell' colspan='3'></td>
                        <td class='bottom_r_curb'></td>
                  </tr>
            </table>


</form>



</body>

</html>
