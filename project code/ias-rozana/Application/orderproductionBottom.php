<?PHP
session_start();

        include_once("Library/dbconnect.php");
        include_once("Library/Library.php");

?>

<html xmlns:ycode>

<style>
        yCode\:combobox {behavior: url(combobox.htc); }
</style>
<style type="text/css">
body      {margin: 2% 5%; background-color: Ivory}
h2,h3,pre      {color: DarkOrchid}
div.breakafter {page-break-after:always;
      color: silver}
div.breakbefore {page-break-before:always;
      color: silver}
</style>

<style type="text/css" media="print">
div.page  {
writing-mode: tb-rl;
height: 80%;
margin: 10% 0%;
}

div.page table {
margin-right: 80pt;
filter: progid:DXImageTransform.Microsoft.BasicImage(Rotation=1);
}
</style>

<head>

<link rel='stylesheet' type='text/css' href='Style/eng_form.css'>
<link rel='stylesheet' type='text/css' href='Style/generic_form.css'>
<link rel='stylesheet' type='text/css' href='Style/interface_styles.css' />

<script language="JavaScript" src="Script/NumberFormat.js"></script>

<script language="JavaScript" src="Script/calendar1.js"></script>

<script language='JavaScript'>


function Submitfrom(val)
{

            document.frmEmployeeEntry.submit();

}
function CreateNewParty()
{
        var popit=window.open('EmployeeInfoEntry.php','console','status,scrollbars,width=700,height=300');
}

function EditPartyEntry(val)
{
        var popit=window.open("EmpInfoUpdate.php?EmployeeID="+val+"",'console','status,scrollbars,width=700,height=300');
}
function gotoinsert(val)
{

}


</script>

</head>
<div class='page'>
<body class='body_e'>




<form name='frmEmployeeEntry' method='post' action='AddToorderproduction.php'>



<?PHP
    $TrnLCInfo="SELECT 
                        mas_order_planed.`plan_object_id`,
                        mas_order_planed.`order_object_id`,
                        date_format(`planed_date`,'%d-%m-%Y') as planed_date ,
                        machine_id,
                        planqtymm,
                        planqtykg,
                        starttime,
                        endtime,
                        endtime-starttime as esttime,
                        mas_item,
                        sub_item,
                        mas_order_planed.remarks,
                        mas_machine.machine_name,
                        mas_machine.speed,
                        mas_order.job_no,
                        mas_customer.company_name,
                        a.qty
                FROM
                        mas_order_planed
                        inner join mas_order on mas_order.order_object_id=mas_order_planed.order_object_id
                        left join mas_machine on mas_machine.machine_object_id=mas_order_planed.machine_id
                        left join mas_customer on mas_customer.customer_id=mas_order.customer_id
                        left join (select order_object_id, sum(trn_order_description.order_quntity) as qty from trn_order_description group by trn_order_description.order_object_id  ) as a on a.order_object_id=mas_order.order_object_id
                WHERE
                        planed_date = str_to_date('$cboDay-$cboMonth-$cboYear','%d-%m-%Y')

                  ";
      //echo  $TrnLCInfo;

      $resultTrnLCInfo=mysql_query($TrnLCInfo) or die(mysql_error());
      $j=0;
      if(mysql_num_rows($resultTrnLCInfo)>0)
      {
            //echo ";
            //drawCompanyInformation("Action Plan ","For the month of ".date("F, Y", mktime(0, 0, 0, $cboMonth,1,$cboYear)));
                  echo "<table border='1' width='100%' id='table1' cellpadding='0' cellspacing='0'>
                  <tr>

                        <td class='title_cell_e'>Job No</td>
                        <td class='title_cell_e'>Item</td>
                        <td class='title_cell_e'>Company</td>
                        <td class='title_cell_e'>Order Qty</td>
                        <td class='title_cell_e'>Materials</td>
                        <td class='title_cell_e'>Qty-Kg/m</td>
                        <td class='title_cell_e'>Duration</td>
                        <td class='title_cell_e'>e.Hou</td>
                        <td class='title_cell_e'>Machine</td>
                        <td class='title_cell_e'>Actual.Hou</td>
                        <td class='title_cell_e'>Product Quantity</td>
                        <td class='title_cell_e'>Remarks</td>
                        

                  </tr>";
                             
                                    $i=0;
            while($rowTrnLCInfo=mysql_fetch_array($resultTrnLCInfo))
            {
                  extract($rowTrnLCInfo);
                                  $mainitem=pick("mas_item","itemdescription","itemcode=$mas_item");
                                  $subitem=pick("mas_item","itemdescription","itemcode=$sub_item");
                                  $itemdesc=pick("trn_order_description","order_description","order_object_id='$order_object_id'");
                  
                                    if(($i%2)==0)
                              {
                                    $cls="even_td_e";
                                    $lcls="even_left_td_e";
                              }
                              else
                              {
                                    $cls="odd_td_e";
                                    $lcls="odd_left_td_e";
                              }
                 

                  echo"<tr >
                        
                        <input type='hidden' name='txtplanid[$i]' value='$plan_object_id'>
                        <td class='$cls' >$job_no&nbsp;</td>
                        <td class='$cls' >$itemdesc&nbsp;</td>
                        <td class='$cls' >$company_name&nbsp;</td>
                        <td class='$cls' align='Right'>".number_format($qty,2,'.',',')."</td>
                        <td class='$cls' >$mainitem-$subitem</td>
                        <td class='$cls' > $planqtykg kg=$planqtymm mm &nbsp;</td>
                        <td class='$cls' >$starttime - $endtime &nbsp;</td>
                        <td class='$cls' >$esttime</td>
                        <td class='$cls' >$machine_name &nbsp;</td>
                        <td class='$cls' ><input type='text' name='txtachour[$i]' value='' class='input_e' size='5'></td>
                        <td class='$cls' ><input type='text' name='txtqty[$i]' value='' class='input_e' size='5'></td>
                        <td class='$cls' ><input type='text' name='txtremarks[$i]' value='' class='input_e' size='10'></td>
                        
                        
                  </tr>" ;
                  $i++;
            }
            echo"
                        <tr>
                                <td class='button_cell_e' colspan='12' align='center'>
                                        <input type='hidden' value='$i' name='totalrow'>
                                        <input type='Button' value='Submit' name='btnsubmit' class='forms_button_e' onclick=Submitfrom($i)>
                                </td>
                        </tr>
                </table>
                " ;
            }
?>




</form>



</body>
</div>
</html>
