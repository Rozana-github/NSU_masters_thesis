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
       url = new Array();

                        
       id = idlist.split(' ');
       pid = pidlist.split(' ');
       nam = namelist.split(',');
       url = urllist.split(' ');
        
              
       d = new dTree('d','dtree/');

       for(var i=0;i<id.length;i++)
        {

           destination = "addElement.php?id="+id[i]+"&pid="+pid[i]+"";
                                    
           d.add(parseInt(id[i]),parseInt(pid[i]),nam[i],destination,'','right');
        }

        document.write(d);

        d.closeAll();

      }



   

          
</script>
      
   
 
</head>

<body bgcolor='#EFF4E3'>

<?PHP

include "Library/dbconnect.php";

if(isset($_SESSION['SUserName']))
{

$tree_query = " Select id,
                      pid,
                      NodeName,
                      url,
                      view_status 
                from _nisl_tree_entries
                order by id";


$rset = mysql_query($tree_query) or die(mysql_error());

$id_tray = "";
$pid_tray = "";
$name_tray = "";
$url_tray = "";


while($row = mysql_fetch_array($rset))
 {
  extract($row);
 
  $id_tray .= $id." ";
  $pid_tray .= $pid." ";
  $name_tray .= $NodeName.",";
  $url_tray .= $url." "; 
 }

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
}
else
  echo "<p class='forms_NewTitle'>You are not authorized to view this content</p>";

       
     //<- <input type='' name='go' value='Add Node'  class='forms_Button' onClick=\"GoToAdd('$parent')\">   !-->
?>

</body>

</html>
<?PHP
        mysql_close();
?>
