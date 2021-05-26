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

<link rel='stylesheet' type='text/css' href='Style/eng_report.css' />
<link rel='stylesheet' type='text/css' href='Style/interface_styles.css' />

<script language="JavaScript" src="Script/NumberFormat.js"></script>

<script language="JavaScript" src="Script/calendar1.js"></script>

<script language='JavaScript'>


function Submitfrom()
{
      if(document.frmEmployeeEntry.txtempno.value=='' )
      {
            alert("You Must Enter Employee No");
            document.frmEmployeeEntry.txtempno.focus();
      }
      else if(document.frmEmployeeEntry.txtempname.value=='' )
      {
            alert("You Must Enter Employee Name");
            document.frmEmployeeEntry.txtempname.focus();
      }
      else
      {
            document.frmEmployeeEntry.submit();
      }
}
function CreateNewParty()
{
        var popit=window.open('EmployeeInfoEntry.php','console','status,scrollbars,width=700,height=300');
}

function EditPartyEntry(val)
{
        var popit=window.open("EmpInfoUpdate.php?EmployeeID="+val+"",'console','status,scrollbars,width=700,height=300');
}


</script>

</head>
<div class='page'>
<body class='body_e'>




<form name='frmEmployeeEntry' method='post' action='AddToEmployeeEntry.php'>



<?PHP
        if($cboDay=='')
        {
                $TrnLCInfo="SELECT
                                mas_order_planed.`order_object_id`,
                                date_format(planed_date,'%d-%m-%Y') as planed_date ,
                                machine_id,
                                planqtymm,
                                planqtykg,
                                starttime,
                                endtime,
                                SUBTIME(endtime,starttime) as esttime,
                                mas_item,
                                sub_item,
                                mas_order_planed.remarks,
                                mas_machine.machine_name,
                                mas_machine.speed,
                                mas_order.job_no,
                                mas_customer.company_name,
                                mas_order_production.actualhour,
                                a.qty
                        FROM
                                mas_order_planed
                                inner join mas_order on mas_order.order_object_id=mas_order_planed.order_object_id
                                left join mas_order_production on mas_order_production.plan_object_id=mas_order_planed.plan_object_id
                                left join mas_machine on mas_machine.machine_object_id=mas_order_planed.machine_id
                                left join mas_customer on mas_customer.customer_id=mas_order.customer_id
                                left join (select order_object_id, sum(trn_order_description.order_quntity) as qty from trn_order_description group by trn_order_description.order_object_id  ) as a on a.order_object_id=mas_order.order_object_id
                        WHERE
                                planed_date between str_to_date('1-$cboMonth-$cboYear','%d-%m-%Y') and last_day(str_to_date('1-$cboMonth-$cboYear','%d-%m-%Y'))

                  ";
        }
        else
        {
                $TrnLCInfo="SELECT
                                mas_order_planed.order_object_id,
                                date_format(planed_date,'%d-%m-%Y') as planed_date ,
                                machine_id,
                                planqtymm,
                                planqtykg,
                                starttime,
                                endtime,
                                SUBTIME(endtime,starttime) as esttime,
                                mas_item,
                                sub_item,
                                mas_order_planed.remarks,
                                mas_machine.machine_name,
                                mas_machine.speed,
                                mas_order.job_no,
                                mas_customer.company_name,
                                mas_order_production.actualhour,
                                a.qty
                        FROM
                                mas_order_planed
                                inner join mas_order on mas_order.order_object_id=mas_order_planed.order_object_id
                                left join mas_order_production on mas_order_production.plan_object_id=mas_order_planed.plan_object_id
                                left join mas_machine on mas_machine.machine_object_id=mas_order_planed.machine_id
                                left join mas_customer on mas_customer.customer_id=mas_order.customer_id
                                left join (select order_object_id, sum(trn_order_description.order_quntity) as qty from trn_order_description group by trn_order_description.order_object_id  ) as a on a.order_object_id=mas_order.order_object_id
                        WHERE
                                planed_date = str_to_date('$cboDay-$cboMonth-$cboYear','%d-%m-%Y')

                          ";
        }
      //echo  $TrnLCInfo;

      $resultTrnLCInfo=mysql_query($TrnLCInfo) or die(mysql_error());
      $j=0;
      if(mysql_num_rows($resultTrnLCInfo)>0)
      {
            //echo ";
            if($cboDay=='')
                drawCompanyInformation("Action Plan ","For the month of ".date("F, Y", mktime(0, 0, 0, $cboMonth,1,$cboYear)));
            else
                drawCompanyInformation("Action Plan ","For the date ".date("j F, Y", mktime(0, 0, 0, $cboMonth,$cboDay,$cboYear)));
                  echo "<table border='1' width='100%' id='table1' cellpadding='0' cellspacing='0'>
                  <tr>
                        <td class='title_cell_e_l'>Date</td>
                        <td class='title_cell_e'>Job No</td>
                        <td class='title_cell_e'>Item</td>
                        <td class='title_cell_e'>Company</td>
                        <td class='title_cell_e'>Order Qty</td>
                        <td class='title_cell_e'>Materials</td>
                        <td class='title_cell_e'>Qty-Kg/m</td>
                        <td class='title_cell_e'>Speed</td>
                        <td class='title_cell_e'>Duration</td>
                        <td class='title_cell_e'>e.Hou</td>
                        <td class='title_cell_e'>Machine</td>
                        <td class='title_cell_e'>C.Hou</td>
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
                        
                        <td class='$lcls' >$planed_date&nbsp;</td>
                        <td class='$cls' >$job_no&nbsp;</td>
                        <td class='$cls' >$itemdesc&nbsp;</td>
                        <td class='$cls' >$company_name&nbsp;</td>
                        <td class='$cls' align='Right'>".number_format($qty,2,'.',',')."</td>
                        <td class='$cls' >$mainitem-$subitem</td>
                        <td class='$cls' > $planqtykg kg=$planqtymm mm &nbsp;</td>
                        <td class='$cls' >$speed m/m</td>
                        <td class='$cls' >$starttime - $endtime &nbsp;</td>
                        <td class='$cls' >$esttime</td>
                        <td class='$cls' >$machine_name &nbsp;</td>
                        <td class='$cls' >$actualhour&nbsp;</td>
                        <td class='$cls' >$remarks &nbsp;</td>
                        
                        
                  </tr>" ;
                  $i++;
            }
            echo"

                        </table>
                        " ;
            }
?>




</form>



</body>
</div>
</html>
