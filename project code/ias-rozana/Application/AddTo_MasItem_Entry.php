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
                  var cboglcode=document.frmAddQuery.cboglcode.value;
                  window.location="Mas_Item_Entry.php?cboglcode="+cboglcode+"";
            }
        </script>
</head>
<form name='frmAddQuery' method='post'>
<?PHP
    /*-------------------- Developed By: MD.SHARIF UR RAHMAN ----------------------------------------*/
      echo "<input type='hidden' name='cboglcode' value='$cboglcode'>";
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
                                          mas_item
                                    set
                                          itemdescription='$txtAssetName'
                                    where
                                          itemcode='$Item_ID'
                                    ";

                  }
                  else
                  {
                        $TrnQuery="insert into mas_item
                                    (
                                          glcode,
                                          itemdescription,
                                          level
                                    )
                                    values
                                    (
                                          '$cboglcode',
                                          '$txtAssetName',
                                          '0'
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

