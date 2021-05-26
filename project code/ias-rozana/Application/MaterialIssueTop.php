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
                        window.parent.MaterialIssueBottom.focus();
                        window.parent.MaterialIssueBottom.print();
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
            <form name="MyForm" method='POST' action='MaterialIssueBottom.php' target='MaterialIssueBottom'>
            <table width='100%' id='table1' cellspacing='0' cellpadding='0' align='center'>
                  <tr>
                        <td class='top_left_curb'></td>
                        <td colspan='6' class='header_cell_e' align='center'>Material Issue </td>
                        <td class='top_right_curb'></td>
                  </tr>
                  <tr>
                        <td class='lb'></td>

                        <td class='caption_e'>Requisition No:</td>
                        <td class='td_e'>
                              <select name='cborequsitionno' class='select_e' onchange='gobottom()'>
                              <?PHP
                                    $query="select
                                                mas_requisition_id,
                                                requisition_number
                                            from
                                                mas_material_req
                                            where
                                               requision_status='0'
                                            order by
                                                requisition_number
                                           ";
                                    createQueryCombo("Requisit No",$query,"-1","");
                              ?>
                              </select>
                        </td>
                        <td class='td_e' colspan='4'></td>
                        <td class='rb'></td>


            </table>

            </form>
      </body>
</html>
<?PHP
      mysql_close();
?>
