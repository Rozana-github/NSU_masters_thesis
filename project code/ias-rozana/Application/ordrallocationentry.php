<?PHP
include "Library/SessionValidate.php";
include "Library/dbconnect.php";
 include "Library/Library.php";

?>
<html>

<head>

<title>Calendar Example 1</title>

<link rel="stylesheet" type="text/css" href="Style/calendar.css" />
<link rel='stylesheet' type='text/css' href='Style/eng_form.css'>
<link rel='stylesheet' type='text/css' href='Style/generic_form.css'>
<script language="JavaScript" src="Script/calendar1.js"></script>
<script language="javascript">
function viewCalender()
{
      var sYear = document.frm1.ddlYear.options[document.frm1.ddlYear.selectedIndex].value;
      var sMonth = document.frm1.ddlMonth.options[document.frm1.ddlMonth.selectedIndex].value;
      
      window.location="ordrallocation.php?calender1_month="+sMonth+"&calender1_year="+sYear;
}      

function submitAllocation()
{
      if(document.frm1.txtAllocationDate.value=='')
          {
                alert('Empty Date.');
          }
          else
          {
                var allocationDate = document.frm1.txtAllocationDate.value;
                var serialNo = document.frm1.sNo.value;
                var dateString = allocationDate.split('-',3);
                var starttime=document.frm1.cbostarthour.value;
                var endtime=document.frm1.cboendhour.value;
                var machine=document.frm1.cbomachine.value;
                var qtym=document.frm1.qtymm.value;
                var qtyk=document.frm1.qtykg.value;
                var mainitem=document.frm1.cbomainitem.value;
                var subitem=document.frm1.cbosubitem.value;
                var remarks=document.frm1.txtremarks.value;
                window.location='AddToorderallocation.php?aDate='+allocationDate+'&sNo='+serialNo+'&item='+mainitem+'&subitem='+subitem+'&qtykg='+qtyk+'&qtymm='+qtym+'&stime='+starttime+'&etime='+endtime+'&mname='+machine+'&planremarks='+remarks;
                }
}

function redirectPage(day,month,year)
{
      window.location="ordrallocation.php?calender1_Day="+day;//+"calender1_month="+month+"&calender1_year="+year;
}
</script>
</head>

<body>
<form name="frm1" method="post">
<table align="center" width="100%" cellpadding="0" cellspacing="0">
<tr>
      <td align="center" height="30" class='header_cell_e'><b>Order Planed</b></td>
</tr>
<tr>
      <td align="center">
            <table width="100%" align="center" cellpadding="0" cellspacing="0">
            <tr>



                  <td  class='caption_e'>Allocation Date</td>
                  <?PHP
                        echo "<input type='hidden' name='sNo' value='$serial_no'>";
                        echo"<td colspan='3' class='td_e'>
                              <input type='text' name='txtAllocationDate' size='10'  class='input_e'>
                                    <a href=\"javascript:ComplainDate.popup();\">
                                          <img src=\"img/cal.gif\" width='13' height='13' border='0' alt=\"Click Here to Pick up the date\">
                                          </a>
                        </td>
                        <script language=\"JavaScript\">

                                          var ComplainDate = new calendar1(document.forms['frm1'].elements['txtAllocationDate']);
                                          ComplainDate.year_scroll = true;
                                          ComplainDate.time_comp = false;

                                    </script>";

                  ?>
                  <tr>
                  <td  class='caption_e'>Start Time</td>
                  <?PHP
                     echo"<td  class='td_e'><select name='cbostarthour' class='select_e'>";comboHour($CurDate); echo"</select></td>";
                  ?>
                  <td  class='caption_e'>End Time</td>
                  <?PHP
                        echo"<td  class='td_e'><select name='cboendhour' class='select_e'>";comboHour($CurDate); echo"</select></td>";
                  ?>
                  </tr>
                  <tr>
                  <td  class='caption_e'>Machine</td>
                   <?PHP
                        echo "<td  class='td_e' colspan='3'><select name='cbomachine' class='select_e'>";createCombo("Machine","mas_machine","machine_object_id","machine_name","",""); echo"</select></td>";
                   ?>
                   </tr>
                   <tr>
                  <td  class='caption_e'>Qty.(mm)</td>
                  <?PHP
                        echo"<td  class='td_e'><input type='text' name='qtymm' size='5' class='input_e'></td>";
                  ?>
                  
                  <td  class='caption_e'>Qty.(kg)</td>
                  <?PHP
                        echo"<td  class='td_e'><input type='text' name='qtykg' size='5' class='input_e'></td>";
                  ?>
                  </tr>
                  <tr>
                  <td  class='caption_e'>Materials</td>
                  <?PHP
                        echo"<td  class='td_e' colspan='3'><select name='cbomainitem' class='select_e'>";createCombo("Item","mas_item","itemcode","itemdescription","left join trn_order on trn_order.mas_item=mas_item.itemcode  where trn_order.order_object_id='$serial_no'",""); echo"</select>
                        <select name='cbosubitem' class='select_e'>";createCombo("Sub-Item","mas_item","itemcode","itemdescription","left join trn_order on trn_order.sub_item=mas_item.itemcode where trn_order.order_object_id='$serial_no'",""); echo"</select></td>";
                  ?>

                  </tr>
                  <tr>
                  <td  class='caption_e'>Remarks</td>
                  
                  <?PHP
                        echo"<td  class='td_e' colspan='3'><input type='text' name='txtremarks' size='30' class='input_e'></td>";
                  ?>
                  </tr>

                  <tr>
                        <td class='button_cell_e' align='center' colspan='4'>
                                <input type='Button' value='Submit' class='forms_button_e' onclick=submitAllocation()>
                        </td>
                  </tr>

            </table>
      </td>
