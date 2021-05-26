<?PHP
        include "Library/SessionValidate.php";
?>
<html>

<head>
<meta http-equiv='Content-Language' content='en-us'>
<meta http-equiv='Content-Type' content='text/html; charset=windows-1252'>
<title>User Entry Form</title>
<LINK href="Application/Style/generic_form.css" type='text/css' rel='stylesheet'>
<link rel='stylesheet' type='text/css' href='Application/Style/eng_form.css' />

<script language='Javascript'>

function checkAndSubmit()
{

        if (document.frm.nam.value=='')
                alert('Please enter your name');
        else if (document.frm.des.value=='')
                 alert('Please enter your designation');
        else if (document.frm.cname.value=='')
                 alert('Please enter your Company Name');
        else if (document.frm.username.value=='')
                 alert('You must choose a user name');
        else if (document.frm.pass.value =='')
                 alert('You must choose a password');
        else if (document.frm.rpass.value=='')
                 alert('You must retype the password');
        else if (document.frm.pass.value!=document.frm.rpass.value)
                alert('Passwords do not match');
        else
                document.frm.submit();

}

</script>


</head>

<body class='body_e'>

<?PHP

echo "
 <form name='frm' method='post' action='createUser.php'>
  <table border='0' width='60%' cellspacing='0' cellpadding='0' align='center'>
        <tr>
                <td class='top_left_curb'></td>
                  <td colspan='2' class='header_cell_e'>User Entry Form</td>
                <td class='top_right_curb'></td>
        </tr>
        <tr>
                <td rowspan='13' class='lb'></td>
                  <td class='caption_e'>Name</td>
                  <td class='td_e'><input type='text' name='nam' size='29' class='input_e'><font color='red'>&nbsp;*</font></td>
                <td rowspan='13' class='rb'></td>
        </tr>
        <tr>
                <td class='caption_e'>Designation</td>
                <td class='td_e'><input type='text' name='des' size='29' class='input_e'><font color='red'>&nbsp;*</font></td>
        </tr>
        <tr>
                <td class='caption_e'>Company Name</td>
                <td class='td_e'><input type='text' name='cname' size='29' class='input_e'><font color='red'>&nbsp;*</font></td>
        </tr>
        <tr>
                <td class='caption_e'>Address</td>
                <td class='td_e'><input type='text' name='address' size='29' class='input_e'></td>
        </tr>
        <tr>
                <td class='caption_e'>Email</td>
                <td class='td_e'><input type='text' name='email' size='29' class='input_e'></td>
        </tr>
        <tr>
                <td class='caption_e'>Phone</td>
                <td class='td_e'><input type='text' name='phone' size='29' class='input_e'></td>
        </tr>
        <tr>
                <td class='caption_e'>Member Type</td>
                <td class='td_e'>
                    <select size='1' name='memdrop' class='select_e'>
                        <option value='0'> General </option>
                        <option value='1'>Administrator</option>
                    </select>
                </td>
        </tr>
        <tr>
                <td class='caption_e'>Enter User Name</td>
                <td class='td_e'>
                    <input type='text' name='username' size='24' class='input_e'><font color='red'>&nbsp;*</font>
                </td>
        </tr>
        <tr>
                <td class='caption_e'>Enter Password</td>
                <td class='td_e'>
                    <input type='password' name='pass' size='24' class='input_e'><font color='red'>&nbsp;*</font>
                </td>
        </tr>
        <tr>
                <td class='caption_e'>Re-Enter Password</td>
                <td class='td_e'>
                    <input type='password' name='rpass' size='24' class='input_e'><font color='red'>&nbsp;*</font>
                </td>
        </tr>
        <tr>
                <td colspan='2' class='td_e'>&nbsp;</td>
        </tr>
        <tr>
                <td colspan='2' class='button_cell_e' align='center'>
                        <input type='button' value='Submit' name='saveBtn' class='forms_button_e' onClick='checkAndSubmit()'>
                        <input type='reset' value='Reset' name='saveBtn' class='forms_button_e'>
                </td>
        </tr>
        <tr>
                  <td colspan='2' class='td_e'>All <font color='FF0000'>*</font> signed fields are required</td>
        </tr>
        <tr>
                <td class='bottom_l_curb' bgcolor='cccccc'></td>
                <td class='bottom_f_cell'colspan='2' bgcolor='cccccc'></td>
                <td class='bottom_r_curb' bgcolor='cccccc'></td>
       </tr>
  </table>
  </form>";
?>

</body>
</html>
