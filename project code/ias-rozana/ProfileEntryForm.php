<?PHP
        include "Library/SessionValidate.php";
?>
<?PHP
        include "Library/dbconnect.php";
?>
<html>

<head>
      <meta http-equiv="Content-Language" content="en-us">
      <meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
      <title>New Page 1</title>
      <script language='javascript'>
            function checkValue()
            {
                  if(document.myform.ProfileName.value=="")
                  {
                        alert("Profile Name Should Not Be Empty.");
                        return false;
                  }
                  return true;
            }
            function assignValue(val)
            {
                  document.myform.ProfileID.value=document.myform.elements["hidProfileID["+val+"]"].value;
                  document.myform.ProfileName.value=document.myform.elements["hidProfileName["+val+"]"].value;
                  document.myform.SaveProfile.value="Edit";
            }
            function ChkAll()
            {
                window.location="ProfileEntryForm.php?CHKAll=1";
            }
            function UnchkAll()
            {
                window.location="ProfileEntryForm.php?CHKAll=2";
            }
      </script>
      <LINK href="Application/Style/generic_form.css" type='text/css' rel='stylesheet'>
      <link rel='stylesheet' type='text/css' href='Application/Style/eng_form.css' />
</head>

<body class='body_e'>


<?PHP /*------------------------------------ Modify by MD.SHARIF UR RAHMAN -------------------------------------------*/ ?>

<form name='myform' method="POST" action="ProfileEntryForm.php">
    <!--webbot bot="SaveResults" U-File="fpweb:///_private/form_results.csv" S-Format="TEXT/CSV" S-Label-Fields="TRUE" -->
      <table border='0' width='80%' id='table1' cellspacing='0' cellpadding='0' align='center'>
            <tr>
                  <td class='top_left_curb'></td>
                  <td class='header_cell_e' colspan='2'>Profile Creation Form</td>
                  <td class='top_right_curb'></td>
            </tr>
            <tr>
                  <td class='lb' rowspan='2'></td>
                  <td class='caption_e'>Profile Name:</td>
                  <td class='td_e'>
                        <input type="hidden" name="ProfileID" size="32">
                        <input type="text" name="ProfileName" size="40" class='input_e'>
                  </td>
                  <td class='rb' rowspan='2'></td>
            </tr>
            <tr>
                  <td align=center colspan='2' class='button_cell_e'>
                        <input type="submit" value="Entry" name="SaveProfile" onclick='return checkValue()' class='forms_button_e'>
                        <input type="reset" value="Refresh" onclick='document.myform.SaveProfile.value="Entry"' class='forms_button_e'>
                  </td>
            </tr>
            <tr>
                  <td class='bottom_l_curb'></td>
                  <td class='bottom_f_cell' colspan='2'></td>
                  <td class='bottom_r_curb'></td>
            </tr>
      </table>


<?PHP
        if(isset($SaveProfile) && $SaveProfile=="Entry"){
                $query="insert into _nisl_mas_profile(ProfileName) values('$ProfileName')";
                $rs=mysql_query($query) or die(mysql_error());
        }
        if(isset($SaveProfile) && $SaveProfile=="Edit"){
                $query="update _nisl_mas_profile set ProfileName='$ProfileName' where ProfileID='$ProfileID'";
                $rs=mysql_query($query) or die(mysql_error());
        }
		
		if(isset($btnUpdate) && $btnUpdate=="Permission")/*--------------------- Modify Date 25/02/08 By: SHARIF ----------------------------*/
        {
            for($i=0;$i<$txtCount; $i++){
               if($txtDeleteLnkStat[$i]=="on"){
                    $UImages="
                                UPDATE
                                    _nisl_mas_profile
                                SET
                                    Data_Status='0'
                                where
                                    ProfileID='$txtCount_ID[$i]'
                            ";
                    mysql_query($UImages) or die(mysql_error());
               }else{
                    $UImages="
                                UPDATE
                                    _nisl_mas_profile
                                SET
                                    Data_Status='1'
                                where
                                    ProfileID='$txtCount_ID[$i]'
                            ";
                    mysql_query($UImages) or die(mysql_error());
               }
            }
            echo "<script language='javascript'>alert(\"Permission Change Successfully\");</script>";
        }/*----------------------------------------- END -----------------------------------------------------------*/
?>
<?PHP
    $query="select * from _nisl_mas_profile order by ProfileName";
    $rs=mysql_query($query) or die(mysql_error());

      if(mysql_num_rows($rs)>0)
      {
            echo "
            <table border='0' width='80%' cellspacing='0' cellpadding='0' id='table2' align='center' style=\"position: relative; top: 6\">
                  <tr>
                        <td class='top_left_curb'></td>
                        <td class='header_cell_e' colspan='3'>Profile List</td>
                        <td class='top_right_curb'></td>
                  </tr>
                  <tr>
                        <td class='lb'></td>
                        <td class='title_cell_e'>
                              Profile Name (click on Profile name for profile permission change)
                        </td>
                        <td class='title_cell_e' align='center'>Title Edit</td>
                        <td class='title_cell_e'>Permission Status</td>
                        <td class='rb'></td>
                  </tr>
            ";

            $i=0;
            while($row=mysql_fetch_array($rs))
            {
                  extract($row);
                  if($i%2==0)
                        $class="even_td_e";
                  else
                        $class="odd_td_e";
                  if(isset($CHKAll) && $CHKAll==2)
                  {
                        $Data_Status=1;
                  }
                  echo "
                  <tr>
                        <td class='lb'></td>
                        <td class='$class'><a href='ProfilePermissionEntry.php?ProfileID=$ProfileID'>$ProfileName</a></td>
                        <td class='$class' align='center'>
                              <input type='button' name='btnEdit[$i]' class='forms_button_e' value='Edit' onclick=\"assignValue('$i')\">
                              <input type='hidden' name='hidProfileID[$i]' value='$ProfileID'>
                              <input type='hidden' name='hidProfileName[$i]' value='".htmlentities($ProfileName,ENT_QUOTES)."'>
                        </td>
                        <input type='hidden' name='txtCount_ID[$i]' value='$ProfileID'>
                        <td class='$class' align='center'>";
                              if(isset($CHKAll) && ($Data_Status==0 || $CHKAll==1))
                              {
                                    echo "<input type='checkbox' name='txtDeleteLnkStat[$i]' value='on' checked>";
                              }
                              else
                              {
                                    echo "<input type='checkbox' name='txtDeleteLnkStat[$i]' value='on'>";
                              }
                              echo "
                        </td>
                        <td class='rb'></td>
                  </tr>";
            $i++;
            }
            echo "
                  <input type='hidden' name='txtCount' value='$i'>
                  <tr>
                        <td class='lb'></td>
                        <td colspan='3' align='center' class='button_cell_e' >
                              <input type='submit' value='Permission' name='btnUpdate' class='forms_button_e'>
                              <input type='button' value='Check All' name='btnChkAll' class='forms_button_e' onclick='ChkAll()'>
                              <input type='button' value='Uncheck All' name='btnChkAll' class='forms_button_e' onclick='UnchkAll()'>
                        </td>
                        <td class='rb'></td>
                  </tr>
                  <tr>
                        <td class='bottom_l_curb'></td>
                        <td class='bottom_f_cell' colspan='3'></td>
                        <td class='bottom_r_curb'></td>
                  </tr>
            </table>";
      }
      else
      {
            echo "Profile Data Not Avilable";
      }
?>
</form>

</body>

</html>
<?PHP
      mysql_close();
?>
