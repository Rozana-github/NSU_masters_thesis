<?PHP
        include "Library/SessionValidate.php";
?>
<?PHP

include_once("Library/dbconnect.php");

$rset =mysql_query("select max(id) as id from _nisl_tree_entries") or die(mysql_error());

$row = mysql_fetch_array($rset);

extract($row);

$iid = intval($id)+1;

$insert_query = " insert into _nisl_tree_entries
                  (
                        id,
                        pid,
                        NodeName,
                        url,
                        view_status
                  )
                  values
                  (
                        $iid,
                        $parent,
                        '$nodename',
                        '$nodeurl',
                        'ON'
                  )
                ";

mysql_query($insert_query) or die(mysql_error());


echo "<script>
          window.parent.left.location = \"editTree.php\";
      </script>
     ";

//include("addElement.php?parent=0");
//window.parent.contents.location = \"lefttree.php\";

?>
<?PHP
        mysql_close();
?>
