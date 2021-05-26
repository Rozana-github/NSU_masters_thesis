<?PHP
      include "Library/dbconnect.php";
      include "Library/Library.php";
      include "Library/SessionValidate.php";

//************************************* INSERT ********************************************
       if ($counter == 0)
       { ?> <BR> <BR> <BR> <BR>
          <center> <TABLE Border = "1" Width="50%"> <TR> <TD>
          <center><font color="#0000F0" face="Arial" size ="4"><strong>
          <?PHP echo "Empty Rates Can Not Be Updated"; ?>
          </strong> </font> </TD> </TR> </TABLE> </center>
          <?PHP  exit();
       }


        for($i=1; $i<=$counter; $i++)
        {
        $qry   = "SELECT *
                    FROM trn_asset_depreciation
                   WHERE assetid='$ASSETID[$i]' AND proc_year = '$proc_year' AND proc_month='$proc_month'";

       echo $qry."<br>";
                  $rs=mysql_query($qry) or die("Error: ".mysql_error());
                $count = mysql_num_rows($rs);

                    if($count > 0)
                    {
                    //echo "update";
                         $q1     = "UPDATE `trn_asset_depreciation` SET
                                                      `opening_cost`='$E[$i]',
                                                      `addition_cost='$F$i]',
                                                      `sales_adjust='$G[$i]',
                                                      `total_cost='$H[$i]',
                                                      `opening_depreciation='$I[$i]',
                                                      `depreciation_rate='$J$i]',
                                                      `current_depreciation='$K[$i]',
                                                      `depreication_adjust='$L[$i]',
                                                      `total_depreciation='$M[$i]',
                                                      `wdv='$N[$i]'
                                          WHERE assetid='$ASSETID[$i]' AND proc_year = '$proc_year' AND proc_month='$proc_month'";
                               echo $q1."<br>";
                               //$result = mysql_db_query($dbName,$q1);
                               $rs=mysql_query($q1) or die("Error: ".mysql_error());
                    }


//Insert, if glcode not found.
                    if($count == 0)
                    {
                    //echo "Insert";
                        $q2     = "      INSERT INTO `trn_asset_depreciation` (
                                                                                                      `assetid`,
                                                                                                      `proc_year`,
                                                                                                      `proc_month`,
                                                                                                      `opening_cost`,
                                                                                                      `addition_cost`,
                                                                                                      `sales_adjust`,
                                                                                                      `total_cost`,
                                                                                                      `opening_depreciation`,
                                                                                                      `depreciation_rate`,
                                                                                                      `current_depreciation`,
                                                                                                      `depreication_adjust`,
                                                                                                      `total_depreciation`,
                                                                                                      `wdv`
                                                                                                )
                                                                                    VALUES  (      '$ASSETID[$i]',
                                                                                                      '$proc_year',
                                                                                                      '$proc_month',
                                                                                                      '$E[$i]',
                                                                                                      '$F[$i]',
                                                                                                      '$G[$i]',
                                                                                                      '$H[$i]',
                                                                                                      '$I[$i]',
                                                                                                      '$J[$i]',
                                                                                                      '$K[$i]',
                                                                                                      '$L[$i]',
                                                                                                      '$M[$i]',
                                                                                                      '$N[$i]'
                                                                                                )";
                              echo $q2."<br>";
                              $rs=mysql_query($q2) or die("Error: ".mysql_error());
                          }

        }
?>

          <center> <TABLE Border = "1" Width="50%">

          <?PHP if ($rs> 0)
             { ?>
             <TR> <TD>
             <font color="#00000F" face="Arial" size ="3">
             <strong> <center> Your Data Has Been Posted. </center> </strong> </font>
          <?PHP } ?>

          </TD> </TR>
          </TABLE>
          </center>

<?PHP  mysql_close(); ?>



