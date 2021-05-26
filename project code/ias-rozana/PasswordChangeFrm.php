<?PHP
        include "Library/SessionValidate.php";
?>
<?PHP

    include "Library/dbconnect.php";
?>
<html>

<head>
<meta http-equiv='Content-Language' content='en-us'>
<meta http-equiv='Content-Type' content='text/html; charset=windows-1252'>
<title>Password Change From  </title>
<LINK href="Application/Style/generic_form.css" type='text/css' rel='stylesheet'>
<link rel='stylesheet' type='text/css' href='Application/Style/eng_form.css' />

<script language='Javascript'>
    function check()
    {
        if(document.frm.newpass.value!='')
        {
            if(document.frm.newpass.value==document.frm.rnewpass.value)
                document.frm.submit();
            else
            {
                alert('Passwords dont match');
                document.frm.newpass.value='';
                document.frm.rnewpass.value='';
            }
        }
        else
        {
            alert('Empty value not accepted');
        }
    }
    
    function ChnageOthers()
    {
        window.location="ChangeUserPassAndPer.php";
    }

</script>

</head>

<body class='body_e'>
<form name='frm' method='post' action='changePassword.php'>
      <table border='0' width='60%' cellspacing='0' cellpadding='0' align='center'>
            <tr>
                  <td class='top_left_curb'></td>
                  <td colspan='3' class='header_cell_e' valign='top'>Password Change Form</td>
                  <td class='top_right_curb'></td>
            </tr>


        <?PHP
        /*-------------------------------- Created By: SHARIF UR RAHMAN ------------------------------------------ */
        /*-------------------------------- This Portion Check Member Type For Change Password -------------------- */
            if(isset($SUserName))
            {
                $MemData="select
                                Type
                            from
                                _nisl_mas_member
                            where
                                User_Name='$SUserName'
                            ";
                $ExecuteSeRcord=mysql_query($MemData) or die(mysql_error());
                if(mysql_num_rows($ExecuteSeRcord)>0)
                {
                    while($rowE=mysql_fetch_array($ExecuteSeRcord))
                    {
                        extract($rowE);
                        if($Type==1)
                        {
                              echo "
                              <tr>
                                    <td class='lb' class='title_cell_e'></td>
                                    <td align='center' colspan='2' class='title_cell_e'>OWN</td>
                                    <td align='right' class='title_cell_e'>
                                          <input type='button' name='btnOthers' value='Others' class='forms_button_e' onclick='ChnageOthers()'>&nbsp;
                                    </td>
                                    <td class='rb'></td>
                              </tr>";
                        }
                    }
                }
            }
        /*----------------------------------------------- END -----------------------------------------------------*/
        ?>

        <tr>
            <td rowspan='4' class='lb'></td>
            <td class='caption_e'>Type Old Password</td>
            <td class='td_e'><input type='password' name='oldpass' size='27' class='input_e'></td>
            <td class='td_e'>&nbsp;</td>
            <td rowspan='4' class='rb'></td>
        </tr>
        <tr>
            <td class='caption_e'>Type New Password</td>
            <td class='td_e'><input type='password' name='newpass' size='27' class='input_e'></td>
            <td class='td_e'>&nbsp;</td>
        </tr>
        <tr>
            <td class='caption_e'>Re-Type New Password</td>
            <td class='td_e'><input type='password' name='rnewpass' size='27' class='input_e'></td>
            <td class='td_e'>&nbsp;</td>
        </tr>
        <tr>
            <td colspan='3' align='center' class='button_cell_e'>
              <input type='button' value='Submit' name='saveBtn' class='forms_button_e' onClick='check()'>
              <input type='reset' value='Reset' name='resetBtn' class='forms_button_e'>
            </td>
       </tr>
      <tr>
            <td class='bottom_l_curb' bgcolor='cccccc'></td>
            <td class='bottom_f_cell'colspan='3' bgcolor='cccccc'></td>
            <td class='bottom_r_curb' bgcolor='cccccc'></td>
      </tr>
    </table>
</form>
</body>
</html>
<?PHP
        mysql_close();
?>

