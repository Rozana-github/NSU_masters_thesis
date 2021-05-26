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
      if(document.frmEmployeeEntry.txtdescription.value=='' )
      {
            alert("You Must Enter Designation");
            document.frmEmployeeEntry.txtdescription.focus();
      }
      else
      {
            document.frmEmployeeEntry.submit();
      }
}
function goback()
{
      window.location="OtherallowanceList.php";
}
function goemployee()
{
    window.location="OtherallowanceEntry.php";
}

</script>


</head>

<body class='body_e'>
<form name='frmEmployeeEntry' method='post'  action='AddToOtherallowanceEntry.php'>

<?PHP
      if($updatevalue=='1')
      {
            $query="select
                              others_allowance_id,
                              description,
                              amount,
                              effective_date
                        from
                              mas_others_allowance
                  where
                        others_allowance_id='$allowanceID'";
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
                <td colspan='2' align='center' class='header_cell_e'>Designation Entry Form</td>
                <td class='top_right_curb'></td>
        </tr>

        <tr>
                <td class='lb'></td>
                <td class='caption_e'><b>Allowance Description</b></td>
                <td class='td_e'>
                        <?PHP
                        echo "<input type='hidden' value='$allowanceID' name='txtallowanceid'>";
                        if($updatevalue=='1')
                              echo "<input type='text' name ='txtdescription' value='$description' class='input_e' >";
                        else
                              echo "<input type='text' name ='txtdescription' value='' class='input_e' >";
                        ?>
                </td>

                <td class='rb'></td>
        </tr>
        <tr>
                <td class='lb'></td>
                <td class='caption_e'><b>Amount</b></td>
                <td class='td_e'>
                        <?PHP
                        echo "<input type='hidden' value='$DesignationID' name='txtdesignation'>";
                        if($updatevalue=='1')
                              echo "<input type='text' name ='txtamount' value='$amount' class='input_e' >";
                        else
                              echo "<input type='text' name ='txtamount' value='' class='input_e' >";
                        ?>
                </td>

                <td class='rb'></td>
        </tr>
        <tr>
                <td class='lb'></td>
                <td class='caption_e'><b>Effctive Date</b></td>
                <td class='td_e'>
                        <?PHP
                        echo "<input type='hidden' value='$DesignationID' name='txtdesignation'>";
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