</tr>
</table>
<?PHP
            /*$objectid=$serial_no;
            include "Rptorderdetails.php";*/
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
                                    mas_order.order_object_id='$serial_no'
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
            order_object_id='$serial_no' ";
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


      echo"
<table border='0' width='100%' id='table2' cellspacing='0'>
      <tr>
            <td colspan='6' width='100%'  align='center'><h4>ORDER FORM</h4></td>
      </tr>
     <tr>
                        <td width='10%' align='right' >Name&nbsp; :</td>
                        <td width='27%' >$Company_Name</td>
                        <td width='14%' >&nbsp;</td>
                        <td width='14%' >&nbsp;</td>
                        <td width='13%' >&nbsp;</td>
                        <td width='18%' >&nbsp;</td>
                  </tr>


                  <tr height='60'>
                        <td align='right' >Address :</td>
                        <td >$Office_Address</td>
                        <td> &nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                  </tr>
                  <tr>
                        <td >&nbsp;</td>
                        <td>&nbsp;</td>
                        <td align='right' >
                        Date :</td>
                        <td height='23' >$order_date</td>
                        <td align='right' >
                        Job No :</td>
                        <td >$job_no</td>
                  </tr>
                  <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                  </tr>
                  <tr align='center' >
                        <td class='title_cell_e'>Sl .No.</td>
                        <td class='title_cell_e'>DESCRIPTION</td>
                        <td class='title_cell_e'>Quantity</td>
                        <td class='title_cell_e'>Rate</td>
                        <td class='title_cell_e'>Amount</td>
                        <td class='title_cell_e'>Remarks</td>
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
                        //$inword=InWords(round($total_amount),"Taka");
                  echo "$inword&nbsp;</td>

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




            </table>
            ";


            //Insert the allocation date
            if(isset($_GET['aDate']) && isset($_GET['sNo']))
            {
                  $allocationDate = $_GET['aDate'];
                  $a=split("-",$_GET['aDate']);
                  $date=$a[2]."-".$a[1]."-".$a[0];
                  $i=$_GET['sl'];
                  //Insert Query
                  
                  $query="insert into
                                    mas_order_planed
                                    (
                                          order_object_id,
                                          planed_date,
                                          machine_id,
                                          starttime,
                                          endtime,
                                          remarks,
                                          planqtykg,
                                          planqtymm,
                                          mas_item,
                                          sub_item,
                                          status,
                                          entry_by,
                                          entry_date
                                    )
                                    values
                                    (
                                          ".$_GET['sNo'].",
                                          '".$date."',
                                          '".$_GET['mname']."',
                                          '".$_GET['stime']."',
                                          '".$_GET['etime']."',
                                          '".$_GET['planremarks']."',
                                          '".$_GET['qtykg']."',
                                          '".$_GET['qtymm']."',
                                          '".$_GET['item']."',
                                          '".$_GET['subitem']."',
                                          '0',
                                          '$SUserID',
                                          sysdate()
                                          
                                    )
                        ";
                echo $query;
                  $rset=mysql_query($query) or die(mysql_error());
                  $update_mas_order="update
                                          mas_order
                                    set
                                          product_status='1'
                                    where
                                          order_object_id=".$_GET['sNo']."
                                    ";
                   mysql_query($update_mas_order)or die(mysql_error());
                  
                  echo '
                  <script language="javascript">
                        redirectPage('.$a[0].','.$a[1].','.$a[2].');
                  </script>
                  ';
            }
?>
</form>
<script language="JavaScript">
        // create calendar object(s) just after form tag closed
        // specify form element as the only parameter (document.forms['formname'].elements['inputname']);
        // note: you can have as many calendar objects as you need for your application
            //alert(document.forms['frm1'].elements['txtAllocationDate'].name);
            /*function calenderCall(target)
            {
                  var allocationDate = new calendar1(document.forms['frm1'].elements['txtAllocationDate'+target]);
                  allocationDate.year_scroll = true;
                  allocationDate.time_comp = false;
                  allocationDate.popup();
            }*/
</script>
</body>
</html>
