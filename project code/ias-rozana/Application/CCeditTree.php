<?PHP
 session_start();  
?>
<html>

<head>
  <title>BTRMS Tree</title>

<link rel='StyleSheet' href='../dtree/dtree.css' type='text/css' />
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
   
   
<script type='text/javascript' src='../dtree/dtree.js'></script>

<script language='javascript'>


        
      function drawTree(idlist,pidlist,namelist)
      {
       
       
       
       id = new Array();
       pid = new Array();
       nam = new Array();

       id = idlist.split(' ');
       pid = pidlist.split(' ');
       nam = namelist.split('***#*');

       d = new dTree('d','../dtree/');

       for(var i=0;i<id.length;i++)
        {

           destination = "CCaddElement.php?id="+id[i]+"&pid="+pid[i]+"";
                                    
           d.add(parseInt(id[i]),parseInt(pid[i]),nam[i],destination,'','right');
        }

        document.write(d);

        d.closeAll();

      }



   

          
</script>
      
   
 
</head>

<body bgcolor='#EFF4E3'>

<?PHP

if(isset($SUserName))
{
include_once("Library/dbconnect.php");


$tree_query = " Select id,
                      pid,
                      CONCAT('[',description,'] ',cost_code) AS description
                from mas_cost_center
                order by id";


$rset = mysql_query($tree_query) or die("Error: ".mysql_error());

while($row = mysql_fetch_array($rset))
 {
  extract($row);
 
  $id_tray .= $id." ";
  $pid_tray .= $pid." ";
  $name_tray .= $description."***#*";

 }

 echo "
     <div class='dtree'>       
       <script>
             drawTree('$id_tray','$pid_tray','$name_tray');
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
