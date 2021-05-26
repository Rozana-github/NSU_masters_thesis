<?PHP
      include "Library/dbconnect.php";
      include "Library/Library.php";
      include "Library/SessionValidate.php";
?>

<html>
      <head>
            <meta http-equiv='Content-Type' content='text/html; charset=windows-1252'>
            <title>Invoice Posting</title>
            <LINK href="Style/generic_report.css" type='text/css' rel='stylesheet'>
            <link rel='stylesheet' type='text/css' href='Style/eng_report.css' />

            <script language='javascript'>
                        function sendDataForPrint(val)
                        {
                                document.Form1.txtInvoiceObjectID.value=val;
                                document.Form1.action="RptPrintInvoiceDetail.php";
                                document.Form1.submit();
                        }
                        function goRptPrintInvoiceDetail(invoiceobjet_id)
                        {
                                window.location="RptPrintInvoiceDetail.php?txtInvoiceObjectID="+invoiceobjet_id;
                        }
            </script>

      </head>
      <body class='body_e'>
                <?PHP
                        if($ckdatecontrol==1)
                        {
                                $query="SELECT
                                        mas_invoice.invoiceobjet_id,
                                        mas_invoice.invoice_number,
                                        date_format(invoice_date,'%d-%m-%Y') as invoicedate,
                                        net_bill,
                                        clamount,
                                        date_format(collection_date,'%d-%m-%Y') as collectdate
                                FROM
                                        mas_invoice
                                        left join
                                                (
                                                SELECT
                                                        mas_invoice_collection.invoiceobjet_id,
                                                        sum(collection_amount) clamount,
                                                        collection_date
                                                FROM
                                                        mas_invoice_collection
                                                        inner join mas_invoice on mas_invoice.invoiceobjet_id=mas_invoice_collection.invoiceobjet_id
                                                WHERE  mas_invoice.invoice_date between STR_TO_DATE('$cbofDay-$cbofMonth-$cbofYear','%e-%c-%Y') AND STR_TO_DATE('$cbotDay-$cbotMonth-$cbotYear','%e-%c-%Y')
                                                group by
                                                        mas_invoice_collection.invoiceobjet_id
                                                ) as collect on mas_invoice.invoiceobjet_id=collect.invoiceobjet_id
                                WHERE
                                        mas_invoice.invoice_date between STR_TO_DATE('$cbofDay-$cbofMonth-$cbofYear','%e-%c-%Y') AND STR_TO_DATE('$cbotDay-$cbotMonth-$cbotYear','%e-%c-%Y') and
                                        mas_invoice.customer_id='$cbocustomer'
                                order by
                                        mas_invoice.invoice_number
                                ";
                        }
                        else
                        {
                                $query="SELECT
                                        mas_invoice.invoiceobjet_id,
                                        mas_invoice.invoice_number,
                                        date_format(invoice_date,'%d-%m-%Y') as invoicedate,
                                        net_bill,
                                        clamount,
                                        date_format(collection_date,'%d-%m-%Y') as collectdate
                                FROM
                                        mas_invoice
                                        left join
                                                (
                                                SELECT
                                                        mas_invoice_collection.invoiceobjet_id,
                                                        sum(collection_amount) clamount,
                                                        collection_date
                                                FROM
                                                        mas_invoice_collection
                                                        inner join mas_invoice on mas_invoice.invoiceobjet_id=mas_invoice_collection.invoiceobjet_id

                                                group by
                                                        mas_invoice_collection.invoiceobjet_id
                                                ) as collect on mas_invoice.invoiceobjet_id=collect.invoiceobjet_id
                                WHERE

                                        mas_invoice.customer_id='$cbocustomer'
                                order by
                                        mas_invoice.invoice_number
                                ";
                        }


                        $rs=mysql_query($query) or die("Error: ".mysql_error());

                        if(mysql_num_rows($rs)>0)
                        {
                               // echo $ckdatecontrol;
                                if( $ckdatecontrol==1)
                                {
                                        drawCompanyInformation("Invoice  Report of ".pick("mas_customer","company_name","customer_id='$cbocustomer'"),"For the period of ".date("jS F, Y", mktime(0, 0, 0, $cbofMonth,$cbofDay,$cbofYear))." To ".date("jS F, Y", mktime(0, 0, 0, $cbotMonth,$cbotDay,$cbotYear)));
                                }
                                else
                                {
                                        drawCompanyInformation("Invoice  Report of ".pick("mas_customer","company_name","customer_id='$cbocustomer'"),"From Starting To ".date("jS F, Y"));
                                }

                                echo "<table width='95%' id='table1' cellspacing='0' cellpadding='0' align='center'>
                                        <tr>
                                                <td class='title_cell_e_l' >SL. No</td>
                                                <td class='title_cell_e'  >Invoice Number</td>
                                                <td class='title_cell_e' >Invoice Date</td>
                                                <td class='title_cell_e' >Invoice Amount</td>
                                                <td class='title_cell_e' >Collected Amount</td>
                                                <td class='title_cell_e' >Collect Date</td>
                                                <td class='title_cell_e' >Due Amount</td>
                                        </tr>

                                    ";
                                $i=0;

                                $totalinvoice=0;
                                $totalcollected=0;
                                $totaldue=0;

                                while($row=mysql_fetch_array($rs))
                                {
                                        extract($row);

                                        if(($i%2)==0)
                                        {
                                                $class="even_td_e";
                                                $lclass="even_left_td_e";
                                        }
                                        else
                                        {
                                                $class="odd_td_e";
                                                $lclass="odd_left_td_e";
                                        }
                                        $dueamount=abs($net_bill-$clamount);
                                        $totalinvoice=$totalinvoice+$net_bill;
                                        $totalcollected=$totalcollected+$clamount;
                                        $totaldue=$totaldue+$dueamount;

                              //////////////////////////////////////////

                                        echo "<tr>
                                                <td class='$lclass' align='center'>".($i+1)."</td>
                                                <td class='$class' style=\"cursor: hand;\" onclick=goRptPrintInvoiceDetail($invoiceobjet_id)> ".$invoice_number." </td>
                                                <td class='$class'>$invoicedate</td>
                                                <td class='$class' align='right'>".number_format($net_bill,2,'.',',')."</td>
                                                <td class='$class'align='right'>".number_format($clamount,2,'.',',')."</td>
                                                <td class='$class'>$collectdate&nbsp;</td>
                                                <td class='$class' align='right'>".number_format($dueamount,2,'.',',')."</td>

                                                </tr>";

                                        $i++;
                                }
                                echo "<tr>
                                        <td class='td_e_b_l' colspan='3' align='right'><b>Total</b></td>
                                        <td class='td_e_b' align='right'>".number_format($totalinvoice,2,'.',',')."</td>
                                        <td class='td_e_b' align='right'>".number_format($totalcollected,2,'.',',')."</td>
                                        <td class='$class'>&nbsp;</td>
                                        <td class='td_e_b' align='right'>".number_format($totaldue,2,'.',',')."</td>
                                     </tr>";
                                echo "</table>";
                        }
                        else
                        {
                                drawNormalMassage("Data Not Found.");
                        }
                ?>
        </body>
        </html>
