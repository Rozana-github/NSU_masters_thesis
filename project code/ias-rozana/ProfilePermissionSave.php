<?PHP
        include "Library/SessionValidate.php";
?>
<html>

<head>
<meta http-equiv='Content-Language' content='en-us'>
<meta http-equiv='Content-Type' content='text/html; charset=windows-1252'>
<title>Permission Entry Form</title>
<link rel='stylesheet' type='text/css' href='css/styles.css' />
<style>

.dtree {
        font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;
        font-size: 11px;
        color: #666;
        white-space: nowrap;
}
.dtree img {
        border: 0px;
        vertical-align: middle;
}
.dtree a {
        color: #333;
        text-decoration: none;
}
.dtree a.node, .dtree a.nodeSel {
        white-space: nowrap;
        padding: 1px 2px 1px 2px;
}
.dtree a.node:hover, .dtree a.nodeSel:hover {
        color: #333;
        text-decoration: underline;
}
.dtree a.nodeSel {
        background-color: #c0d2ec;
}
.dtree .clip {
        overflow: hidden;
}


</style>

<script type='text/javascript' src='dtree/dtree.js'></script>

<script language='javascript'>



      function drawTree(idlist,pidlist,namelist,urllist)
      {


       id = new Array();
       pid = new Array();
       nam = new Array();
       url = new Array();


       id = idlist.split(' ');
       pid = pidlist.split(' ');
       nam = namelist.split(',');
       url = urllist.split(' ');


       d = new dTree('d','dtree/');

       for(var i=0;i<id.length;i++)
        {
            d.add(parseInt(id[i]),parseInt(pid[i]),nam[i],'','','main');
        }

        document.write(d);
        d.openAll();
      }

</script>

</head>

<body>

<?PHP

include_once("Library/dbconnect.php");

$qry = "Select  id,
                pid,
                NodeName
       from _nisl_tree_entries";



$rset = mysql_query($qry) or die(mysql_error());

$deletePermission="delete from _nisl_profile_permission where ProfileID='$ProfileID'";

mysql_query($deletePermission) or die(mysql_error());

while($row = mysql_fetch_array($rset))
{
 extract($row);

 if($c[$id]=="1")
 {
  $insert_query = "Insert into _nisl_profile_permission
                   (
                    ProfileID,
                    id,
                    pid
                    )
                   values
                   (
                    '$ProfileID',
                    $id,
                    $pid
                   )";


   mysql_query($insert_query) or die(mysql_error());

  }
}

  echo " <table border='0' align='center'>
          <tr>
            <td class='forms_NewTitle'>The Following Tree is Generated for the Profile: $userdrop </td>
          <tr>

          </table>";


   $user_tree_query = "select b.id as iid,
                              b.pid as ppid,
                              b.NodeName as nn
                       from _nisl_mas_profile as a,
                            _nisl_tree_entries as b,
                            _nisl_profile_permission  as c
                       where
                            b.id = c.id and
                            b.pid = c.pid and
                            a.ProfileID = c.ProfileID and
                            a.ProfileID = '$ProfileID'

                      ";

   $rset = mysql_query($user_tree_query) or die(mysql_error());

   while($row = mysql_fetch_array($rset))
   {
     extract($row);

     $id_tray .= $iid." ";
     $pid_tray .= $ppid." ";
     $name_tray .= $nn.",";

   }


   echo "
     <div class='dtree'>
       <script>

             drawTree('$id_tray','$pid_tray','$name_tray','');

      </script>

    </div> ";



?>
</body>
</html>
<?PHP
        mysql_close();
?>
