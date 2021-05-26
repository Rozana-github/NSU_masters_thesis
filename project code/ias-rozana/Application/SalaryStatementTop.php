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
function doPrint()
                  {
                        window.parent.SalaryStatementBottom.focus();
                        window.parent.SalaryStatementBottom.print();
                  }



</script>

</head>

<body class='body_e'>




<form name='frmEmployeeEntry' method='post' action='SalaryStatementBottom.php' target='SalaryStatementBottom'>


<table width='100%' id='table1' cellspacing='0' cellpadding='0' align='center'>
                  <tr>
                        <td class='top_left_curb'></td>
                        <td colspan='5' class='header_cell_e' align='center'>Month Selection</td>
                        <td class='top_right_curb'></td>
                  </tr>
                  <tr>
                        <td class='lb'></td>
                        <td class='caption_e'>Month</td>
                        <td class='td_e'>
                              <select name='cboMonth' class='select_e'>

                                    <?PHP
                                          $M=date('m');
                                          comboMonth("");
                                    ?>
                              </select>
                              <select name='cboYear' class='select_e'>
                                    <?PHP
                                          $Y=date('Y');
                                          $PY=$Y-10;
                                          $NY=$Y+10;
                                          comboYear($PY,$NY,$Y);
                                    ?>
                              </select>
                        </td>
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
                              <input value='Submit' type='button' name='btnsubmit' class='forms_button_e' onclick='sendData()'>
                              <input value='Print' type='button' name='btnprint' class='forms_button_e' onclick='doPrint()'></td>
                        <td class='rb'></td>
                  </tr>
                  <tr>
                        <td class='bottom_l_curb'></td>
                        <td class='bottom_f_cell' colspan='5'></td>
                        <td class='bottom_r_curb'></td>
                  </tr>
            </table>


</form>



</body>

</html>
