<?PHP
      include "Library/dbconnect.php";
      include "Library/Library.php";
      include "Library/SessionValidate.php";
?>

<html>
      <head>
            <meta http-equiv='Content-Type' content='text/html; charset=windows-1252'>
            <title>Aging Report</title>
            <script language='javascript'>
                  function ReportPrint()
                  {
                        print();
                  }
            </script>
            
            <LINK href="Style/generic_report.css" type='text/css' rel='stylesheet'>
            <link rel='stylesheet' type='text/css' href='Style/eng_report.css' />
            <link type='text/css' media='print' rel='stylesheet' href='Style/print.css' />
      </head>
      <body class='body_e'>
            <form name="MyForm" method='POST' action='CashReceivedSave.php'>
             <?PHP
                echo "
                    <table width='100%' id='table1' cellspacing='0' cellpadding='0' align='center'>
                        <tr>
                            <td align='center' HEIGHT='20'>
                                <div class='hide'>
                                    <input type='button' name='btnPrint' value='Print' onclick='ReportPrint()'>
                                </div>
                            </td>
                        </tr>
                    </table>
                ";

                  $query="
                        select
                              b.customer_id As CustID,
                              mas_customer.Company_Name As CustName,
                              max(over180) As days180,
                              max(over90) As days90,
                              max(over60) As days60,
                              max(over30) As days30,
                              max(over15) As days15,
                              max(over0) As days0
                        from
                        (     select
                                    customer_id,
                                    if(overdays=180,ammount,0) as over180,
                                    if(overdays=90,ammount,0) as over90,
                                    if(overdays=60,ammount,0) as over60,
                                    if(overdays=30,ammount,0) as over30,
                                    if(overdays=15,ammount,0) as over15,
                                    if(overdays=0,ammount,0) as over0
                              from
                              (
                                    SELECT
                                          '180' as overdays,
                                          sum(mas_invoice.net_bill-(ifnull(collection_amount,0.0)+ifnull(ait_amount,0.0)+ifnull(sales_return_amount,0.0))) as ammount,
                                          mas_invoice.customer_id
                                    FROM
                                          mas_invoice
                                          left join mas_invoice_collection on mas_invoice_collection.invoiceobjet_id=mas_invoice.invoiceobjet_id
                                    WHERE
                                          TIMESTAMPDIFF(DAY,invoice_date,CURDATE())>180

                                          and receive_status in ('0','1')
                                    GROUP BY
                                          mas_invoice.customer_id
                                    union
                                    SELECT
                                          '90' as overdays,
                                          sum(mas_invoice.net_bill-(ifnull(collection_amount,0.0)+ifnull(ait_amount,0.0)+ifnull(sales_return_amount,0.0))) as ammount,
                                          mas_invoice.customer_id
                                    FROM
                                          mas_invoice
                                          left join mas_invoice_collection on mas_invoice_collection.invoiceobjet_id=mas_invoice.invoiceobjet_id
                                    WHERE
                                          TIMESTAMPDIFF(DAY,invoice_date,CURDATE())>90
                                          and TIMESTAMPDIFF(DAY,invoice_date,CURDATE())<=180
                                          and receive_status in ('0','1')
                                    GROUP BY
                                          mas_invoice.customer_id
                                    union
                                    SELECT
                                          '60' as overdays,
                                          sum(mas_invoice.net_bill-(ifnull(collection_amount,0.0)+ifnull(ait_amount,0.0)+ifnull(sales_return_amount,0.0))) as ammount,
                                          mas_invoice.customer_id
                                    FROM
                                          mas_invoice
                                          left join mas_invoice_collection on mas_invoice_collection.invoiceobjet_id=mas_invoice.invoiceobjet_id
                                    WHERE
                                          TIMESTAMPDIFF(DAY,invoice_date,CURDATE())>60
                                          and TIMESTAMPDIFF(DAY,invoice_date,CURDATE())<=90
                                          and receive_status in ('0','1')
                                    GROUP BY
                                          mas_invoice.customer_id
                                    union
                                    SELECT
                                          '30' as overdays,
                                          sum(mas_invoice.net_bill-(ifnull(collection_amount,0.0)+ifnull(ait_amount,0.0)+ifnull(sales_return_amount,0.0))) as ammount,
                                          mas_invoice.customer_id
                                    FROM
                                          mas_invoice
                                          left join mas_invoice_collection on mas_invoice_collection.invoiceobjet_id=mas_invoice.invoiceobjet_id
                                    WHERE
                                          TIMESTAMPDIFF(DAY,invoice_date,CURDATE())>30
                                          and TIMESTAMPDIFF(DAY,invoice_date,CURDATE())<=60
                                          and receive_status in ('0','1')
                                    GROUP BY
                                          mas_invoice.customer_id
                                    union
                                    SELECT
                                          '15' as overdays,
                                          sum(mas_invoice.net_bill-(ifnull(collection_amount,0.0)+ifnull(ait_amount,0.0)+ifnull(sales_return_amount,0.0))) as ammount,
                                          mas_invoice.customer_id
                                    FROM
                                          mas_invoice
                                          left join mas_invoice_collection on mas_invoice_collection.invoiceobjet_id=mas_invoice.invoiceobjet_id
                                    WHERE
                                          TIMESTAMPDIFF(DAY,invoice_date,CURDATE())>15
                                          and TIMESTAMPDIFF(DAY,invoice_date,CURDATE())<=30
                                          and receive_status in ('0','1')
                                    GROUP BY
                                          mas_invoice.customer_id
                                    union
                                    SELECT
                                          '0' as overdays,
                                          sum(mas_invoice.net_bill-(ifnull(collection_amount,0.0)+ifnull(ait_amount,0.0)+ifnull(sales_return_amount,0.0))) as ammount,
                                          mas_invoice.customer_id
                                    FROM
                                          mas_invoice
                                          left join mas_invoice_collection on mas_invoice_collection.invoiceobjet_id=mas_invoice.invoiceobjet_id
                                    WHERE
                                          CURDATE()>invoice_date
                                          and TIMESTAMPDIFF(DAY,invoice_date,CURDATE())<=15
                                          and receive_status in ('0','1')
                                    GROUP BY
                                          mas_invoice.customer_id
                              ) As a
                        ) As b
                        left join mas_customer on mas_customer.customer_id=b.customer_id
                        group by
                              b.customer_id
                  ";

                  $rs=mysql_query($query) or die("Error: ".mysql_error());

                  $RowCount=mysql_num_rows($rs);
                  if($RowCount>0)
                  {
                     drawCompanyInformation("Ageing Report( Receivable )","Printed Date: ".date("l dS of F Y"));
                        echo "<table width='90%' id='table1' cellspacing='0' cellpadding='0' align='center'>
                                    <tr>
                                          <td class='title_cell_e_l' align='center'>Customer ID</td>
                                          <td class='title_cell_e' align='center'>Customer Name</td>
                                          <td class='title_cell_e' align='center'>0-15 Days</td>
                                          <td class='title_cell_e' align='center'>16-30 Days</td>
                                          <td class='title_cell_e' align='center'>31-60 Days</td>
                                          <td class='title_cell_e' align='center'>61-90 Days</td>
                                          <td class='title_cell_e' align='center'>91-180 Days</td>
                                          <td class='title_cell_e' align='center'>over 180</td>
                                          <td class='title_cell_e' align='center'>Total</td>
                                    </tr>";
                        $i=0;
                        $Grandtotal=0.0;
                        $Granddays0=0.0;
                        $Granddays15=0.0;
                        $Granddays30=0.0;
                        $Granddays60=0.0;
                        $Granddays90=0.0;
                        $Granddays180=0.0;

                        while($row=mysql_fetch_array($rs))
                        {
                              extract($row);
                              $Total=$days180+$days90+$days60+$days30+$days15+$days0;
                              $Grandtotal=$Grandtotal+$Total;
                              $Granddays0=$Granddays0+$days0;
                              $Granddays15=$Granddays15+$days15;
                              $Granddays30=$Granddays30+$days30;
                              $Granddays60=$Granddays60+$days60;
                              $Granddays90=$Granddays90+$days90;
                              $Granddays180=$Granddays180+$days180;
                              

                              if(($i%2)==0)
                              {
                                    $class='even_td_e';
                                    $lclass="even_left_td_e";
                              }
                              else
                              {
                                    $class='odd_td_e';
                                    $lclass="odd_left_td_e";
                              }
                              echo "<tr>
                                          <td class='$lclass'>$CustID&nbsp;";

                                          echo "
                                          </td>
                                          <td class='$class'>$CustName&nbsp;</td>
                                          <td class='$class' align='Right'>".number_format($days0,2,'.',',')."</td>
                                          <td class='$class' align='Right'>".number_format($days15,2,'.',',')."</td>
                                          <td class='$class' align='Right'>".number_format($days30,2,'.',',')."</td>
                                          <td class='$class' align='Right'>".number_format($days60,2,'.',',')."</td>
                                          <td class='$class' align='Right'>".number_format($days90,2,'.',',')."</td>
                                          <td class='$class' align='Right'>".number_format($days180,2,'.',',')."</td>
                                          <td class='$class' align='Right'>".number_format($Total,2,'.',',')."</td>
                                    </tr>";
                              $i++;
                        }
                        if(($i%2)==0)
                                    $class='even_td_e';
                              else
                                    $class='odd_td_e';

                        echo "<tr>
                                    <td class='$lclass' colspan='2'><b>Total</b></td>
                                    <td class='$class' align='Right'><b>".number_format($Granddays0,2,'.',',')."</b></td>
                                    <td class='$class' align='Right'><b>".number_format($Granddays15,2,'.',',')."</b></td>
                                    <td class='$class' align='Right'><b>".number_format($Granddays30,2,'.',',')."</b></td>
                                    <td class='$class' align='Right'><b>".number_format($Granddays60,2,'.',',')."</b></td>
                                    <td class='$class' align='Right'><b>".number_format($Granddays90,2,'.',',')."</b></td>
                                    <td class='$class' align='Right'><b>".number_format($Granddays180,2,'.',',')."</b></td>
                                    <td class='$class' align='Right'><b>".number_format($Grandtotal,2,'.',',')."</b></td>
                              </tr>
                              </table>";
                        echo "<input type='hidden' name='hidIndex' value='$i'>";
                  }
                  else
                  {
                        drawNormalMassage("No Information Available.");
                        die();
                  }
            ?>


            </form>
      </body>
</html>
