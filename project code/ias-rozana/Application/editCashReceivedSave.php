<?PHP
      include "Library/dbconnect.php";
      include "Library/Library.php";
      include "Library/SessionValidate.php";
?>
<?PHP
      mysql_query("BEGIN") or die("Begin Error.");
?>
<html>
      <head>
            <meta http-equiv='Content-Type' content='text/html; charset=windows-1252'>
            <title>Invoice Posting</title>
            <LINK href="Style/generic_form.css" type='text/css' rel='stylesheet'>
            <link rel='stylesheet' type='text/css' href='Style/eng_form.css' />
      </head>
      <body class='body_e'>
            <?PHP
                  $query="replace INTO mas_journal
                          (
                              journalid,
                              journalno,
                              journaltype,
                              journaldate,
                              moneyreceiptno,
                              paytype,
                              bankid,
                              accountno,
                              chequeno,
                              chequedate,
                              partyid,
                              remarks,
                              journal_status,
                              entry_by,
                              entry_date
                          )
                          VALUES
                          (
                              '".$txtjournalid."',
                              '$txtVoucherNo',
                              'REC',
                              STR_TO_DATE('$cboVoucherDay-$cboVoucherMonth-$cboVoucherYear','%e-%c-%Y'),
                              '$txtMoneyReceiptNo',
                              '$rdoReceiveType',
                              '$cboBank',
                              '$cboBankAccount',
                              '$txtChequeNo',
                              STR_TO_DATE('$cboChequeDay-$cboChequeMonth-$cboChequeYear','%e-%c-%Y'),
                              '$CustomerID',
                              '$txaRemarks',
                              '0',
                              '$SUserID',
                              DATE(now())
                          )
                          ";
                  //echo $query;
                  mysql_query($query) or die("Error: 1".mysql_error());
                  
                  /*$query="select last_insert_id() as journalid from mas_journal";
                  $rs=mysql_query($query) or die("Error: 2".mysql_error());
                  while($row=mysql_fetch_array($rs))
                  {
                        extract($row);
                  }*/
                  
                  /* delete from trn_journal */
                  
                  $update_trn_journal="delete from trn_journal where journalid='".$txtjournalid."'";
                  
                  /*$update_trn_journal="update
                                                trn_journal
                                        set
                                                amount='".$txtTotalAmount."'
                                        where
                                                journalid='".$txtjournalid."'
                                        ";
                  echo "<br>".$update_trn_journal; */
                  mysql_query($update_trn_journal)or die("error 2: ".mysql_error());

                  $i=1;
                  
                  if($rdoReceiveType=='C')
                  {
                        $query="INSERT INTO trn_journal
                                    (journalid,slno,glcode,amount,ttype)
                                VALUES
                                    ('".$txtjournalid."','".$i."','10201','".$txtTotalAmount."','Dr')";
                        mysql_query($query) or die("Error: 3".mysql_error());

                        $i++;
                        //echo "<br>".$query;
                        $query="INSERT INTO trn_journal
                                    (journalid,slno,glcode,amount,ttype)
                                VALUES
                                    ('".$txtjournalid."','".$i."','10501','".$txtTotalAmount."','Cr')";
                        //echo "<br>".$query;
                        mysql_query($query) or die("Error: 4".mysql_error());
                  }
                  else if($rdoReceiveType=='Q')
                  {
                        $query="INSERT INTO trn_journal
                                    (journalid,slno,glcode,amount,ttype)
                                VALUES
                                    ('".$txtjournalid."','".$i."','10202','".$txtTotalAmount."','Dr')";
                        //echo "<br>".$query;
                        mysql_query($query) or die("Error: 3".mysql_error());

                        $i++;

                        $query="INSERT INTO trn_journal
                                    (journalid,slno,glcode,amount,ttype)
                                VALUES
                                    ('".$txtjournalid."','".$i."','10501','".$txtTotalAmount."','Cr')";
                        //echo "<br>".$query;
                        mysql_query($query) or die("Error: 4".mysql_error());
                  }
                  else
                  {
                        drawNormalMassage("Error: Invalid Pay Type.");
                        die();
                  }
                  $update_mas_invoice_collection="delete from mas_invoice_collection where journal_id='".$txtjournalid."'";
                  mysql_query($update_mas_invoice_collection)or die(mysql_error());
                  
                  for($i=0;$i<$hidIndex;$i++)
                  {
                        if($chkAccept[$i]=="ON")
                        {
                              $query="INSERT INTO mas_invoice_collection
                                    (
                                          invoiceobjet_id,
                                          journal_id,
                                          customer_id,
                                          collection_date,
                                          collection_amount,
                                          entry_by,
                                          entry_date
                                    )
                                    VALUES
                                    (
                                          '".$txtInvoiceObjectID[$i]."',
                                          '".$txtjournalid."',
                                          '".$CustomerID."',
                                          STR_TO_DATE('".$cboVoucherDay."-".$cboVoucherMonth."-".$cboVoucherYear."','%e-%c-%Y'),
                                          '".$txtAmount[$i]."',
                                          '".$SUserID."',
                                          DATE(now())
                                    )";

                              //echo "<br>".$query;
                              mysql_query($query) or die("Error: Collection: ".mysql_error());
                              
                              if(($txtReceivedAmount[$i]+$txtAmount[$i])>=$txtNetBill[$i])
                              {
                                    $query="update mas_invoice set receive_status='2' where invoiceobjet_id='".$txtInvoiceObjectID[$i]."'";
                                    mysql_query($query) or die("Error: Invoice Status: ".mysql_error());
                              }
                              else
                              {
                                    $query="update mas_invoice set receive_status='1' where invoiceobjet_id='".$txtInvoiceObjectID[$i]."'";
                                    mysql_query($query) or die("Error: Invoice Status: ".mysql_error());
                              }
                        }
                  }
                  

                  /*$query="update mas_latestjournalnumber set DR='$txtVoucherNo'";
                  mysql_query($query) or die("Error: 7".mysql_error());*/
                  
                  drawNormalMassage("Data Saved Successfully");
            ?>
      </body>
</html>
<?PHP
      mysql_query("COMMIT") or die("Commit Error.");
      mysql_close();
?>
