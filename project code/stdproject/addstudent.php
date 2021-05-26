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
  $insertSQL = sprintf("INSERT INTO std_info (std_id_no, std_name, std_address) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['std_id_no'], "text"),
                       GetSQLValueString($_POST['std_name'], "text"),
                       GetSQLValueString($_POST['std_address'], "text"));

  mysql_select_db($database_conStdPoject, $conStdPoject);
  $Result1 = mysql_query($insertSQL, $conStdPoject) or die(mysql_error());
  
    $insertGoTo = "addstudent.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$maxRows_rsetStudentInfo = 10;
$pageNum_rsetStudentInfo = 0;
if (isset($_GET['pageNum_rsetStudentInfo'])) {
  $pageNum_rsetStudentInfo = $_GET['pageNum_rsetStudentInfo'];
}
$startRow_rsetStudentInfo = $pageNum_rsetStudentInfo * $maxRows_rsetStudentInfo;

mysql_select_db($database_conStdPoject, $conStdPoject);
$query_rsetStudentInfo = "SELECT std_id_no, std_name, std_address FROM std_info ORDER BY std_id DESC";
$query_limit_rsetStudentInfo = sprintf("%s LIMIT %d, %d", $query_rsetStudentInfo, $startRow_rsetStudentInfo, $maxRows_rsetStudentInfo);
$rsetStudentInfo = mysql_query($query_limit_rsetStudentInfo, $conStdPoject) or die(mysql_error());
$row_rsetStudentInfo = mysql_fetch_assoc($rsetStudentInfo);

if (isset($_GET['totalRows_rsetStudentInfo'])) {
  $totalRows_rsetStudentInfo = $_GET['totalRows_rsetStudentInfo'];
} else {
  $all_rsetStudentInfo = mysql_query($query_rsetStudentInfo);
  $totalRows_rsetStudentInfo = mysql_num_rows($all_rsetStudentInfo);
}
$totalPages_rsetStudentInfo = ceil($totalRows_rsetStudentInfo/$maxRows_rsetStudentInfo)-1;
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
    <td width="90%"><p align="center" style="font-weight:bolder">ADD STUDENT INFORMATION</p>
    <p>&nbsp;</p>
    <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
      <table align="center">
        <tr valign="baseline">
          <td nowrap="nowrap" align="right"><strong>Student ID:</strong></td>
          <td><input type="text" name="std_id_no" value="" size="32" /></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right"><strong>Name:</strong></td>
          <td align="left"><input type="text" name="std_name" value="" size="32" /></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right" valign="top"><strong>Address:</strong></td>
          <td align="left"><div align="left"><textarea name="std_address" cols="50" rows="5"></textarea></div></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">&nbsp;</td>
          <td><input type="submit" value="Insert record" /></td>
        </tr>
      </table>
      <input type="hidden" name="MM_insert" value="form1" />
    </form>
    <p>&nbsp;</p>
    <p align="center" style="font-weight:bolder">NEW STUDENTS INFORMATION</p>
    <table border="1" align="center">
      <tr>
        <td width="186" align="center"><strong>Student ID No.</strong></td>
        <td width="179"><strong>Name</strong></td>
        <td width="217"><strong>Address</strong></td>
      </tr>
      <?php do { ?>
        <tr>
          <td align="center"><?php echo $row_rsetStudentInfo['std_id_no']; ?></td>
          <td><?php echo $row_rsetStudentInfo['std_name']; ?></td>
          <td><?php echo $row_rsetStudentInfo['std_address']; ?></td>
        </tr>
        <?php } while ($row_rsetStudentInfo = mysql_fetch_assoc($rsetStudentInfo)); ?>
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
mysql_free_result($rsetStudentInfo);
?>
