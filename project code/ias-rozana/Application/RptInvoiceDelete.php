<?PHP
      include "Library/dbconnect.php";
      include "Library/Library.php";
      include "Library/SessionValidate.php";
      
      mysql_query("BEGIN") or die("Operation can't Start");
?>

<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=windows-1252'>
<title>Invoice Posting</title>
<script language='javascript'>

</script>

<LINK href="Style/generic_form.css" type='text/css' rel='stylesheet'>
<link rel='stylesheet' type='text/css' href='Style/eng_form.css' />

</head>
<body class='body_e'>

<form Name='Form1' method='post' action=''>

<?PHP
//------------ delete invoice number-----------------

$deleteMasInvoice="delete
                from
                        mas_invoice
                where
                       invoiceobjet_id='".$txtInvoiceObjectID."'
                ";
$resultMasInvoice=mysql_query($deleteMasInvoice) or die(mysql_error());

$deleteTrnInvoice="delete
                from
                        trn_invoice
                where
                       invoiceobject_id='".$txtInvoiceObjectID."'
                ";
$resultTrnInvoice=mysql_query($deleteTrnInvoice) or die(mysql_error());



echo"
<script language='javascript'>
        window.location.href=\"RptPrintInvoice.php\";
</script>
";


?>

<?PHP
      mysql_query("COMMIT") or die("Operation can't Successfull");
?>
</form>
</body>
</html>
