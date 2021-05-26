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
                  $query="INSERT INTO mas_journal
                          (
                              journalno,
                              journaltype,
                              journaldate,
                              partyid,
                              journal_status,
                              entry_by,
                              entry_date
                          )
                          VALUES
                          (
                              '$VoucherNo',
                              'JV',
                              STR_TO_DATE('$cboVoucherDay-$cboVoucherMonth-$cboVoucherYear','%e-%c-%Y'),
                              '$CustomerID',
                              '0',
                              '$SUserID',
                              DATE(now())
                          )";

                  mysql_query($query) or die("Error: 1".mysql_error());

                  $query="select last_insert_id() as journalid from mas_journal";
                  $rs=mysql_query($query) or die("Error: 2".mysql_error());
                  while($row=mysql_fetch_array($rs))
                  {
                        extract($row);
                  }

                  $i=1;
                  $query="INSERT INTO trn_journal
                              (journalid,slno,glcode,amount,ttype)
                          VALUES
                              ('$journalid','$i','10501','$NetBill','Dr')";
                  if(isset($NetBill) && $NetBill!=0)
                        mysql_query($query) or die("Error: 3".mysql_error());
                  $i++;

                  $query="INSERT INTO trn_journal
                              (journalid,slno,glcode,amount,ttype)
                          VALUES
                              ('$journalid','$i','30202','$DiscountAmount','Dr')";
                  if(isset($DiscountAmount) && $DiscountAmount!=0)
                        mysql_query($query) or die("Error: 4".mysql_error());
                  $i++;

                  $query="INSERT INTO trn_journal
                              (journalid,slno,glcode,amount,ttype)
                          VALUES
                              ('$journalid','$i','30102','$TotalBill','Cr')";
                  if(isset($TotalBill) && $TotalBill!=0)
                        mysql_query($query) or die("Error: 5".mysql_error());
                  $i++;

                  $query="INSERT INTO trn_journal
                              (journalid,slno,glcode,amount,ttype)
                          VALUES
                              ('$journalid','$i','10601','$Vat','Cr')";
                  if(isset($Vat) && $Vat!=0)
                        mysql_query($query) or die("Error: 6".mysql_error());


                  $query="update mas_latestjournalnumber set JV='$VoucherNo'";
                  mysql_query($query) or die("Error: 7".mysql_error());

                  $query="update mas_invoice set journal_status='1' where invoiceobjet_id='$InvoiceObjectID'";
                  mysql_query($query) or die("Error: 8".mysql_error());

                  echo "<script language='javascript'>
                              window.parent.InvoicePostingTop.location=\"InvoicePostingTop.php\";
                        </script>";
                  drawNormalMassage("Data Saved Successfully");
            ?>
      </body>
</html>
<?PHP
      mysql_query("COMMIT") or die("Commit Error.");
      mysql_close();
?>
