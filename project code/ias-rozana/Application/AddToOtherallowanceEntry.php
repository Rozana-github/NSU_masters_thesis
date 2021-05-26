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

                if($txtallowanceid=='')
                {
                //Insert into mas_invoice
                  $insertMasDesignation="insert into mas_others_allowance
                                        (
                                          description,
                                          amount,
                                          effective_date,
                                          issue_date
                                        )
                                        values
                                        (
                                          '".$txtdescription."',
                                          '".$txtamount."',
                                          STR_TO_DATE('$EYear-$EMonth-$EDay','%Y-%c-%e'),
                                          sysdate()

                                       )
                                ";
                 }
                 else
                 {
                  $insertMasDesignation="
                                    update
                                          mas_others_allowance
                                    set
                                         description='".$txtdescription."',
                                         amount='".$txtamount."',
                                         effective_date=STR_TO_DATE('$EYear-$EMonth-$EDay','%Y-%c-%e')
                                         
                                          
                                    where
                                          others_allowance_id='".$txtallowanceid."'

                                          
                  ";
                 }
                //echo $insertMasDesignation;
                $resultMasEmployee=mysql_query($insertMasDesignation) or die(mysql_error());
                
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

