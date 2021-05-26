<?PHP
      session_start();
      include_once("Library/dbconnect.php");
      include_once("Library/Library.php");
?>
<html>
<head>
      <script language='JavaScript'>
            function back()
            {
                  //var cboglcode=document.frmAddQuery.cboglcode.value;
                  //window.location="Mas_Bank_Entry.php?cboglcode="+cboglcode+"";
                  window.location="Mas_Matchine_Entry.php?";
            }
      </script>
</head>
<form name='frmAddQuery' method='post'>
<?PHP
    /*-------------------- Developed By: MD.SHARIF UR RAHMAN ----------------------------------------*/
      //echo "<input type='hidden' name='cboglcode' value='$cboglcode'>";
      mysql_query("BEGIN") or die("Operation cant be start");
      /*
      echo "<font color='ff0000'>
           Q_Mode--$Q_Mode
      </font>";*/

      echo "<link rel='stylesheet' type='text/css' href='Style/eng_form.css'>";

                  
                  if($Q_Mode==1)
                  {
                        $TrnQuery="
                                    update
                                          mas_machine
                                    set
                                          machine_name='$txtMatchineName',
                                          speed='$txtSpeed',
                                          status='$txtstatus'
                                    where
                                          machine_object_id='$MatchineID'
                                    ";

                  }
                  else
                  {
                        $TrnQuery="insert into mas_machine
                                    (
                                          machine_name,
                                          speed,
                                          status
                                    )
                                    values
                                    (
                                          '$txtMatchineName',
                                          '$txtSpeed',
                                          '$txtstatus'
                                    )";
                   }
                  $resultTrnQuery=mysql_query($TrnQuery) or die(mysql_error());



        if(mysql_query("COMMIT"))
        {
                drawMassage("Operation Done","onClick='back()'");
        }
        else
        {
                drawMassage("Operation Not Done","onClick='back()'");

        }
?>
</html>

