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
      if(document.frmEmployeeEntry.txtleavename.value=='' )
      {
            alert("You Must Enter Leave Name");
            document.frmEmployeeEntry.txtleavename.focus();
      }
      else
      {
            document.frmEmployeeEntry.submit();
      }
}
function goback()
{
      window.location="MasLeaveList.php";
}
function goemployee()
{
    window.location="MasLeaveEntry.php";
}

</script>


</head>

<body class='body_e'>
<form name='frmEmployeeEntry' method='post'  action='AddToleaveEntry.php'>

<?PHP
      if($updatevalue=='1')
      {
            $query="select
                              leave_id,
                              leave_name,
                              yearly_allocated,
                              employee_type
                        from
                              mas_leave
                        where
                            leave_id='$leaveID'
                         ";
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
                <td colspan='2' align='center' class='header_cell_e'>Leave Detail Entry Form</td>
                <td class='top_right_curb'></td>
        </tr>

        <tr>
                <td class='lb'></td>
                <td class='caption_e'><b>Leave Name</b></td>
                <td class='td_e'>
                        <?PHP
                        echo "<input type='hidden' value='$leaveID' name='txtleaveid'>";
                        if($updatevalue=='1')
                              echo "<input type='text' name ='txtleavename' value='$leave_name' class='input_e' >";
                        else
                              echo "<input type='text' name ='txtleavename' value='' class='input_e' >";
                        ?>
                </td>

                <td class='rb'></td>
        </tr>
        <tr>
                <td class='lb'></td>
                <td class='caption_e'><b>Employee Type</b></td>
                <td><select name='text_emptype' class='td_e'>
                  <?PHP
                        if($employee_type==1)
                        {
                              echo "
                                   <option value='1' selected >Admin</option>
                                   <option value='2'>Factory</Option>
                              ";
                        }
                        else if ($employee_type==2)
                             {
                              echo"
                                   <option value='1'>Admin</option>
                                   <option value='2'selected >Factory</Option>
                              ";
                             }
                        else
                        {
                         echo"
                         <option value='1'>Admin</option>
                         <option value='2'>Factory</Option>
                         ";
                         }
                    ?>
                  </select>
                </td>

                <td class='rb'></td>
        </tr>

        <tr>
                <td class='lb'></td>
                <td class='caption_e'><b>Number Of Days</b></td>
                <td class='td_e'>
                        <?PHP

                        if($updatevalue=='1')
                              echo "<input type='text' name ='txtnumber' value='$yearly_allocated' class='input_e' >";
                        else
                              echo "<input type='text' name ='txtnumber' value='' class='input_e' >";
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

