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
                        window.parent.DebtorInvoiceBottom.focus();
                        window.parent.DebtorInvoiceBottom.print();
                  }
                  function enabledate()
                  {
                        if(document.MyForm.ckdatecontrol.checked==true)
                        {
                                document.MyForm.cbofDay.disabled=false;
                                document.MyForm.cbofMonth.disabled=false;
                                document.MyForm.cbofYear.disabled=false;
                                document.MyForm.cbotDay.disabled=false;
                                document.MyForm.cbotMonth.disabled=false;
                                document.MyForm.cbotYear.disabled=false;
                                
                        }
                        else
                        {
                                document.MyForm.cbofDay.disabled=true;
                                document.MyForm.cbofMonth.disabled=true;
                                document.MyForm.cbofYear.disabled=true;
                                document.MyForm.cbotDay.disabled=true;
                                document.MyForm.cbotMonth.disabled=true;
                                document.MyForm.cbotYear.disabled=true;
                        }
                  }
            </script>
            <LINK href="Style/generic_form.css" type='text/css' rel='stylesheet'>
            <link rel='stylesheet' type='text/css' href='Style/eng_form.css' />
      </head>
      <body class='body_e'>
            <form name="MyForm" method='POST' action='DebtorInvoiceBottom.php' target='DebtorInvoiceBottom'>
            <table width='100%' id='table1' cellspacing='0' cellpadding='0' align='center'>
                  <tr>
                        <td class='top_left_curb'></td>
                        <td colspan='7' class='header_cell_e' align='center'>Date Selection</td>
                        <td class='top_right_curb'></td>
                  </tr>
                  <tr>
                        <td class='lb'></td>
                        <td class='td_e'><input type='checkbox' name='ckdatecontrol' value='ON' onclick='enabledate()'></td>
                        <td class='caption_e'>From</td>
                        <td class='td_e'>
                              <select name='cbofDay' class='select_e' disabled>
                                    <?PHP
                                          $D=date('d');
                                          comboDay($D);
                                    ?>
                              </select>
                              <select name='cbofMonth' class='select_e' disabled>
                                    <?PHP
                                          $M=date('m');
                                          comboMonth($M);
                                    ?>
                              </select>
                              <select name='cbofYear' class='select_e' disabled>
                                    <?PHP
                                          $Y=date('Y');
                                          $PY=$Y-10;
                                          $NY=$Y+10;
                                          comboYear($PY,$NY,$Y);
                                    ?>
                              </select>
                        </td>
                        <td class='caption_e'>To</td>
                        <td class='td_e'>
                             <select name='cbotDay' class='select_e' disabled>
                                    <?PHP
                                          $D=date('d');
                                          comboDay($D);
                                    ?>
                              </select>
                              <select name='cbotMonth' class='select_e' disabled>
                                    <?PHP
                                          $M=date('m');
                                          comboMonth($M);
                                    ?>
                              </select>
                              <select name='cbotYear' class='select_e' disabled>
                                    <?PHP
                                          $Y=date('Y');
                                          $PY=$Y-10;
                                          $NY=$Y+10;
                                          comboYear($PY,$NY,$Y);
                                    ?>
                              </select>
                        </td>
                        <td class='caption_e'>Customer:</td>
                        <td class='td_e'>
                                <select name='cbocustomer' class='select_e'>
                                <?PHP
                                        createCombo("Customer","mas_customer","customer_id","company_name","order by company_name","");
                                ?>
                                </select>
                        </td>
                        <td class='rb'></td>
                        
                  </tr>
                  <tr>
                        <td class='lb'></td>
                        <td class='button_cell_e' align='center' colspan='7'>
                                <input value='Show Report' type='button' name='btnsubmit' class='forms_button_e' onclick='sendData()'>
                                <input value='Print' type='button' name='btnsubmit' class='forms_button_e' onclick='doPrint()'>
                        </td>
                        <td class='rb'></td>
                  </tr>
                  <tr>
                        <td class='bottom_l_curb'></td>
                        <td class='bottom_f_cell' colspan='7'></td>
                        <td class='bottom_r_curb'></td>
                  </tr>
            </table>
            </form>
      </body>
</html>
<?PHP
      mysql_close();
?>
