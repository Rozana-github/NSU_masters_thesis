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

<link rel='stylesheet' type='text/css' href='Style/eng_form.css'>
<link rel='stylesheet' type='text/css' href='Style/generic_form.css'>


<script language="JavaScript" src="Script/NumberFormat.js"></script>

<script language="JavaScript" src="Script/calendar1.js"></script>

<script language='JavaScript'>



function submitfrom()
{


        //frmMasAssetEntry.TotalIndex.value=index;

        if(document.frmMasAssetEntry.cboglcode.value=='-1')
        {
             alert('Value Required');
             document.frmMasAssetEntry.cboglcode.focus();
        }
        else
        {
                frmMasAssetEntry.submit();
        }
}
function backtoprevious()
{
      var glcode=document.frmAssetAdustEntry.txtglcode.value;
      window.location="AssetListBottom.php?cboglcode="+glcode+"" ;
}




</script>

</head>

<body class='body_e'>
<?PHP
     /* $queryexistvalue="
                  Select
                        *
                  From
                        trn_asset_disposal
                        left join trn_asset_depreciation on trn_asset_depreciation.assetid=trn_asset_disposal.assetid
                  where
                        assetid='".$AssetID."'
                  ";*/
       $findmaxmonth="SELECT
                                max( proc_month ) as proc_month , max( `proc_year` ) as proc_year
                        FROM
                                `trn_asset_depreciation`
                        WHERE `proc_year` = (
                                                SELECT
                                                        max( `proc_year` )
                                                FROM
                                                        `trn_asset_depreciation`
                                                WHERE
                                                        assetid='".$AssetID."' )
                                                ";
       $rs=mysql_query($findmaxmonth)or die(mysql_error());
       while($row=mysql_fetch_array($rs))
       {
                extract($row);
       }
       $queryexistvalue="
                        Select
                                total_cost,
                                total_depreciation
                        From
                                trn_asset_depreciation
                        where
                                assetid='".$AssetID."'
                                and proc_month='".$proc_month."'
                                and `proc_year`='".$proc_year."'
                        ";
      //echo $queryexistvalue;
       $rsexistvalue=mysql_query($queryexistvalue) or die(mysql_error());
       while($rows=mysql_fetch_array($rsexistvalue))
       {
            extract($rows);
            $salesdate=explode('-',$sales_date );
            $salseday=$salesdate[2];
            $salsemonth=$salesdate[1];
            $salseyear=$salesdate[0];
            
       }

?>




<form name='frmAssetAdustEntry' method='post' action='AddToAssetAdustEntry.php' target='bottomfrmForReport'>
<?PHP
echo "<input type='hidden' value='$AssetID' name='txtassetid'>
      <input type='hidden' name='txtglcode' value='$cboglcode'>";
?>

<table border='0' width='90%'  align='center' cellpadding='3' cellspacing='0'>
        <tr>
                <td class='top_left_curb'></td>
                <td align='center' colspan='2' width='100%' class='header_cell_e'>
                        Asset Sales/Adjust
                </td>
                <td class='top_right_curb'></td>
        </tr>
        <tr>
                <td class='lb'></td>
                <td align='right' class='td_e' >
                        date:
                </td>
                <td align='left' class='td_e' >

                        <?PHP
                              echo "<select name='AdjustDay' class='select_e'>";
                                          comboDay($salseday);
                              echo "</select>
                                    <select name='AdjustMonth' class='select_e'>";
                                          comboMonth($salsemonth);
                              echo "</select>
                                    <select name='AdjustYear' class='select_e'>";
                                          comboYear($salseyear);
                              echo"</select>";
                        ?>

               </td>
               <td class='rb'></td>
        </tr>
        <tr>
                <td class='lb'></td>
                <td align='right' class='td_e' >
                        Sales/Adjust Ammount:
                </td>
                <td align='left' class='td_e' >
                        <?PHP
                              echo"<input type='text' name='txtAdjustamount' value='".$total_cost."' class='input_e'>";
                        ?>
               </td>
               <td class='rb'></td>
        </tr>
        
        <tr>
                <td class='lb'></td>
                <td align='right' class='td_e' >
                        Depreciation Adjust:
                </td>
                <td align='left'   class='td_e' >
                        <?PHP
                              echo"<input type='text' name='txtAdjustdepreciation' value='".$total_depreciation."' class='input_e'>";
                        ?>
               </td>
               <td class='rb'></td>
        </tr>
        <tr>
                <td class='lb'></td>
                <td align='right' class='td_e' >
                        Remarks:
                </td>
                <td align='left'   class='td_e' >
                        <?PHP
                              echo"<textarea rows='2' name='txtremarks'  class='input_e'>$remarks</textarea>";
                        ?>
               </td>
               <td class='rb'></td>
        </tr>
        <tr>
                <td class='lb'></td>
                <td  colspan=2  class='button_cell_e' align='center'>
                        <input type='submit' name='btnsubmit' value='Submit' class='forms_button_e'>
                        <input type='Button' name='btnback' value='Back' class='forms_button_e' onclick='backtoprevious()'>
               </td>
               <td class='rb'></td>
        </tr>
        <tr>
                <td class='bottom_l_curb'></td>
                <td colspan='2' width='100%' class='bottom_f_cell'>

                </td>
                <td class='bottom_r_curb'></td>
        </tr>
</table>


</form>



</body>

</html>
