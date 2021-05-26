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
                        window.parent.SupplierInvoicePostingBottom.location="SupplierInvoicePostingBottom.php?invoiceobjet_id="+invoiceobjet_id+"&vat="+vat+"&discount_amount="+discount_amount+"&total_bill="+total_bill+"&net_bill="+net_bill+"&customer_id="+customer_id+"&Company_Name="+Company_Name+"";
                  }
            </script>
            <LINK href="Style/generic_form.css" type='text/css' rel='stylesheet'>
            <link rel='stylesheet' type='text/css' href='Style/eng_form.css' />
      </head>
      <body class='body_e'>
            <?PHP
                  $query="select
                              mas_supplier_invoice.invoiceobjet_id,
                              mas_supplier_invoice.invoice_number,
                              mas_supplier_invoice.invoice_date,
                              mas_supplier_invoice.supplier_id,
                              mas_supplier.company_name,
                              mas_supplier_invoice.vat,
                              mas_supplier_invoice.discount_amount,
                              mas_supplier_invoice.total_bill,
                              mas_supplier_invoice.net_bill
                        FROM
                              mas_supplier_invoice
                              LEFT JOIN mas_supplier on mas_supplier_invoice.supplier_id=mas_supplier.supplier_id
                        WHERE
                              mas_supplier_invoice.journal_status='0' ";

                  $rs=mysql_query($query) or die("Error: ".mysql_error());

                  $RowCount=mysql_num_rows($rs);
                  if($RowCount>0)
                  {
                        echo "<table width='90%' id='table1' cellspacing='0' cellpadding='0' align='center'>
                                    <tr>
                                          <td class='top_left_curb'></td>
                                          <td colspan='8' class='header_cell_e' align='center'>Invoice Posting Information</td>
                                          <td class='top_right_curb'></td>
                                    </tr>
                                    <tr>
                                          <td class='lb' rowspan='".($RowCount+1)."'></td>
                                          <td class='title_cell_e'>Invoice Number</td>
                                          <td class='title_cell_e'>Customer</td>
                                          <td class='title_cell_e'>Date</td>
                                          <td class='title_cell_e'>Total Bill</td>
                                          <td class='title_cell_e'>Vat</td>
                                          <td class='title_cell_e'>Discount Amount</td>
                                          <td class='title_cell_e'>Net Bill</td>
                                          <td class='title_cell_e'>Posting</td>
                                          <td class='rb' rowspan='".($RowCount+1)."'></td>
                                    </tr>";
                                    
                        $i=0;
                        while($row=mysql_fetch_array($rs))
                        {
                              extract($row);

                              if(($i%2)==0)
                                    $class='even_td_e';
                              else
                                    $class='odd_td_e';
                                    
                              echo "<tr>
                                          <td class='$class'>$invoice_number</td>
                                          <td class='$class'>$company_name</td>
                                          <td class='$class'>$invoice_date</td>
                                          <td class='$class'>$total_bill</td>
                                          <td class='$class'>$vat</td>
                                          <td class='$class'>$discount_amount</td>
                                          <td class='$class'>$net_bill</td>
                                          <td class='$class'><input type='button' class='forms_button_e' name='btnpost[$i]' value='Post' onclick=\"sendData('$invoiceobjet_id','$vat','$discount_amount','$total_bill','$net_bill','$supplier_id','".urlencode($Company_Name)."')\"></td>
                                    </tr>";
                              $i++;
                        }
                        echo "<tr>
                                    <td class='bottom_l_curb'></td>
                                    <td class='bottom_f_cell' colspan='8'></td>
                                    <td class='bottom_r_curb'></td>
                              </tr>";
                        echo "</table>";
                  }
                  else
                  {
                        drawNormalMassage("No Information Available.");
                  }
            ?>
      </body>
</html>
