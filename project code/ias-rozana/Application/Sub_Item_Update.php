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


<script language="JavaScript" src="Script/NumberFormat.js"></script>

<script language="JavaScript" src="Script/calendar1.js"></script>

<script language='JavaScript'>

function Submit()
{

            frmMasSubitemEntry.submit();

}

function submitthis()
{

      window.parent.bottomfrmForReport.location="Sub_Item_Entry.php?cboglcode="+cboglcode+"&itemcode="+itemcode;
}


function NewDoc()
{
      var cboglcode=document.frmMasSubitemEntry.cboglcode.value;
      var parent_itemcode=document.frmMasSubitemEntry.parent_itemcode.value;
      window.location="Sub_Item_Entry.php?cboglcode="+cboglcode+"&parent_itemcode="+parent_itemcode;
}


</script>

</head>

<body class='body_e'>
<?PHP/*-------------------------- Developed By: MD.SHARIF UR RAHMAN ---------------------------------------------*/?>
<form name='frmMasSubitemEntry' method='post' action='AddTo_Sub_Item_Entry.php' target='bottomfrmForReport'>
      <table border='0' width='100%'  align='center' cellpadding='3' cellspacing='0'>
            <tr>
                  <td class='top_left_curb'></td>
                  <td align='center' colspan='2' width='100%' class='header_cell_e'>
                       Sub Item Entry Form
                  </td>
                  <td class='top_right_curb'></td>
            </tr>
            <tr>
                  <td class='lb' rowspan='3'></td>
                  <td class='caption_e' >
                        Sub-Item:
                  </td>

                  <td class='td_e'>
                  <?PHP
                       if($Optype==2)
                       {
                              echo "<input type='text' name='txtSubItem' size='25' value='$ItemNam'  class='input_e'>";
                       }
                       else
                       {
                              echo "<input type='text' name='txtSubItem' size='25' value=''  class='input_e'>";
                       }
                  ?>
                  </td>
                  <?PHP
                        echo "<input type='hidden' name='cboglcode' value='$cboglcode'>
                              <input type='hidden' name='parent_itemcode' value='$parent_itemcode'>";
                  ?>
                  
            </tr>
            
            <tr>
                  <td colspan='2' class='button_cell_e' align='center'>
                  <?PHP
                        if($Optype==2)
                        {
                              echo "<input type='button' name='btnUpdate' value='Update' class='forms_button_e' onclick='Submit()'>";
                              echo "<input type='hidden' name='Q_Mode' value='1'>";
                              echo "<input type='hidden' name='Item_ID' value='$ItemID' >";

                        }
                        else
                        {
                              echo "<input type='button' name='btnSave' value='Save' class='forms_button_e' onclick='Submit()'>";
                        }
                  ?>
                   <input type='button' name='btnNew' value='new' class='forms_button_e' onclick='NewDoc()'>
                  </td>
            <tr>
            <tr>
                  <td class='bottom_l_curb'></td>
                  <td class='bottom_f_cell' colspan='2'></td>
                  <td class='bottom_r_curb'></td>
            </tr>
      </table>
      
      <?PHP
            $querysubitem="select
                        itemcode,
                        itemdescription,
                        glcode,
                        parent_itemcode
                  from
                        mas_item
                  where

                       parent_itemcode='$parent_itemcode'
                  order by
                        itemdescription
                  ";
            $rssubitem=mysql_query($querysubitem) or die(mysql_error());
            if(mysql_num_rows($rssubitem)>0)
            {
                  echo "<table border='0' align='center' width='100%' cellpadding='0' cellspacing='0'>
                              <tr>
                                    <td class='top_l_curb'></td>
                                    <td class='top_f_cell' ></td>
                                    <td class='top_r_curb'></td>
                              </tr>
                              <tr>
                                    <td class='lb'></td>
                                    <td class='title_cell_e' >Sub-Item</td>

                                    <td class='rb'></td>
                              <tr>";
                  $i=0;
                  while($rowsubitem=mysql_fetch_array($rssubitem))
                  {
                        extract($rowsubitem);
                        if($i%2==0)
                              $cls='even_td_e';
                        else
                              $cls='odd_td_e';
                                    echo "
                                    <tr>
                                          <td class='lb'></td>
                                          <td align='center' class='$cls'>
                                                <a href='Sub_Item_Update.php?Optype=2&ItemID=".urlencode($itemcode)."&cboglcode=".urlencode($glcode)."&ItemNam=".urlencode($itemdescription)."&parent_itemcode=".urlencode($parent_itemcode)."' target='bottomfrmForReport' title='Click for Update'>
                                                      $itemdescription
                                                </a>
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
                                          <td class='bottom_f_cell' ></td>
                                          <td class='bottom_r_curb'></td>
                                    </tr>
                  </table>";

            }


      ?>
</form>



</body>

</html>
