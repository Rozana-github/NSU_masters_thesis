<?PHP
      include "Library/SessionValidate.php";
      include "Library/dbconnect.php";
      include "Library/Library.php";
?>

<html>
<head>
<link rel='stylesheet' type='text/css' href='Style/eng_form.css'>
<link rel='stylesheet' type='text/css' href='Style/generic_form.css'>
<link rel='stylesheet' type='text/css' href='Style/interface_styles.css' />



<script language="JavaScript" src="Script/NumberFormat.js"></script>

<script language="JavaScript" src="Script/calendar1.js"></script>

<script language='JavaScript'>


function enabledaterange()
{
      if(document.frmIOEclear.enabledate.checked)
      {
            document.frmIOEclear.fDay.disabled=false;
            document.frmIOEclear.fMonth.disabled=false;
            document.frmIOEclear.fYear.disabled=false;
            document.frmIOEclear.tDay.disabled=false;
            document.frmIOEclear.tMonth.disabled=false;
            document.frmIOEclear.tYear.disabled=false;

      }
      else
      {
            document.frmIOEclear.fDay.disabled=true;
            document.frmIOEclear.fMonth.disabled=true;
            document.frmIOEclear.fYear.disabled=true;
            document.frmIOEclear.tDay.disabled=true;
            document.frmIOEclear.tMonth.disabled=true;
            document.frmIOEclear.tYear.disabled=true;
      }
}

function doPrint()
{
      window.parent.bottomfrmForReport.focus();
      window.parent.bottomfrmForReport.print();
}
</script>

</head>

<body class='body_e'>

<form name='frmIOEclear' method='post' action='IOEReport.php' target='bottomfrmForReport'>
      <table width='100%' id='table1' cellspacing='0' cellpadding='0' align='center'>
            <tr>
                  <td class='top_left_curb'></td>
                  <Td  class='header_cell_e' colspan='5' align='center'>IOU Report</Td>
                  <td class='top_right_curb'></td>
            </tr>
            <tr>

                  <td class='lb'></td>
                  <td class='td_e' >
                        <input type='checkbox' name='enabledate' value='ON' onclick='enabledaterange()'>
                  </td>
                  <td class='td_e'> Date from</td>
                  <td class='td_e'>
                  <?PHP
                        echo "<select name='fDay'  disabled class='select_e'>";
                                    comboDay("");
                        echo "</select>
                              <select name='fMonth' disabled class='select_e'>";
                                    comboMonth("");
                        echo "</select>
                              <select name='fYear' disabled class='select_e'>";
                                    comboYear("");
                        echo"</select>"
                  ?>
                  </td>
                  <td class='td_e'>To</td>
                  <td class='td_e'>
                  <?PHP
                        echo "<select name='tDay'  disabled class='select_e'>";
                                    comboDay("");
                        echo "</select>
                              <select name='tMonth' disabled class='select_e'>";
                                    comboMonth("");
                        echo "</select>
                              <select name='tYear' disabled class='select_e'>";
                                    comboYear("");
                        echo"</select>"
                  ?>
                  </td>
                  <td class='rb'></td>
            </tr>
            <tr>
                  <td class='lb'></td>
                  <td class='td_e'> Type </td>
                  <td class='td_e' colspan='2'>
                        <input type='radio' name='rdotype' value='0' class='td_e'> Unpaid
                        <input type='radio' name='rdotype' value='1' class='td_e'> Paid
                        <input type='radio' name='rdotype' value='-1' checked class='td_e'> All
                  </td>
                  <td class='button_cell_e' align='center' colspan='2'>
                        <input type='submit' value='Submit' class='forms_Button_e' >
                        <input value='Print' type='button' name='btnsubmit' class='forms_button_e' onclick='doPrint()'>
                  </td>
                  <td class='rb'></td>
            </tr>
            <tr>
                  <td class='bottom_l_curb'></td>
                  <td class='bottom_f_cell' colspan='5'></td>
                  <td class='bottom_r_curb'></td>
            </tr>

      </table>
      </form>
</form>
</body>

</html>
