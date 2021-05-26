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
                  window.location="mas_asset_dep_setup.php?";
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

                  
            for($i=0;$i<$txtTotalrow;$i++)
            {
                  if($cbodepreciation[$i] != '-1' || $cboAccumulated[$i] != '-1')
                  {
                  $insertmas_asset_dep_setup="replace into
                                                      mas_asset_dep_setup
                                                      (
                                                            asset_glcode,
                                                            cost_code,
                                                            asset_dep_glcode,
                                                            asset_acm_glcode
                                                      )
                                                      values
                                                      (
                                                            '".$txtasset_gl[$i]."',
                                                            '".$cbocost_center[$i]."',
                                                            '".$cbodepreciation[$i]."',
                                                            '".$cboAccumulated[$i]."'
                                                      )";
                  $resultTrnQuery=mysql_query($insertmas_asset_dep_setup) or die(mysql_error());
                  }
            }



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

