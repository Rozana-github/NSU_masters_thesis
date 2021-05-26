<?PHP
session_start();

        include_once("Library/dbconnect.php");
        include_once("Library/Library.php");

?>

<html xmlns:ycode>
<meta content="Author" name="Md.Sharif Ur Rahman">
<style>
        yCode\:combobox {behavior: url(combobox.htc); }
</style>

<head>

<link rel='stylesheet' type='text/css' href='Style/eng_form.css'>
<link rel='stylesheet' type='text/css' href='Style/generic_form.css'>
<script language='JavaScript'>
function gosubitementry(itemcode,cboglcode)
{
      window.parent.bottomfrmForReport.location="Sub_Item_Entry.php?cboglcode="+cboglcode+"&parent_itemcode="+itemcode;
}
</script>

</head>

<body class='body_e'>



<?PHP/*-------------------------- Developed By: MD.SHARIF UR RAHMAN ---------------------------------------------*/?>
<form name='frmMasAssetEntry' method='post' action='AddTo_MasItem_Entry.php'>

     <?PHP
            $query="
                  Select
                        itemcode,
                        itemdescription
                  from
                        mas_item
                  where
                        glcode='".$cboglcode."' and
                        level='0'
                  order by
                        itemdescription
            ";
           $rsasset=mysql_query($query)or die(mysql_error());
            if(mysql_num_rows($rsasset)>0)
            {
                  echo "<table border='0' align='center' width='100%' cellpadding='0' cellspacing='0'>
                              <tr>
                                    <td class='top_l_curb'></td>
                                    <td class='top_f_cell' colspan='2'></td>
                                    <td class='top_r_curb'></td>
                              </tr>
                              <tr>
                                    <td class='lb'></td>
                                    <td class='title_cell_e' >Item Name</td>
                                    <td class='title_cell_e' >Sub-Item</td>
                                    <td class='rb'></td>
                              <tr>
                       ";

                  $i=0;
                  while($row=mysql_fetch_array($rsasset))
                  {
                        extract($row);
                        if($i%2==0)
                              $cls='even_td_e';
                        else
                              $cls='odd_td_e';
                                    echo "
                                    <tr>
                                          <td class='lb'></td>
                                          <td align='center' class='$cls'>
                                                <a href='Mass_Item_Entry_Top.php?Optype=2&ItemID=".urlencode($itemcode)."&GLCODE=".urlencode($cboglcode)."&ItemNam=".urlencode($itemdescription)."' target='topfrmForReport' title='Click for Update'>
                                                      $itemdescription
                                                </a>
                                          </td>
                                          <td class='$cls' align='center'>
                                                <input type='button' value='Add Sub-Item' class='forms_button_e' name='btnaddsubitem' onclick='gosubitementry($itemcode,$cboglcode)'>
                                          </td>
                                          <td class='rb'></td>
                                    </tr>
                                    <input name='upId' type='hidden' value='$itemcode'>
                                    ";
                  $i++;
                  }
                              echo "
                                    <tr>
                                          <td class='bottom_l_curb'></td>
                                          <td class='bottom_f_cell' colspan='2'></td>
                                          <td class='bottom_r_curb'></td>
                                    </tr>
                  </table>";
            }

     ?>


</form>
</body>
</html>
