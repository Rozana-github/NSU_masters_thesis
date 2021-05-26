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
            if($livename[$i]!='-1')
            {
            $inserttrn_emp_gratuaty="replace into
                                          mas_emp_leave
                                          (
                                                emp_id,
                                                leave_year,
                                                leave_id,
                                                opening_balance,
                                                current_allocation,
                                                balance,
                                                remarks

                                          )
                                          values
                                          (
                                                '".$txtempid[$i]."',
                                                '$cboYear',
                                                '".$livename[$i]."',
                                                '".$txtopen[$i]."',
                                                '".$txtcurrent[$i]."',
                                                '".$txtbalance[$i]."',
                                                '".$txtremarks[$i]."'


                                          )";

      echo $inserttrn_emp_gratuaty;
                  mysql_query($inserttrn_emp_gratuaty) or die(mysql_error());
                  }
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

