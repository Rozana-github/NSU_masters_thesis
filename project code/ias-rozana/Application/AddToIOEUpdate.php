<?PHP
session_start();
        include_once("Library/dbconnect.php");
        include_once("Library/Library.php");

        mysql_query("BEGIN") or die("Operation can't be open");
?>

<html>

<head>

<meta http-equiv='Content-Language' content='en-us'>
<meta http-equiv='Content-Type' content='text/html; charset=windows-1252'>
<title>Supplier Entry Form</title>
<link rel='stylesheet' type='text/css' href='css/interface_styles.css' />

</head>

<body>
<form name='Form1' method='post'  action=''>

<?PHP


                //Insert into mas_invoice

                  $insertMasEmployee="
                                    update
                                          mas_ioe
                                    set
                                          employeeobjectid='".$cboemp."',
                                          amount='".$txtamount."',
                                          received_date=STR_TO_DATE('$rYear-$rMonth-$rDay','%Y-%c-%e'),
                                          expected_pay_date=STR_TO_DATE('$epYear-$epMonth-$epDay','%Y-%c-%e'),
                                          purpose='".$txtpurpose."',
                                          remarks='".$txtremarks."',
                                          method_of_pay='".$cbopaymathod."'

                                    where
                                          serial_no='".$txtslno."'

                                          
                  ";

                 //echo $insertMasEmployee;
                $resultMasEmployee=mysql_query($insertMasEmployee) or die(mysql_error());
                
               //------search invoice recent id-----------

        echo"
        <DIV class=form_background style=\"position: absolute; WIDTH: 570px; height:300px;\">
        <DIV class=form_groove_outer>
        <DIV class=form_groove_inner>

                <table border='0' width='100%' align='center' cellspacing='0' cellpadding='3'>
                        <tr>
                                <td align='center' width='100%'>
                                        <b><font size='2'>Information save Successfully</b></font>
                                </td>
                        </tr>
                        <tr>
                                <td align='center' width='100%'>
                                        <input type='button' name='btnBack' value='Back' onClick=\"window.location.href='IOEEntry.php' \"; >
                                </td>
                        </tr>
                </table>
        </DIV>
        </DIV>";

?>


<?PHP
        mysql_query("COMMIT") or die("Operation can't be Successfull");
?>

</form>
</body>

</html>

