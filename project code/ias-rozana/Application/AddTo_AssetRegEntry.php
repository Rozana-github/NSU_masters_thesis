<?PHP
session_start();

        include_once("Library/dbconnect.php");
        include_once("Library/Library.php");
?>
<html>
<head>
        <LINK href="../Style/Apperance_1.css" type=text/css rel=stylesheet>
        <script language='JavaScript'>
            function back()
            {
                  window.location="AssetRegEntryTop.php";
            }
        </script>
</head>
<body>
<?PHP
      $query1="INSERT INTO mas_asset_register
      (
            purchase_date,
            supplier_Id
      )
      VALUES
      (
            STR_TO_DATE('$txtChequeDate','%d-%m-%Y'),
            '$user'
      )";

      mysql_query($query1) or die("Invalid query1: " . mysql_error());


      /*-------------------------- LAST INSERT ID ----------------------------------------*/
      $query2="SELECT LAST_INSERT_ID() AS AssetRegisterObjectID  from mas_asset_register";
      $rs=mysql_query($query2) or die("Error: ".mysql_error());
      while($row=mysql_fetch_array($rs))
      {
            extract($row);
      }
      /*-------------------------- END LAST INSERT ID -----------------------------------*/


        for ($i=0;$i<$index;$i++)
        {

                $query="INSERT INTO trn_asset_register
                        (
                                asseregisterobjectid,
                                assetobjectid,
                                purchase_date,
                                remarks,
                                purchase_qty,
                                depreciation_rate,
                                purchase_amount
                                
                        )
                        VALUES
                        (           '$AssetRegisterObjectID',
                                    '".$Title[$i]."',
                                    STR_TO_DATE('$txtChequeDate','%d-%m-%Y'),
                                    '".$Remarks[$i]."',
                                    '".$Description[$i]."',
                                    '".$Heading[$i]."',
                                    '".$PurchCost[$i]."'
                        );";
                //echo $query;
                mysql_query($query) or die("Invalid query2: " . mysql_error());
        }
        drawMassage("Operation Done","onClick='back()'");

?>

  </body>
</html>
