<?PHP
        include "Library/SessionValidate.php";
?>
<?PHP
       include_once "Library/Library.php";
       include_once "Library/dbconnect.php";
?>

<html>

<head>
<meta http-equiv='Content-Language' content='en-us'>
<meta http-equiv='Content-Type' content='text/html; charset=windows-1252'>
<title>Password Change From  </title>
<LINK href="Application/Style/Apperance_1.css" type=text/css rel=stylesheet>

<script language='javascript'>
 function back(UID)
 {
       window.location="UserEntryChangeFrm.php?user="+UID;
 }
</script>

</head>
<body>
<?PHP


  $query1="Update
                _nisl_mas_member
           Set
                User_Name='$username',
                Type='$memdrop'
           Where
                User_ID = '$user'
          ";
  //echo $query1;

  $query2="Update
                _nisl_mas_user
           Set
                Name='$nam',
                Designation='$des',
                CompanyName='$cname',
                Address='$address',
                Email='$email',
                Phone='$phone'
           Where
                User_ID = '$user'
          ";
   //echo $query2;

if(mysql_query($query1)&& mysql_query($query2))
        drawMassage("Your Information is updated successfully.","onClick=back($user)");
else
        drawMassage("Invalid Information.","onClick=back($user)");

?>
</body>
</html>
<?PHP
        mysql_close();
?>
