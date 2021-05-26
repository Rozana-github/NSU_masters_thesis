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
               $totalamount=0;

                for($i=0;$i<$txtdescIndex;$i++)
                {
                       $totalamount=$totalamount+$txtorderamount[$i];


                }

                //Insert into mas_invoice
                $insertMasInvoice="insert into mas_order
                                        (
                                          job_no,
                                          customer_id,
                                          order_date,
                                          order_description,
                                          order_qty,
                                          order_unit,
                                          rate,
                                          total_amount,
                                          vat_status,
                                          first_proof_date,
                                          final_proof_date,
                                          printing_order_date,
                                          delivery_date ,
                                          order_status,
                                          product_status,
                                          paid_on_order_amount,
                                          due_on_delivery_amount,
                                          remarks,
                                          entryby,
                                          entry_date

                                        )
                                        values
                                        (
                                       '$txtjobno',
                                       '$txtCustomerID',
                                       '$OrderDate',
                                       '',
                                       '$txtqty',
                                       '0',
                                       '$txtrate',
                                       '$totalamount',
                                       '$vatstatus',
                                       Str_to_date('$txtfstproofdate','%d-%m-%Y'),
                                       Str_to_date('$txtfinalproofdate','%d-%m-%Y'),
                                       Str_to_date('$txtprintorderdate','%d-%m-%Y'),
                                       Str_to_date('$txtdeliverydate','%d-%m-%Y'),
                                       '0',
                                       '0',
                                       '$txtpaidamount',
                                       '$txtdueamount',
                                       '$txtremarks',
                                       '$SUserID',
                                       CURDATE()
                                        )
                                ";
                echo $insertMasInvoice;
                $resultMasInvoice=mysql_query($insertMasInvoice) or die(mysql_error());
                
               //------search invoice recent id-----------
               $searchInvoiceID="select
                                        LAST_INSERT_ID() as orderid
                                from
                                       mas_order
                                ";
               $resultInvoice=mysql_query($searchInvoiceID) or die(mysql_error());
               while($rowInvoice=mysql_fetch_array($resultInvoice))
               {
                        extract($rowInvoice);
               }
                
                // Insert into trn_order_description
                for($i=0;$i<$txtdescIndex;$i++)
                {
                  $inserttrnorderdesc="insert into
                                          trn_order_description
                                          (
                                                order_object_id,
                                                order_description,
                                                order_quntity,
                                                order_rate,
                                                order_unit,
                                                order_amount,
                                                entry_by,
                                                entry_date

                                          )
                                          values
                                          (
                                                '$orderid',
                                                '".$txtorderdescription[$i]."',
                                                '".$txtorderqunatity[$i]."',
                                                '".$txtorderrate[$i]."',
                                                '".$txtunitid[$i]."',
                                                '".$txtorderamount[$i]."',
                                                '$SUserID',
                                                sysdate()
                                          )

                                    ";
                        echo $inserttrnorderdesc;
                        mysql_query($inserttrnorderdesc) or die(mysql_error());
                }
                
                for($i=0;$i<$txtIndex;$i++)
                {


                //Insert into trn_invoice
                $insertTrnInvoice="insert into trn_order
                                        (
                                          order_object_id,
                                          mas_item,
                                          sub_item

                                        )
                                        values
                                        (
                                          '$orderid',
                                          '".$ItemID[$i]."',
                                          '".$SubItemID[$i]."'

                                        )
                                ";
                echo $insertTrnInvoice;
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
                                        <input type='button' name='btnBack' value='Back' onClick=\"window.location.href='OrderEntry.php' \"; >
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

