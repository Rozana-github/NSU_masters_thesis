<?php require_once('Connections/conStdPoject.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$maxRows_rsetStudentDetails = 10;
$pageNum_rsetStudentDetails = 0;
if (isset($_GET['pageNum_rsetStudentDetails'])) {
  $pageNum_rsetStudentDetails = $_GET['pageNum_rsetStudentDetails'];
}
$startRow_rsetStudentDetails = $pageNum_rsetStudentDetails * $maxRows_rsetStudentDetails;

if ((!isset($_GET['search'])) or ($_GET['search'] == "")) {
$q = "SELECT std_id, std_id_no, std_name, std_address FROM std_info  ORDER BY std_id_no DESC";
}
else
{
	$q = sprintf("SELECT std_id, std_id_no, std_name, std_address FROM std_info WHERE std_id_no = %s or std_name = %s ORDER BY std_id_no DESC",  GetSQLValueString($_GET['search'], "text"), GetSQLValueString($_GET['search'], "text")) ;
}

mysql_select_db($database_conStdPoject, $conStdPoject);
$query_rsetStudentDetails = $q;
$query_limit_rsetStudentDetails = sprintf("%s LIMIT %d, %d", $query_rsetStudentDetails, $startRow_rsetStudentDetails, $maxRows_rsetStudentDetails);
$rsetStudentDetails = mysql_query($query_limit_rsetStudentDetails, $conStdPoject) or die(mysql_error());
$row_rsetStudentDetails = mysql_fetch_assoc($rsetStudentDetails);

if (isset($_GET['totalRows_rsetStudentDetails'])) {
  $totalRows_rsetStudentDetails = $_GET['totalRows_rsetStudentDetails'];
} else {
  $all_rsetStudentDetails = mysql_query($query_rsetStudentDetails);
  $totalRows_rsetStudentDetails = mysql_num_rows($all_rsetStudentDetails);
}
$totalPages_rsetStudentDetails = ceil($totalRows_rsetStudentDetails/$maxRows_rsetStudentDetails)-1;

if ((!isset($_GET['sid'])) or ($_GET['sid'] == "")) {
$_GET['sid']= -1;
}

mysql_select_db($database_conStdPoject, $conStdPoject);
$query_rsetResult = sprintf("SELECT sc_course_id, course_title, course_semester, sc_grade FROM std_course_details INNER JOIN course_offered ON course_id_no = sc_course_id WHERE sc_std_id = %s ORDER BY sc_id ASC", GetSQLValueString($_GET['sid'], "text"));
$rsetResult = mysql_query($query_rsetResult, $conStdPoject) or die(mysql_error());
$row_rsetResult = mysql_fetch_assoc($rsetResult);
$totalRows_rsetResult = mysql_num_rows($rsetResult);

if ((isset($_GET['dsid'])) && ($_GET['dsid'] != "")) {
  $deleteSQL = sprintf("DELETE FROM std_info WHERE std_id=%s",
                       GetSQLValueString($_GET['dsid'], "int"));

  mysql_select_db($database_conStdPoject, $conStdPoject);
  $Result1 = mysql_query($deleteSQL, $conStdPoject) or die(mysql_error());

  $deleteGoTo = "studentdetails.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
<!--
body {
	background-color: #CCF;
}
-->
</style></head>

<body>
<table width="100%" border="0">
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td width="15%"><?php include('leftmenu.php'); ?>&nbsp;</td>
    <td width="90%" align="center"><p align="center" style="font-weight:bolder">STUDENT DETAILS</p>
      <form id="form1" name="form1" method="get" action="">
        Search by ID or Name :
        <label>
          <input type="text" name="search" id="search" value="<?php echo $_GET['search']; ?>"/>
        </label>
        <label>
          <input type="submit" name="button" id="button" value="Search" />
        </label>
      </form>
      <p>&nbsp;</p>
    <table width="759" border="1">
      <tr>
        <td width="196" align="center"><strong>Student ID No</strong></td>
        <td width="194"><strong>Name</strong></td>
        <td width="201"><strong>Address</strong></td>
        <td width="201"><strong>Delete</strong></td>
      </tr>
      <?php do { ?>
        <tr>
          <td align="center"><?php echo $row_rsetStudentDetails['std_id_no']; ?></td>
          <td><?php echo $row_rsetStudentDetails['std_name']; ?></td>
          <td><?php echo $row_rsetStudentDetails['std_address']; ?></td>
          <td><a  href="studentdetails.php?dsid=<?php echo $row_rsetStudentDetails['std_id']; ?>"><img src="images/drop.png" width="16" height="16" alt="delete" /></a></td>
        </tr>
        <?php } while ($row_rsetStudentDetails = mysql_fetch_assoc($rsetStudentDetails)); ?>

    </table>
    <p>&nbsp;</p>
    </td>
    <td width="5%">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($rsetStudentDetails);

mysql_free_result($rsetResult);
?>
