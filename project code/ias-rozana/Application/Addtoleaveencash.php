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

            $inserttrn_emp_gratuaty="insert into
                                           trn_leave_encash
                                          (
                                                emp_id,
                                                encash_month,
                                                encash_year,
                                                salary,
                                                available_leave,
                                                encash_days,
                                                amount,
                                                entry_date,
                                                entry_by

                                          )
                                          values
                                          (
                                                '".$cboemployee."',
                                                '".$cboMonth."',
                                                '".$cboYear."',
                                                '".$txtsalary."',
                                                '".$txtavailableleave."',
                                                '".$txtadjustleave."',
                                                '".$txtamount."',
                                                sysdate(),
                                                '".$SUserID."'


                                          )";

                  //echo $inserttrn_emp_gratuaty;
                  mysql_query($inserttrn_emp_gratuaty) or die(mysql_error());
                  
                  $balance_after_encash=$txtavailableleave-$txtadjustleave;
                  $updatemas_emp_leave="update
                                                mas_emp_leave
                                          set
                                                balance='".$balance_after_encash."'
                                          where
                                                leave_year='".$cboYear."'
                                                and emp_id='".$cboemployee."'
                                          ";
                mysql_query($updatemas_emp_leave) or die(mysql_error());


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

