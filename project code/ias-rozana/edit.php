<?PHP
include "Library/SessionValidate.php";
?>
<html>
<head>
<meta http-equiv='Content-Language' content='en-us'>
<meta http-equiv='Content-Type' content='text/html; charset=windows-1252'>
<title>Requisition Authorization Form</title>
 <link rel='stylesheet' type='text/css' href='css/styles.css' />
 </head>
 <body>
<?PHP

include_once("Library/dbconnect.php");

$node_query = "select NodeName as nname
               from _nisl_tree_entries
               where id='$parent'
               ";

$rset = mysql_query($node_query) or die(mysql_error());

$row = mysql_fetch_array($rset);

extract($row);

$update_query = "update _nisl_tree_entries
                 set NodeName ='$nodename',
                     url = '$nodeurl'
                 where id ='$parent'
                ";

if(mysql_query($update_query))
   echo "<p class='forms_NewTitle'>Node Information is successfully Updated.</p>";
else
  echo "<p class='forms_NewTitle'>Update operation was unsuccessful.</p>";


echo "<script>
          window.parent.left.location = \"editTree.php\";
     </script>
       ";

?>
</body>
</html>
<?PHP
        mysql_close();
?>
