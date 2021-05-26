<?PHP
      session_start();
      include_once("Library/dbconnect.php");
      include_once("Library/Library.php");
      include_once("Library/GLLibrary.php");
?>
<?PHP
      $ParentGLCode=getGLCode("$parent");
      //echo $ParentGLCode."<br>";
      $NewGLCode=getNewGLCode($ParentGLCode);
      //echo $NewGLCode;
      $insert_query= "  insert into mas_gl
                        (
                              pid,
                              description,
                              gl_code
                        )
                        values
                        (
                              '$parent',
                              '$nodename',
                              '$NewGLCode'
                        )
                       ";

      if(mysql_query($insert_query))
            drawNormalMassage("New GL Created.");
      else
            drawNormalMassage("New GL Creation was unsuccessful.");

      echo "<script>
                  window.parent.left.location = \"GLeditTree.php\";
           </script>";

?>

