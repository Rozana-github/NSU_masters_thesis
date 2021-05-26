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
                  window.location="blank.php";
            }
        </script>
</head>
<form name='frmAddQuery' method='post'>
<?PHP


      mysql_query("BEGIN") or die("Operation cant be start");

      echo "<link rel='stylesheet' type='text/css' href='Style/eng_form.css'>";

                        for($i=0;$i<$totalrow;$i++)
                        {

                         $updatetrn_store_in="update
                                                trn_store_in
                                             set
                                                purchase_rate  = '$txtrate[$i]',
                                                purchase_quantity = '$txtquantity[$i]',
                                                quantity_disburse='$txtquantity[$i]'
                                             where
                                                store_in_id ='$hidstoreinid[$i]';
                                             ";

                        //echo $updatetrn_store_in;
                        mysql_query($updatetrn_store_in)or die(mysql_error());
                        }


        if(mysql_query("COMMIT"))
        {
                drawMassage("Update Done","onClick='back()'");
        }
        else
        {
                drawMassage("Update Not Done","onClick='back()'");

        }
?>
</html>

