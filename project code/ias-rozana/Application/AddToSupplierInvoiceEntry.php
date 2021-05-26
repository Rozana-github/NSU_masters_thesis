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

                //Insert into mas_invoice
                $insertMasInvoice="insert into mas_supplier_invoice
                                        (
                                        invoice_number,
                                        supplier_id,
                                        invoice_date,
                                        purchase_order_number,
                                        order_date,
                                        vat_parcent,
                                        vat,
                                        discount_amount,
                                        total_bill,
                                        net_bill,
                                        payment_terms,
                                        journal_status,
                                        receive_status,
                                        entry_by,
                                        entry_date
                                        )
                                        values
                                        (
                                       '$txtInvoiceNumber',
                                       '$txtSupplierID',
                                       '$InvoiceDate',
                                       '$txtOrderNo',
                                       '$OrderDate',
                                       '$txtVatRate',
                                       '$txtVatValue',
                                       '$txtDiscount',
                                       '$txtSum',
                                       '$txtNet',
                                       '$txtPaymentType',
                                       '0',
                                       '0',
                                       '$SUserID',
                                        CURDATE()
                                        )
                                ";
                $resultMasInvoice=mysql_query($insertMasInvoice) or die(mysql_error());
                
               //------search invoice recent id-----------
               $searchInvoiceID="select
                                        LAST_INSERT_ID() as InvoiceID
                                from
                                       mas_supplier_invoice
                                ";
               $resultInvoice=mysql_query($searchInvoiceID) or die(mysql_error());
               while($rowInvoice=mysql_fetch_array($resultInvoice))
               {
                        extract($rowInvoice);
               }
                
                for($i=0;$i<$txtIndex;$i++)
                {

                $CD=explode("-",$BDate[$i]);
                $ChallanDate=$CD[2]."-".$CD[1]."-".$CD[0];
                //Insert into trn_invoice
                $insertTrnInvoice="insert into trn_supplier_invoice
                                        (
                                        lcobjectid,
                                        glcode,
                                        itemcode,
                                        unit_type,
                                        unit_price,
                                        totalqty,
                                        remarks,
                                        total_price

                                        )
                                        values
                                        (
                                       '$InvoiceID',
                                       '".$Glcode[$i]."',
                                       '".$Itemno[$i]."',
                                       '".$UnitID[$i]."',
                                       '".$UnitPrice[$i]."',
                                       '".$Quantity[$i]."',
                                       '".$Description[$i]."',
                                       '".$TotalPrice[$i]."'
                                        )
                                ";
                //echo $insertTrnInvoice;
                $resultTrnInvoice=mysql_query($insertTrnInvoice) or die(mysql_error());

                }

        echo"
        <DIV class=form_background style=\"position: absolute; WIDTH: 570px; height:300px;\">
        <DIV class=form_groove_outer>
        <DIV class=form_groove_inner>

                <table border='0' width='100%' align='center' cellspacing='0' cellpadding='3'>
                        <tr>
                                <td align='center' width='100%'>
                                        <b><font size='2'>Information save Successfully</b></font>
                                </td>
                        </tr>
                        <tr>
                                <td align='center' width='100%'>
                                        <input type='button' name='btnBack' value='Back' onClick=\"window.location.href='SupplierInvoiceEntry.php' \"; >
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

