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

            if($txtloanid=='')
            {
                  $insertmas_loan=" insert into
                                          mas_loan
                                          (
                                                loan_description,
                                                loan_type,
                                                status,
                                                inerest_rate,
                                                remarks,
                                                effctive_date
                                          )
                                          values
                                          (
                                                '$txtloan',
                                                '$txtType',
                                                '$cboStatus',
                                                '$txtrate',
                                                '$txtremarks',
                                                STR_TO_DATE('$EDay-$EMonth-$EYear','%d-%m-%Y')
                                          )
                                    ";
                  //echo $insertmas_loan;
                  mysql_query($insertmas_loan) or die(mysql_error());
            }
            else
            {
                  $updatemas_loan=" update
                                          mas_loan
                                    set
                                          loan_description='$txtloan',
                                          loan_type='$txtType',
                                          status='$cboStatus',
                                          inerest_rate='$txtrate',
                                          remarks='$txtremarks',
                                          effctive_date=STR_TO_DATE('$EDay-$EMonth-$EYear','%d-%m-%Y')
                                    where
                                          loan_id='$txtloanid'
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

