<?PHP
      include "Library/dbconnect.php";
      include "Library/Library.php";
      include "Library/SessionValidate.php";
?>
<?PHP
      mysql_query("BEGIN") or die("Begin Error.");
?>
<html>
      <head>
            <meta http-equiv='Content-Type' content='text/html; charset=windows-1252'>
            <title>Invoice Posting</title>
            <LINK href="Style/generic_form.css" type='text/css' rel='stylesheet'>
            <link rel='stylesheet' type='text/css' href='Style/eng_form.css' />
      </head>
      <body class='body_e'>
            <?PHP
                 for($i=0;$i<$hidIndex;$i++)
                 {
                        if(isset($chkAccept[$i]))
                        {
                                $insertmas_order_delivery="insert into
                                        mas_order_delivery
                                        (
                                                plan_object_id,
                                                order_object_id,
                                                delivered_qty,
                                                delivered_date,
                                                entry_by,
                                                entry_date,
                                                status
                                        )
                                        values
                                        (
                                                '".$txtplanobjectid[$i]."',
                                                '".$txtorderobjectid[$i]."',
                                                '".$txtdeliverdqty[$i]."',
                                                STR_TO_DATE('".$cbodeliveryYear."-".$cbodeliveryMonth."-".$cbodeliveryDay."','%Y-%m-%d'),
                                                '".$SUserID."',
                                                sysdate(),
                                                '0'
                                        )
                                ";
                                //echo $insertmas_order_delivery."<br>";
                                mysql_query($insertmas_order_delivery)or die(mysql_error());
                                //echo $balance."=".$txtproducedqty[$i]."-".$txtorderobjectid[$i]."";
                                $balance=$txtproducedqty[$i]-$txtdeliverdqty[$i];
                                //echo $balance;
                                if($balance>0)
                                        $state=1;
                                else
                                        $state=2;
                                        
                                $updatemas_order_production="update
                                                                mas_order_production
                                                             set
                                                                status='".$state."'
                                                             where
                                                                plan_object_id='".$txtplanobjectid[$i]."'
                                                                ";
                              //echo $updatemas_order_production."<br>";
                              mysql_query($updatemas_order_production)or die(mysql_error());
                        }
                }
                  

            ?>
      </body>
</html>
<?PHP
      if(mysql_query("COMMIT"))
      {
        drawNormalMassage("Data Saved Successfully");
      }
      else
      {
        drawNormalMassage("Data Saved Failed");
      }
      mysql_close();
?>
