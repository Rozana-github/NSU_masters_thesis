<?PHP
      include "Library/SessionValidate.php";
      include "Library/dbconnect.php";
      include "Library/Library.php";
      include "Library/InWords.php";

?>

<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=windows-1252'>
<title>Invoice Posting</title>
      <script language='javascript'>
            function ReportPrint()
            {
                  print();
            }
      </script>

<LINK href="Style/generic_form.css" type='text/css' rel='stylesheet'>
<link rel='stylesheet' type='text/css' href='Style/generic_report.css'/>
<link rel='stylesheet' type='text/css' href='Style/eng_report.css' />
<link type='text/css' media='print' rel='stylesheet' href='Style/print.css' />
</head>

<body >
<form Name='Form1' method='post' action=''>
<?PHP
$TodayDate=date('d-m-Y');

//-------search Invoice Information------------------
$searchinvoiceInfo="select
                                mas_invoice.invoice_number,
                                date_format(mas_invoice.invoice_date,'%d-%m-%Y') as BillDate,
                                mas_invoice.order_number,
                                date_format(mas_invoice.order_date,'%d-%m-%Y') as OrderDate,
                                mas_invoice.vat_parcent,
                                mas_invoice.vat,
                                mas_invoice.total_bill,
                                mas_invoice.net_bill,
                                mas_invoice.discount_amount,
                                mas_invoice.payment_terms,
                                date_format(trn_invoice.challan_date,'%d-%m-%Y') as ChallanDate,
                                trn_invoice.challan_no,
                                trn_invoice.job_no,
                                trn_invoice.product_name,
                                trn_invoice.total_quantity,
                                trn_invoice.unit_price,
                                trn_invoice.total_price,
                                mas_unit.unitdesc,
                                mas_customer.Company_Name,
                                mas_customer.Contact_Person,
                                mas_customer.Office_Address
                        from
                                mas_invoice inner join trn_invoice
                                on mas_invoice.invoiceobjet_id=trn_invoice.invoiceobject_id
                                inner join mas_unit
                                on trn_invoice.unit_type=mas_unit.unitid
                                inner join mas_customer
                                on mas_invoice.customer_id=mas_customer.customer_id
                        where
                                mas_invoice.invoiceobjet_id='".$txtInvoiceObjectID."'
                        order by
                                trn_invoice.challan_date
                ";
$resultInvoiceInfo=mysql_query($searchinvoiceInfo) or die(mysql_error());


$Style="style='BACKGROUND: #ffffff;BORDER-LEFT: #000000 0px solid;BORDER-RIGHT: #000000 1px solid;COLOR: #2B3934;font-family: Verdana;FONT-SIZE: 10px;font-weight: normal;padding-right:2px;padding-left:2px;'";

$Style_l="style='BACKGROUND: #ffffff;BORDER-LEFT: #000000 1px solid;BORDER-RIGHT: #000000 1px solid;COLOR: #2B3934;font-family: Verdana;FONT-SIZE: 10px;font-weight: normal;padding-right:2px;padding-left:2px;'";

$Style_l_b="style='BACKGROUND: #ffffff;BORDER-BOTTOM: #000000 1px solid; BORDER-LEFT: #000000 1px solid;BORDER-RIGHT: #000000 1px solid;COLOR: #2B3934;font-family: Verdana;FONT-SIZE: 10px;font-weight: normal;padding-right:2px;padding-left:2px;'";

$Style_b="style='BACKGROUND: #ffffff;BORDER-BOTTOM: #000000 1px solid;BORDER-RIGHT: #000000 1px solid;COLOR: #2B3934;font-family: Verdana;FONT-SIZE: 10px;font-weight: normal;padding-right:2px;padding-left:2px;'";

