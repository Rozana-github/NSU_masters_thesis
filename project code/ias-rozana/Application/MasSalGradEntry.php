<?PHP
        include_once("Library/dbconnect.php");
        include_once("Library/Library.php");

?>

<html>

<head>
<meta http-equiv='Content-Language' content='en-us'>
<meta http-equiv='Content-Type' content='text/html; charset=windows-1252'>
<title>Employee Entry Form</title>
<link rel='stylesheet' type='text/css' href='Style/interface_styles.css' />
<link rel='stylesheet' type='text/css' href='Style/generic_form.css'>
<link rel='stylesheet' type='text/css' href='Style/eng_form.css'>
<script language="JavaScript">
function Submitfrom()
{
      if(document.frmEmployeeEntry.txtGname.value=='' )
      {
            alert("You Must Enter Designation");
            document.frmEmployeeEntry.txtGname.focus();
      }
      else
      {
            document.frmEmployeeEntry.submit();
      }
}
function goback()
{
      window.location="MasSalGradList.php";
}
function goemployee()
{
    window.location="MasSalGradEntry.php";
}

</script>


</head>

<body class='body_e'>
<form name='frmEmployeeEntry' method='post'  action='AddToMasSalGradEntry.php'>

<?PHP
      if($updatevalue=='1')
      {
            $query="select
                              sal_grad_id,
                              grad_name as description,
                              basic_salary,
                              house_allowance,
                              medical_allowance,
                              convance,
                              food_allowance,
                              utility_allowance,
                              special_allowance,
                              maintenance_allowance,
                              inflation_allowance,
                              transport,
                              others_allowance_id as othersid,
                              date_format(effctive_from,'%d-%m-%Y') as effectdate,
                              status,
                              entry_date,
                              increment_date
                        from
                              mas_sal_info
                  where
                        sal_grad_id='$allowanceID'";
             //echo $query;
            $rs=mysql_query($query)or die(mysql_error());
            while($row=mysql_fetch_array($rs))
            {
                  extract($row);
                  $efdate=explode("-",$effective_date);
                  
            }
      }

?>


