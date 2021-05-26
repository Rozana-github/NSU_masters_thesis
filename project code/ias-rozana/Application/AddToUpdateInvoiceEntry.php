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
               $InvoiceDate=$cboInvoiceYear."-".$cboInvoiceMonth."-".$cboInvoiceDay;
               $OrderDate=$cboOrderYear."-".$cboOrderMonth."-".$cboOrderDay;

                //Update mas_invoice
                $updateMasInvoice="update mas_invoice set
                                        invoice_number='".$txtInvoiceNumber."',
                                        invoice_date='".$InvoiceDate."',
                                        customer_id='".$txtCustomerID."',
                                        order_number='".$txtOrderNo."',
                                        order_date='".$OrderDate."',
                                        vat_parcent='".$txtVatRate."',
                                        vat='".$txtVatValue."',
                                        discount_amount='".$txtDiscount."',
                                        total_bill='".$txtSum."',
                                        net_bill='".$txtNet."',
                                        payment_terms='".$txtPaymentType."',
                                        journal_status='0',
                                        receive_status='0',
                                        update_by='".$SUserID."',
                                        update_date=CURDATE()
                                where
                                        invoiceobjet_id='".$txtInvoiceObjectID."'
                                ";
                $resultMasInvoice=mysql_query($updateMasInvoice) or die(mysql_error());


                for($i=0;$i<$txtIndex;$i++)
                {

                        if($TrnInvoiceID[$i]=='-1')
                        {
                        $CD=explode("-",$BDate[$i]);
                        $ChallanDate=$CD[2]."-".$CD[1]."-".$CD[0];
                        //Insert into trn_invoice
                        $insertTrnInvoice="insert into trn_invoice
                                                (
                                                invoiceobject_id,
                                                challan_no,
                                                challan_date,
                                                job_no,
                                                product_name,
                                                unit_type,
                                                total_quantity,
                                                unit_price,
                                                total_price
                                                )
                                                values
                                                (
                                                '".$txtInvoiceObjectID."',
                                                '".$ChallanNo[$i]."',
                                                '".$ChallanDate."',
                                                '".$JobNo[$i]."',
                                                '".$Description[$i]."',
                                                '".$UnitID[$i]."',
                                                '".$Quantity[$i]."',
                                                '".$UnitPrice[$i]."',
                                                '".$TotalPrice[$i]."'
                                                )
                                        ";
                        //echo $insertTrnInvoice;
                        $resultTrnInvoice=mysql_query($insertTrnInvoice) or die(mysql_error());

                        }

                }
                
                //------------ delete from trn_invoice table------------
                for($j=0;$j<$txtDelNumber;$j++)
                {
                        $deleteTrnInvoice="delete
                                                from
                                                        trn_invoice
                                                where
                                                        trninvoiceobject_id='".$DelTrnInvoiceID[$j]."'
                                        ";
                        $ResultTrnInvoice=mysql_query($deleteTrnInvoice) or die(mysql_error());
                }

        echo"
        <DIV class=form_background style=\"position: absolute; WIDTH: 570px; height:300px;\">
        <DIV class=form_groove_outer>
        <DIV class=form_groove_inner>

                <table border='0' width='100%' align='center' cellspacing='0' cellpadding='3'>
                        <tr>
                                <td align='center' width='100%'>
                                        <b><font size='2'>Information update Successfully</b></font>
                                </td>
                        </tr>
                        <tr>
                                <td align='center' width='100%'>
                                        <input type='button' name='btnBack' value='Back' onClick=\"window.location.href='RptPrintInvoice.php' \"; >
                                </td>
                        </tr>
                </table>
        </DIV>
        </DIV>";

?>


<?PHP
        mysql_query("COMMIT") or die("Operation can't be Successfull");
?>

</form>
</body>

</html>

