<?PHP
      include "Library/dbconnect.php";
      include "Library/Library.php";
      include "Library/SessionValidate.php";
?>

<html>
      <head>
            <meta http-equiv='Content-Type' content='text/html; charset=windows-1252'>
            <title>Invoice Posting</title>
            <script language='javascript'>

                  function ShowDetail()
                    {
                         document.MyForm.submit();
                         //document.frmMasAssetEntry.target="SelectQuery";

                    }

                  function doPrint()
                  {
                        window.parent.MyForm.focus();
                        window.parent.Rpt_Close_floor_Bottom.print();
                  }
            </script>
            <LINK href="Style/generic_form.css" type='text/css' rel='stylesheet'>
            <link rel='stylesheet' type='text/css' href='Style/eng_form.css' />
      </head>
      <body class='body_e'>

      <form name="MyForm" method='POST' action='Rpt_Close_floor_Bottom.php' target='Rpt_Close_floor_Bottom'>
            <table width='100%' id='table1' cellspacing='0' cellpadding='0' align='center'>
                  <tr>
                        <td class='top_left_curb'></td>
                        <td colspan='2' class='header_cell_e' align='center'>Closeing Report</td>
                        <td class='top_right_curb'></td>
                  </tr>
                  <tr>
                    <td class='lb'></td>
                    <td class='td_e' align='center'> <b>Month</b>
                     </td>
                     <td class='td_e'>
                    <?PHP
                       echo "<select name='fMonth' class='select_e' >";
                                    comboMonth($fMonth);
                            echo" </select>

                             <select name='fYear'  class='select_e'>";
                                    comboYear('','',$fYear);
                             echo "</select>" ;
                    ?>
                    </td>
                    <td class='rb'></td>
                   </tr>
                   <tr>
                        <td class='lb'></td>
                        <td class='button_cell_e' align='center' colspan='2'>
                              <input value='Show Report' type='button' name='btnsubmit' class='forms_button_e' onclick='ShowDetail()'>
                              <input value='Print' type='button' name='btnsubmit' class='forms_button_e' onclick='doPrint()'></td>
                        <td class='rb'></td>
                  </tr>
                  <tr>
                        <td class='bottom_l_curb'></td>
                        <td class='bottom_f_cell' colspan='2'></td>
                        <td class='bottom_r_curb'></td>
                  </tr>
            </table>
            </form>
      </body>
</html>
<?PHP
      mysql_close();
?>
