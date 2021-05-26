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
function Submit()
{
      var GLCODE=document.frmMasAssetEntry.cboglcode.value;
      var ItemName=document.frmMasAssetEntry.txtAssetName.value;
      if(GLCODE=='' && ItemName=='')
      {
            alert("All type of data required");
      }
      else
      {
            frmMasAssetEntry.submit();
      }
}

function submitfrom()
{

        var cboglcode=document.frmMasAssetEntry.cboglcode.value;
        if(cboglcode=='-1')
        {
             alert('GL CODE data required');
             document.frmMasAssetEntry.cboglcode.focus();
        }
        else
        {
                window.parent.bottomfrmForReport.location="MasAssetEntry.php?cboglcode="+cboglcode+"";
        }
}

function NewDoc()
{
      window.location="MassAssetEntryTop.php";
}
</script>


</head>

<body class='body_e'>
<?PHP/*-------------------------- Developed By: MD.SHARIF UR RAHMAN ---------------------------------------------*/?>
<form name='frmMasAssetEntry' method='post' action='AddToMasAsstEntry.php' target='bottomfrmForReport'>
      <table border='0' width='100%'  align='center' cellpadding='0' cellspacing='0'>
            <tr>
                  <td class='top_left_curb'></td>
                  <td align='center' colspan='2' class='header_cell_e'>
                        Asset Entry Form
                  </td>
                  <td class='top_right_curb'></td>
            </tr>
            <tr>
                  <td class='lb' rowspan='4'></td>
                  <td align='right' class='caption_e'>
                        Choose GLCode:
                  </td>
                  <td align='left' class='td_e' >
                        <select name='cboglcode' class='td_e' onchange='submitfrom()'>
                        <?PHP
                              createCombo("GL","mas_gl","gl_code","description","where gl_code>10100 and gl_code<10200","$GLCODE");
                        ?>
                        </select>
                  </td>
                  <td class='lb' rowspan='4'></td>
            </tr>
            <tr>
                  <td class='caption_e'>
                        Asset Name:
                  </td>
                  <td class='td_e'>
                  <?PHP
                       if($Optype==2)
                       {
                              echo "<input type='text' name='txtAssetName' size='25' value='$AssetNam'  class='input_e'>";
                       }
                       else
                       {
                              echo "<input type='text' name='txtAssetName' size='25' value=''  class='input_e'>";
                       }
                  ?>
                  </td>
            </tr>
            <tr>
                  <td class='caption_e'>
                        Depreciation Rate:
                  </td>
                  <td class='td_e'>
                  <?PHP
                       if($Optype==2)
                       {
                              echo "<input type='text' name='txtD_Rate' size='25' value='$DR'  class='input_e'>";
                       }
                       else
                       {
                              echo "<input type='text' name='txtD_Rate' size='25' value=''  class='input_e'>";
                       }
                  ?>%
                  </td>
            </tr>
            <tr>
                  <td colspan='2' class='button_cell_e' align='center'>
                  <?PHP
                        if($Optype==2)
                        {
                              echo "<input type='button' name='btnUpdate' value='Update' class='forms_button_e' onclick='Submit()'>";
                              echo "<input type='hidden' name='Q_Mode' value='1'>";
                              echo "<input type='hidden' name='Object_ID' value='$ItemID' >";
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
</form>
</body>
</html>
