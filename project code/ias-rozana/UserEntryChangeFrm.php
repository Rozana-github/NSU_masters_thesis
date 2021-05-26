<?PHP
        include "Library/SessionValidate.php";
?>
<?PHP
        include_once "Library/Library.php";
        include_once "Library/dbconnect.php";
?>


<html>

<head>
<meta http-equiv='Content-Language' content='en-us'>
<meta http-equiv='Content-Type' content='text/html; charset=windows-1252'>
<title>User Entry Form</title>
<LINK href="Application/Style/generic_form.css" type='text/css' rel='stylesheet'>
<link rel='stylesheet' type='text/css' href='Application/Style/eng_form.css' />

<script language='Javascript'>
      function showPresentUserData(){
            document.frm.action="UserEntryChangeFrm.php";
            document.frm.submit();
      }

function checkAndSubmit(){
        if (document.frm.nam.value=='')
                alert('Please enter your name');
        else if (document.frm.des.value=='')
                 alert('Please enter your designation');
        else if (document.frm.cname.value=='')
                 alert('Please enter your Company Name');
        else if (document.frm.username.value=='')
                 alert('You must choose a user name');
        else
                document.frm.submit();

}

</script>
</head>

<body class='body_e'>
<?PHP

echo "
<form name='frm' method='post' action='UpdateUser.php'>
<table border='0' width='60%' cellspacing='0' cellpadding='0' align='center'>
      <tr>
            <td class='top_left_curb'></td>
            <td colspan='2' class='header_cell_e'>User Entry Change Form</td>
            <td class='top_right_curb'></td>
      </tr>
      <tr>
            <td class='lb'></td>
            <td class='title_cell_e' align='right'>Select User</td>
            <td class='title_cell_e'>
                  <select size='1' name='user' onchange='showPresentUserData()' class='select_e'>";
                        createCombo("User","_nisl_mas_user","User_ID","Name","",$user);
                  echo "</select>
            </td>
            <td class='rb'></td>
      </tr>";
if(isset($_POST['user']) && $_POST['user'] != "-1" && isset($_POST['user'])){
    $show = "
	select
			_nisl_mas_user.User_ID,
			_nisl_mas_member.User_Name,
			_nisl_mas_member.Type,
			_nisl_mas_user.Name,
			_nisl_mas_user.Designation,
			_nisl_mas_user.CompanyName,
			_nisl_mas_user.Address,
			_nisl_mas_user.Email,
			_nisl_mas_user.Phone
	From
			_nisl_mas_user LEFT JOIN _nisl_mas_member ON _nisl_mas_user.User_ID=_nisl_mas_member.User_ID
	Where
			_nisl_mas_user.User_ID='".$_POST['user']."'";

      
	$Query=mysql_query($show)or die(mysql_error());
	while($row=mysql_fetch_array($Query)){
		$Name=$row["Name"];
		$Designation=$row["Designation"];
		$CompanyName=$row["CompanyName"];
		$Address=$row["Address"];
		$Email=$row["Email"];
		$Phone=$row["Phone"];
		$UserName=$row["User_Name"];
		$Type=$row["Type"];
		
		echo "	<tr>
					<td rowspan='8' class='lb'></td>
					<td class='caption_e'>Name</td>
					<td class='td_e'><input type='text' name='nam' size='30' value='$Name' class='input_e'><font color='red'>&nbsp;*</font></td>
					<td rowspan='8' class='rb'></td>
				</tr>
				<tr>
					<td class='caption_e'>Designation</td>
					<td class='td_e'><input type='text' name='des' size='30' value='$Designation' class='input_e'><font color='red'>&nbsp;*</font></td>
				</tr>
				<tr>
					<td class='caption_e'>Company Name</td>
					<td class='td_e'><input type='text' name='cname' size='30' value='$CompanyName' class='input_e'><font color='red'>&nbsp;*</font></td>
				</tr>
				<tr>
					<td class='caption_e'>Address</td>
					<td class='td_e'><input type='text' name='address' size='30' value='$Address' class='input_e'></td>
				</tr>
				<tr>
					<td class='caption_e'>Email</td>
					<td class='td_e'><input type='text' name='email' size='30' value='$Email' class='input_e'></td>
				</tr>
				<tr>
					<td class='caption_e'>Phone</td>
					<td class='td_e'><input type='text' name='phone' size='30' value='$Phone' class='input_e'></td>
				</tr>
				<tr>
					<td class='caption_e'>Member Type</td>
					<td class='td_e'> 
					<select size='1' name='memdrop' class='select_e'>
						<option value='0'"; echo ($Type=="0")? "selected":""; echo "> General </option>
						<option value='1'"; echo ($Type=="1")? "selected":""; echo ">Administrator</option>";
                    
					echo "</select></td>
                        </tr>
                        <tr>
                                <td class='caption_e'>User Name</td>
                                <td class='td_e'><input type='text' name='username' size='30' value='$UserName' class='input_e'><font color='red'>&nbsp;*</font></td>
                        </tr>";
	}
	
	echo    "
				<tr>
					<td class='lb'></td>
					<td class='td_e' colspan='2'>&nbsp;</td>
					<td class='rb'></td>
				</tr>
				<tr>
					<td class='lb'></td>
					<td colspan='2' class='button_cell_e' align='center'>
						<input type='button' value='Update' name='saveBtn' class='forms_button_e' onClick='checkAndSubmit()'>
						<input type='reset' value='Reset' name='saveBtn' class='forms_button_e'>
					</td>
					<td class='rb'></td>
				</tr>";
				echo "
				<tr>
					<td class='lb'></td>
					<td class='td_e' colspan='2'>All <font color='FF0000'>*</font> marked fields are Required</td>
					<td class='rb'></td>
				</tr>";
}
        echo "
            <tr>
                  <td class='bottom_l_curb'>&nbsp;</td>
                  <td class='bottom_f_cell' colspan='2'></td>
                  <td class='bottom_r_curb'></td>
            </tr>


  </table>
  </form>";

?>

</body>
</html>
<?PHP
        mysql_close();
?>
