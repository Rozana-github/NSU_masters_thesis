<?PHP
        include "Library/SessionValidate.php";
?>
<?PHP
        include "Library/dbconnect.php";
        include "Library/Library.php";
?>

<?PHP
      if(is_numeric($ACCatID) && is_numeric($ACRank) && is_numeric($PreviousCatID) && is_numeric($PreviousRank))
      {
            $UpdCategory1="UPDATE _nisl_chart_color
                                    SET
                                          display_rank='$PreviousRank'
                                    where
                                          demo_color_id='$ACCatID'
                  ";
            mysql_query($UpdCategory1) or die(mysql_error());
      
            $UpdCategory2="UPDATE _nisl_chart_color
                        SET
                              display_rank='$ACRank'
                        where
                              demo_color_id='$PreviousCatID'
                  ";
            mysql_query($UpdCategory2) or die(mysql_error());
            echo "
            <script language='javascript'>
            window.location='ColorChartTitleList.php';
            </script>";

      }
      else
      {
            drawMassage("Swap Not Completed.","");
      }
?>
<?PHP
        mysql_close();
?>
