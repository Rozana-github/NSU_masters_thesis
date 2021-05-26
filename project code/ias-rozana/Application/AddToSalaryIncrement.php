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

                for($i=0;$i<$txtTotalrow;$i++)
                {
                //Insert into mas_invoice
                        $increasebasic=$txtbasic[$i]+$txtIncrement[$i];

                            $inserttrn_emp_sal="update
                                                       mas_emp_sal_info
                                                set
                                                      basic_salary='$increasebasic',
                                                      incement_amount='".$txtIncrement[$i]."',
                                                      increment_date=STR_TO_DATE('".$txtDay[$i]."-".$txtMonth[$i]."-".$txtYear[$i]."','%d-%m-%Y')
                                                where
                                                        employee_id='".$txtEmployeeid[$i]."'

                                                      " ;
                                           echo $inserttrn_emp_sal;
                                           mysql_query($inserttrn_emp_sal) or die(mysql_error());

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

