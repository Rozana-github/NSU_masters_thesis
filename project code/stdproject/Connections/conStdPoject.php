<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_conStdPoject = "localhost";
$database_conStdPoject = "dbstudent";
$username_conStdPoject = "root";
$password_conStdPoject = "";
$conStdPoject = mysql_pconnect($hostname_conStdPoject, $username_conStdPoject, $password_conStdPoject) or trigger_error(mysql_error(),E_USER_ERROR); 
?>