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



           //insert into mas_ytd_note
      $insertmas_ytd_note="replace into mas_ytd_note
                        (
                              proc_year,
                              proc_month,
                              glcode,
                              note_no,
                              trn_amount
                        )
                        values
                        (
                              '$txtyear',
                              '$txtMonth',
                              '30203',
                              '9',
                              '$txttotal'

                        )";
      mysql_query($insertmas_ytd_note) or die(mysql_error());

               //------search invoice recent id-----------
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

