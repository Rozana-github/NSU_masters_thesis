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

<script language='JavaScript'>
            function back()
            {
                  window.location="OverTimeEntry.php";
            }
        </script>

</head>

<body>
<form name='Form1' method='post'  action=''>

<?PHP


                //Insert into mas_invoice
                for($i=0;$i<$txttotal;$i++)
                {
                  $insertmas_wip="replace into
                                          trn_emp_ot
                                          (
                                                emp_id,
                                                ot_date,
                                                ot_hour

                                          )
                                          values
                                          (

                                                '".$txtempid[$i]."',
                                                STR_TO_DATE('$txtDay-$txtMonth-$txtYear','%d-%m-%Y'),
                                                '".$txtothours[$i]."'
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
            drawMassage("Data Saved Succssfully","onClick='back()'");
      }
      else
      {
            drawMassage("Data Saved Error","Onclick='back()'");
      }
?>

</form>
</body>

</html>

