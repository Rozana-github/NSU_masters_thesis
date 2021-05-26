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
$searchinvoiceInfo="SELECT
                                    trn_order_description.order_desc_object_id,
                                    mas_order.order_object_id,
                                    mas_order.job_no,
                                    trn_order_description.order_description,
                                    mas_customer.customer_id,
                                    Company_Name,
                                    office_address,
                                    date_format(mas_order.order_date,'%d-%m-%Y') as order_date,
                                    trn_order_description.order_quntity,
                                    trn_order_description.order_unit ,
                                    trn_order_description.order_rate,
                                    trn_order_description.order_amount,
                                    total_amount,
                                    vat_status,
                                    date_format(first_proof_date,'%d-%m-%Y') as first_proof_date,
                                    date_format(final_proof_date,'%d-%m-%Y') final_proof_date,
                                    date_format(printing_order_date,'%d-%m-%Y') printing_order_date,
                                    date_format(delivery_date,'%d-%m-%Y') delivery_date,
                                    size,
                                    order_status,
                                    product_status,
                                    paid_on_order_amount,
                                    due_on_delivery_amount,
                                    remarks
                              FROM
                                    mas_order
                                    LEFT JOIN mas_customer ON mas_customer.customer_id = mas_order.customer_id
                                    left join trn_order_description on trn_order_description.order_object_id=mas_order.order_object_id
                              where
                                    mas_order.order_object_id='$objectid'
                ";
//echo $searchinvoiceInfo;
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

        $slno=$slno.($i+1)."<br>";
        $unit=pick("mas_unit","unitdesc","unitid=$order_unit");

        $printdescription=$printdescription.$order_description."<br>";
        $printqty=$printqty.$order_quntity." ".$unit."<br>";
        $printrate=$printrate.$order_rate."<br>";
        $printamount=$printamount.$order_amount."<br>";
        
        $Office_Address=nl2br($office_address);
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
        $i++;

}

$querytrn="SELECT 
            mas_item ,
            sub_item
      FROM       
            trn_order
      WHERE 
            order_object_id='$objectid' ";
