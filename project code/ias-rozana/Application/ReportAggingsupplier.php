<?PHP
      include "Library/dbconnect.php";
      include "Library/Library.php";
      include "Library/SessionValidate.php";
?>

<html>
      <head>
            <meta http-equiv='Content-Type' content='text/html; charset=windows-1252'>
            <title>Aging Report</title>
            <LINK href="Style/generic_form.css" type='text/css' rel='stylesheet'>
            <link rel='stylesheet' type='text/css' href='Style/eng_form.css' />
      </head>
      <body class='body_e'>
            <form name="MyForm" method='POST' action='CashReceivedSave.php'>
            <?PHP
                  /*$query="select
                              b.customer_id As CustID,
                              mas_customer.Company_Name As CustName,
                              max(over90) As days90,
                              max(over60) As days60,
                              max(over30) As days30,
                              max(over0) As days0
                        from
                        (     select
                                    customer_id,
                                    if(overdays=90,ammount,0) as over90,
                                    if(overdays=60,ammount,0) as over60,
                                    if(overdays=30,ammount,0) as over30,
                                    if(overdays=0,ammount,0) as over0
                              from
                              (
                                    SELECT
                                          '90' as overdays,
                                          sum(mas_invoice.net_bill-ifnull(collection_amount,0.0)) as ammount,
                                          customer_id
                                    FROM
                                          mas_invoice
                                          left join mas_invoice_collection on mas_invoice_collection.invoiceobjet_id=mas_invoice.invoiceobjet_id
                                    WHERE
                                          DATE_SUB(CURDATE(),INTERVAL 90 DAY)>invoice_date
                                          and receive_status in ('0','1')
                                    GROUP BY
                                          customer_id
                                    union
                                    SELECT
                                          '60' as overdays,
                                          sum(mas_invoice.net_bill-ifnull(collection_amount,0.0)) as ammount,
                                          customer_id
                                    FROM
                                          mas_invoice
                                          left join mas_invoice_collection on mas_invoice_collection.invoiceobjet_id=mas_invoice.invoiceobjet_id
                                    WHERE
                                          DATE_SUB(CURDATE(),INTERVAL 60 DAY)>invoice_date
                                          and DATE_SUB(CURDATE(),INTERVAL 90 DAY)<invoice_date
                                          and receive_status in ('0','1')
                                    GROUP BY
                                          customer_id
                                    union
                                    SELECT
                                          '30' as overdays,
                                          sum(mas_invoice.net_bill-ifnull(collection_amount,0.0)) as ammount,
                                          customer_id
                                    FROM
                                          mas_invoice
                                          left join mas_invoice_collection on mas_invoice_collection.invoiceobjet_id=mas_invoice.invoiceobjet_id
                                    WHERE
                                          DATE_SUB(CURDATE(),INTERVAL 30 DAY)>invoice_date
                                          and DATE_SUB(CURDATE(),INTERVAL 60 DAY)<invoice_date
                                          and receive_status in ('0','1')
                                    GROUP BY
                                          customer_id
                                    union
                                    SELECT
                                          '0' as overdays,
                                          sum(mas_invoice.net_bill-ifnull(collection_amount,0.0)) as ammount,
                                          customer_id
                                    FROM
                                          mas_invoice
                                          left join mas_invoice_collection on mas_invoice_collection.invoiceobjet_id=mas_invoice.invoiceobjet_id
                                    WHERE
                                          CURDATE()>invoice_date
                                          and DATE_SUB(CURDATE(),INTERVAL 30 DAY)<invoice_date
                                          and receive_status in ('0','1')
                                    GROUP BY
                                          customer_id
                              ) As a
                        ) As b
                        left join mas_customer on mas_customer.customer_id=b.customer_id
                        group by
                              b.customer_id";*/
                  $query="
                        select
                              b.supplier_id As CustID,
                              mas_supplier.company_name As CustName,
                              max(over90) As days90,
                              max(over60) As days60,
                              max(over30) As days30,
                              max(over15) As days15,
                              max(over0) As days0
                        from
                        (     select
                                    supplier_id,
                                    if(overdays=90,ammount,0) as over90,
                                    if(overdays=60,ammount,0) as over60,
                                    if(overdays=30,ammount,0) as over30,
                                    if(overdays=15,ammount,0) as over15,
                                    if(overdays=0,ammount,0) as over0
                              from
                              (
                                    SELECT
                                          '90' as overdays,
                                          sum(mas_supplier_invoice.net_bill-ifnull(pay_amount,0.0)) as ammount,
                                          supplier_id
                                    FROM
                                          mas_supplier_invoice
                                          left join mas_invoice_payment  on mas_invoice_payment.invoiceobject_id=mas_supplier_invoice.invoiceobjet_id
                                    WHERE
                                          TIMESTAMPDIFF(DAY,invoice_date,CURDATE())>=90
                                          and receive_status in ('0','1')
                                    GROUP BY
                                          supplier_id
                                    union
                                    SELECT
                                          '60' as overdays,
                                          sum(mas_supplier_invoice.net_bill-ifnull(pay_amount,0.0)) as ammount,
                                          supplier_id
                                    FROM
                                          mas_supplier_invoice
                                          left join mas_invoice_payment on mas_invoice_payment.invoiceobject_id=mas_supplier_invoice.invoiceobjet_id
                                    WHERE
                                          TIMESTAMPDIFF(DAY,invoice_date,CURDATE())>=60
                                          and TIMESTAMPDIFF(DAY,invoice_date,CURDATE())<90
                                          and receive_status in ('0','1')
                                    GROUP BY
                                          supplier_id
                                    union
                                    SELECT
                                          '30' as overdays,
                                          sum(mas_supplier_invoice.net_bill-ifnull(pay_amount,0.0)) as ammount,
                                          supplier_id
                                    FROM
                                          mas_supplier_invoice
                                          left join mas_invoice_payment on mas_invoice_payment.invoiceobject_id=mas_supplier_invoice.invoiceobjet_id
                                    WHERE
                                          TIMESTAMPDIFF(DAY,invoice_date,CURDATE())>=30
                                          and TIMESTAMPDIFF(DAY,invoice_date,CURDATE())<60
                                          and receive_status in ('0','1')
                                    GROUP BY
                                          supplier_id
                                    union
                                    SELECT
                                          '15' as overdays,
                                          sum(mas_supplier_invoice.net_bill-ifnull(pay_amount,0.0)) as ammount,
                                          supplier_id
                                    FROM
                                          mas_supplier_invoice
                                          left join mas_invoice_payment on mas_invoice_payment.invoiceobject_id=mas_supplier_invoice.invoiceobjet_id
                                    WHERE
                                          TIMESTAMPDIFF(DAY,invoice_date,CURDATE())>=15
                                          and TIMESTAMPDIFF(DAY,invoice_date,CURDATE())<30
                                          and receive_status in ('0','1')
                                    GROUP BY
                                          supplier_id
                                    union
                                    SELECT
                                          '0' as overdays,
                                          sum(mas_supplier_invoice.net_bill-ifnull(pay_amount,0.0)) as ammount,
                                          supplier_id
                                    FROM
                                          mas_supplier_invoice
                                          left join mas_invoice_payment on mas_invoice_payment.invoiceobject_id=mas_supplier_invoice.invoiceobjet_id
                                    WHERE
                                          CURDATE()>invoice_date
                                          and TIMESTAMPDIFF(DAY,invoice_date,CURDATE())<15
                                          and receive_status in ('0','1')
                                    GROUP BY
                                          supplier_id
                              ) As a
                        ) As b
                        left join mas_supplier on mas_supplier.supplier_id=b.supplier_id
                        group by
                              b.supplier_id
                  ";

                  $rs=mysql_query($query) or die("Error: ".mysql_error());

                  $RowCount=mysql_num_rows($rs);
                  if($RowCount>0)
                  {
                        echo "<table width='90%' id='table1' cellspacing='0' cellpadding='0' align='center'>
                                    <tr>
                                          <td class='top_left_curb'></td>
                                          <td colspan='8' class='header_cell_e' align='center'>Aging Report Accounts Payable</td>
                                          <td class='top_right_curb'></td>
                                    </tr>
                                    <tr>
                                          <td class='lb' ></td>
                                          <td class='sub_title_cell'  colspan='8' align='Right'><b>Date: ".Date("d/m/Y")."<b></td>
                                          <td class='rb' ></td>
                                    </tr>
                                    <tr>
                                          <td class='lb' ></td>
                                          <td class='title_cell_e' align='center'>Supplier ID</td>
                                          <td class='title_cell_e' align='center'>Supplier Name</td>
                                          <td class='title_cell_e' align='center'>0-15 Days</td>
                                          <td class='title_cell_e' align='center'>16-30 Days</td>
                                          <td class='title_cell_e' align='center'>31-60 Days</td>
                                          <td class='title_cell_e' align='center'>61-90 Days</td>
                                          <td class='title_cell_e' align='center'>over 90</td>
                                          <td class='title_cell_e' align='center'>Total</td>
                                          <td class='rb' ></td>
                                    </tr>";
                                    
                        $i=0;
                        $Grandtotal=0.0;
                        $Granddays0=0.0;
                        $Granddays15=0.0;
                        $Granddays30=0.0;
                        $Granddays60=0.0;
                        $Granddays90=0.0;

                        while($row=mysql_fetch_array($rs))
                        {
                              extract($row);
                              $Total=$days90+$days60+$days30+$days15+$days0;
                              $Grandtotal=$Grandtotal+$Total;
                              $Granddays0=$Granddays0+$days0;
                              $Granddays0=$Granddays15+$days15;
                              $Granddays30=$Granddays30+$days30;
                              $Granddays60=$Granddays60+$days60;
                              $Granddays90=$Granddays90+$days90;
                              

                              if(($i%2)==0)
                                    $class='even_td_e';
                              else
                                    $class='odd_td_e';
                                    
                              echo "<tr>
                                          <td class='lb' ></td>
                                          <td class='$class'>$CustID</td>
                                          <td class='$class'>$CustName</td>
                                          <td class='$class' align='Right'>".number_format($days0,2,'.','')."</td>
                                          <td class='$class' align='Right'>".number_format($days15,2,'.','')."</td>
                                          <td class='$class' align='Right'>".number_format($days30,2,'.','')."</td>
                                          <td class='$class' align='Right'>".number_format($days60,2,'.','')."</td>
                                          <td class='$class' align='Right'>".number_format($days90,2,'.','')."</td>
                                          <td class='$class' align='Right'>".number_format($Total,2,'.','')."</td>
                                          <td class='rb' ></td>
                                    </tr>";
                              $i++;
                        }
                        if(($i%2)==0)
                                    $class='even_td_e';
                              else
                                    $class='odd_td_e';

                        echo "<tr>
                                    <td class='lb' ></td>
                                    <td class='$class' colspan='2'><b>Total</b></td>

                                    <td class='$class' align='Right'><b>".number_format($Granddays0,2,'.','')."</b></td>
                                    <td class='$class' align='Right'><b>".number_format($Granddays15,2,'.','')."</b></td>
                                    <td class='$class' align='Right'><b>".number_format($Granddays30,2,'.','')."</b></td>
                                    <td class='$class' align='Right'><b>".number_format($Granddays60,2,'.','')."</b></td>
                                    <td class='$class' align='Right'><b>".number_format($Granddays90,2,'.','')."</b></td>
                                    <td class='$class' align='Right'><b>".number_format($Grandtotal,2,'.','')."</b></td>
                                    <td class='rb' ></td>
                              </tr>
                              <tr>
                                    <td class='bottom_l_curb'></td>
                                    <td class='bottom_f_cell' colspan='8'></td>
                                    <td class='bottom_r_curb'></td>
                              </tr>";
                        echo "</table>";
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
