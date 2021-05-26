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
function ValSubmitData()
{
      var MatchineName=document.frmMasAssetEntry.txtMatchineName.value;
      var MatchiSpeed=document.frmMasAssetEntry.txtSpeed.value;
      var MatchiStatus=document.frmMasAssetEntry.txtstatus.value;

      if(MatchineName=='' || MatchiSpeed=='' || MatchiStatus=='-1')
      {
            alert("All field must be Required");
      }
      else
      {
            frmMasAssetEntry.submit();
      }
}

function NewPageDoc()
{
      window.location="Matchine_Entry_Top.php";
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
                        machine_object_id,
                        machine_name,
                        speed,
                        status
                  from
                        mas_machine
                  where
                       machine_object_id='$BankID'
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
<form name='frmMasAssetEntry' method='post' action='AddTo_Matchine_Entry.php' target='bottomfrmForReport'>
      <table border='0' width='100%'  align='center' cellpadding='3' cellspacing='0'>
            <tr>
                  <td class='top_left_curb'></td>
                  <td align='center' colspan='2' width='100%' class='header_cell_e'>
                        Machine Entry Form
                  </td>
                  <td class='top_right_curb'></td>
            </tr>
            <tr>
                  <td class='lb' rowspan='4'></td>
                  <td class='caption_e' width='30%'>
                        Machine Name:
                  </td>
                  <td class='td_e'>
                  <?PHP
                       if($Optype==2)
                       {
                              echo "<input type='text' name='txtMatchineName' size='40' value='$machine_name'  class='input_e'>";
                       }
                       else
                       {
                              echo "<input type='text' name='txtMatchineName' size='40' value=''  class='input_e'>";
                       }
                  ?>
                  </td>
                  <td class='rb' rowspan='4'></td>
            </tr>
            <tr>
                  <td class='caption_e' width='30%'>
                        Speed:
                  </td>
                  <td class='td_e'>
                  <?PHP
                       if($Optype==2)
                       {
                              echo "<input type='text' name='txtSpeed' size='40' value='$speed'  class='input_e'>M/M";
                       }
                       else
                       {
                              echo "<input type='text' name='txtSpeed' size='40' value=''  class='input_e'>M/M";
                       }
                  ?>
                  </td>
            </tr>
            <tr>
                  <td class='caption_e' width='30%'>
                        Status:
                  </td>
                  <td class='td_e'>
                  <?PHP
                       if($Optype==2)
                       {
                              echo "<select name='txtstatus'> ";
                                    if($status==0)
                                    {
                                          echo "<option value='-1'>Select Status</option>";
                                          echo "<option value='0' selected>Active</option>";
                                          echo "<option value='1'>Inactive</option>";
                                    }
                                    else if($status==1)
                                    {
                                          echo "<option value='-1'>Select Status</option>";
                                          echo "<option value='0'>Active</option>";
                                          echo "<option value='1' selected>Inactive</option>";
                                    }
                                    else
                                    {
                                          echo "<option value='-1' selected>Select Status</option>";
                                          echo "<option value='0'>Active</option>";
                                          echo "<option value='1'>Inactive</option>";
                                    }
                              echo "</select>";
                       }
                       else
                       {
                          echo "<select name='txtstatus' >
                              <option value='-1'>Select Status</option>
                              <option value='0'>Active</option>
                              <option value='1'>Inactive</option>
                          </select>";
                       }
                  ?>
                  </td>
            </tr>
            <tr>
                  <td colspan='2' class='button_cell_e' align='center'>
                  <?PHP
                        if($Optype==2)
                        {
                              echo "<input type='button' name='btnUpdate' value='Update' class='forms_button_e' onclick='ValSubmitData()'>";
                              echo "<input type='hidden' name='Q_Mode' value='1'>";
                              echo "<input type='hidden' name='MatchineID' value='$machine_object_id' >";

                        }
                        else
                        {
                              echo "<input type='button' name='btnSave' value='Save' class='forms_button_e' onclick='ValSubmitData()'>";
                        }
                  ?>
                   <input type='button' name='btnNew' value='new' class='forms_button_e' onclick='NewPageDoc()'>
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
