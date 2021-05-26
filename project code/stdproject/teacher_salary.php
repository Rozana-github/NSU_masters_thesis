<?php require_once('Connections/conStdPoject.php'); ?>
<?php require_once('Connections/conHRProject.php'); ?>
<?php
$min_ext_work = 4;
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
$query_rsetFacultyDetails = "SELECT fac_id, fac_id_no, fac_name, fac_desig, fac_join_date FROM faculty_info ORDER BY fac_id DESC";
$query_limit_rsetFacultyDetails = sprintf("%s LIMIT %d, %d", $query_rsetFacultyDetails, $startRow_rsetFacultyDetails, $maxRows_rsetFacultyDetails);
$rsetFacultyDetails = mysql_query($query_limit_rsetFacultyDetails, $conStdPoject) or die(mysql_error());
$row_rsetFacultyDetails = mysql_fetch_assoc($rsetFacultyDetails);

if (isset($_GET['totalRows_rsetFacultyDetails'])){ 
  $totalRows_rsetFacultyDetails = $_GET['totalRows_rsetFacultyDetails'];
} else {
  $all_rsetFacultyDetails = mysql_query($query_rsetFacultyDetails);
  $totalRows_rsetFacultyDetails = mysql_num_rows($all_rsetFacultyDetails);
}
$totalPages_rsetFacultyDetails = ceil($totalRows_rsetFacultyDetails/$maxRows_rsetFacultyDetails)-1;


// Get teacher salary
 function getSalary($facId,$conStdPoject,$database_conHRProject)
{ 
   //echo $facId;
	mysql_select_db($database_conHRProject,$conStdPoject);
	$query_salary = "SELECT * FROM mas_emp_sal_info WHERE employee_id='".$facId."'";
	//$query_limit_salary = sprintf("%s LIMIT %d, %d", $query_salary, $startRow_rsetFacultyDetails, $maxRows_rsetFacultyDetails);
	$rseSalary = mysql_query($query_salary, $conStdPoject) or die(mysql_error());
	$row_resSalary = mysql_fetch_assoc($rseSalary);
	return $row_resSalary;
	print_r($row_resSalary);
}
 function getCourseCount($facId,$conStdPoject,$database_conStdProject)
{ 
    //echo $database_conStdProject;
	mysql_select_db($database_conStdProject,$conStdPoject);
	$query_course_count = "SELECT COUNT(course_id) as course_count  FROM course_offered WHERE course_fc_id='".$facId."'";
	//$query_limit_salary = sprintf("%s LIMIT %d, %d", $query_salary, $startRow_rsetFacultyDetails, $maxRows_rsetFacultyDetails);
	$rsecourse_count = mysql_query($query_course_count, $conStdPoject) or die(mysql_error());
	$row_rescourse_count = mysql_fetch_assoc($rsecourse_count);
	return $row_rescourse_count['course_count'];
	//print_r($row_rescourse_count);
}




//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Faculty Salary</title>
<style type="text/css">
<!--
body {
	background-color: #CCF;
}
-->
</style></head>

<body style="background:rgb(255,179,255)">
<table width="100%" border="0">
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td width="15%" valign="top"><?php include('leftmenu.php'); ?>&nbsp;</td>
    <td width="90%" align="center"><p align="center" style="font-weight:bolder">FACULTY SALARY</p>
    <p>&nbsp;</p>

    <p>&nbsp;</p>
    <table border="1">
      <tr>
        <td width="198"><strong>Facluty ID No.</strong></td>
        <td width="184"><strong>Name</strong></td>
        <td width="183"><strong>Designation</strong></td>
        <td width="213"><strong>Join Date (yyyy/mm/dd)</strong></td>
		<td width="213"><strong>Salary</strong></td>
		<td width="213"><strong>CourseCount</strong></td>
      </tr>
      <?php do { ?>
        <tr>
          <td><?php echo $row_rsetFacultyDetails['fac_id_no']; ?></td>
          <td><?php echo $row_rsetFacultyDetails['fac_name']; ?></td>
          <td><?php echo $row_rsetFacultyDetails['fac_desig']; ?></td>
          <td><?php echo $row_rsetFacultyDetails['fac_join_date']; ?></td>
		  <td><?php  //salary
               $row_Salary = getSalary($row_rsetFacultyDetails['fac_id'],$conStdPoject,$database_conHRProject);
			   
			   $sal =  $row_Salary['basic_salary']+$row_Salary['house_allowance']+$row_Salary['medical_allowance']+$row_Salary['convance']+$row_Salary['food_allowance ']+$row_Salary['utility_allowance ']+$row_Salary['special_allowance']+$row_Salary['maintenance_allowance']+$row_Salary['inflation_allowance']+$row_Salary['transport']+$row_Salary['others_allowance']+$row_Salary['incement_amount'];
			   if(getCourseCount($row_rsetFacultyDetails['fac_id'],$conStdPoject,$database_conStdPoject) >= $min_ext_work)
			       $sal+= 6000;
			   echo $sal; 
			   
		  ?></td>
		  <td><?php  //course count
              
			   echo getCourseCount($row_rsetFacultyDetails['fac_id'],$conStdPoject,$database_conStdPoject);
			   
		  ?></td>
        </tr>
        <?php 
		  //$row_resSalary = mysql_fetch_assoc($rseSalary);
		} while ($row_rsetFacultyDetails = mysql_fetch_assoc($rsetFacultyDetails)); 
		
		
		?>
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
