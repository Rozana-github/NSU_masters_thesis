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
      if(BankName=='-1')
      {
            alert("Select A Bank name");
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
        if(BankName=='-1')
        {
             alert("Select A Bank name");
             document.frmMasAssetEntry.txtBankName.focus();
        }
        else
        {
                window.parent.bottomfrmForReport.location="Mas_BankAccount_Entry.php?BankID="+BankName+"";
        }
}

function NewDoc()
{
      window.location="BankAccount_Entry_Top.php";
}


</script>

</head>

<body class='body_e'>
<?PHP/*-------------------------- Developed By: MD.SHARIF UR RAHMAN ---------------------------------------------*/?>
<?PHP
if($Optype==2)
{
            $query="Select
                        account_object_id,
                        bank_id,
                        IFNULL(account_no,0) as account_no,
                        IFNULL(branch,0) as branch,
                        IFNULL(contract_person,0) as contract_person,
                        IFNULL(address1,0) as address1,
                        IFNULL(address2,0) as address2,
                        IFNULL(phone,0) as phone
                  from
                        trn_bank
                  where
                        account_object_id='$AccountObjID'
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
<form name='frmMasAssetEntry' method='post' action='AddTo_BankAccount_Entry.php' target='bottomfrmForReport'>
      <table border='0' width='100%' align='center' cellpadding='2' cellspacing='0'>
            <tr>
                  <td class='top_left_curb'></td>
                  <td align='center' colspan='2' width='100%' class='header_cell_e'>
                        Bank Entry Form
                  </td>
                  <td class='top_right_curb'></td>
            </tr>
            <tr>
                  <td class='lb' rowspan='8'></td>
                  <td class='caption_e' >
                       Bank Name:
                  </td>
                  <td class='td_e'>
                  <select name='txtBankName' class='td_e' onchange='submitfrom()'>
                  <?PHP
                       if($Optype==2)
                       {
                              createCombo("Bank Name","mas_bank","bank_id","bank_name","","$bank_id");
                       }
                       else
                       {
                              createCombo("Bank Name","mas_bank","bank_id","bank_name","","");
                       }
                  ?>
                  </select>
                  </td>
                  <td class='rb' rowspan='8'></td>
            </tr>
            <tr>
                  <td class='caption_e'>
                       Account No:
                  </td>
                  <td class='td_e'>
                  <?PHP
                       if($Optype==2)
                       {
                              echo "<input type='text' name='txtAccountNo' size='40' value='$account_no'  class='input_e'>";
                       }
                       else
                       {
                              echo "<input type='text' name='txtAccountNo' size='40' value=''  class='input_e'>";
                       }
                  ?>
                  </td>
            </tr>
            <tr>
                  <td class='caption_e'>
                       Brance Name:
                  </td>
                  <td class='td_e'>
                  <?PHP
                       if($Optype==2)
                       {
                              echo "<input type='text' name='txtBranceNam' size='40' value='$branch'  class='input_e'>";
                       }
                       else
                       {
                              echo "<input type='text' name='txtBranceNam' size='40' value=''  class='input_e'>";
                       }
                  ?>
                  </td>
            </tr>
            <tr>
                  <td class='caption_e'>
                       Contact Person:
                  </td>
                  <td class='td_e'>
                  <?PHP
                       if($Optype==2)
                       {
                              echo "<input type='text' name='txtContactP' size='40' value='$contract_person'  class='input_e'>";
                       }
                       else
                       {
                              echo "<input type='text' name='txtContactP' size='40' value=''  class='input_e'>";
                       }
                  ?>
                  </td>
            </tr>
            <tr>
                  <td class='caption_e'>
                       Address 1:
                  </td>
                  <td class='td_e'>
                  <?PHP
                       if($Optype==2)
                       {
                              echo "<textarea name='txtAddress1' cols='39' rows='3' class='input_e'>$address1</textarea> ";
                       }
                       else
                       {
                              echo "<textarea name='txtAddress1' cols='39' rows='3' class='input_e'></textarea> ";
                       }
                  ?>
                  </td>
            </tr>
            <tr>
                  <td class='caption_e'>
                       Address 2:
                  </td>
                  <td class='td_e'>
                  <?PHP
                       if($Optype==2)
                       {
                              echo "<textarea name='txtAddress2' cols='39' rows='3' class='input_e'>$address2</textarea> ";
                       }
                       else
                       {
                              echo "<textarea name='txtAddress2' cols='39' rows='3' class='input_e'></textarea> ";
                       }
                  ?>
                  </td>
            </tr>
            <tr>
                  <td class='caption_e'>
                       Phone:
                  </td>
                  <td class='td_e'>
                  <?PHP
                       if($Optype==2)
                       {
                              echo "<input type='text' name='txtPhone' size='40' value='$phone'  class='input_e'>";
                       }
                       else
                       {
                              echo "<input type='text' name='txtPhone' size='40' value=''  class='input_e'>";
                       }
                  ?>
                  </td>
            </tr>
            <tr>
                  <td colspan='2' class='button_cell_e' align='center'>
                  <?PHP
                        if($Optype==2)
                        {
                              echo "<input type='button' name='btnUpdate' value='Update' class='forms_button_e' onclick='Submit()'>";
                              echo "<input type='hidden' name='Q_Mode' value='1'>";
                              echo "<input type='hidden' name='AccountObjID' value='$account_object_id' >";

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
