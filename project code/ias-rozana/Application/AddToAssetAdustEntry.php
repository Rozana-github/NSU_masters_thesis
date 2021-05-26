<?PHP
session_start();
        include_once("Library/dbconnect.php");
        include_once("Library/Library.php");

        mysql_query("BEGIN") or die("Operation can't be open");
?>

<html>

<head>

<meta http-equiv='Content-Language' content='en-us'>
<meta http-equiv='Content-Type' content='text/html; charset=windows-1252'>
<title>Supplier Entry Form</title>
<link rel='stylesheet' type='text/css' href='css/interface_styles.css' />

</head>

<body>
<form name='Form1' method='post'  action=''>

<?PHP


               $queryinsert="
                              replace into
                                    trn_asset_disposal
                                    (
                                          assetid,
                                          sales_amount,
                                          depreciation_adjust,
                                          sales_date,
                                          remarks
                                    )
                                    values
                                    (
                                          '".$txtassetid."',
                                          '".$txtAdjustamount."',
                                          '".$txtAdjustdepreciation."',
                                          STR_TO_DATE('$AdjustYear-$AdjustMonth-$AdjustDay','%Y-%c-%e'),
                                          '".$txtremarks."'
                                    )
                              ";
                 //echo $queryinsert;
                 mysql_query($queryinsert) or die(mysql_error());
                
               //------search invoice recent id-----------

        echo"



                <table border='0' width='100%' align='center' cellspacing='0' cellpadding='3'>
                        <tr>
                                <td align='center' width='100%'>
                                        <b><font size='2'>Information save Successfully</b></font>
                                </td>
                        </tr>
                        <tr>
                                <td align='center' width='100%'>
                                        <input type='button' name='btnBack' value='Back' onClick=\"window.location.href='AssetListBottom.php?cboglcode=$txtglcode' \"; >
                                </td>
                        </tr>
                </table>
        ";

?>


<?PHP
        mysql_query("COMMIT") or die("Operation can't be Successfull");
?>

</form>
</body>

</html>

