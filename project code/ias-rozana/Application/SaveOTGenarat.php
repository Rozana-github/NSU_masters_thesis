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
                for($i=0;$i<$txttotal;$i++)
                {
                  $insertmas_wip="replace into
                                          emp_month_ot
                                          (
                                                emp_id,
                                                genarat_month,
                                                genarat_year,
                                                month_ot_hour,
                                                month_ot_amount,
                                                night_allowance,
                                                genarat_date

                                          )
                                          values
                                          (

                                                '".$txtempid[$i]."',
                                                '$cboMonth',
                                                '$cboYear',
                                                '".$txtothours[$i]."',
                                                '".$txtotamount[$i]."',
                                                '".$txtnightallowance[$i]."',
                                                sysdate()
                                          )
                                ";
                                //echo $insertmas_wip."<br>";
                              $resultmas_wip=mysql_query($insertmas_wip) or die(mysql_error());

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

