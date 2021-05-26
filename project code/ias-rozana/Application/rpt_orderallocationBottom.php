<?PHP
        include "Library/SessionValidate.php";
?>
<html>

<head>

<link rel="stylesheet" type="text/css" href="Style/calendar.css">
<link rel="stylesheet" href="Style/theme.css" type="text/css">
<link rel="stylesheet" href="Style/css_cacher.css" type="text/css">

<script language="JavaScript" src="Script/calendar1.js"></script>
<script language="JavaScript" >
function printorder(id)
{
      window.location="Rptorderdetails.php?objectid="+id;
}
</script>
<body>
<form name="frm1" method="post">
<?PHP

include "includes/PHP4/calendar.php";

//Create an Object of Calender
$calendar = new Calendar("calender1");

//Draw the calender
echo $calendar->Output();

?>
</form>

</body>
</html>
