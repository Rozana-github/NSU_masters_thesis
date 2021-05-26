<?PHP
        include "Library/SessionValidate.php";
?>
<html>

<head>
<meta http-equiv='Content-Language' content='en-us'>
<meta http-equiv='Content-Type' content='text/html; charset=windows-1252'>
<title>Password Change From  </title>
<link rel='stylesheet' type='text/css' href='css/styles.css' />
</head>
<body>
<?PHP

include_once("Library/dbconnect.php");


$check_query = "select *
                from _nisl_mas_member
                where Password = '$oldpass'
                and User_Name='$SUserName'
                ";

$rset = mysql_query($check_query) or die(mysql_error());


$row = mysql_fetch_array($rset);

if($row)
{
  extract($row);
  
  $newpass = trim($newpass);

  $update_query = "update _nisl_mas_member
                   set Password = '$newpass'
                   where User_Name = '$SUserName'
                  ";


 if(mysql_query($update_query))
      echo "<p class='forms_NewTitle'>Your Password is changed successfully.</p>";

}
else
  echo "<p class='forms_NewTitle'>Invalid Password</p>";

?>
</body>
</html>
<?PHP
        mysql_close();
?>
