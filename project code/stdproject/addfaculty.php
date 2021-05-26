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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO faculty_info (fac_id_no, fac_name, fac_desig, fac_join_date) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['fac_id_no'], "text"),
                       GetSQLValueString($_POST['fac_name'], "text"),
                       GetSQLValueString($_POST['fac_desig'], "text"),
                       GetSQLValueString($_POST['fac_join_date'], "date"));

  mysql_select_db($database_conStdPoject, $conStdPoject);
  $Result1 = mysql_query($insertSQL, $conStdPoject) or die(mysql_error());

  $insertGoTo = "addfaculty.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$maxRows_rsetFacultyDetails = 10;
$pageNum_rsetFacultyDetails = 0;
if (isset($_GET['pageNum_rsetFacultyDetails'])) {
  $pageNum_rsetFacultyDetails = $_GET['pageNum_rsetFacultyDetails'];
}
$startRow_rsetFacultyDetails = $pageNum_rsetFacultyDetails * $maxRows_rsetFacultyDetails;

mysql_select_db($database_conStdPoject, $conStdPoject);
$query_rsetFacultyDetails = "SELECT fac_id_no, fac_name, fac_desig, fac_join_date FROM faculty_info ORDER BY fac_id DESC";
$query_limit_rsetFacultyDetails = sprintf("%s LIMIT %d, %d", $query_rsetFacultyDetails, $startRow_rsetFacultyDetails, $maxRows_rsetFacultyDetails);
$rsetFacultyDetails = mysql_query($query_limit_rsetFacultyDetails, $conStdPoject) or die(mysql_error());
$row_rsetFacultyDetails = mysql_fetch_assoc($rsetFacultyDetails);

if (isset($_GET['totalRows_rsetFacultyDetails'])) {
  $totalRows_rsetFacultyDetails = $_GET['totalRows_rsetFacultyDetails'];
} else {
  $all_rsetFacultyDetails = mysql_query($query_rsetFacultyDetails);
  $totalRows_rsetFacultyDetails = mysql_num_rows($all_rsetFacultyDetails);
}
$totalPages_rsetFacultyDetails = ceil($totalRows_rsetFacultyDetails/$maxRows_rsetFacultyDetails)-1;
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
    <td width="15%" valign="top"><?php include('leftmenu.php'); ?>&nbsp;</td>
    <td width="90%" align="center"><p align="center" style="font-weight:bolder">FACULTY DETAILS</p>
    <p>&nbsp;</p>
    <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
      <table align="center">
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">Faculty ID No.:</td>
          <td align="left"><input type="text" name="fac_id_no" value="" size="20" /></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">Name:</td>
          <td><input type="text" name="fac_name" value="" size="32" /></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">Designation:</td>
          <td><input type="text" name="fac_desig" value="" size="32" /></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">Join Date:</td>
          <td><input type="text" name="fac_join_date" value="" size="20" /> 
            (yyyy/mm/dd)</td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">&nbsp;</td>
          <td><input type="submit" value="Insert record" /></td>
        </tr>
      </table>
      <input type="hidden" name="MM_insert" value="form1" />
    </form>
    <p>&nbsp;</p>
    <table border="1">
      <tr>
        <td width="198"><strong>Facluty ID No.</strong></td>
        <td width="184"><strong>Name</strong></td>
        <td width="183"><strong>Designation</strong></td>
        <td width="213"><strong>Join Date (yyyy/mm/dd)</strong></td>
      </tr>
      <?php do { ?>
        <tr>
          <td><?php echo $row_rsetFacultyDetails['fac_id_no']; ?></td>
          <td><?php echo $row_rsetFacultyDetails['fac_name']; ?></td>
          <td><?php echo $row_rsetFacultyDetails['fac_desig']; ?></td>
          <td><?php echo $row_rsetFacultyDetails['fac_join_date']; ?></td>
        </tr>
        <?php } while ($row_rsetFacultyDetails = mysql_fetch_assoc($rsetFacultyDetails)); ?>
    </table></td>
    <td width="5%">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($rsetFacultyDetails);
?>
