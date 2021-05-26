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
                  $insertMasSal="insert into mas_sal_info
                                        (
                                          grad_name,
                                          basic_salary,
                                          house_allowance,
                                          medical_allowance,
                                          convance,
                                          food_allowance,
                                          utility_allowance,
                                          special_allowance,
                                          maintenance_allowance,
                                          inflation_allowance,
                                          transport,
                                          others_allowance_id,
                                          effctive_from,
                                          status,
                                          entry_date

                                        )
                                        values
                                        (
                                          '".$txtGname."',
                                          '".$txtBasic."',
                                          '".$txtHouse."',
                                          '".$txtMedical."',
                                          '".$txtConvance."',
                                          '".$txtFood."',
                                          '".$txtUtility."',
                                          '".$txtSpecial."',
                                          '".$txtMaintainnance."',
                                          '".$txtInflation."',
                                          '".$txtTransport."',
                                          '".$cboOthers."',
                                          STR_TO_DATE('$EYear-$EMonth-$EDay','%Y-%c-%e'),
                                          '".$cboStatus."',
                                          sysdate()

                                       )
                                ";
                 }
                 else
                 {
                  $insertMasSal="
                                    update
                                          mas_sal_info
                                    set
                                         grad_name='".$txtGname."',
                                          basic_salary='".$txtBasic."',
                                          house_allowance='".$txtHouse."',
                                          medical_allowance='".$txtMedical."',
                                          convance='".$txtConvance."',
                                          food_allowance='".$txtFood."',
                                          utility_allowance='".$txtUtility."',
                                          special_allowance='".$txtSpecial."',
                                          maintenance_allowance='".$txtMaintainnance."',
                                          inflation_allowance='".$txtInflation."',
                                          transport='".$txtTransport."',
                                          others_allowance_id='".$cboOthers."',
                                          effctive_from=STR_TO_DATE('$EYear-$EMonth-$EDay','%Y-%c-%e'),
                                          status='".$cboStatus."',
                                          increment_date=sysdate()
                                         
                                          
                                    where
                                         sal_grad_id='".$txtallowanceid."'

                                          
                  ";
                 }
                echo $insertMasSal;
                $resultMasSal=mysql_query($insertMasSal) or die(mysql_error());
                
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

