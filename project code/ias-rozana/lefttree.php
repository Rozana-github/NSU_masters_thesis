<?PHP
include "Library/SessionValidate.php";
?>
<html>

<head>
  <title>BTRMS Tree</title>

<link rel='StyleSheet' href='dtree/dtree.css' type='text/css' />
<style>
   
.forms_Button
{
        border:none;
        width:70px;
        height:20px;
        text-align:center;
        background-image:url(images/button/sweeterBtn.gif);
        font-family:Arial, Helvetica, sans-serif;
        font-size:11px;
        font-weight: bold;
        color:#333333;
        vertical-align: middle;
} 
  
   
   
</style>
   
   
<script type='text/javascript' src='dtree/dtree.js'></script>

<script language='javascript'>


        
      function drawTree(idlist,pidlist,namelist,urllist)
      {
            id = new Array();
            pid = new Array();
            nam = new Array();
            url = new Array(200);

                        

            id = idlist.split(' ');
            pid = pidlist.split(' ');
            nam = namelist.split(',');
            url = urllist.split(' ');
        
            d = new dTree('d','dtree/');

            for(var i=0;i<id.length;i++)
            {

                  destination = url[i]+"?id="+id[i]+"&pid="+pid[i]+"";

                  d.add(parseInt(id[i]),parseInt(pid[i]),nam[i],destination,'','main');
            }
            document.write(d);
      }

</script>
      
   
 
</head>

<body bgcolor='C6D1D6'>
<?PHP
if(isset($_SESSION['SUserName'])){
    include "Library/dbconnect.php";

    $member_query = "select Type
                         from _nisl_mas_member
                         where User_Name='".$_SESSION['SUserName']."'";

	$rset = mysql_query($member_query) or die(mysql_error());

	$row = mysql_fetch_array($rset);

	extract($row);

	if($Type=='1'){
		$tree_query = "Select
                        id,
                        pid,
                        NodeName,
                        url,
                        view_status
                  from
                        _nisl_tree_entries
                  order by
                        id ASC";

		$rset = mysql_query($tree_query) or die(mysql_error());
		/*
		while($row11 = mysql_fetch_array($rset))
		{
			extract($row11);
			echo " NodeName->$NodeName ------ url->$url<br>";
		} */
	}else if($Type=='0'){
		//echo "<font color=ff0000 size=5>NOT Right</font>";
		$tree_query = "select b.id as id,
                          b.pid as pid,
                          b.NodeName as NodeName,
                          b.url as url

                  from
                        _nisl_mas_member as a,
                        _nisl_tree_entries as b,
                        _nisl_user_permission as c
                  where
                       b.id = c.id and
                       b.pid = c.pid and
                       a.User_Name = c.User_Name and
                       a.User_Name = '".$_SESSION['SUserName']."'
                       
                  order by b.id asc;
                      ";

		$rset = mysql_query($tree_query) or die(mysql_error());
	}
	
	$id_tray = "";
	$pid_tray = "";
	$name_tray = "";
	$url_tray = "";
	
	while($row = mysql_fetch_array($rset)){
		extract($row);
	
		$id_tray .= $id." ";
		$pid_tray .= $pid." ";
		$name_tray .= $NodeName.",";
		$url_tray .= $url." ";
	}
		//echo $url_tray;
	echo "
    <div class='dtree'>
       <script>
             drawTree('$id_tray','$pid_tray','$name_tray','$url_tray');
       </script>
      
    </div> 
 
	<div>
	<table border='0' align='center'>
	<tr>
	<td>
		&nbsp;  
	</td>
	</tr>
	<tr>
	<td>
		&nbsp;
	</td>
	</tr> 
	<tr>
	<td>
  
	</td>
	</tr>
	</table>
 
	</div>
	";


	mysql_close();
}else
	echo "<script>
            window.location.href = \"ErrorMessage.php?error=You are not authorized to view this content\";    
          </script>";
?>

</body>

</html>
