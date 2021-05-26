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
                  function sendData(invoiceobjet_id,vat,discount_amount,total_bill,net_bill,customer_id,Company_Name)
                  {
                        window.parent.InvoicePostingBottom.location="InvoicePostingBottom.php?invoiceobjet_id="+invoiceobjet_id+"&vat="+vat+"&discount_amount="+discount_amount+"&total_bill="+total_bill+"&net_bill="+net_bill+"&customer_id="+customer_id+"&Company_Name="+Company_Name+"";
                  }
            </script>
            <LINK href="Style/generic_form.css" type='text/css' rel='stylesheet'>
            <link rel='stylesheet' type='text/css' href='Style/eng_form.css' />
      </head>
      <body class='body_e'>
            <form name="MyForm" method='POST' action='AdvanceAdjustmentBottom.php' target='AdvanceAdjustmentBottom'>
            <table width='90%' id='table1' cellspacing='0' cellpadding='0' align='center'>
                  <tr>
                        <td class='top_left_curb'></td>
                        <td colspan='3' class='header_cell_e' align='center'>Debtor Selection</td>
                        <td class='top_right_curb'></td>
                  </tr>
                  <tr>
                        <td class='lb'></td>
                        <td class='caption_e'>Debtor</td>
                        <td class='td_e'>
                              <select name='cboDebtor' class='select_e' onchange='window.parent.AdvanceAdjustmentBottom.location="blank.php"'>
                                    <?PHP createCombo("Debtor","mas_customer","customer_id","Company_Name","order by Company_Name",""); ?>
                              </select>
                        </td>
                        <td class='td_e' align='center'><input value='Show Detail' type='submit' name='submit' class='forms_button_e'></td>
                        <td class='rb'></td>
                  </tr>
                  <tr>
                        <td class='bottom_l_curb'></td>
                        <td class='bottom_f_cell' colspan='3'></td>
                        <td class='bottom_r_curb'></td>
                  </tr>
            </table>
            </form>
      </body>
</html>
