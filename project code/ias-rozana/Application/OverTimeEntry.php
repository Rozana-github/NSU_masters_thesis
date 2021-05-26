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

            document.frmEmployeeEntry.submit();

}
function emplistshow()
{
      document.frmEmployeeEntry.action="OverTimeEntry.php";
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




<form name='frmEmployeeEntry' method='post' action='SaveOTEntry.php' >


<table width='100%' id='table1' cellspacing='0' cellpadding='0' align='center'>
                  <tr>
                        <td class='top_left_curb'></td>
                        <td colspan='4' class='header_cell_e' align='center'>Over Time Entry</td>
                        <td class='top_right_curb'></td>
                  </tr>
                  <tr>
                        <td class='lb'></td>

                        <td class='caption_e'>Department</td>
                        <td class='td_e'>
                              <select name='cboDepartment' class='select_e' onchange='emplistshow()'>
                              <?PHP
                                    $query="select
                                                cost_code,
                                                description
                                            from
                                                mas_cost_center

                                            order by
                                                description
                                           ";
                                    createQueryCombo("Department",$query,"-1","$cboDepartment");
                              ?>
                              </select>
                        </td>
                        <td class='caption_e'>Date</td>
                        <td class='td_e'>
                              <?PHP
                                    if(!isset($txtDay))
                                          $txtDay=date("d");
                                    if(!isset($txtMonth))
                                          $txtMonth=date("m");
                                    if(!isset($txtYear))
                                          $txtYear=date("Y");

                                     echo"
                                          dd<input type='text' name='txtDay' value='$txtDay' size='2' maxlength='2' class='input_e'>
                                          mm<input type='text' name='txtMonth' value='$txtMonth' size='2' maxlength='2' class='input_e'>
                                          yyyy<input type='text' name='txtYear' value='$txtYear' size='4' maxlength='4' class='input_e'>
                                    ";
                              ?>
                        </td>
                     </tr>
                     </table>
                     
                     <?PHP
                              if($cboDepartment!='-1' && $cboDepartment!='')
                              {
                                    $queryemp="SELECT
                                                      trn_employees.emp_id,
                                                      employee_name,
                                                      ot_hour
                                                FROM
                                                      trn_employees
                                                      inner join mas_employees on trn_employees.emp_id=mas_employees.employeeobjectid
                                                      left join trn_emp_ot on trn_emp_ot.emp_id=trn_employees.emp_id and ot_date=STR_TO_DATE('$txtDay-$txtMonth-$txtYear','%d-%m-%Y')
                                                where
                                                      mas_employees.department_id='$cboDepartment'";
                                    //echo $queryemp;
                                    $rsemp=mysql_query($queryemp)or die(mysql_error());
                                    if(mysql_num_rows($rsemp)>0)
                                    {
                                          echo"<table width='100%' id='table1' cellspacing='0' cellpadding='0' align='center'>
                                                <tr>
                                                      <td class='title_cell_e'>Sl.No</td>
                                                      <td class='title_cell_e'>Employee Name</td>
                                                      <td class='title_cell_e'>Over Time Hour</td>
                                                </tr>";
                                          $i=0;
                                          while($rowsemp=mysql_fetch_array($rsemp))
                                          {
                                                extract($rowsemp);
                                                if($i%2==0)
                                                        $cls='even_td_e';
                                                else
                                                        $cls='odd_td_e';
                                                echo"
                                                    <tr>
                                                      <td class='$cls'>".($i+1)."</td>
                                                      <td class='$cls' align='left'>$employee_name<input type='hidden' name='txtempid[$i]' value='$emp_id' class='input_e'></td>
                                                      <td class='$cls' align='center'><input type='text' style='text-align:right' name='txtothours[$i]' size='10' value='$ot_hour' class='input_e'></td>
                                                </tr>
                                                ";
                                                $i++;
                                          }
                                          echo"<input type='hidden' name='txttotal' value='$i' class='input_e'>
                                          <tr>
                                                <td class='button_cell_e' align='center' colspan='3'>
                                                      <input value='Submit' type='button' name='btnsubmit' class='forms_button_e' onclick='sendData()'>
                                                </td>
                                           </tr>
                                          </table>";
                                    }
                              }
                     ?>




</form>



</body>

</html>
