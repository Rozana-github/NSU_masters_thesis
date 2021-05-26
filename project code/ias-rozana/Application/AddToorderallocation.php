<?PHP
session_start();
        include_once("Library/dbconnect.php");
        include_once("Library/Library.php");

        mysql_query("BEGIN") or die("Operation can't be open");
?>

<html>

<head>
<script language='JavaScript'>
           /* function back()
            {
                  //var cboglcode=document.frmAddQuery.cboglcode.value;
                  //window.location="Mas_Bank_Entry.php?cboglcode="+cboglcode+"";
                  window.location="orderproductionBottom.php?";
            } */
      </script>

<meta http-equiv='Content-Language' content='en-us'>
<meta http-equiv='Content-Type' content='text/html; charset=windows-1252'>
<title>Supplier Entry Form</title>
<link rel='stylesheet' type='text/css' href='css/interface_styles.css' />

</head>

<body>
<form name='Form1' method='post'  action=''>

<?PHP

                 if(isset($_GET['aDate']) && isset($_GET['sNo']))
            {
                  $allocationDate = $_GET['aDate'];
                  $a=split("-",$_GET['aDate']);
                  $date=$a[2]."-".$a[1]."-".$a[0];
                  $i=$_GET['sl'];
                  //Insert Query

                  $query="insert into
                                    mas_order_planed
                                    (
                                          order_object_id,
                                          planed_date,
                                          machine_id,
                                          starttime,
                                          endtime,
                                          remarks,
                                          planqtykg,
                                          planqtymm,
                                          mas_item,
                                          sub_item,
                                          status,
                                          entry_by,
                                          entry_date
                                    )
                                    values
                                    (
                                          ".$_GET['sNo'].",
                                          '".$date."',
                                          '".$_GET['mname']."',
                                          MAKETIME(".$_GET['stime'].",00,00),
                                          MAKETIME(".$_GET['etime'].",00,00),
                                          '".$_GET['planremarks']."',
                                          '".$_GET['qtykg']."',
                                          '".$_GET['qtymm']."',
                                          '".$_GET['item']."',
                                          '".$_GET['subitem']."',
                                          '0',
                                          '$SUserID',
                                          sysdate()

                                    )
                        ";
                echo $query;
                  $rset=mysql_query($query) or die(mysql_error());
                  $update_mas_order="update
                                          mas_order
                                    set
                                          product_status='1'
                                    where
                                          order_object_id=".$_GET['sNo']."
                                    ";
                   mysql_query($update_mas_order)or die(mysql_error());

                 /* echo '
                  <script language="javascript">
                        redirectPage('.$a[0].','.$a[1].','.$a[2].');
                  </script>
                  '; */
            }

        if(mysql_query("COMMIT"))
        {
                drawNormalMassage("Operation Done");
        }
        else
        {
                drawNormalMassage("Operation Not Done");
        }

?>






</form>
</body>

</html>

