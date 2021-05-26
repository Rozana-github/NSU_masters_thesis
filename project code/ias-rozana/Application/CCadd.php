<?PHP
      session_start();
      include_once("Library/dbconnect.php");
      include_once("Library/Library.php");
      include_once("Library/CCLibrary.php");
?>
<?PHP
      $ParentGLCode=getGLCode("$parent");
      //echo $ParentGLCode."<br>";
      $NewGLCode=getNewGLCode($ParentGLCode);
      //echo $NewGLCode;
      $insert_query= "  insert into mas_cost_center
                        (
                              pid,
                              description,
                              cost_code
                        )
                        values
                        (
                              '$parent',
                              '$nodename',
                              '$NewGLCode'
                        )
                       ";

      if(mysql_query($insert_query))
            drawNormalMassage("New CC Created.");
      else
            drawNormalMassage("New CC Creation was unsuccessful.");

      echo "<script>
                  window.parent.left.location = \"CCeditTree.php\";
           </script>";

?>

