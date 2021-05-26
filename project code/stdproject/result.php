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

mysql_select_db($database_conStdPoject, $conStdPoject);
$query_rsetYear = "SELECT distinct course_year FROM course_offered ORDER BY course_year ASC";
$rsetYear = mysql_query($query_rsetYear, $conStdPoject) or die(mysql_error());
$row_rsetYear = mysql_fetch_assoc($rsetYear);
$totalRows_rsetYear = mysql_num_rows($rsetYear);

mysql_select_db($database_conStdPoject, $conStdPoject);
$query_rsetSemester = "SELECT distinct course_semester FROM course_offered ORDER BY course_semester ASC";
$rsetSemester = mysql_query($query_rsetSemester, $conStdPoject) or die(mysql_error());
$row_rsetSemester = mysql_fetch_assoc($rsetSemester);
$totalRows_rsetSemester = mysql_num_rows($rsetSemester);

if ((isset($_GET['StudentID'])) and strlen($_GET['StudentID'] > 0)) {

if ((isset($_GET['Semester'])) and (strlen($_GET['Semester']) > 0)) {

	$qs = sprintf("course_semester = %s", GetSQLValueString($_GET['Semester'], "text")); 
}
else { $qs = 1;}

if ((isset($_GET['Year'])) and strlen($_GET['Year']) > 0) {
	$qy = sprintf("course_year = '%s'", $_GET['Year']); 
}
else { $qy = 1;}

mysql_select_db($database_conStdPoject, $conStdPoject);
$query_rsetResultDetails =  sprintf("SELECT std_id_no, course_id_no, course_title, course_semester,course_year, sc_grade FROM std_course_details INNER JOIN std_info ON sc_std_id = std_id_no INNER JOIN course_offered ON course_id =sc_course_id  where std_id_no = %s and %s and %s ORDER BY sc_id ASC", $_GET['StudentID'],  $qs,  $qy);

$rsetResultDetails = mysql_query($query_rsetResultDetails, $conStdPoject) or die(mysql_error());
$row_rsetResultDetails = mysql_fetch_assoc($rsetResultDetails);
$totalRows_rsetResultDetails = mysql_num_rows($rsetResultDetails);
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
    <td width="90%" align="center"><p align="center" style="font-weight:bolder">STUDENT RESULT DETAILS</p>
      <form id="form1" name="form1" method="get" action="">
        <label>
          <input type="text" name="StudentID" id="textfield" value="<?php echo $_GET['StudentID'];?>" />
        </label>
        <label>
          <select name="Semester" id="Semester">
          <option value="">ALL</option>
            <?php
do {  
?>
            <option value="<?php echo $row_rsetSemester['course_semester']?>"<?php if (!(strcmp($row_rsetSemester['course_semester'], $_GET['Semester']))) {echo "selected=\"selected\"";} ?>><?php echo $row_rsetSemester['course_semester']?></option>
            <?php
} while ($row_rsetSemester = mysql_fetch_assoc($rsetSemester));
  $rows = mysql_num_rows($rsetSemester);
  if($rows > 0) {
      mysql_data_seek($rsetSemester, 0);
	  $row_rsetSemester = mysql_fetch_assoc($rsetSemester);
  }
?>
          </select>
        </label>
        <label>
          <select name="Year" id="Year">
          <option value="">ALL</option>
            <?php
do {  
?>
            <option value="<?php echo $row_rsetYear['course_year']?>"<?php if (!(strcmp($row_rsetYear['course_year'], $_GET['Year']))) {echo "selected=\"selected\"";} ?>><?php echo $row_rsetYear['course_year']?></option>
            <?php
} while ($row_rsetYear = mysql_fetch_assoc($rsetYear));
  $rows = mysql_num_rows($rsetYear);
  if($rows > 0) {
      mysql_data_seek($rsetYear, 0);
	  $row_rsetYear = mysql_fetch_assoc($rsetYear);
  }
?>
          </select>
        </label>
        <label>
          <input type="submit" name="button" id="button" value="Submit" />
        </label>
      </form>
      <p>&nbsp;</p>
      <?php if ((isset($_GET['StudentID'])) and strlen($_GET['StudentID'] > 0)) { ?>
    <table border="1" cellpadding="0" cellspacing="0">
      <tr>
        <td width="188"><strong>Course Title</strong></td>
        <td width="220"><strong>Semester</strong></td>
        <td width="193"><strong>Year</strong></td>
        <td width="183"><strong>Grade</strong></td>
      </tr>
      <?php do { ?>
        <tr>
          <td><?php echo $row_rsetResultDetails['course_title']; ?></td>
          <td><?php echo $row_rsetResultDetails['course_semester']; ?></td>
          <td><?php echo $row_rsetResultDetails['course_year']; ?></td>
          <td><?php echo number_format($row_rsetResultDetails['sc_grade'], 2); $c = $c+1; $tgpa = $tgpa + $row_rsetResultDetails['sc_grade']; ?></td>
        </tr>
        <?php } while ($row_rsetResultDetails = mysql_fetch_assoc($rsetResultDetails)); ?>
              <tr>
        <td><strong>&nbsp;</strong></td>
        <td><strong>&nbsp;</strong></td>
        <td><strong>CGPA</strong></td>
        <td><strong><?php if ($c>1) { echo number_format(($tgpa / $c), 2); } ?></strong></td>
      </tr>
    </table>
    
    <?php } ?></td>
    <td width="5%">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($rsetYear);

mysql_free_result($rsetSemester);


?>
