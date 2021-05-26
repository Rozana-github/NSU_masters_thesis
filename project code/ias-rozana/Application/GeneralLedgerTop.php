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
                  function sendData()
                  {
                        document.MyForm.submit();
                  }
                  function doPrint()
                  {
                        window.parent.GeneralLedgerBottom.focus();
                        window.parent.GeneralLedgerBottom.print();
                  }
            </script>
            <LINK href="Style/generic_form.css" type='text/css' rel='stylesheet'>
            <link rel='stylesheet' type='text/css' href='Style/eng_form.css' />
      </head>
      <body class='body_e'>
            <form name="MyForm" method='POST' action='GeneralLedgerBottom.php' target='GeneralLedgerBottom'>
            <table width='100%' id='table1' cellspacing='0' cellpadding='0' align='center'>
                  <tr>
                        <td class='top_left_curb'></td>
                        <td colspan='6' class='header_cell_e' align='center'>Month Selection</td>
                        <td class='top_right_curb'></td>
                  </tr>
                  <tr>
                        <td class='lb'></td>
                        <td class='caption_e'>Month</td>
                        <td class='td_e'>
                              <select name='cboMonth' class='select_e'>
                                        <option value='-1'>No Month</option>
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
                        <td class='caption_e'>Account Head</td>
                        <td class='td_e'>
                              <select name='cboAccountHead' class='select_e'>
                              <?PHP
                                    $query="select
                                                gl_code,
                                                description
                                            from
                                                mas_gl
                                            where
                                                id not in (select distinct pid from mas_gl)
                                            order by
                                                description
                                           ";
                                    createQueryCombo("Account Head",$query,"-1","");
                              ?>
                              </select>
                        </td>
                        <td class='button_cell_e' align='center'><input value='Show Report' type='button' name='btnsubmit' class='forms_button_e' onclick='sendData()'></td>
                        <td class='button_cell_e' align='center'><input value='Print' type='button' name='btnsubmit' class='forms_button_e' onclick='doPrint()'></td>
                        <td class='rb'></td>
                  </tr>
                  <tr>
                        <td class='bottom_l_curb'></td>
                        <td class='bottom_f_cell' colspan='6'></td>
                        <td class='bottom_r_curb'></td>
                  </tr>
            </table>
            </form>
      </body>
</html>
<?PHP
      mysql_close();
?>
