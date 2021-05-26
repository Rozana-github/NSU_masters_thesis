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

                        if($cboleave[$i]!='-1')
                        {
                        $insertmas_emp_loan=" insert into
                                                trn_emp_leave
                                                (
                                                      emp_id,
                                                      starting_date ,
                                                      ending_date ,
                                                      leave_id ,
                                                      remarks
                                                )
                                                values
                                                (
                                                       '".$txtEmployeeid[$i]."',
                                                       STR_TO_DATE('".$txtstartYear[$i]."-".$txtstartMonth[$i]."-".$txtstartDay[$i]."','%Y-%c-%e'),
                                                       STR_TO_DATE('".$txtendYear[$i]."-".$txtendMonth[$i]."-".$txtendDay[$i]."','%Y-%c-%e'),

                                                       '".$cboleave[$i]."',
                                                       '".$txtremark[$i]."'


                                                )
                                          ";
                         //echo
                         mysql_query($insertmas_emp_loan)or die(mysql_error());
                         }
                        //echo $insertmas_emp_loan;

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

