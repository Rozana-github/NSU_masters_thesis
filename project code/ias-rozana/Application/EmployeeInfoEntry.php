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
      if(document.frmEmployeeEntry.txtempno.value=='' )
      {
            alert("You Must Enter Employee No");
            document.frmEmployeeEntry.txtempno.focus();
      }
      else if(document.frmEmployeeEntry.txtempname.value=='' )
      {
            alert("You Must Enter Employee Name");
            document.frmEmployeeEntry.txtempname.focus();
      }
      else
      {
            document.frmEmployeeEntry.submit();
      }
}

</script>


</head>

<body class='body_e'>
<form name='frmEmployeeEntry' method='post'  action='AddToEmployeeEntry.php'>

<?PHP

//select maximum customer id
/*$CustomerId="select
                   ifnull(lpad(max(cast(customer_id as unsigned))+1,4,0),0) as CustomerID
             from
                   mas_customer
            ";
$resultCustomer=mysql_query($CustomerId) or die(mysqL_error());
while($rowCustomer=mysql_fetch_array($resultCustomer))
{
   extract($rowCustomer);

}
if($CustomerID==0)
        $MaxCustomerId="0001";
else
        $MaxCustomerId=$CustomerID;  */


?>


<table border='0' width='100%'  cellspacing='0' cellpadding='0'>
        <tr>
                <td class='top_left_curb'></td>
                <td colspan='4' align='center' class='header_cell_e'>Employee Entry Form</td>
                <td class='top_right_curb'></td>
        </tr>

        <tr>
                <td class='lb'></td>
                <td class='td_e'><b>Employee No</b></td>
                <td class='td_e'>
                        <input type='text' name ='txtempno' value='' class='input_e' Size='10'>
                </td>
                <td class='td_e'><b>Employee Name</b></td>
                <td class='td_e'>
                        <input type='text' name='txtempname' value='' class='input_e'>
                </td>
                <td class='rb'></td>
        </tr>

        <tr>
                <td class='lb'></td>
                <td class='td_e'><b>Father Name</b></td>
                <td class='td_e' >
                        <input type='text' name='txtfathername' value='' class='input_e'>
                </td>
                <td class='td_e'><b>Mother Name</b></td>
                <td class='td_e' >
                        <input type='text' name='txtmothername' value='' class='input_e'>
                </td>
                <td class='rb'></td>
        </tr>

        <tr>
                <td class='lb'></td>
                <td class='td_e'><b>Date Of Birth</b></td>
                <td class='td_e'>
                  <?PHP
                              echo "<select name='BDay'  class='select_e'>";
                                          comboDay("");
                              echo "</select>
                                    <select name='BMonth' class='select_e'>";
                                          comboMonth("");
                              echo "</select>
                                    <select name='BYear' class='select_e'>";
                                          comboYear("");
                              echo"</select>";
                        ?>
                </td>
                <td class='td_e'><b>Joining Date at HR</b></td>
                <td class='td_e'>
                        <?PHP
                              echo "<select name='JDay' class='select_e'>";
                                          comboDay("");
                              echo "</select>
                                    <select name='JMonth' class='select_e'>";
                                          comboMonth("");
                              echo "</select>
                                    <select name='JYear' class='select_e'>";
                                          comboYear("");
                              echo"</select>";


                        ?>
                </td>
                <td class='rb'></td>
        </tr>
        <tr>
                <td class='lb'></td>
                <td class='td_e'><b>Joining Date at BPP</b></td>
                <td class='td_e'>
                        <?PHP
                              echo "<select name='BPDay' class='select_e'>";
                                          comboDay("");
                              echo "</select>
                                    <select name='BPMonth' class='select_e'>";
                                          comboMonth("");
                              echo "</select>
                                    <select name='BPYear' class='select_e'>";
                                          comboYear("");
                              echo"</select>";


                        ?>
                </td>
                <td class='td_e'><b>Designation</b></td>
                <td class='td_e'>
                        <select name='cbodesignation' class='select_e'>
                              <?PHP
                                    createCombo("Designation","mas_designation","designationid","description","","");
                              ?>
                        </select>
                </td>

                <td class='rb'></td>
        </tr>
        <tr>
                <td class='lb'></td>
                <td class='td_e'><b>Department</b></td>
                <td class='td_e'>
                        <select name='cboDepartment' class='select_e'>
                              <?PHP
                                    createCombo("Department","mas_cost_center","cost_code","description","","");
                              ?>
                        </select>
                </td>
                <td class='td_e'><b>Staf Type</b></td>
                <td class='td_e'>
                        <select name='cbostafftype' class='select_e'>
                              <option value='1'>Admin</option>
                              <option value='2'>Factory</option>
                        </select>
                </td>

                <td class='rb'></td>
        </tr>
        
        <tr>
                <td class='lb'></td>
                <td class='td_e'><b>Current Address</b></td>
                <td class='td_e' >
                        <textarea name='txtcuraddress'  class='input_e' ></textarea>
                </td>
                <td class='td_e'><b>Permanent Address</b></td>
                <td class='td_e' >
                        <textarea name='txtperaddress'  class='input_e'></textarea>
                </td>
                <td class='rb'></td>
        </tr>
        <tr>
                <td class='lb'></td>
                <td class='td_e'><b>Contact Number</b></td>
                <td class='td_e' >
                        <input type='text' name='txtcontactno' value='' class='input_e'>
                </td>
                <td class='td_e'><b>Blood Group</b></td>
                <td class='td_e' >
                        <input type='text' name='txtbloodgroup' value='' class='input_e' Size='10'>
                </td>

                <td class='rb'></td>
        </tr>
        <tr>
                <td class='lb'></td>
                <td class='td_e'><b>Email Address</b></td>
                <td class='td_e' colspan='3'>
                        <input type='text' name='txtemail' value='' class='input_e' Size='30'>
                </td>

                <td class='rb'></td>
        </tr>
         <tr>
                <td class='lb'></td>
                <td class='td_e'><b>Type</b></td>
                <td class='td_e' >
                       <select name='cbotype' class='select_e'>
                              <option value='1'>Regular</option>
                              <option value='2'>Casual</option>
                              <option value='3'>Project</option>
                              <option value='3'>Contract</option>
                        </select>
                </td>
                <td class='td_e'><b>Payment Type</b></td>
                <td class='td_e' >
                        <select name='cbopaytype' class='select_e'>
                              <option value='1'>Cash</option>
                              <option value='2'>Bank</option>
                        </select>
                        
                </td>

                <td class='rb'></td>
        </tr>
        <tr>
                <td class='lb'></td>
                <td class='td_e'><b>Remarks</b></td>
                <td class='td_e' >
                       <input type='text' name='txtremarks' value='' class='input_e' Size='30'>
                </td>
                <td class='td_e'><b>Status</b></td>
                <td class='td_e' >
                        <select name='cbostatus' class='select_e'>
                              <option value='1'>Active</option>
                              <option value='0'>Inactive</option>
                        </select>

                </td>

                <td class='rb'></td>
        </tr>

        <tr>
                <td class='lb'></td>
                <td  colspan='4' align='center' class='button_cell_e'>
                   <input type='Button' value='Submit' class='forms_Button_e' onclick='Submitfrom()'>
                </td>
                <td class='rb'></td>
        </tr>


        <tr>
            <td class='bottom_l_curb'></td>
            <td class='bottom_f_cell' colspan='4'></td>
            <td class='bottom_r_curb'></td>

        </tr>

</table>

</form>
</body>

</html>

