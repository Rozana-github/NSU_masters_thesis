<?PHP
session_start();

        include_once("Library/dbconnect.php");
        include_once("Library/Library.php");

?>

<html xmlns:ycode>

<style>
        yCode\:combobox {behavior: url(combobox.htc); }
</style>

<head>

<link rel='stylesheet' type='text/css' href='Style/eng_report.css' />
<link rel='stylesheet' type='text/css' href='Style/interface_styles.css' />

<script language="JavaScript" src="Script/NumberFormat.js"></script>

<script language="JavaScript" src="Script/calendar1.js"></script>

<script language='JavaScript'>


function Submitfrom()
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


</script>

</head>

<body class='body_e'>

<form name="Form1" method="post" action="">
<?PHP
      /*------------------ Modification ,Indentation & Add CSS BY: MD.SHARIF UR RAHMAN ------------------------*/

      /*--------------------------------------- New Table ----------------------------------------------*/
        //$cboMonth=date("m");
        //$cboYear=date("Y");
        if($deletrow=='1')
        {
            $querydel="delete from mas_wip where wipobjectid='$objectid'";
            mysql_query($querydel) or die(mysql_error());
        }

      /*--------------------------------------- New Table ----------------------------------------------*/


?>

<?PHP/*---------------------------------- -----------------------------------------------------------------*/?>

<?PHP/*---------------------------------- -----------------------------------------------------------------*/?>

<?PHP/*---------------------------------- -----------------------------------------------------------------*/?>


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
                        LEFT JOIN mas_supplier ON mas_supplier.supplier_id=mas_wip.company_id
                  where
                        wip_month='$cboMonth'
                        and wip_year='$cboYear'
                  ";
      //echo  $TrnLCInfo;

      $resultTrnLCInfo=mysql_query($TrnLCInfo) or die(mysql_error());
      $j=0;
      if(mysql_num_rows($resultTrnLCInfo)>0)
      {
            echo "<table border='1' width='100%' id='table1' cellpadding='0' cellspacing='0'>
                  <tr>
                        <td class='title_cell_e'>P.Date</td>
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
                        <td class='title_cell_e'>&nbsp;</td>
                  </tr>";
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

                  echo"<tr>
                        <input type='hidden' name='hipdate[$j]' value='$pdate'>
                        <input type='hidden' name='hijobno[$j]' value='$job_no'>
                        <input type='hidden' name='hijobname[$j]' value='$job_name'>
                        <input type='hidden' name='hicompany[$j]' value='$company_id'>
                        <input type='hidden' name='hiquantity[$j]' value='$job_quantity'>
                        <input type='hidden' name='hietype[$j]' value='$e_type'>
                        <input type='hidden' name='hibpqty[$j]' value='$bopp_quantity'>
                        <input type='hidden' name='hibprate[$j]' value='$bopp_rate'>
                        <input type='hidden' name='hiinkqty[$j]' value='$ink_quantity'>
                        <input type='hidden' name='hiinkrate[$j]' value='$ink_rate'>
                        <input type='hidden' name='hipetqty[$j]' value='$pet_quantity'>
                        <input type='hidden' name='hipetrate[$j]' value='$pet_rate'>
                        <input type='hidden' name='hiadiveqty[$j]' value='$adive_quantity'>
                        <input type='hidden' name='hiadiverate[$j]' value='$adive_rate'>
                        <input type='hidden' name='hisolvtqty[$j]' value='$solvt_quantity'>
                        <input type='hidden' name='hisolvtrate[$j]' value='$solvt_rate'>
                        <input type='hidden' name='himcppqty[$j]' value='$mcpp_quantity'>
                        <input type='hidden' name='himcpprate[$j]' value='$mcpp_rate'>
                        <input type='hidden' name='himpetqty[$j]' value='$mpet_quantity'>
                        <input type='hidden' name='himpetrate[$j]' value='$mpet_rate'>
                        <input type='hidden' name='hifoilqty[$j]' value='$foil_quantity'>
                        <input type='hidden' name='hifoilrate[$j]' value='$foil_rate'>
                        <input type='hidden' name='hilfqty[$j]' value='$lf_quantity'>
                        <input type='hidden' name='hilfrate[$j]' value='$lf_rate'>
                        <input type='hidden' name='himfqty[$j]' value='$mf_quantity'>
                        <input type='hidden' name='himfrate[$j]' value='$mf_rate'>
                        <input type='hidden' name='hitmcost[$j]' value='$tm_cost'>
                        <input type='hidden' name='hioh[$j]' value='$oh'>
                        <input type='hidden' name='hioh_rate[$j]' value='$oh_rate'>
                        <input type='hidden' name='hitcost[$j]' value='$t_cost'>
                        <td class='td_e' align='center'>$pdate</td>
                        <td class='td_e' align='center'>$job_no</td>
                        <td class='td_e' align='center'>$job_name</td>
                        <td class='td_e' align='center'>$company_name($edesc)</td>
                        <td class='td_e' align='Right'>$job_quantity</td>
                        <td class='td_e' align='Right'>$pet_quantity</td>
                        <td class='td_e' align='Right'>$bopp_quantity</td>
                        <td class='td_e' align='Right'>$ink_quantity</td>
                        <td class='td_e' align='Right'>$adive_quantity</td>
                        <td class='td_e' align='Right'>$solvt_quantity</td>
                        <td class='td_e' align='Right'>$mcpp_quantity</td>
                        <td class='td_e' align='Right'>$mpet_quantity</td>
                        <td class='td_e' align='Right'>$foil_quantity</td>
                        <td class='td_e' align='Right'>$lf_quantity</td>
                        <td class='td_e' align='Right'>$mf_quantity</td>
                        <td class='td_e' align='Right'>$tm_cost</td>
                        <td class='td_e' align='Right'>$oh</td>
                        <td class='td_e' align='Right'>$t_cost</td>
                        <td class='td_e' align='Right'>
                              <input type='button' name='btndelet' value='Delete' class='forms_button_e' onclick='deleterow($wipobjectid)'>
                        </td>
                  </tr>" ;
                  $j++;
            }
            echo"</table>" ;
      }
      //echo "Numrows=$j;";
      //echo "copyRecords(dbDeleteCheck,dbTrnObjectID,dbItemID,dbItemName,dbRate,dbRequiredQuantity,dbRemarks,dbItemUnit,dbItemUnitValue,Numrows);";
?>



</form>



</body>

</html>