<table border='0' width='100%'  cellspacing='0' cellpadding='0'>
        <tr>
                <td class='top_left_curb'></td>
                <td colspan='2' align='center' class='header_cell_e'>Sary Detail Entry Form</td>
                <td class='top_right_curb'></td>
        </tr>

        <tr>
                <td class='lb'></td>
                <td class='caption_e'><b>Grad Name</b></td>
                <td class='td_e'>
                        <?PHP
                        echo "<input type='hidden' value='$allowanceID' name='txtallowanceid'>";
                        if($updatevalue=='1')
                              echo "<input type='text' name ='txtGname' value='$description' class='input_e' >";
                        else
                              echo "<input type='text' name ='txtGname' value='' class='input_e' >";
                        ?>
                </td>

                <td class='rb'></td>
        </tr>
        <tr>
                <td class='lb'></td>
                <td class='caption_e'><b>Basic</b></td>
                <td class='td_e'>
                        <?PHP

                        if($updatevalue=='1')
                              echo "<input type='text' name ='txtBasic' value='$basic_salary' class='input_e' >";
                        else
                              echo "<input type='text' name ='txtBasic' value='' class='input_e' >";
                        ?>
                </td>

                <td class='rb'></td>
        </tr>
        

        <tr>
                <td class='lb'></td>
                <td class='caption_e'><b>House Allowance</b></td>
                <td class='td_e'>
                        <?PHP

                        if($updatevalue=='1')
                              echo "<input type='text' name ='txtHouse' value='$house_allowance' class='input_e' >";
                        else
                              echo "<input type='text' name ='txtHouse' value='' class='input_e' >";
                        ?>
                </td>

                <td class='rb'></td>
        </tr>

        
        <tr>
                <td class='lb'></td>
                <td class='caption_e'><b>Medical Allowance</b></td>
                <td class='td_e'>
                        <?PHP

                        if($updatevalue=='1')
                              echo "<input type='text' name ='txtMedical' value='$medical_allowance' class='input_e' >";
                        else
                              echo "<input type='text' name ='txtMedical' value='' class='input_e' >";
                        ?>
                </td>

                <td class='rb'></td>
        </tr>
        <tr>
                <td class='lb'></td>
                <td class='caption_e'><b>convance</b></td>
                <td class='td_e'>
                        <?PHP

                        if($updatevalue=='1')
                              echo "<input type='text' name ='txtConvance' value='$convance' class='input_e' >";
                        else
                              echo "<input type='text' name ='txtConvance' value='' class='input_e' >";
                        ?>
                </td>

                <td class='rb'></td>
        </tr>
        <tr>
                <td class='lb'></td>
                <td class='caption_e'><b>Food</b></td>
                <td class='td_e'>
                        <?PHP

                        if($updatevalue=='1')
                              echo "<input type='text' name ='txtFood' value='$food_allowance' class='input_e' >";
                        else
                              echo "<input type='text' name ='txtFood' value='' class='input_e' >";
                        ?>
                </td>

                <td class='rb'></td>
        </tr>
        <tr>
                <td class='lb'></td>
                <td class='caption_e'><b>Utility Allowance</b></td>
                <td class='td_e'>
                        <?PHP

                        if($updatevalue=='1')
                              echo "<input type='text' name ='txtUtility' value='$utility_allowance' class='input_e' >";
                        else
                              echo "<input type='text' name ='txtUtility' value='' class='input_e' >";
                        ?>
                </td>

                <td class='rb'></td>
        </tr>
        <tr>
                <td class='lb'></td>
                <td class='caption_e'><b>Special Allowance</b></td>
                <td class='td_e'>
                        <?PHP

                        if($updatevalue=='1')
                              echo "<input type='text' name ='txtSpecial' value='$special_allowance' class='input_e' >";
                        else
                              echo "<input type='text' name ='txtSpecial' value='' class='input_e' >";
                        ?>
                </td>

                <td class='rb'></td>
        </tr>

        
         <tr>
                <td class='lb'></td>
                <td class='caption_e'><b>Maintainnance Allowance</b></td>
                <td class='td_e'>
                        <?PHP

                        if($updatevalue=='1')
                              echo "<input type='text' name ='txtMaintainnance' value='$maintenance_allowance' class='input_e' >";
                        else
                              echo "<input type='text' name ='txtMaintainnance' value='' class='input_e' >";
                        ?>
                </td>

                <td class='rb'></td>
        </tr>
        <tr>
                <td class='lb'></td>
                <td class='caption_e'><b>Inflation allowance</b></td>
                <td class='td_e'>
                        <?PHP

                        if($updatevalue=='1')
                              echo "<input type='text' name ='txtInflation' value='$inflation_allowance' class='input_e' >";
                        else
                              echo "<input type='text' name ='txtInflation' value='' class='input_e' >";
                        ?>
                </td>

                <td class='rb'></td>
        </tr>
        <tr>
                <td class='lb'></td>
                <td class='caption_e'><b>Transport</b></td>
                <td class='td_e'>
                        <?PHP

                        if($updatevalue=='1')
                              echo "<input type='text' name ='txtTransport' value='$transport' class='input_e' >";
                        else
                              echo "<input type='text' name ='txtTransport' value='' class='input_e' >";
                        ?>
                </td>

                <td class='rb'></td>
        </tr>
        <tr>
                <td class='lb'></td>
                <td class='caption_e'><b>Others Allowance</b></td>
                <td class='td_e'>
                        <select name='cboOthers' class='select_e'>
                        <?PHP

                        if($updatevalue=='1')
                        {
                              createCombo("Other Amount","mas_others_allowance","others_allowance_id","amount"," where effective_date <= sysdate()","$othersid");
                        }
                        else
                        {
                                createCombo("Other Amount","mas_others_allowance","others_allowance_id","amount"," where effective_date <= sysdate()","");
                        }

                        ?>
                        </select>
                </td>

                <td class='rb'></td>
        </tr>
        <tr>
                <td class='lb'></td>
                <td class='caption_e'><b>Status</b></td>
                <td class='td_e'>
                        <select name='cboStatus' class='select_e'>
                              <?PHP
                              if($updatevalue=='1')
                              {
                                     if($status=='1')
                                    {
                                          echo "<option value='1' selected>Active</option>
                                                <option value='0'>Inactive</option>";
                                    }
                                    if($status=='0')
                                    {
                                          echo "
                                                <option value='1'>Active</option>
                                                <option value='0' selected>Inactive</option>
                                                ";
                                    }
                              }
                              else
                              {
                                    echo"<option value='1'>Active</option>
                                          <option value='0'>Inactive</option>";
                              }
                              ?>
                        </select>
                </td>

                <td class='rb'></td>
        </tr>

        <tr>
                <td class='lb'></td>
                <td class='caption_e'><b>Effctive Date</b></td>
                <td class='td_e'>
                        <?PHP

                        if($updatevalue=='1')
                        {
                               echo "<select name='EDay'  class='select_e'>";
                                          comboDay($efdate[2]);
                              echo "</select>
                                    <select name='EMonth' class='select_e'>";
                                          comboMonth($efdate[1]);
                              echo "</select>
                                    <select name='EYear' class='select_e'>";
                                          comboYear($efdate[0]);
                              echo"</select>";
                        }
                        else
                        {
                               echo "<select name='EDay'  class='select_e'>";
                                          comboDay("");
                              echo "</select>
                                    <select name='EMonth' class='select_e'>";
                                          comboMonth("");
                              echo "</select>
                                    <select name='EYear' class='select_e'>";
                                          comboYear("");
                              echo"</select>";
                        }

                        ?>
                </td>

                <td class='rb'></td>
        </tr>


        <tr>
                <td class='lb'></td>
                <td  colspan='2' align='center' class='button_cell_e'>
                   <input type='Button' value='Submit' class='forms_Button_e' onclick='Submitfrom()'>
                   <input type='Button' value='New' class='forms_Button_e' onclick='goemployee()'>
                   <input type='Button' value='Back' class='forms_Button_e' onclick='goback()'>
                </td>
                <td class='rb'></td>
        </tr>


        <tr>
            <td class='bottom_l_curb'></td>
            <td class='bottom_f_cell' colspan='2'></td>
            <td class='bottom_r_curb'></td>

        </tr>

</table>

</form>
</body>

</html>

