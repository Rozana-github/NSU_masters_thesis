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

            if($txtleaveid=='')
            {
                  $insertmas_loan=" insert into
                                          mas_leave
                                          (
                                                leave_name,
                                                yearly_allocated,
                                                employee_type
                                          )
                                          values
                                          (
                                                '$txtleavename',
                                                '$txtnumber',
                                                '$text_emptype'

                                          )
                                    ";
                  //echo $insertmas_loan;
                  mysql_query($insertmas_loan) or die(mysql_error());
            }
            else
            {
                  $updatemas_loan=" update
                                          mas_leave
                                    set
                                          leave_name='$txtleavename',
                                          yearly_allocated='$txtnumber',
                                          employee_type='$text_emptype'
                                    where
                                          leave_id='$txtleaveid'
                                    ";
                  //echo $updatemas_loan;
                  mysql_query($updatemas_loan) or die(mysql_error());
            }






                
               //------search invoice recent id-----------



?>


<?PHP
        if(mysql_query("COMMIT"))
      {
            drawMassage("Data Saved Succssfully","");
      }
      else
      {
            drawMassage("Data Saved Error","");
      }
?>

</form>
</body>

</html>

