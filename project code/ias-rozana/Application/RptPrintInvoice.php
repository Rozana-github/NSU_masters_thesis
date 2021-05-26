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
                        function sendDataForPrint(val)
                        {
                                document.Form1.txtInvoiceObjectID.value=val;
                                document.Form1.action="RptPrintInvoiceDetail.php";
                                document.Form1.submit();
                        }
                        function sendDataForDelete(val)
                        {
                                answerType=confirm("Do you really want to Delete?")
                                
                                if(answerType==0)
                                {
                                        return;
                                }
                                else
                                {

                                        document.Form1.txtInvoiceObjectID.value=val;
                                        document.Form1.action="RptInvoiceDelete.php";
                                        document.Form1.submit();
                                }
                        }
                        function sendDataForEdit(val)
                        {
                                document.Form1.txtInvoiceObjectID.value=val;
                                document.Form1.action="EditInvoiceDetail.php";
                                document.Form1.submit();
                        }

            </script>
            <LINK href="Style/generic_form.css" type='text/css' rel='stylesheet'>
            <link rel='stylesheet' type='text/css' href='Style/eng_form.css' />
      </head>
      <body class='body_e'>
      <form Name='Form1' method='post' action=''>
            <?PHP
                  $query="select
                              mas_invoice.invoiceobjet_id,
                              mas_invoice.invoice_number,
                              date_format(mas_invoice.invoice_date,'%d-%m-%Y') as invoice_date,
                              mas_invoice.customer_id,
                              mas_customer.Company_Name,
                              mas_invoice.vat,
                              mas_invoice.discount_amount,
                              mas_invoice.total_bill,
                              mas_invoice.net_bill
                        FROM
                              mas_invoice
                              LEFT JOIN mas_customer on mas_invoice.customer_id=mas_customer.customer_id
                        WHERE
                              mas_invoice.journal_status='0' ";

                  $rs=mysql_query($query) or die("Error: ".mysql_error());

                  $RowCount=mysql_num_rows($rs);
                  if($RowCount>0)
                  {
                        echo "<table width='100%' id='table1' cellspacing='0' cellpadding='0' align='center'>
                                    <tr>
                                          <td class='top_left_curb'></td>
                                          <td colspan='8' class='header_cell_e' align='center'>Invoice Printing Information</td>
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
                                          <td class='title_cell_e'>Status</td>
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
                                          <td class='$class'>$Company_Name</td>
                                          <td class='$class'>$invoice_date</td>
                                          <td class='$class' align='right'>".number_format($total_bill,2,'.',',')."</td>
                                          <td class='$class' align='right'>".number_format($vat,2,'.',',')."</td>
                                          <td class='$class' align='right'>".number_format($discount_amount,2,'.',',')."</td>
                                          <td class='$class' align='right'>".number_format($net_bill,2,'.',',')."</td>
                                          <td class='$class'>
                                                <input type='button' class='forms_button_e' name='btnDelete[$i]' value='Delete' onclick=\"sendDataForDelete('$invoiceobjet_id')\">
                                                <input type='button' class='forms_button_e' name='btnEdit[$i]' value='Edit' onclick=\"sendDataForEdit('$invoiceobjet_id')\">
                                                <input type='button' class='forms_button_e' name='btnPrint[$i]' value='Print' onclick=\"sendDataForPrint('$invoiceobjet_id')\">
                                          </td>
                                    </tr>";
                              $i++;
                        }
                        echo "<tr>
                                    <td class='bottom_l_curb'></td>
                                    <td class='bottom_f_cell' colspan='8'></td>
                                    <td class='bottom_r_curb'></td>
                              </tr>";
                        echo "</table>";
                        
                       echo"<input type='hidden' name='txtInvoiceObjectID' value=''>";
                  }
                  else
                  {
                        drawNormalMassage("No Information Available.");
                  }
            ?>
      </form>
      </body>
</html>
