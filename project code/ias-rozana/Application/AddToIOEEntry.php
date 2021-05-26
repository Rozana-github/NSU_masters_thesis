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
                  $insertMasIOE="insert into mas_ioe
                                        (
                                          employeeobjectid,
                                          amount,
                                          received_date,
                                          expected_pay_date,
                                          purpose,
                                          remarks,
                                          method_of_pay,
                                          status
                                        )
                                        values
                                        (
                                          '".$cboemp."',
                                          '".$txtamount."',
                                          STR_TO_DATE('$rYear-$rMonth-$rDay','%Y-%c-%e'),
                                          STR_TO_DATE('$epYear-$epMonth-$epDay','%Y-%c-%e'),
                                          '".$txtpurpose."' ,
                                          '".$txtremarks."',
                                          '".$cbopaymathod."',
                                          '0'
                                       )
                                ";

                 //echo $insertMasEmployee;
                $resultMasIOE=mysql_query($insertMasIOE) or die(mysql_error());
                
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

