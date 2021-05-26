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

function Submit()
{
      var BankName=document.frmMasAssetEntry.txtBankName.value;
      if(BankName=='')
      {
            alert("Type A Bank name");
            document.frmMasAssetEntry.txtBankName.focus();
      }
      else
      {
            frmMasAssetEntry.submit();
      }
}

function submitfrom()
{
        var BankName=document.frmMasAssetEntry.txtBankName.value;
        if(BankName=='')
        {
             alert("Type A Bank name");
             document.frmMasAssetEntry.txtBankName.focus();
        }
        else
        {
                window.parent.bottomfrmForReport.location="Mas_Bank_Entry.php";
        }
}

function NewDoc()
{
      window.location="Bank_Entry_Top.php";
}


</script>

</head>

<body class='body_e'>
<?PHP/*-------------------------- Developed By: MD.SHARIF UR RAHMAN ---------------------------------------------*/?>
<?PHP
if($Optype==2)
{
            $query="
                  Select
                        bank_id,
                        bank_name
                  from
                        mas_bank
                  where
                       bank_id='$BankID'
                  ";
            $Rcset=mysql_query($query)or die(mysql_error());
            if(mysql_num_rows($Rcset)>0)
            {
                  while($row=mysql_fetch_array($Rcset))
                  {
                        extract($row);
                  }
            }
}
?>
<form name='frmMasAssetEntry' method='post' action='AddTo_Bank_Entry.php' target='bottomfrmForReport'>
      <table border='0' width='100%'  align='center' cellpadding='3' cellspacing='0'>
            <tr>
                  <td class='top_left_curb'></td>
                  <td align='center' colspan='2' width='100%' class='header_cell_e'>
                        Bank Entry Form
                  </td>
                  <td class='top_right_curb'></td>
            </tr>
            <tr>
                  <td class='lb' rowspan='2'></td>
                  <td class='caption_e' width='30%'>
                        Bank Name:
                  </td>
                  <td class='td_e'>
                  <?PHP
                       if($Optype==2)
                       {
                              echo "<input type='text' name='txtBankName' size='40' value='$bank_name'  class='input_e'>";
                       }
                       else
                       {
                              echo "<input type='text' name='txtBankName' size='40' value=''  class='input_e'>";
                       }
                  ?>
                  </td>
                  <td class='rb' rowspan='2'></td>
            </tr>
            <tr>
                  <td colspan='2' class='button_cell_e' align='center'>
                  <?PHP
                        if($Optype==2)
                        {
                              echo "<input type='button' name='btnUpdate' value='Update' class='forms_button_e' onclick='Submit()'>";
                              echo "<input type='hidden' name='Q_Mode' value='1'>";
                              echo "<input type='hidden' name='BankID' value='$bank_id' >";

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
