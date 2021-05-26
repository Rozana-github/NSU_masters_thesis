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
    $TrnLCInfo="select
                        wipobjectid,
                        date_format(`pdate`,'%d-%m-%Y') as pdate,
                        `wip_month`,
                        `wip_year`,
                        `job_no`,
                        `job_name`,
                        `company_id`,
                        `job_quantity`,
                        `pet_quantity`,
                        `pet_rate`,
                        `bopp_quantity`,
                        `bopp_rate`,
                        `ink_quantity`,
                        `ink_rate`,
                        `adive_quantity`,
                        `adive_rate`,
                        `solvt_quantity`,
                        `solvt_rate`,
                        `mcpp_quantity`,
                        `mcpp_rate`,
                        `mpet_quantity`,
                        `mpet_rate`,
                        `foil_quantity`,
                        `foil_rate`,
                        `lf_quantity`,
                        `lf_rate`,
                        `mf_quantity`,
                        `mf_rate`,
                        `tm_cost`,
                        `oh`,
                        oh_rate,
                        `t_cost`,
                        `e_type`,
                        company_name

                  from
                        mas_wip
                        LEFT JOIN mas_customer ON mas_customer.customer_id=mas_wip.company_id
                  where
                        wip_month='$cboMonth'
                        and wip_year='$cboYear'
                  ";
      //echo  $TrnLCInfo;

      $resultTrnLCInfo=mysql_query($TrnLCInfo) or die(mysql_error());
      $j=0;
      if(mysql_num_rows($resultTrnLCInfo)>0)
      {
            //echo ";
            drawCompanyInformation("Report Work In Progress ","For the month of ".date("F, Y", mktime(0, 0, 0, $cboMonth,1,$cboYear)));
                  echo "<table border='1' width='100%' id='table1' cellpadding='0' cellspacing='0'>
                  <tr>
                        <td class='title_cell_e_l'>P.Date</td>
                        <td class='title_cell_e'>Job No</td>
                        <td class='title_cell_e'>Job Name</td>
                        <td class='title_cell_e'>Company</td>
                        <td class='title_cell_e'>Kg</td>
                        <td class='title_cell_e'>Pet</td>
                        <td class='title_cell_e'>Bopp</td>
                        <td class='title_cell_e'>Ink</td>
                        <td class='title_cell_e'>Adive.</td>
                        <td class='title_cell_e'>Solvt.</td>
                        <td class='title_cell_e'>Mcpp</td>
                        <td class='title_cell_e'>Mpet</td>
                        <td class='title_cell_e'>Foil</td>
                        <td class='title_cell_e'>L.F</td>
                        <td class='title_cell_e'>M.F</td>
                        <td class='title_cell_e'>T.M.Cost</td>
                        <td class='title_cell_e'>O.H</td>
                        <td class='title_cell_e'>T.Cost</td>

                  </tr>";
                              $totaljob=0;
                              $totalpet=0;
                              $totalbopp=0;
                              $totalink=0;
                              $totaladive=0;
                              $totalsolvt=0;
                        $totalmcpp=0;
                        $totalmpet=0;
                        $totalfoil=0;
                        $totallf=0;
                        $totalmf=0;
                        $totaltm=0;
                        $totaloh=0;
                        $totalt_cost=0;
                                    $i=0;
            while($rowTrnLCInfo=mysql_fetch_array($resultTrnLCInfo))
            {
                  extract($rowTrnLCInfo);
                  if($e_type=='1')
                        $edesc="R/D";
                  else if($e_type=='2')
                        $edesc="P/C";
                  else if($e_type=='3')
                        $edesc="L/C";
                  else
                        $edesc="";
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
                  
                  $totaljob=$totaljob+$job_quantity;
                  $totalpet=$totalpet+$pet_quantity;
                  $totalbopp=$totalbopp+$bopp_quantity;
                  $totalink=$totalink+$ink_quantity;
                  $totaladive=$totaladive+$adive_quantity;
                  $totalsolvt=$totalsolvt+$solvt_quantity;
                        $totalmcpp=$totalmcpp+$mcpp_quantity;
                        $totalmpet=$totalmpet+$mpet_quantity;
                        $totalfoil= $totalfoil+$foil_quantity;
                        $totallf=$totallf+$lf_quantity;
                        $totalmf=$totalmf+$mf_quantity;
                        $totaltm=$totaltm+$tm_cost;
                        $totaloh=$totaloh+$oh;
                        $totalt_cost=$totalt_cost+$t_cost;

                  echo"<tr >
                        
                        <td class='$lcls' align='center'>$pdate&nbsp;</td>
                        <td class='$cls' align='center'>$job_no&nbsp;</td>
                        <td class='$cls' align='center'>$job_name&nbsp;</td>
                        <td class='$cls' align='center'>$company_name($edesc)&nbsp;</td>
                        <td class='$cls' align='Right'>".number_format($job_quantity,2,'.',',')."</td>
                        <td class='$cls' align='Right'>".number_format($pet_quantity,2,'.',',')."</td>
                        <td class='$cls' align='Right'>".number_format($bopp_quantity,2,'.',',')."</td>
                        <td class='$cls' align='Right'>".number_format($ink_quantity,2,'.',',')."</td>
                        <td class='$cls' align='Right'>".number_format($adive_quantity,2,'.',',')."</td>
                        <td class='$cls' align='Right'>".number_format($solvt_quantity,2,'.',',')."</td>
                        <td class='$cls' align='Right'>".number_format($mcpp_quantity,2,'.',',')."</td>
                        <td class='$cls' align='Right'>".number_format($mpet_quantity,2,'.',',')."</td>
                        <td class='$cls' align='Right'>".number_format($foil_quantity,2,'.',',')."</td>
                        <td class='$cls' align='Right'>".number_format($lf_quantity,2,'.',',')."</td>
                        <td class='$cls' align='Right'>".number_format($mf_quantity,2,'.',',')."</td>
                        <td class='$cls' align='Right'>".number_format($tm_cost,2,'.',',')."</td>
                        <td class='$cls' align='Right'>".number_format($oh,2,'.',',')."</td>
                        <td class='$cls' align='Right'>".number_format($t_cost,2,'.',',')."</td>
                        
                  </tr>" ;
                  $i++;
            }
            echo"<tr>
                                    <td class='$lcls' align='Right' colspan='4'>Total</td>
                        <td class='$cls' align='Right'>".number_format($totaljob,2,'.',',')."</td>
                        <td class='$cls' align='Right'>".number_format($totalpet,2,'.',',')."</td>
                        <td class='$cls' align='Right'>".number_format($totalbopp,2,'.',',')."</td>
                        <td class='$cls' align='Right'>".number_format($totalink,2,'.',',')."</td>
                        <td class='$cls' align='Right'>".number_format($totaladive,2,'.',',')."</td>
                        <td class='$cls' align='Right'>".number_format($totalsolvt,2,'.',',')."</td>
                        <td class='$cls' align='Right'>".number_format($totalmcpp,2,'.',',')."</td>
                        <td class='$cls' align='Right'>".number_format($totalmpet,2,'.',',')."</td>
                        <td class='$cls' align='Right'>".number_format($totalfoil,2,'.',',')."</td>
                        <td class='$cls' align='Right'>".number_format($totallf,2,'.',',')."</td>
                        <td class='$cls' align='Right'>".number_format($totalmf,2,'.',',')."</td>
                        <td class='$cls' align='Right'>".number_format($totaltm,2,'.',',')."</td>
                        <td class='$cls' align='Right'>".number_format($totaloh,2,'.',',')."</td>
                        <td class='$cls' align='Right'>".number_format($totalt_cost,2,'.',',')."</td>
                        
                  </tr>

                        </table>
                        " ;
            }
?>




</form>



</body>
</div>
</html>
