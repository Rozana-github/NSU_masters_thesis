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

                  function gobottom()
                  {
                        document.MyForm.submit();
                  }
            </script>
            <LINK href="Style/generic_form.css" type='text/css' rel='stylesheet'>
            <link rel='stylesheet' type='text/css' href='Style/eng_form.css' />
      </head>
      <body class='body_e'>
            <form name="MyForm" method='POST' action='RptLcLedgerBottom.php' target='RptLcLedgerBottom'>
            <table width='100%' id='table1' cellspacing='0' cellpadding='0' align='center'>
                  <tr>
                        <td class='top_left_curb'></td>
                        <td colspan='2' class='header_cell_e' align='center'>Receive from LC</td>
                        <td class='top_right_curb'></td>
                  </tr>
                  <tr>
                        <td class='lb'></td>

                        <td class='caption_e'>LC No:</td>
                        <td class='td_e'>
                              <select name='cboLc' class='select_e' onchange='gobottom()'>
                              <?PHP
                                    $query="select
                                                lcobjectid,
                                                lcno
                                            from
                                                mas_lc

                                            order by
                                                lcno
                                           ";
                                    createQueryCombo("LC",$query,"-1","");
                              ?>
                              </select>
                        </td>

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
