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
      window.location="DesignationList.php";
}
function goemployee()
{
    window.location="DesignationEntry.php";
}

</script>


</head>

<body class='body_e'>
<form name='frmEmployeeEntry' method='post'  action='AddToDesignationEntry.php'>

<?PHP
      if($updatevalue=='1')
      {
            $query="select
                        mas_designation.description,
                        mas_designation.designationid
                  from
                        mas_designation
                  where
                        designationid='$DesignationID'";
             //echo $query;
            $rs=mysql_query($query)or die(mysql_error());
            while($row=mysql_fetch_array($rs))
            {
                  extract($row);
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
                <td class='caption_e'><b>Designation Name</b></td>
                <td class='td_e'>
                        <?PHP
                        echo "<input type='hidden' value='$DesignationID' name='txtdesignation'>";
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

