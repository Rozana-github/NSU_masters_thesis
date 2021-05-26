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


var index=0;
var totalindex=0;
var DataRow= new Array();
function DrawTable()
{
        index=parseInt(frmMasAssetEntry.TotalIndex.value);
        var assetname=document.frmMasAssetEntry.txtAssetName.value;
        var deprate=document.frmMasAssetEntry.txtRate.value;

        var ResRow="";

        if(document.frmMasAssetEntry.cboglcode.value=='-1')
        {
             alert('Value Required');
             document.frmMasAssetEntry.cboglcode.focus();
        }

        else if(document.frmMasAssetEntry.txtAssetName.value=="")
        {
                alert('Value Required');
                document.frmMasAssetEntry.txtAssetName.focus();
        }

        else if(document.frmMasAssetEntry.txtRate.value=="")
        {
                alert('Value Required');
                document.frmMasAssetEntry.txtRate.focus();
        }

        else
        {
                if(frmMasAssetEntry.addBtn.value=='Update')
                {
                        var UpdateIndex=frmMasAssetEntry.HidUpdateIndex.value;


                        frmMasAssetEntry.elements["txtDepRate["+UpdateIndex+"]"].value=frmMasAssetEntry.txtRate.value;
                        frmMasAssetEntry.elements["txtAssName["+UpdateIndex+"]"].value=frmMasAssetEntry.txtAssetName.value;
                        frmMasAssetEntry.addBtn.value='Add';
                }
                else
                {
                        DataRow[index]='';
                        DataRow[index]+="<table border='1' align='center' width='80%' bordercolor='black' cellpadding='0' cellspacing='0'>";
                        DataRow[index]+="<tr>";
                        DataRow[index]+="<td width='40%' align='center' class='td_e'><input type='text' style='border:0;cursor:hand' name='txtAssName["+index+"]'  value='"+assetname+"' readonly onclick='EditInformation("+index+");') class='input_e'></td>";
                        DataRow[index]+="<td width='40%' align='center' class='td_e'><input type='text' style='border:0;cursor:hand' name='txtDepRate["+index+"]'  value='"+deprate+"' readonly onclick='EditInformation("+index+");' class='input_e' ></td>";

                        DataRow[index]+="</tr></table>";

                        window.d.innerHTML=window.d.innerHTML+DataRow[index];
                        index++;
                        totalindex=index;
                }


        }
}




function EditInformation(index)
{

        frmMasAssetEntry.txtAssetName.value=frmMasAssetEntry.elements("txtAssName["+index+"]").value;
        frmMasAssetEntry.txtRate.value=frmMasAssetEntry.elements("txtDepRate["+index+"]").value;
        frmMasAssetEntry.addBtn.value='Update';
        frmMasAssetEntry.HidUpdateIndex.value=index;
}

function saveintomasasset()
{

        if(totalindex>parseInt(frmMasAssetEntry.TotalIndex.value))
        {
            frmMasAssetEntry.TotalIndex.value=totalindex;
        }

        if(frmMasAssetEntry.TotalIndex.value==0)
        {
                alert('At list one Asset Name should entered');
                return false;
        }
        else
        {
                //for (i=0;i<index;i++)
                //alert(frmMasAssetEntry.elements("txtAssName["+i+"]").value+" is "+i)
                frmMasAssetEntry.submit();
        }
}
function AssetAdjust(val)
{
      var glcode=document.frmMasAssetEntry.txtglcode.value;
      window.location="AssetAdustEntry.php?AssetID="+val+"&cboglcode="+glcode+"";
}




</script>

</head>

<body >




<form name='frmMasAssetEntry' method='post' action='AddToMasAsstEntry.php'>
<input type="hidden" name="HidUpdateIndex" value="">




<input type="hidden" name="txtHiddenIndex" value="">

<br>



     <?PHP
            $query="
                  Select
                        trn_asset_register.assetid,
                        mas_asset.description,
                        trn_asset_register.purchase_qty,
                        date_format( trn_asset_register.purchase_date, '%d-%m-%Y' ) As purchasedate ,
                        trn_asset_register.remarks,
                        trn_asset_register.purchase_amount


                  from
                        trn_asset_register
                        left join mas_asset on mas_asset.assetobjectid=trn_asset_register.assetobjectid
                  where
                        mas_asset.gl_code='".$cboglcode."'
                  order by
                        description
            ";
            $rsasset=mysql_query($query)or die(mysql_error());
            $i=0;
            if(mysql_num_rows($rsasset)>0)
            {
                  echo "<input type='hidden' name='txtglcode' value='$cboglcode'>
                        <table border='1' align='center' width='80%' bordercolor='black' cellpadding='0' cellspacing='0'>
                        <tr>
                              <td  align='center' class='title_cell_e'>Name of Asset</td>
                              <td  align='center' class='title_cell_e'>Quantity</td>
                              <td  align='center' class='title_cell_e'>Purchase Date</td>
                              <td  align='center' class='title_cell_e'>Purchase Cost</td>
                              <td  align='center' class='title_cell_e'>Remarks</td>
                        </tr>";
            while($rowasset=mysql_fetch_array($rsasset))
            {
                  extract($rowasset);
                  if($i%2==0)
                        $cls='even_td_e';
                  else
                        $cls='odd_td_e';
                  echo"<tr>
                              <td   class='$cls' onclick=AssetAdjust($assetid) style='cursor:hand'>$description</td>
                              <td  align='center' class='$cls' onclick=AssetAdjust($assetid) style='cursor:hand'>$purchase_qty</td>
                              <td  align='center' class='$cls' onclick=AssetAdjust($assetid) style='cursor:hand'>$purchasedate</td>
                              <td  align='right' class='$cls' onclick=AssetAdjust($assetid) style='cursor:hand'>".number_format($purchase_amount,2,'.','')."</td>
                              <td  align='center' class='$cls' onclick=AssetAdjust($assetid) style='cursor:hand'>$remarks&nbsp;</td>
                              <input type='hidden' name='assetid[".$i."]' value='$assetobjectid'>
                        </tr>
                                    ";
             $i++;
            }
            echo "
                  </table><input type='hidden' value='$cboglcode' name='cboglcode'>
                  <input type='hidden' name='TotalIndex' value='$i'>";
            }
            else
            {
                  drawNormalMassage("No data found");
            }
     ?>

















</form>



</body>

</html>
