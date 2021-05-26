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
                  function sendData(val)
                  {
                        window.parent.InvoicePostingBottom.location="";
                  }
            </script>
            <LINK href="Style/generic_form.css" type='text/css' rel='stylesheet'>
            <link rel='stylesheet' type='text/css' href='Style/eng_form.css' />
      </head>
      <body class='body_e'>
            <form name='MyForm' method='POST' action='SupplierInvoicePostingBottomSave.php'>
            <?PHP
                  $query="select (MAX(JV)+1) AS JV from mas_latestjournalnumber";

                  $rs=mysql_query($query) or die("Error: ".mysql_error());

                  $RowCount=mysql_num_rows($rs);
                  if($RowCount>0)
                  {
                        while($row=mysql_fetch_array($rs))
                        {
                              extract($row);
                        }

                        echo "<table width='90%' id='table1' cellspacing='0' cellpadding='0' align='center'>
                                    <tr>
                                          <td class='top_left_curb'></td>
                                          <td colspan='4' class='header_cell_e' align='center'>Journal Voucher</td>
                                          <td class='top_right_curb'></td>
                                    </tr>
                                    <tr>
                                          <td class='lb' rowspan='2'></td>
                                          <td class='caption_e'>Voucher No</td>
                                          <td class='td_e'><input type='text' class='input_e' name='VoucherNo' value='$JV'></td>
                                          <td class='caption_e'>Voucher Date</td>
                                          <td class='td_e'>";
                                          echo "<select name='cboVoucherDay' class='select_e'>";
                                                      $D=date('d');
                                                      comboDay($D);
                                          echo "</select>";
                                          echo "<select name='cboVoucherMonth' class='select_e'>";
                                                      $M=date('m');
                                                      comboMonth($M);
                                          echo "</select>";
                                          echo "<select name='cboVoucherYear' class='select_e'>";
                                                      $Y=date('Y');
                                                      $PY=$Y-10;
                                                      $NY=$Y+10;
                                                      comboYear($PY,$NY,$Y);
                                          echo "</select>";
                                          echo "</td>
                                          <td class='rb' rowspan='2'></td>
                                    </tr>
                                    <tr>
                                          <td class='caption_e'>Supplier</td>
                                          <td class='td_e' colspan='3'>
                                                <input type='text' class='input_e' name='CustomerName' value='$Company_Name'>
                                                <input type='hidden' class='input_e' name='CustomerID' value='$customer_id'>
                                                <input type='hidden' class='input_e' name='InvoiceObjectID' value='$invoiceobjet_id'>
                                          </td>
                                    </tr>
                                    <tr>
                                          <td class='bottom_l_curb'></td>
                                          <td class='bottom_f_cell' colspan='4'></td>
                                          <td class='bottom_r_curb'></td>
                                    </tr>
                              </table>";
                        echo "<br>";
                        $RowSpan=6;
                        if($vat==0)
                        {
                                $total_bill=$net_bill-$net_bill*.1304;
                                $vat=$net_bill*.1304;
                        }
                        if($net_bill==0)
                              $RowSpan--;
                        if($discount_amount==0)
                              $RowSpan--;
                        if($total_bill==0)
                              $RowSpan--;
                        if($vat==0)
                              $RowSpan--;
                        echo "<table width='90%' id='table2' cellspacing='0' cellpadding='0' align='center'>
                                    <tr>
                                          <td class='top_left_curb'></td>
                                          <td colspan='3' class='header_cell_e' align='center'>Journal Voucher Detail</td>
                                          <td class='top_right_curb'></td>
                                    </tr>
                                    <tr>
                                          <td class='lb' rowspan='$RowSpan'></td>
                                          <td class='title_cell_e'></td>
                                          <td class='title_cell_e' align='center'>Dr</td>
                                          <td class='title_cell_e' align='center'>Cr</td>
                                          <td class='rb' rowspan='$RowSpan'></td>
                                    </tr>";
                        if($net_bill!=0)
                        {

                              echo "<tr>
                                          <td class='caption_e'>Trade Debtors</td>
                                          <td class='td_e' align='center'><input type='text' class='input_e' name='NetBill' value='$net_bill' style=\"text-align : right;\"></td>
                                          <td class='td_e'></td>
                                    </tr>";
                        }


                        if($discount_amount!=0)
                        {
                              echo "<tr>
                                          <td class='caption_e'>Discount Bill</td>
                                          <td class='td_e' align='center'><input type='text' class='input_e' name='DiscountAmount' value='$discount_amount' style=\"text-align : right;\"></td>
                                          <td class='td_e'></td>
                                    </tr>";
                        }
                        if($total_bill!=0)
                        {
                              echo "<tr>
                                          <td class='caption_e'>Credit Sales</td>
                                          <td class='td_e'></td>
                                          <td class='td_e' align='center'><input type='text' class='input_e' name='TotalBill' value='$total_bill' style=\"text-align : right;\"></td>
                                    </tr>";
                        }
                        if($vat!=0)
                        {
                              echo "<tr>
                                          <td class='caption_e'>Vat</td>
                                          <td class='td_e'></td>
                                          <td class='td_e' align='center'><input type='text' class='input_e' name='Vat' value='$vat' style=\"text-align : right;\"></td>
                                    </tr>";
                        }
                        echo "      <tr>
                                          <td class='button_cell_e' colspan='3' align='center'><input type='submit' class='forms_button_e' name='Submit' value='Submit'></td>
                                    </tr>
                                    <tr>
                                          <td class='bottom_l_curb'></td>
                                          <td class='bottom_f_cell' colspan='3'></td>
                                          <td class='bottom_r_curb'></td>
                                    </tr>
                              </table>";
                  }
                  else
                  {
                        drawNormalMassage("Voucher Number Generation Failed.");
                  }
            ?>
            </form>
      </body>
</html>
