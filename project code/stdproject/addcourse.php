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
  $insertSQL = sprintf("INSERT INTO course_offered (course_fc_id, course_id_no, course_title, course_semester, course_year) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['course_fc'], "text"),
                       GetSQLValueString($_POST['course_id_no'], "text"),
                       GetSQLValueString($_POST['course_title'], "text"),
                       GetSQLValueString($_POST['course_semester'], "text"),
                       GetSQLValueString($_POST['course_year'], "int"));

  mysql_select_db($database_conStdPoject, $conStdPoject);
  $Result1 = mysql_query($insertSQL, $conStdPoject) or die(mysql_error());

  $insertGoTo = "addcourse.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$maxRows_rsetCourseDetails = 10;
$pageNum_rsetCourseDetails = 0;
if (isset($_GET['pageNum_rsetCourseDetails'])) {
  $pageNum_rsetCourseDetails = $_GET['pageNum_rsetCourseDetails'];
}
$startRow_rsetCourseDetails = $pageNum_rsetCourseDetails * $maxRows_rsetCourseDetails;

mysql_select_db($database_conStdPoject, $conStdPoject);
$query_rsetCourseDetails = "SELECT fac_id_no, course_id_no, course_title, course_semester, course_year FROM course_offered INNER JOIN faculty_info ON course_fc_id = fac_id ORDER BY course_id DESC";
$query_limit_rsetCourseDetails = sprintf("%s LIMIT %d, %d", $query_rsetCourseDetails, $startRow_rsetCourseDetails, $maxRows_rsetCourseDetails);
$rsetCourseDetails = mysql_query($query_limit_rsetCourseDetails, $conStdPoject) or die(mysql_error());
$row_rsetCourseDetails = mysql_fetch_assoc($rsetCourseDetails);

if (isset($_GET['totalRows_rsetCourseDetails'])) {
  $totalRows_rsetCourseDetails = $_GET['totalRows_rsetCourseDetails'];
} else {
  $all_rsetCourseDetails = mysql_query($query_rsetCourseDetails);
  $totalRows_rsetCourseDetails = mysql_num_rows($all_rsetCourseDetails);
}
$totalPages_rsetCourseDetails = ceil($totalRows_rsetCourseDetails/$maxRows_rsetCourseDetails)-1;

mysql_select_db($database_conStdPoject, $conStdPoject);
$query_rsetFacultyID = "SELECT fac_id, fac_id_no, fac_name, fac_desig FROM faculty_info ORDER BY fac_id_no ASC";
$rsetFacultyID = mysql_query($query_rsetFacultyID, $conStdPoject) or die(mysql_error());
$row_rsetFacultyID = mysql_fetch_assoc($rsetFacultyID);
$totalRows_rsetFacultyID = mysql_num_rows($rsetFacultyID);
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
    <td width="90%" align="center"><p align="center" style="font-weight:bolder">ADD COURSES</p>
    <p>&nbsp;</p>
    <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
      <table align="center">
        <tr valign="baseline">
          <td nowrap="nowrap" align="right"><strong>Facutly ID:</strong></td>
          <td align="left"><select name="course_fc">
            <?php
do {  
?>
            <option value="<?php echo $row_rsetFacultyID['fac_id']?>"><?php echo $row_rsetFacultyID['fac_id_no']?></option>
            <?php
} while ($row_rsetFacultyID = mysql_fetch_assoc($rsetFacultyID));
  $rows = mysql_num_rows($rsetFacultyID);
  if($rows > 0) {
      mysql_data_seek($rsetFacultyID, 0);
	  $row_rsetFacultyID = mysql_fetch_assoc($rsetFacultyID);
  }
?>
          </select>            </td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right"><strong>Couse ID:</strong></td>
          <td><input type="text" name="course_id_no" value="" size="32" /></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right"><strong>Course Title:</strong></td>
          <td><input type="text" name="course_title" value="" size="32" /></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right"><strong>Semester:</strong></td>
          <td align="left"><select name="course_semester">
            <option value="Spring">Spring</option>
            <option value="Summer">Summer</option>
            <option value="Fall">Fall</option>
          </select>
          </td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right"><strong>Year:</strong></td>
          <td align="left"><select name="course_year">
            <option value="2012">2012</option>
            <option value="2013">2013</option>
            <option value="2014">2014</option>
          </select></td>
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
        <td width="220"><strong>Faculty</strong></td>
        <td width="220"><strong>Course ID No.</strong></td>
        <td width="195"><strong>Title</strong></td>
        <td width="231"><strong>Semester</strong></td>
        <td width="231"><strong>Year</strong></td>
      </tr>
      <?php do { ?>
        <tr>
          <td><?php echo $row_rsetCourseDetails['fac_id_no']; ?></td>
          <td><?php echo $row_rsetCourseDetails['course_id_no']; ?></td>
          <td><?php echo $row_rsetCourseDetails['course_title']; ?></td>
          <td><?php echo $row_rsetCourseDetails['course_semester']; ?></td>
          <td><?php echo $row_rsetCourseDetails['course_year']; ?></td>
        </tr>
        <?php } while ($row_rsetCourseDetails = mysql_fetch_assoc($rsetCourseDetails)); ?>
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
mysql_free_result($rsetCourseDetails);

mysql_free_result($rsetFacultyID);
?>
