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
include_once("Library/Library.php");


$node_query = "select description as nname
               from mas_cost_center 
               where id='$parent'
               ";

$rset = mysql_query($node_query) or die ("Error: ".mysql_error());

$row = mysql_fetch_array($rset);

extract($row);

$update_query = "update mas_cost_center 
                 set description='$nodename'
                 where description='$nname'
                ";

if(mysql_query($update_query))
   drawNormalMassage("CC is successfully Updated.");
else
   drawNormalMassage("Update operation was unsuccessful.");


echo "<script>
          window.parent.left.location = \"CCeditTree.php\";
     </script>
       ";

?>
</body>
</html>


