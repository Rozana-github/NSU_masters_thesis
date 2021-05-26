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
      document.frmEmployeeEntry.action="OverTimeGenaret.php";
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




<form name='frmEmployeeEntry' method='post' action='SaveOTGenarat.php' >


<table width='100%' id='table1' cellspacing='0' cellpadding='0' align='center'>
                  <tr>
                        <td class='top_left_curb'></td>
                        <td colspan='4' class='header_cell_e' align='center'>Genarate Over Time</td>
                        <td class='top_right_curb'></td>
                  </tr>
                  <tr>
                        <td class='lb'></td>

                        <td class='caption_e'>&nbsp;</td>
                        <td class='td_e'>&nbsp;
                        </td>
                        <td class='caption_e'>Month</td>
                        <td class='td_e'>
                              <select name='cboMonth'  class='select_e' onchange='emplistshow()'>
                                    <?PHP comboMonth($cboMonth);?>

                              </select>
                              <select name='cboYear'  class='select_e' onchange='emplistshow()'>
                              <?PHP comboYear("","",$cboYear);?>

                              </select>

                        </td>
                     </tr>
                     </table>
                     
                     <?PHP
                                    if(isset($cboMonth) || isset($cboYear))
                                    {
                                    $queryemp="SELECT
                                                      trn_emp_ot.emp_id,
                                                      mas_employees.employee_name,
                                                      ifnull(sum(ot_hour),0) AS othour,
                                                      ifnull( mas_emp_sal_info.basic_salary, 0 ) AS basicsalary
                                                FROM
                                                      trn_emp_ot
                                                      INNER JOIN mas_employees ON trn_emp_ot.emp_id = mas_employees.employeeobjectid
                                                      LEFT JOIN mas_emp_sal_info ON mas_emp_sal_info.employee_id = trn_emp_ot.emp_id
                                                WHERE
                                                      ot_date BETWEEN STR_TO_DATE('01-$cboMonth-$cboYear','%d-%m-%Y') AND LAST_DAY(STR_TO_DATE('01-$cboMonth-$cboYear','%d-%m-%Y'))
                                                GROUP BY
                                                      trn_emp_ot.emp_id
                                                ";
                                   //echo $queryemp;
                                    $rsemp=mysql_query($queryemp)or die(mysql_error());
                                    if(mysql_num_rows($rsemp)>0)
                                    {
                                          echo"<table width='100%' id='table1' cellspacing='0' cellpadding='0' align='center'>
                                                <tr>
                                                      <td class='title_cell_e'>Employee Name</td>
                                                      <td class='title_cell_e'>Basic</td>
                                                      <td class='title_cell_e'>Over Time Hour</td>
                                                      <td class='title_cell_e'>OT Amount</td>
                                                      <td class='title_cell_e'>Night Allowanc</td>
                                                </tr>";
                                          $i=0;
                                          while($rowsemp=mysql_fetch_array($rsemp))
                                          {
                                                extract($rowsemp);
                                                $amount=($basicsalary/208)*2*$othour;
                                                echo "
                                                    <tr>
                                                      <td class='td_e' align='center'>$employee_name<input type='hidden' name='txtempid[$i]' value='$emp_id' class='input_e'></td>
                                                      <td class='td_e' align='center'><input type='text' name='txtbasic[$i]' value='$basicsalary' class='input_e'></td>
                                                      <td class='td_e' align='center'><input type='text' name='txtothours[$i]' value='$othour' class='input_e'></td>
                                                      <td class='td_e' align='center'><input type='text' name='txtotamount[$i]' value='".number_format($amount,2,'.','')."' class='input_e'></td>
                                                      <td class='td_e' align='center'><input type='text' name='txtnightallowance[$i]' value='' class='input_e'></td>
                                                </tr>
                                                ";
                                                $i++;
                                          }
                                          echo "<input type='hidden' name='txttotal' value='$i' class='input_e'>
                                          <tr>
                                                <td class='button_cell_e' align='center' colspan='5'>
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
