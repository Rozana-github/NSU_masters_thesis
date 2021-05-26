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
           for($i=0;$i<$totalrow;$i++)
           {
            $inserttrn_emp_gratuaty="replace into
                                          trn_emp_gratuaty
                                          (
                                                emp_id,
                                                gratuaty_month,
                                                gratuaty_year,
                                                gratuaty_amount,
                                                remarks,
                                                entry_date,
                                                entry_by
                                          )
                                          values
                                          (
                                                '".$txtempid[$i]."',
                                                '$cboMonth',
                                                '$cboYear',
                                                '".$txtgratuaty[$i]."',
                                                '".$txtremarks[$i]."',
                                                sysdate(),
                                                '$SUserID'

                                          )";
      echo $inserttrn_emp_gratuaty;
                  mysql_query($inserttrn_emp_gratuaty) or die(mysql_error());
            }

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

