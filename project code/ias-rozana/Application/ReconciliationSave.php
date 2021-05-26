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
                  $query="INSERT INTO mas_accounts_reconcile
                          (
                              rec_year,
                              rec_month,
                              accountno,
                              year_dr,
                              year_cr,
                              month_dr,
                              month_cr,
                              closing_dr,
                              closing_cr,
                              unreconcile_dr,
                              unreconcie_cr,
                              remarks,
                              reconcile_date,
                              entry_by,
                              entry_date
                          )
                          VALUES
                          (
                              '$hidReconciliationYear',
                              '$hidReconciliationMonth',
                              '$hidBankAccount',
                              '$txtOpeningDr',
                              '$txtOpeningCr',
                              '$txtTotalDr',
                              '$txtTotalCr',
                              '".($txtOpeningDr+$txtTotalDr)."',
                              '".($txtOpeningCr+$txtTotalCr)."',
                              '$txtUnreconciliationDr',
                              '$txtUnreconciliationCr',
                              '$txaRemarks',
                              STR_TO_DATE('$cboReconcilDay-$cboReconcilMonth-$cboReconcilYear','%e-%c-%Y'),
                              '$SUserID',
                              DATE(NOW())
                          )";

                  //echo $query."<br>";
                  mysql_query($query) or die("Error: 1".mysql_error());


                  for($i=0;$i<$hidIndex;$i++)
                  {
                        if($txtInsertStatus[$i]=="I")
                        {
                              if($chkClear[$i]=="ON")
                              {
                                    $query="INSERT INTO trn_accounts_reconcile
                                            (
                                                rec_year,
                                                rec_month,
                                                journalid,
                                                journaltype,
                                                journaldate,
                                                accountno,
                                                chequeno,
                                                chequedate,
                                                partyid,
                                                supplierid,
                                                glcode,
                                                dr_amount,
                                                cr_amount,
                                                reconcile_date,
                                                reconcile_year,
                                                reconcile_month,
                                                reconcile_status,
                                                entry_by,
                                                entry_date
                                            )
                                            VALUES
                                            (
                                                '$hidReconciliationYear',
                                                '$hidReconciliationMonth',
                                                '".$txtJournalID[$i]."',
                                                '".$txtJournalType[$i]."',
                                                STR_TO_DATE('".$txtJournalDate[$i]."','%e-%c-%Y'),
                                                '$hidBankAccount',
                                                '".$txtChequeNo[$i]."',
                                                STR_TO_DATE('".$txtChequeDate[$i]."','%e-%c-%Y'),
                                                '".$txtPartyID[$i]."',
                                                '".$txtSupplierID[$i]."',
                                                '".$txtGLCode[$i]."',
                                                '".$txtDrAmount[$i]."',
                                                '".$txtCrAmount[$i]."',
                                                STR_TO_DATE('$cboReconcilDay-$cboReconcilMonth-$cboReconcilYear','%e-%c-%Y'),
                                                '$cboReconciliationYear',
                                                '$cboReconciliationMonth',
                                                '1',
                                                '$SUserID',
                                                DATE(NOW())
                                            )";

                                    //echo $query."<br>";
                                    mysql_query($query) or die("Error: 2".mysql_error());
                                    
                                    $updatetrnjournla="update
                                                                trn_journal
                                                        set
                                                                reconcile_status='1'
                                                        where
                                                                journalid='".$txtJournalID[$i]."'
                                                                and ttype='".$txtttype[$i]."'

                                                        ";
                                   //echo $updatetrnjournla."<br>";
                                   mysql_query($updatetrnjournla)or die("Error: 3 update ".mysql_error());
                              }
                              else
                              {
                                    $query="INSERT INTO trn_accounts_reconcile
                                            (
                                                rec_year,
                                                rec_month,
                                                journalid,
                                                journaltype,
                                                journaldate,
                                                accountno,
                                                chequeno,
                                                chequedate,
                                                partyid,
                                                supplierid,
                                                glcode,
                                                dr_amount,
                                                cr_amount,
                                                entry_by,
                                                entry_date
                                            )
                                            VALUES
                                            (
                                                '$hidReconciliationYear',
                                                '$hidReconciliationMonth',
                                                '".$txtJournalID[$i]."',
                                                '".$txtJournalType[$i]."',
                                                STR_TO_DATE('".$txtJournalDate[$i]."','%e-%c-%Y'),
                                                '$hidBankAccount',
                                                '".$txtChequeNo[$i]."',
                                                STR_TO_DATE('".$txtChequeDate[$i]."','%e-%c-%Y'),
                                                '".$txtPartyID[$i]."',
                                                '".$txtSupplierID[$i]."',
                                                '".$txtGLCode[$i]."',
                                                '".$txtDrAmount[$i]."',
                                                '".$txtCrAmount[$i]."',
                                                '$SUserID',
                                                DATE(NOW())
                                            )";

                                    mysql_query($query) or die("Error: 3".mysql_error());
                              }
                        }
                        /*if($txtInsertStatus[$i]=="U")
                        {
                              if($chkClear[$i]=="ON")
                              {
                                    $query="Update trn_accounts_reconcile set
                                                reconcile_date=STR_TO_DATE('$cboReconciliationDay-$cboReconciliationMonth-$cboReconciliationYear','%e-%c-%Y'),
                                                reconcile_year='$cboReconciliationYear',
                                                reconcile_month='$cboReconciliationMonth',
                                                reconcile_status='1'
                                            where
                                                journalid='".$txtJournalID[$i]."'";

                                    mysql_query($query) or die("Error: 4".mysql_error());
                              }
                        }*/
                  }
                  drawNormalMassage("Data Saved Successfully");
            ?>
      </body>
</html>
<?PHP
      mysql_query("COMMIT") or die("Commit Error.");
      mysql_close();
?>
