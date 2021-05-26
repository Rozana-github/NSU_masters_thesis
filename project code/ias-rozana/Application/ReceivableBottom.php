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
                        if($fMonth=='1' || $fMonth=='-1')
                        {
                              $pyear=$fYear-1;
                              $pmonth=12;
                        }
                        else
                        {
                              $pyear=$fYear;
                              $pmonth=$fMonth-1;
                        }
                        if($fMonth=='-1')
                        {

                               $query="SELECT
                                          mas_customer.`customer_id`,
                                          mas_customer.company_name,
                                          CAA.Invoice_Amount,

                                          CAAA.open_balance,
                                          CA.collcedamount,
                                          CA.ait_amount,
                                          CA.sales_return_amount
                                    FROM
                                          `mas_customer`
                                          LEFT JOIN (
                                                SELECT
                                                        mas_invoice_collection.customer_id,
                                                        ifnull(sum( `collection_amount` ),0) AS collcedamount,
                                                        ifnull(sum(ait_amount),0)as ait_amount,
                                                        ifnull(sum(sales_return_amount),0)as sales_return_amount
                                                FROM
                                                        `mas_invoice_collection`
                                                WHERE
                                                         `mas_invoice_collection`.`collection_date` between STR_TO_DATE('1-1-$fYear','%e-%c-%Y') AND last_day(STR_TO_DATE('1-12-$fYear','%e-%c-%Y'))
                                                GROUP BY
                                                        mas_invoice_collection.customer_id
                                                ) AS CA ON mas_customer.customer_id = CA.customer_id

                                          LEFT JOIN (
                                                SELECT
                                                        mas_invoice.customer_id,
                                                        ifnull(sum( `net_bill` ),0) AS Invoice_Amount
                                                FROM
                                                        mas_invoice
                                                WHERE
                                                         `mas_invoice`.`invoice_date` between STR_TO_DATE('1-1-$fYear','%e-%c-%Y') AND last_day(STR_TO_DATE('1-12-$fYear','%e-%c-%Y'))
                                                GROUP BY
                                                        mas_invoice.customer_id
                                                ) AS CAA ON mas_customer.customer_id = CAA.customer_id

                                          LEFT JOIN (
                                                SELECT
                                                        mas_customer_balance.customerobject_id,
                                                        ifnull((closing_dr-closing_cr),0) AS open_balance
                                                FROM
                                                        mas_customer_balance
                                                WHERE
                                                        mas_customer_balance.proc_year=$pyear and mas_customer_balance.proc_month=$pmonth
                                                 ) AS CAAA ON mas_customer.customerobject_id = CAAA.customerobject_id
                                    order by
                                        mas_customer.company_name
                                ";
                        }
                        else
                        {
                               $query="SELECT
                                          mas_customer.`customer_id`,
                                          mas_customer.company_name,
                                          CAA.Invoice_Amount,
                                          CAAA.open_balance,
                                          CA.collcedamount,
                                          CA.ait_amount,
                                          CA.sales_return_amount
                                    FROM
                                        `mas_customer`
                                    LEFT JOIN (
                                                SELECT
                                                        mas_invoice_collection.customer_id,
                                                        ifnull(sum( `collection_amount` ),0) AS collcedamount,
                                                        ifnull(sum(ait_amount),0)as ait_amount,
                                                        ifnull(sum(sales_return_amount),0)as sales_return_amount
                                                FROM
                                                        `mas_invoice_collection`
                                                WHERE
                                                         `mas_invoice_collection`.`collection_date` between STR_TO_DATE('1-$fMonth-$fYear','%e-%c-%Y') AND last_day(STR_TO_DATE('1-$fMonth-$fYear','%e-%c-%Y'))
                                                GROUP BY
                                                        mas_invoice_collection.customer_id
                                                ) AS CA ON mas_customer.customer_id = CA.customer_id
                                
                                    LEFT JOIN (
                                                SELECT
                                                        mas_invoice.customer_id,
                                                        ifnull(sum( `net_bill` ),0) AS Invoice_Amount
                                                FROM
                                                        mas_invoice
                                                WHERE
                                                         `mas_invoice`.`invoice_date` between STR_TO_DATE('1-$fMonth-$fYear','%e-%c-%Y') AND last_day(STR_TO_DATE('1-$fMonth-$fYear','%e-%c-%Y'))
                                                GROUP BY
                                                        mas_invoice.customer_id
                                                ) AS CAA ON mas_customer.customer_id = CAA.customer_id

                                    LEFT JOIN (
                                                SELECT
                                                        mas_customer_balance.customerobject_id,
                                                        closing_dr-closing_cr AS open_balance
                                                FROM
                                                        mas_customer_balance
                                                WHERE
                                                        mas_customer_balance.proc_year=$pyear and mas_customer_balance.proc_month=$pmonth
                                                 ) AS CAAA ON mas_customer.customerobject_id = CAAA.customerobject_id
                                    order by
                                          mas_customer.company_name
                                    ";
                        }
                        // echo $query;
                         $rs=mysql_query($query) or die("Error: ".mysql_error());

                        if(mysql_num_rows($rs)>0)
                        {
                                if($fMonth=='-1')
                                {
                                        drawCompanyInformation("Summery Report on Receivable","For the Year of ".date("Y", mktime(0, 0, 0, 1,1,$fYear)));

                                }
                                else
                                {
                                        drawCompanyInformation("Summery Report on Receivable","For the Month of ".date("F,Y", mktime(0, 0, 0, $fMonth,1,$fYear)));

                                }


                                echo "<table width='95%' id='table1' cellspacing='0' cellpadding='0' align='center'>
                                        <tr>
                                                <td class='title_cell_e_l' >SL. No</td>
                                                <td class='title_cell_e' >Customer Name</td>
                                                <td class='title_cell_e' >Opening Balance</td>
                                                <td class='title_cell_e' >Invoiced Amount</td>
                                                <td class='title_cell_e' >Collected Amount</td>
                                                <td class='title_cell_e' >AIT Amount</td>
                                                <td class='title_cell_e' >Sales Return</td>
                                                <td class='title_cell_e' >Closing Balance</td>
                                        </tr>

                                    ";

                                $i=0;
                                $totalopen_balance=0;
                                $totalinvoice=0;
                                $totalcollected=0;
                                $totaldue=0;
                                $totalait=0;
                                $totalsalesreturn=0;

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
                              
                                        $dueamount=($open_balance+$Invoice_Amount)-($collcedamount+$sales_return_amount+$ait_amount);
                                        $totalopen_balance=$totalopen_balance+$open_balance;
                                        $totalinvoice=$totalinvoice+$Invoice_Amount;
                                        $totalcollected=$totalcollected+$collcedamount;
                                        $totaldue=$totaldue+$dueamount;
                                        $totalait=$totalait+$ait_amount;
                                        $totalsalesreturn=$totalsalesreturn+$sales_return_amount;

                              //////////////////////////////////////////

                                        echo "<tr>
                                                <td class='$lclass' align='center'>".($i+1)."</td>
                                                <td class='$class' > ".$company_name."&nbsp;</td>
                                                <td class='$class' align='right'>".number_format($open_balance,2,'.',',')."</td>
                                                <td class='$class' align='right'>".number_format($Invoice_Amount,2,'.',',')."</td>
                                                <td class='$class'align='right'>".number_format($collcedamount,2,'.',',')."</td>
                                                <td class='$class'align='right'>".number_format($ait_amount,2,'.',',')."</td>
                                                <td class='$class'align='right'>".number_format($sales_return_amount,2,'.',',')."</td>
                                                <td class='$class' align='right'>".number_format($dueamount,2,'.',',')."</td>

                                                </tr>";

                                        $i++;
                                }
                                echo "<tr>
                                        <td class='td_e_b_l' colspan='2' align='right'><b>Total</b></td>
                              <td class='td_e_b' align='right'>".number_format($totalopen_balance,2,'.',',')."</td>
                                        <td class='td_e_b' align='right'>".number_format($totalinvoice,2,'.',',')."</td>
                                        <td class='td_e_b' align='right'>".number_format($totalcollected,2,'.',',')."</td>
                                        <td class='td_e_b' align='right'>".number_format($totalait,2,'.',',')."</td>
                                        <td class='td_e_b' align='right'>".number_format($totalsalesreturn,2,'.',',')."</td>
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
