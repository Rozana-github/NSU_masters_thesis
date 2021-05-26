<?PHP
session_start();
        include_once("Library/dbconnect.php");
        include_once("Library/Library.php");

        mysql_query("BEGIN") or die("Operation can't be open");
?>

<html>

<head>
<script language='JavaScript'>
            function back()
            {
                  //var cboglcode=document.frmAddQuery.cboglcode.value;
                  //window.location="Mas_Bank_Entry.php?cboglcode="+cboglcode+"";
                  window.location="orderproductionBottom.php?";
            }
      </script>

<meta http-equiv='Content-Language' content='en-us'>
<meta http-equiv='Content-Type' content='text/html; charset=windows-1252'>
<title>Supplier Entry Form</title>
<link rel='stylesheet' type='text/css' href='css/interface_styles.css' />

</head>

<body>
<form name='Form1' method='post'  action=''>

<?PHP

                for($i=0;$i<$totalrow;$i++)
                {
                        if($txtachour[$i]!='')
                        {
                                $insertMasorderproduction="insert into
                                                                mas_order_production
                                                                (
                                                                        plan_object_id,
                                                                        actualhour,
                                                                        productionqty,
                                                                        remarks,
                                                                        status
                                                                )
                                                                values
                                                                (
                                                                        '".$txtplanid[$i]."',
                                                                        '".$txtachour[$i]."',
                                                                        '".$txtqty[$i]."',
                                                                        '".$txtremarks[$i]."',
                                                                        '0'
                                                )

                                        ";
                                //echo $insertMasorderproduction;
                                $resultMasInvoice=mysql_query($insertMasorderproduction) or die(mysql_error());

                                $updatequery="update
                                                        mas_order_planed
                                                set
                                                        status='2'
                                                where
                                                        plan_object_id='".$txtplanid[$i]."'
                                                " ;
                                mysql_query($updatequery)or die(mysql_error());
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






</form>
</body>

</html>

