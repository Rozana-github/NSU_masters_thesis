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

<form name='frmIOEclear' method='post' action='Note9ProcessBottom.php' target='bottomfrmForReport'>
      <table width='100%' id='table1' cellspacing='0' cellpadding='0' align='center'>
            <tr>
                  <td class='top_left_curb'></td>
                  <Td  class='header_cell_e'  align='center'>Note-9</Td>
                  <td class='top_right_curb'></td>
            </tr>
            <tr>

                  <td class='lb'></td>
                  <td class='td_e' align='center'> <b>Month</b>

                  <?PHP
                       echo "<select name='fMonth' class='select_e'>";
                                    comboMonth("");
                        echo "</select>
                              <select name='fYear'  class='select_e'>";
                                    comboYear("");
                        echo"</select>"
                  ?>
                  </td>
                  <td class='rb'></td>
            </tr>
            <tr>

                  <td class='lb'></td>
                  <td class='button_cell_e' align='center' >
                        <input type='submit' value='Submit' class='forms_Button_e' >

                  </td>
                  <td class='rb'></td>
            </tr>

            <tr>
                  <td class='bottom_l_curb'></td>
                  <td class='bottom_f_cell' ></td>
                  <td class='bottom_r_curb'></td>
            </tr>

      </table>
      </form>
</form>
</body>

</html>