$rstrn=mysql_query($querytrn)or die(mysql_error());
while($rowtrn=mysql_fetch_array($rstrn))
{
      extract($rowtrn);
      $mainitem=pick("mas_item","itemdescription","itemcode=$mas_item");
        $subitem=pick("mas_item","itemdescription","itemcode=$sub_item");
      $stracture=$stracture.$mainitem.'-'.$subitem.'<br>';
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
      </table>
<br>
<br>
<br>
<br>
<br>";
      
      echo"
<table border='0' width='100%' id='table2' cellspacing='0'>
      <tr>
            <td colspan='6' width='100%' class='td_e' align='center'><h4>ORDER FORM</h4></td>
      </tr>
     <tr>
                        <td width='10%' align='right' class='td_e'>Name&nbsp; :</td>
                        <td width='27%' class='td_e'>$Company_Name</td>
                        <td width='14%' class='td_e'>&nbsp;</td>
                        <td width='14%' class='td_e'>&nbsp;</td>
                        <td width='13%' class='td_e'>&nbsp;</td>
                        <td width='18%' class='td_e'>&nbsp;</td>
                  </tr>


                  <tr height='60'>
                        <td align='right' class='td_e'>Address :</td>
                        <td class='td_e'>$Office_Address</td>
                        <td> &nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                  </tr>
                  <tr>
                        <td class='td_e'>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td align='right' class='td_e'>
                        Date :</td>
                        <td height='23' class='td_e'>$order_date</td>
                        <td align='right' class='td_e'>
                        Job No :</td>
                        <td class='td_e'>$job_no</td>
                  </tr>
                  <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                  </tr>
                  <tr align='center' height='40'>
                        <td class='title_cell_e_l'>Sl .No.</td>
                        <td class='title_cell_e_l'>DESCRIPTION</td>
                        <td class='title_cell_e_l'>Quantity</td>
                        <td class='title_cell_e_l'>Rate</td>
                        <td class='title_cell_e_l'>Amount</td>
                        <td class='title_cell_e_l'>Remarks</td>
                  </tr>
                  <tr>
                        <td height='140' $height $Valign $Style_l>$slno</td>
                        <td  $height $Valign $Style>$printdescription <br> <br>$stracture</td>
                        <td  align='right' align='right' $height $Valign $Style>$printqty  ";
                  echo " </td>
                        <td align='right' $height $Valign $Style>$printrate</td>
                        <td align='right' $height $Valign $Style>$printamount</td>
                        <td $height $Valign $Style>$remarks <br><br><br>

                        <b>Estemated Dtate of</b>
                        <br><br>
                        1st Proof: $first_proof_date
                        <br>
                        <br>
                        Final Proof: $final_proof_date
                        <br>
                        <br>
                        Print Order: $printing_order_date
                        <br>
                        <br>
                        Delivery: $delivery_date
                        </td>
                  </tr>


                  <tr>
                        <td align='left' height=23' class='td_e' class='td_e'  style='BORDER-TOP: #000000 1px solid;BORDER-LEFT: #000000 1px solid;BORDER-RIGHT: #000000 0px solid;BORDER-BOTTOM: #000000 1px solid;'>Total(Taka) :</td>
                        <td height='23' colspan='3' class='td_e' class='td_e'  style='BORDER-TOP: #000000 1px solid;BORDER-LEFT: #000000 1px solid;BORDER-RIGHT: #000000 0px solid;BORDER-BOTTOM: #000000 1px solid;'>";
                        $inword=InWords(round($total_amount),"Taka");
                  echo "$inword</td>

                        <td height='23' class='td_e' class='td_e' align='right' style='BORDER-TOP: #000000 1px solid;BORDER-LEFT: #000000 1px solid;BORDER-RIGHT: #000000 0px solid;BORDER-BOTTOM: #000000 1px solid;'>$total_amount</td>
                        <td height='23' class='td_e'class='td_e'  style='BORDER-TOP: #000000 1px solid;BORDER-LEFT: #000000 1px solid;BORDER-RIGHT: #000000 1px solid;BORDER-BOTTOM: #000000 1px solid;'>&nbsp;</td>
                  </tr>
            <tr>
                        <td align='right' class='td_e'class='td_e'  style='BORDER-TOP: #000000 1px solid;BORDER-LEFT: #000000 1px solid;BORDER-RIGHT: #000000 0px solid;BORDER-BOTTOM: #000000 0px solid;'>Challan No :</td>
                        <td colspan='2' class='td_e' class='td_e'  style='BORDER-TOP: #000000 1px solid;BORDER-LEFT: #000000 1px solid;BORDER-RIGHT: #000000 0px solid;BORDER-BOTTOM: #000000 0px solid;'>&nbsp;</td>
                        <td align='right' class='td_e'class='td_e'  style='BORDER-TOP: #000000 1px solid;BORDER-LEFT: #000000 1px solid;BORDER-RIGHT: #000000 0px solid;BORDER-BOTTOM: #000000 0px solid;'>Paid on order</td>
                        <td class='td_e'class='td_e' align='right'  style='BORDER-TOP: #000000 1px solid;BORDER-LEFT: #000000 1px solid;BORDER-RIGHT: #000000 0px solid;BORDER-BOTTOM: #000000 0px solid;'>$paid_on_order_amount</td>
                        <td class='td_e'  style='BORDER-TOP: #000000 1px solid;BORDER-LEFT: #000000 1px solid;BORDER-RIGHT: #000000 1px solid;BORDER-BOTTOM: #000000 1px solid;'>&nbsp;</td>
                  </tr>
            <tr>
                        <td align='right' class='td_e' class='td_e'  style='BORDER-TOP: #000000 1px solid;BORDER-LEFT: #000000 1px solid;BORDER-RIGHT: #000000 0px solid;BORDER-BOTTOM: #000000 1px solid;'>Invoice No&nbsp; :</td>
                        <td colspan='2' class='td_e' class='td_e'  style='BORDER-TOP: #000000 1px solid;BORDER-LEFT: #000000 1px solid;BORDER-RIGHT: #000000 0px solid;BORDER-BOTTOM: #000000 1px solid;'>&nbsp;</td>
                        <td align='right' class='td_e'  style='BORDER-TOP: #000000 1px solid;BORDER-LEFT: #000000 1px solid;BORDER-RIGHT: #000000 0px solid;BORDER-BOTTOM: #000000 1px solid;'>Due on delivery</td>
                        <td  class='td_e' class='td_e' align='right'  style='BORDER-TOP: #000000 1px solid;BORDER-LEFT: #000000 1px solid;BORDER-RIGHT: #000000 0px solid;BORDER-BOTTOM: #000000 1px solid;'>$due_on_delivery_amount</td>
                        <td class='td_e' class='td_e'  style='BORDER-TOP: #000000 1px solid;BORDER-LEFT: #000000 1px solid;BORDER-RIGHT: #000000 1px solid;BORDER-BOTTOM: #000000 1px solid;'>&nbsp;</td>
                  </tr>
                  <tr  height='23'>
                        <td>&nbsp;</td>
                        <td rowspan='2'>&nbsp;</td>
                        <td height='23'>&nbsp;</td>
                        <td height='23'>&nbsp;</td>
                        <td height='23'>&nbsp;</td>
                        <td rowspan='2'>&nbsp;</td>
                  </tr>
            <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                  </tr>

            <tr align='center'>
                        <td>&nbsp;</td>
                        <td class='td_e'>Customer's Signature</td>
                        <td colspan='2' class='td_e'>CUSTOMERS COPY</td>
                        <td class='td_e'>&nbsp;</td>
                        <td class='td_e'>Order received by</td>
                  </tr>

            </table>
            ";


?>

</form>
</body>
</html>
