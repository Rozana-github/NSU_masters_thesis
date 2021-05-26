<?PHP
        include "Library/SessionValidate.php";
?>
<?PHP
        include "Library/dbconnect.php";
        include "Library/Library.php";
?>


<html>
<script language='javascript'>
         function back()
         {
                window.location="ChangeUserPassAndPer.php?";
         }


</script>
<LINK href="Application/Style/Apperance_1.css" type=text/css rel=stylesheet>
<body>
<form name='frmAddToBTSUpdate' method='post'>
<?PHP
        /*---------------------------- Developed By: MD.SHARIF UR RAHMAN --------------------------------------- */

        if($Modstat!=1)/*-------------- Users Permission Active And Disable when update all --------------------- */
        {

            for($i=0;$i<$txtCount; $i++)
            {

               if($txtDeleteLnkStat[$i]=="on")
               {

                        $UImages="
                                  UPDATE
                                        _nisl_mas_member
                                  SET
                                        Password='$txtnewpass[$i]',
                                        Data_Status='0',
                                        Type='$memType[$i]'
                                  where
                                        User_Name='$txtCount_ID[$i]'
                                ";
                        mysql_query($UImages) or die(mysql_error());

               }
               else
               {
                        $UImages="
                                  UPDATE
                                        _nisl_mas_member
                                  SET
                                        Password='$txtnewpass[$i]',
                                        Data_Status='1',
                                        Type='$memType[$i]'
                                  where
                                        User_Name='$txtCount_ID[$i]'
                                ";
                        mysql_query($UImages) or die(mysql_error());
               }


            }
        }/*------------------------------------------ END ---------------------------------------------------------*/
        else/*-------------- Permission Active And Disable when update at a time One User ---------------------*/
        {
            $UImages="
                    UPDATE
                            _nisl_mas_member
                        SET
                            Password='$txtnewpass',
                            Data_Status='$TxtActi',
                            Type='$memType'
                        where
                            User_Name='$txtUNam'
                    ";
            mysql_query($UImages) or die(mysql_error());

        }/*-------------------------------------------- END --------------------------------------------------*/


             echo "<table border='0' cellpadding='0' cellspacing='0' width='50%' height='30%' align='center'>
                <tr>
                        <td height='27%' align='center' style=\"background-color: #FFFFFF\">

                        </td>
                </tr>
                <tr>
                        <td height='13%' align='center' class='Header_Cell'>
                                Delete Report Confermation
                        </td>
                </tr>
                <tr>
                <td height='20%' align='center'>
                  <br>
                  Records Update Successfully

                <input type='button' value='Back' style=\"width: 80\" name='btnBack' onClick=back()>
               </td>
                </tr>
                <tr>
                    <td height='40%'></td>
                </tr>
                </table> ";






?>

</form>
</body>
</html>
<?PHP
        mysql_close();
?>
