<?php
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
/*
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
 
*/
 header("location:".$_SERVER['HTTP_REFERER']."?integrated=1");
?>