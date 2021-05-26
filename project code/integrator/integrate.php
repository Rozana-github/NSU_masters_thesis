<html>
<head>
<title>Data Integration via Mediator</title>
<style>
.fnbutton {
    color: #555;
    font: bold 12px Helvetica, Arial, sans-serif;
    text-decoration: none;
    padding: 7px 12px;
	margin-top: 5px;
    position: relative;
    display: inline-block;
    text-shadow: 0 1px 0 #fff;
    -webkit-transition: border-color .218s;
    -moz-transition: border .218s;
    -o-transition: border-color .218s;
    transition: border-color .218s;
    background: #f3f3f3;
    background: -webkit-gradient(linear,0% 40%,0% 70%,from(#F5F5F5),to(#F1F1F1));
    background: -moz-linear-gradient(linear,0% 40%,0% 70%,from(#F5F5F5),to(#F1F1F1));
    border: solid 1px #ccc;
    border-radius: 2px;
    -webkit-border-radius: 2px;
    -moz-border-radius: 2px;
	width:200px;
}
</style>
</head>
<body style="text-align:center;">
<?php
mysql_connect("localhost", "root", "") or $db_error = mysql_error("Could not connect to the database.");
if(isset($_GET['integrated']) && intval($_GET['integrated'])==1){
	/**
	 * Algorithm that we followed
	 *
		1: procedure SourceQuery(RelSrc, Q)
		2: ar = List of built - in variables in the body of Q( ¯X )
		3: for each predicate Vi in RelSrc do
		4: for each variable Xk in predicate Vi do
		5: if Xk 2 ar then
		6: Concatenate data retrieval query for Vi with condition for Xk
		7: end if
		8: end for
		9: end for
	 */
	mysql_select_db("dbstudent");
	$sql = "SELECT * FROM information_schema.columns WHERE table_name = 'faculty_info'";
	$rsetFields = mysql_query($sql);
	mysql_select_db("braciais");
	$fieldsList = '';
	$sqlAlter = "ALTER TABLE `mas_emp_sal_info` ";
	while($rFields = mysql_fetch_array($rsetFields)){
		$fieldName = $rFields['COLUMN_NAME'];
		$dataType = $rFields['DATA_TYPE'];
		$columnDefault = $rFields['COLUMN_DEFAULT'];
		$columnDefault = ($columnDefault==null) ? 'NULL' : 'NOT NULL DEFAULT '.$columnDefault;
		$characterMaxLength = $rFields['CHARACTER_MAXIMUM_LENGTH'];
		if($characterMaxLength) $characterMaxLength = "($characterMaxLength)";
		$columnKey = $rFields['COLUMN_KEY'];
		if($columnKey!='PRI'){
			$sqlAlter .= " ADD `$fieldName` $dataType $characterMaxLength $columnDefault,";
			$fieldsList .= $fieldName.",";
		}else{
			$pk = $fieldName;
		}
	}
	$sqlAlter = substr($sqlAlter,0,strlen($sqlAlter)-1);
	mysql_query($sqlAlter) or die(mysql_error()); //add fields in target table

	//------------ transfer data to the target table ------------//
	$fieldsList = substr($fieldsList,0,strlen($fieldsList)-1);
	$fieldsArr = explode(",",$fieldsList);

	mysql_select_db("dbstudent");
	$sql = "select * from faculty_info";
	$rset1 = mysql_query($sql);

	while($r1 = mysql_fetch_array($rset1)){
		$valuesList = "";
		if(array_key_exists($pk,$r1)){
			$pkValue=$r1[$pk];
		}
		foreach($fieldsArr as $f){
			if(array_key_exists($f, $r1)){
				$valuesList .= " $f='".$r1[$f]."',";
			}
		}
		$valuesList = substr($valuesList,0,strlen($valuesList)-1);
		$insertEmployee = "update mas_emp_sal_info set $valuesList where employee_id='$pkValue'";
		mysql_select_db("braciais");
		mysql_query($insertEmployee) or die(mysql_error());
	}


	mysql_select_db("braciais");
	$sql = "select * from mas_emp_sal_info";
	$rset3 = mysql_query($sql);
	?>
	<br /><br />
	<div style="border:1px solid #CCCCCC; width:100%; float:left;">
		<h2>Data Migrated Succesfully</h2>
		<table>
		<tr><th>Employee ID</th><th>Grad ID</th><th>Basic Salary</th><th>House Allowance</th><th>Convayance</th><th>Food Allowance</th><th>Utility Allowance</th><th>Name</th><th>ID</th><th>Joining Date</th><th>Designation</th></tr>
		<?php
		while($r = mysql_fetch_array($rset3)){
			echo '<tr><td>'.$r['employee_id'].'</td><td>'.$r['grad_id'].'</td><td>'.$r['basic_salary'].'</td><td>'.$r['house_allowance'].'</td><td>'.$r['convance'].'</td><td>'.$r['food_allowance'].'</td><td>'.$r['utility_allowance'].'</td><td>'.$r['fac_name'].'</td><td>'.$r['fac_id_no'].'</td><td>'.$r['fac_join_date'].'</td><td>'.$r['fac_desig'].'</td></tr>';
		}
		?>
		</table>
	</div>
	<div style="clear:both;"></div>
<?php
}else{ ?>
<h1>Data Integration via Mediator</h1>
<p align="center">
<a class="fnbutton" href="integrate.php?integrated=1">Integrate Data Tables</a>
</p>
<?php
mysql_select_db("dbstudent");
$sql = "select * from faculty_info";
$rset1 = mysql_query($sql);
?>
<div style="border:1px solid #CCCCCC; width:45%; float:left; margin-right:20px;">
	<h2>Employeed data from dbstudents</h2>
	<table>
	<tr><th>Name</th><th>ID</th><th>Joining Date</th><th>Designation</th></tr>
	<?php
	while($r = mysql_fetch_array($rset1)){
		echo '<tr><td>'.$r['fac_name'].'</td><td>'.$r['fac_id_no'].'</td><td>'.$r['fac_join_date'].'</td><td>'.$r['fac_desig'].'</td></tr>';
	}
	?>
	</table>
</div>
<?php
mysql_select_db("braciais");
$sql = "select * from mas_emp_sal_info";
$rset2 = mysql_query($sql);
?>
<div style="border:1px solid #CCCCCC; width:50%; float:left;">
	<h2>Employeed data from braciais</h2>
	<table>
	<tr><th>Employee ID</th><th>Grad ID</th><th>Basic Salary</th><th>House Allowance</th><th>Convayance</th><th>Food Allowance</th><th>Utility Allowance</th></tr>
	<?php
	while($r = mysql_fetch_array($rset2)){
		echo '<tr><td>'.$r['employee_id'].'</td><td>'.$r['grad_id'].'</td><td>'.$r['basic_salary'].'</td><td>'.$r['house_allowance'].'</td><td>'.$r['convance'].'</td><td>'.$r['food_allowance'].'</td><td>'.$r['utility_allowance'].'</td></tr>';
	}
	?>
	</table>
</div>
<div style="clear:both;"></div>
<?php
} ?>
</body>
</html>
<?php?>