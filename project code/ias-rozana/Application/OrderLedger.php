<?PHP
        include_once("Library/dbconnect.php");
        include_once("Library/Library.php");

?>
<html>

<head>
<meta http-equiv='Content-Language' content='en-us'>
<meta http-equiv='Content-Type' content='text/html; charset=windows-1252'>
<title>Supplier Entry Form</title>
<link rel='stylesheet' type='text/css' href='Style/eng_report.css' />
<link href='Style/generic_report.css' type='text/css' rel='stylesheet' />
<link rel='stylesheet' type='text/css' href='Style/interface_styles.css' />
<script language="JavaScript">
function CreateNewParty()
{
        var popit=window.open('DebtorPartyEntry.php','console','status,scrollbars,width=650,height=350');
}

function EditPartyEntry(val)
{
        var popit=window.open("DebtorPartyUpdate.php?CustomerID="+val+"",'console','status,scrollbars,width=650,height=350');
}
function canceljob(id)
{
      //alert(id);
      //document.Form1.update.value='1';
      document.Form1.objectid.value=id;
      
      //document.Form1.action="OrderCancel.php";
      document.Form1.submit();
}

</script>


</head>

<body class='body_e'>
<form name='Form1' method='post'  action='Rptorderdetails.php'>
<table border='0' cellspacing='0' cellpadding='0'  width='100%' align='center'>





        <?PHP
                //echo "2222".$update;

                $searchAllInfo="SELECT
                                    mas_order.order_object_id,
                                    mas_order.job_no,
                                    date_format(mas_order.order_date,'%d-%m-%y') as order_date,
                                    trn_order_description.order_description,
                                    trn_order_description.order_quntity,
                                    trn_order_description.order_rate,
                                    trn_order_description.order_unit,
                                    trn_order_description.order_amount,
                                    mas_customer.customer_id,
                                    mas_customer.Company_Name,
                                    mas_unit.unitdesc
                              FROM
                                    mas_order
                                    left join trn_order_description on trn_order_description.order_object_id=mas_order.order_object_id
                                    LEFT JOIN mas_customer ON mas_customer.customer_id = mas_order.customer_id
                                    left join mas_unit on mas_unit.unitid=trn_order_description.order_unit
                              where
                                    mas_order.order_date between str_to_date('1-".$cboMonth."-".$cboYear."','%d-%m-%Y') and last_day(str_to_date('1-".$cboMonth."-".$cboYear."','%d-%m-%Y'))
                              order by
                                    mas_order.order_date

                                ";

                $resultAllInfo=mysql_query($searchAllInfo) or die(mysql_error());

            if(mysql_num_rows($resultAllInfo)>0)
            {
                  drawCompanyInformation("Order Ledger","For the Month of ".date('F ,Y',mktime(0, 0, 0, $cboMonth,1,$cboYear)));
                  echo "<table border='0' width='98%'  cellspacing='0' cellpadding='0' align='center'>
                  <tr>
                        <td class='title_cell_e_l'>Order Date</Td>
                        <td class='title_cell_e'>Job No</Td>
                        <td class='title_cell_e'>Company Name</Td>
                        <td class='title_cell_e'>Job Description</Td>
                        <td class='title_cell_e'>Quantity</Td>
                        <td class='title_cell_e'>Rate</Td>
                        <td class='title_cell_e'>Amount</Td>

                  </tr>";
                $i=1;
                while($rowAllInfo=mysql_fetch_array($resultAllInfo))
                {
                        extract($rowAllInfo);
                        if($i%2==0)
                        {
                              $clss='even_td_e';
                              $lclss="even_left_td_e";
                        }
                        else
                        {
                              $clss='odd_td_e';
                              $lclass="odd_left_td_e";
                        }
                        
                        $querytrn="SELECT
                                        mas_item ,
                                        sub_item
                                   FROM
                                        trn_order
                                   WHERE
                                        order_object_id='$order_object_id' ";
                        //echo
                        $stracture="";
                        $rstrn=mysql_query($querytrn)or die(mysql_error());
                        while($rowtrn=mysql_fetch_array($rstrn))
                        {
                                extract($rowtrn);
                                $mainitem=pick("mas_item","itemdescription","itemcode=$mas_item");
                                $subitem=pick("mas_item","itemdescription","itemcode=$sub_item");
                                $stracture=$stracture.$mainitem.'-'.$subitem.'<br>';
                        }
                              
                        echo"
                        <tr  >

                              <td class='$lclass' >$order_date</Td>
                              <td class='$clss' >$job_no</Td>
                              <td class='$clss' >$Company_Name&nbsp;</Td>
                              <td class='$clss' >$order_description<br>$stracture&nbsp;</Td>
                              <td class='$clss' align='right'>&nbsp;".$order_quntity." ".$unitdesc."</Td>
                              <td class='$clss' align='right'>&nbsp;".$order_rate."</Td>
                              <td class='$clss' align='right'>&nbsp;".$order_amount."</Td>

                        </tr>
                        ";
                        $i++;
                }
                 echo "</table>";
                        
            }
            else
            {
                  drawNormalMassage("Data Not Avilable");
            }
        ?>

</form>
</body>

</html>

