<?PHP
      session_start();
      session_unset();
      session_destroy();

      echo "<script>
                  window.parent.location.href = \"login.php\";
            </script>";
?>