$TotalRow=mysql_num_rows($resultInvoiceInfo);
$i=0;
while($rowInvoiceInfo=mysql_fetch_array($resultInvoiceInfo))
{
        extract($rowInvoiceInfo);
        
        $Office_Address=nl2br($Office_Address);
        $Office_Address=str_replace("   ","&nbsp;","$Office_Address");

        //-------------- format the unit price---------------
        $unit_price=number_format($unit_price,2,'.','');

        //-------------- format the total price---------------
        $total_price=number_format($total_price,2,'.','');

        //-------------- format the total bill---------------
        $total_bill=number_format($total_bill,2,'.','');

        //-------------- format the total vat value---------------
        $vat=number_format($vat,2,'.','');

        //-------------- format the total discount---------------
        $discount_amount=number_format($discount_amount,2,'.','');

        //-------------- format the net bill---------------
        $net_bill=number_format($net_bill,2,'.','');

if($i<1)
{
      /*----------------------This Print section Developed By: Sharif Ur Rahman Date:07-08-2008-------------------*/
      echo "
      <table width='100%' id='table1' cellspacing='0' cellpadding='0' align='center'>
            <tr>
                  <td align='center' HEIGHT='20'>
                        <div class='hide'>
                              <input type='button' name='btnPrint' value='Print' onclick='ReportPrint()'>
                        </div>
                  </td>
            </tr>
      </table>";
      /*--------------------------------- END ----------------------------------------------------------------*/
      echo"
<table border='0' width='100%' id='table2' cellspacing='0'>
      <tr>
            <td colspan='5' width='100%' class='td_e' align='center'><h2>BILL</h2></td>
      </tr>
      <tr>
            <td colspan='2' width='40%' class='td_e'>To</td>
            <td width='30%' rowspan='7' class='td_e'>&nbsp;</td>
            <td align='left' width='10%' class='td_e'>Bill No</td>
            <td align='left' width='20%' class='td_e'>:$invoice_number</td>
      </tr>
      <tr>
            <td colspan='2' width='40%' class='td_e'>$Contact_Person</td>
            <td align='right' width='10%' class='td_e'>&nbsp;</td>
            <td align='left' width='20%' class='td_e'>&nbsp;</td>
      </tr>
      <tr>
            <td colspan='2' width='40%' class='td_e'>$Company_Name</td>
            <td align='left' width='10%' class='td_e'>Date</td>
            <td align='left' width='20%' class='td_e'>:$BillDate</td>
      </tr>
      <tr>
            <td colspan='2' width='40%' rowspan='2' class='td_e'>$Office_Address</td>
            <td align='right' width='10%' class='td_e'>&nbsp;</td>
            <td align='left' width='20%' class='td_e'>&nbsp;</td>
      </tr>
      <tr>
            <td align='left' width='10%' class='td_e'>Order No</td>
            <td align='left' width='20%' class='td_e'>:$order_number</td>
      </tr>
      <tr>
            <td align='left' width='15%' class='td_e'>User Ref No</td>
            <td align='left' width='25%' class='td_e'>:&nbsp;</td>
            <td align='right' width='10%' class='td_e'>&nbsp;</td>
            <td align='left' width='20%' class='td_e'>&nbsp;</td>
      </tr>
      <tr>
            <td align='left' width='15%' class='td_e'>Date</td>
            <td align='left' width='25%' class='td_e'>:$TodayDate</td>
            <td align='left' width='10%' class='td_e'>Date</td>
            <td align='left' width='20%' class='td_e'>:$OrderDate</td>
      </tr>
      <tr>
            <td colspan='4' height='10'></td>
      </tr>
</table>
<br>
";

echo"
<table border='0' width='100%' id='table3' cellspacing='0'>
        <tr>
                <td align='left' width='10%' rowspan='2' class='title_cell_e_l' style='BORDER-BOTTOM: #000000 1px solid;'>Date</td>
                <td align='left' width='10%' rowspan='2' class='title_cell_e' style='BORDER-BOTTOM: #000000 1px solid;'>Challan No</td>
                <td align='left' width='10%' rowspan='2' class='title_cell_e' style='BORDER-BOTTOM: #000000 1px solid;'>Job No</td>
                <td width='30%' align='left' rowspan='2' class='title_cell_e' style='BORDER-BOTTOM: #000000 1px solid;'>Description</td>
                <td align='center' width='18%' colspan='2' class='title_cell_e'>To Supply</td>
                <td align='center' width='22%' colspan='2' class='title_cell_e'>Price</td>
        </tr>
        <tr>
                <td align='center' width='8%' class='sub_title_cell_e' style='BORDER-BOTTOM: #000000 1px solid;'>Unit</td>
                <td width='10%' class='sub_title_cell_e' style='BORDER-BOTTOM: #000000 1px solid;'>Qnty.</td>
                <td align='right' width='10%' class='sub_title_cell_e' style='BORDER-BOTTOM: #000000 1px solid;'>Unit</td>
                <td align='right' width='12%' class='sub_title_cell_e' style='BORDER-BOTTOM: #000000 1px solid;'>Total</td>
        </tr>
";

}


if($i==$TotalRow-1)
{
        $height="height='140px'";
        $Valign="valign='top'";
        $Style=$Style_b;
        $Style_l=$Style_l_b;
}
else
{
        $height="";
        $Valign="valign='top'";
        $Style=$Style;
        $Style_l=$Style_l;

}
echo"
        <tr>
                <td align='left' width='10%' $height $Valign $Style_l>$ChallanDate</td>
                <td align='left' width='10%' $height $Valign $Style>$challan_no</td>
                <td align='left' width='10%' $height $Valign $Style>$job_no</td>
                <td align='left' width='30%'  $height $Valign $Style>$product_name</td>
                <td align='center' width='8%' $height $Valign $Style>$unitdesc</td>
                <td align='center' width='10%' $height $Valign $Style>$total_quantity</td>
                <td align='right' width='10%' $height $Valign $Style>$unit_price</td>
                <td align='right' width='12%' $height $Valign $Style>$total_price</td>
        </tr>
";



$i++;
}
echo"   <tr>
                <td align='right' width='88%' class='td_e' colspan='7' style='BORDER-TOP: #000000 0px solid;BORDER-LEFT: #000000 1px solid;BORDER-RIGHT: #000000 0px solid;BORDER-BOTTOM: #000000 0px solid;'>Sub Total:</td>
                <td align='right' width='12%' class='td_e' style='BORDER-TOP: #000000 0px solid;BORDER-LEFT: #000000 0px solid;BORDER-RIGHT: #000000 1px solid;BORDER-BOTTOM: #000000 0px solid;'><b>".number_format($total_bill,2,'.',',')."</b></td>
        </tr>
