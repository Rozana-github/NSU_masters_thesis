<?PHP
session_start();
        include_once("Library/dbconnect.php");
        include_once("Library/Library.php");

mysql_query("BEGIN") or die("Operation cant be start");

        echo "<link rel='stylesheet' type='text/css' href='Style/eng_form.css'>";


        $VoucherDate=$txtVoucherYear."-".$txtVoucherMonth."-".$txtVoucherDay;

        $cqdateTemp = explode("-",$txtChequeDate);
        $cqdate=$cqdateTemp[2].'-'.$cqdateTemp[1].'-'.$cqdateTemp[0];


        $MasVoucherEntryQuery="insert into mas_journal
                             (
                                    journalno,
                                    journaltype,
                                    journaldate,
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
                             values
                             (
                                    '$journalno',
                                    '$txtJournalType',
                                    '$VoucherDate',
                                    '$rdopayto',
                                    '$cboBank',
                                    '$cboAccountNo',
                                    '$cqno',
                                    STR_TO_DATE('$txtChequeDate','%d-%m-%Y'),
                                    '$cmbCustomer',
                                    '$mremarks',
                                    '0',
                                    '$SUserID',
                                    CURDATE()
                             )";

        $resultMasVoucher=mysql_query($MasVoucherEntryQuery) or die(mysql_error());

       //---------------update mas_latestjournalnumber table----------
       $updateLatestJournalNo="update mas_latestjournalnumber set
                                        DR='".$journalno."'
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
        }

        for($i=1;$i<$TotalIndex;$i++)
        {
                  $ChartOfAccuntTemp=explode("-",$txtChartofAccount[$i]);
                  $ChartOfAccunt=$ChartOfAccuntTemp[sizeof($ChartOfAccuntTemp)-1];

//echo $txtChartofAccount[$i]."<br>";
//echo $ChartOfAccunt;


                  $TrnQuery="insert into trn_journal
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
                                    '$JournalId',
                                    '$i',
                                    '$txtglcode[$i]',
                                    'rests',
                                    '".$txtCreditAmount[$i]."',
                                    '".$txtRemarks[$i]."',
                                    'Cr'
                             )";

                  $resultTrnQuery=mysql_query($TrnQuery) or die(mysql_error());
        }

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
                        '$JournalId',
                        '$i',
                        '$GLCode',
                        'rests',
                        '$TotalCredit',
                        '',
                        'Dr'
                  )
                ";
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
