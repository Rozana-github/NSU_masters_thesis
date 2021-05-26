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
  $insertSQL = sprintf("INSERT INTO std_course_details (sc_std_id, sc_fac_id, sc_course_id, sc_grade) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['sc_std_id'], "text"),
                       GetSQLValueString($_POST['sc_fac_id'], "int"),
                       GetSQLValueString($_POST['sc_course_id'], "int"),
                       GetSQLValueString($_POST['sc_grade'], "double"));

  mysql_select_db($database_conStdPoject, $conStdPoject);
  $Result1 = mysql_query($insertSQL, $conStdPoject) or die(mysql_error());

  $insertGoTo = "addresult.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_conStdPoject, $conStdPoject);
$query_rsetFacID = "SELECT fac_id, fac_id_no FROM faculty_info ORDER BY fac_id_no ASC";
$rsetFacID = mysql_query($query_rsetFacID, $conStdPoject) or die(mysql_error());
$row_rsetFacID = mysql_fetch_assoc($rsetFacID);
$totalRows_rsetFacID = mysql_num_rows($rsetFacID);

mysql_select_db($database_conStdPoject, $conStdPoject);
$query_rsetCourseID = "SELECT course_id, course_id_no, course_title, course_semester, course_year FROM course_offered order by course_year, course_semester, course_id_no ASC";
$rsetCourseID = mysql_query($query_rsetCourseID, $conStdPoject) or die(mysql_error());
$row_rsetCourseID = mysql_fetch_assoc($rsetCourseID);
$totalRows_rsetCourseID = mysql_num_rows($rsetCourseID);
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
    <td width="90%" align="center"><p align="center" style="font-weight:bolder">ADD STUDENT RESULT</p>
    <p>&nbsp;</p>
    <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
      <table align="center">
        <tr valign="baseline">
          <td nowrap="nowrap" align="right"><strong>Student ID:</strong></td>
          <td><input type="text" name="sc_std_id" value="" size="32" /></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right"><strong>Faculty ID:</strong></td>
          <td align="left"><select name="sc_fac_id">
            <?php 
do {  
?>
            <option value="<?php echo $row_rsetFacID['fac_id']?>" ><?php echo $row_rsetFacID['fac_id_no']?></option>
            <?php
} while ($row_rsetFacID = mysql_fetch_assoc($rsetFacID));
?>
          </select></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right"><strong>Course ID:</strong></td>
          <td align="left"><select name="sc_course_id">
            <?php 
do {  
?>
            <option value="<?php echo $row_rsetCourseID['course_id']?>" ><?php echo $row_rsetCourseID['course_title']?><?php echo $row_rsetCourseID['course_semester']?><?php echo $row_rsetCourseID['course_year']?></option>
            <?php
} while ($row_rsetCourseID = mysql_fetch_assoc($rsetCourseID));
?>
            </select></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right"><strong>Grade:</strong></td>
          <td><input type="text" name="sc_grade" value="" size="32" /></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">&nbsp;</td>
          <td><input type="submit" value="Insert record" /></td>
        </tr>
      </table>
      <input type="hidden" name="MM_insert" value="form1" />
    </form>
    <p>&nbsp;</p></td>
    <td width="5%">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($rsetFacID);

mysql_free_result($rsetCourseID);
?>