";
if($vat>0)
{
echo"   <tr>
                <td align='right' width='88%' class='td_e' colspan='7' style='BORDER-TOP: #000000 0px solid;BORDER-LEFT: #000000 1px solid;BORDER-RIGHT: #000000 0px solid;BORDER-BOTTOM: #000000 0px solid;'>Add Vat($vat_parcent%):</td>
                <td align='right' width='12%' class='td_e' style='BORDER-TOP: #000000 0px solid;BORDER-LEFT: #000000 0px solid;BORDER-RIGHT: #000000 1px solid;BORDER-BOTTOM: #000000 0px solid;'>".number_format($vat,2,'.',',')."</td>
        </tr>
";
}

if($discount_amount>0)
{
echo"   <tr>
                <td align='right' width='88%' class='td_e' colspan='7' style='BORDER-TOP: #000000 0px solid;BORDER-LEFT: #000000 1px solid;BORDER-RIGHT: #000000 0px solid;BORDER-BOTTOM: #000000 0px solid;'>Discount:</td>
                <td align='right' width='12%' class='td_e' style='BORDER-TOP: #000000 0px solid;BORDER-LEFT: #000000 0px solid;BORDER-RIGHT: #000000 1px solid;BORDER-BOTTOM: #000000 0px solid;'>$discount_amount</td>
        </tr>
";
}

$Inword=InWords($net_bill,"Taka");
echo"   <tr>
                <td align='right' width='10%' class='td_e'  style='BORDER-TOP: #000000 1px solid;BORDER-LEFT: #000000 1px solid;BORDER-RIGHT: #000000 0px solid;BORDER-BOTTOM: #000000 1px solid;'>Total:</td>
                <td width='78%' class='td_e' colspan='6' align='left'  style='BORDER-TOP: #000000 1px solid;BORDER-LEFT: #000000 0px solid;BORDER-RIGHT: #000000 0px solid;BORDER-BOTTOM: #000000 1px solid;'><b>$Inword</b></td>
                <td align='right' width='12%' class='td_e'  style='BORDER-TOP: #000000 1px solid;BORDER-LEFT: #000000 0px solid;BORDER-RIGHT: #000000 1px solid;BORDER-BOTTOM: #000000 1px solid;'><b>".number_format($net_bill,2,'.',',')."</b></td>
        </tr>
        <tr>
            <td class='td_e' colspan='8'>&nbsp;</td>
        </tr>
        <tr>
            <td class='td_e' colspan='8' style='padding-left: 8px;'>Payment Term:$payment_terms</td>
        </tr>
        <tr>
            <td class='td_e' colspan='8' height='45'>&nbsp;</td>
        </tr>
        <tr>
                <td class='td_e' colspan='3' width='100%' style='padding-left: 8px;'>Prepared By:</td>
                <td class='td_e' colspan='2' width='100%' align='center'>Checked By:</td>
                <td class='td_e' colspan='3' width='100%' align='right'>Authorized By:</td>
        </tr>
</table><br><br>";


?>

</form>
</body>
</html>
