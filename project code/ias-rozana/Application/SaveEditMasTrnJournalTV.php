<?PHP
        session_start();
        include_once("Library/dbconnect.php");
        include_once("Library/Library.php");

        mysql_query("BEGIN") or die("Operation cant be start");

        echo "<link rel='stylesheet' type='text/css' href='css/styles.css'/>";


        $VoucherDate=$txtVoucherYear."-".$txtVoucherMonth."-".$txtVoucherDay;

        $cqdateTemp = explode("-",$txtChequeDate);
        $cqdate=$cqdateTemp[2].'-'.$cqdateTemp[1].'-'.$cqdateTemp[0];


        $MasVoucherEntryQuery="update
                                        mas_journal
                                set

                                    journaltype='$txtJournalType',
                                    journaldate='$VoucherDate',
                                    paytype='$rdopayto',
                                    bankid='$cboBank',
                                    accountno='$cboAccountNo',
                                    chequeno='$cqno',
                                    chequedate=STR_TO_DATE('$txtChequeDate','%d-%m-%Y'),

                                    remarks='$mremarks',
                                    tobankid='$cboToBank',
                                    toaccountno='$cboToAccountNo',
                                    journal_status='0',
                                    entry_by= '$SUserID',
                                    entry_date= CURDATE()
                            where
                                    journalno='$journalno'
                                ";

        echo $MasVoucherEntryQuery;
        $resultMasVoucher=mysql_query($MasVoucherEntryQuery) or die(mysql_error());

       //---------------update mas_latestjournalnumber table----------
      /* $updateLatestJournalNo="update mas_latestjournalnumber set
                                        TR='".$journalno."'
                                ";
       $resultLatestNo=mysql_query($updateLatestJournalNo) or die(mysql_error());



        //--------------- search max journal id from mas_journal table-----------
        $Lastjournalid="select
                                LAST_INSERT_ID() AS  JournalId
                        from
                                mas_journal
                        ";
        $resultJournalID=mysql_query($Lastjournalid) or die(mysql_error());
        while($rowJournalID= mysql_fetch_array($resultJournalID))
        {
                extract($rowJournalID);
        } */
        
        /************** Delete from trn_journal ****************/
        
        $deletetrn_journal="delete from trn_journal where journalid='".$txtjournalid."'";
        mysql_query($deletetrn_journal)or die(mysql_error());
        
        /******************** End of Delete from trn_journal ******************/

        if($rdopayto=="C")
                $GLCode="10201";
        else
                $GLCode="10202";

        $TrnQueryCR="insert into trn_journal
                 (
                        journalid,
                        slno,
                        glcode,
                        subglcode,
                        amount,
                        remarks,
                        ttype
                 )
                 values
                 (
                        '$txtjournalid',
                        '1',
                        '$GLCode',
                        'rests',
                        '$txtAmount',
                        '$mremarks',
                        'Cr'
                  )
                ";
        echo $TrnQueryCR;
        $resultTrnQueryCR=mysql_query($TrnQueryCR)  or die(mysql_error());

        if($rdoTopayto=="C")
                $GLCode="10201";
        else
                $GLCode="10202";

        $TrnQueryCR="insert into trn_journal
                 (
                        journalid,
                        slno,
                        glcode,
                        subglcode,

                        amount,
                        remarks,
                        ttype
                 )
                 values
                 (
                        '$txtjournalid',
                        '2',
                        '$GLCode',
                        'rests',

                        '$txtAmount',
                        '$mremarks',
                        'Dr'
                  )
                ";
        echo $TrnQueryCR;
        $resultTrnQueryCR=mysql_query($TrnQueryCR)  or die(mysql_error());

        if(mysql_query("COMMIT"))
        {
                drawMassage("Data Saved Succssfully","");
        }
        else
        {
                drawMassage("Data Saved Error","");

        }

?>
