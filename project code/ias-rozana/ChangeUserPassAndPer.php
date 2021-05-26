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
    function Permission()
    {
        var i;
        var j=0;
        var txtCount=document.frmPermi.txtCount.value;
        for(i=0;i<txtCount;i++)
        {
            if(document.frmPermi.elements["txtDeleteLnkStat["+i+"]"].checked==false)
            {
                j=j+1;
            }
        }
        if(txtCount==j)
        {
            alert("Select at least one title click on check box then press Delete");
        }
        else
        {
            document.frmPermi.submit();
        }
    }
    
    function PermissionSpacific(i)
    {

        if(document.frmPermi.elements["txtDeleteLnkStat["+i+"]"].checked==false)
        {
            var Acti=1;
        }
        else
        {
            var Acti=0;
        }
        var Type=document.frmPermi.elements["memType["+i+"]"].value;
        var Pass=document.frmPermi.elements["txtnewpass["+i+"]"].value;
        var Uname=document.frmPermi.elements["txtCount_ID["+i+"]"].value;
        window.location="AddToUsersChangePas.php?Modstat=1&txtUNam="+Uname+"&txtnewpass="+Pass+"&memType="+Type+"&TxtActi="+Acti+"";
    }
    function Back()
    {
        window.location="PasswordChangeFrm.php";
    }

</script>

</head>

<body class='body_e'>

<form name='frmPermi' method='post' action='AddToUsersChangePas.php'>
      <table border='0' width='100%' cellspacing='0' cellpadding='0' align='center'>
            <tr>
                  <td class='top_left_curb'></td>
                  <td colspan='5' class='header_cell_e' valign='top' align='center'>Other Users Password Change Form</td>
                  <td class='top_right_curb'></td>
            </tr>
            <?PHP
      /*-------------------------------- Created By: SHARIF UR RAHMAN ------------------------------------------ */
      /*-------------------------------- This Portion Check Member Type For Change Password -------------------- */
            echo "
            <tr>
                  <td class='lb'></td>
                  <td align='center' class='title_cell_e'>Users Name</td>
                  <td align='center' class='title_cell_e'>Password</td>
                  <td align='center' class='title_cell_e'>Permission Status</td>
                  <td align='center' class='title_cell_e'>User Type</td>
                  <td align='center' class='title_cell_e'>Update?</td>
                  <td class='rb'></td>
            </tr>";
            if(isset($SUserName))
            {
                  $MemData="select
                                    User_Name,
                                    Password,
                                    Type,
                                    Data_Status
                              from
                                    _nisl_mas_member
                            ";
                  $ExecuteSeRcord=mysql_query($MemData) or die(mysql_error());
                  if(mysql_num_rows($ExecuteSeRcord)>0)
                  {
                        $i=0;
                        while($rowE=mysql_fetch_array($ExecuteSeRcord))
                        {
                              extract($rowE);
                              if ($i%2==0)
                                    $class="even_td_e";
                              else
                                    $class="odd_td_e";
                              echo "
                              <tr>
                                    <td class='lb'></td>
                                    <td class='$class'>&nbsp;$User_Name</td>
                                    <td align='center' class='$class'>
                                          <input type='password' name='txtnewpass[$i]' size='27' value='$Password' class='input_e'>
                                    </td>
                                    <td align='center' class='$class'>";
                                          if($Data_Status==0)
                                          {
                                                echo "<input type='checkbox' name='txtDeleteLnkStat[$i]' value='on' checked class='input_e'>";
                                          }
                                          else
                                          {
                                                echo "<input type='checkbox' name='txtDeleteLnkStat[$i]' value='on' class='input_e'>";
                                          }
                                    echo "
                                    </td>
                                    <td align='center' class='$class'>
                                          <select size='1' name='memType[$i]'>";
                                                if($Type==1)
                                                {
                                                      echo "
                                                      <option value='0'> General </option>
                                                      <option value='1' selected>Administrator</option>";
                                                }
                                                else
                                                {
                                                      echo "
                                                      <option value='0' selected> General </option>
                                                      <option value='1'>Administrator</option>";
                                                }
                                          echo "
                                          </select>
                                    </td>
                                          <input type='hidden' name='txtCount_ID[$i]' value='$User_Name' >
                                    <td align='center' class='$class'>
                                          <input type='button' value='Update' name='btnUpdate' class='forms_button_e' onClick='PermissionSpacific($i)'>
                                    </td>
                                    <td class='rb'></td>
                              </tr>
                              ";
                        $i++;
                        }
                  echo "<input type='hidden' name='txtCount' value='$i'>";
                  }
            }
        /*----------------------------------------------- END -----------------------------------------------------*/
        ?>

            <tr>
                  <td class='lb'></td>
                  <td colspan='5' align='center' class='button_cell_e'>
                        <input type='button' value='Update All' name='btnUpdateAll' class='forms_button_e' onClick='Permission()'>
                        <input type='button' value='Back' name='resetBtn' class='forms_button_e' onclick='Back()'>
                  </td>
                  <td class='rb'></td>
            </tr>
      <tr>
            <td class='bottom_l_curb' bgcolor='cccccc'></td>
            <td class='bottom_f_cell'colspan='5' bgcolor='cccccc'></td>
            <td class='bottom_r_curb' bgcolor='cccccc'></td>
      </tr>
      </table>
</form>
</body>
</html>
<?PHP
        mysql_close();
?>
