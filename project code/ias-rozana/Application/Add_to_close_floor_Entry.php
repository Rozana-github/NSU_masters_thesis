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
                  window.location="close_floor_Entry_Top.php";
            }
        </script>
</head>
<form name='frmAddQuery' method='post'>
<?PHP



                        $TrnQuery="replace into mas_closing_flr
                                    (
                                          product_id ,
                                          product_qty ,
                                          rate ,
                                          amount ,
                                          remarks,
                                          flr_month,
                                          flr_year

                                    )
                                    values
                                    (
                                          '$text_productid',
                                          '$text_Quantity',
                                          '$text_Rate',
                                          '$text_Amount',
                                          '$text_Remarks',
                                          '$fMonth',
                                          '$fYear'
                                          
                                    )";

//echo"$TrnQuery";

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
</form>
</html>

