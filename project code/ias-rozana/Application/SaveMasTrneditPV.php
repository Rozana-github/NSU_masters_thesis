<?PHP
session_start();
        include_once("Library/dbconnect.php");
        include_once("Library/Library.php");

mysql_query("BEGIN") or die("Operation cant be start");

        echo "<link rel='stylesheet' type='text/css' href='css/styles.css'/>";


        $VoucherDate=$txtVoucherYear."-".$txtVoucherMonth."-".$txtVoucherDay;

        $cqdateTemp = explode("-",$txtChequeDate);
        $cqdate=$cqdateTemp[2].'-'.$cqdateTemp[1].'-'.$cqdateTemp[0];


        $MasVoucherEntryQuery="replace into mas_journal
                             (
                                    journalid,
                                    journalno,
                                    journaltype,
                                    journaldate,
                                    paytype,
                                    bankid,
                                    accountno,
                                    chequeno,
                                    chequedate,
                                    supplierid,
                                    remarks,
                                    journal_status,
                                    entry_by,
                                    entry_date
                             )
                             values
                             (
                                    '$txtjurnalid',
                                    '$journalno',
                                    '$txtJournalType',
                                    '$VoucherDate',
                                    '$rdopayto',
                                    '$cboBank',
                                    '$cboAccountNo',
                                    '$cqno',
                                    STR_TO_DATE('$txtChequeDate','%d-%m-%Y'),
                                    '$cmbParty',
                                    '$mremarks',
                                    '0',
                                    '$SUserID',
                                    CURDATE()
                             )";
                        //echo $MasVoucherEntryQuery."<br>";

        $resultMasVoucher=mysql_query($MasVoucherEntryQuery) or die(mysql_error());

       //---------------update mas_latestjournalnumber table----------
       /*$updateLatestJournalNo="update mas_latestjournalnumber set
                                        CR='".$journalno."'
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
        }*/
       // echo  $TotalIndex;
        $deletrow="delete from trn_journal where journalid='$txtjurnalid'";
        mysql_query($deletrow) or die(mysql_error());
        for($i=0;$i<$TotalIndex;$i++)
        {
                  $ChartOfAccuntTemp=explode("-",$txtChartofAccount[$i]);
                  $ChartOfAccunt=$ChartOfAccuntTemp[sizeof($ChartOfAccuntTemp)-1];

                  $TrnQuery="replace into trn_journal
                             (
                                    journalid,
                                    slno,
                                    glcode,
                                    subglcode,
                                    cost_code,
                                    amount,
                                    remarks,
                                    ttype
                             )
                             values
                             (
                                    '$txtjurnalid',
                                    '$i',
                                    '$txtglcode[$i]',
                                    'rests',
                                    '".$cmbCostCenter1[$i]."',
                                    '".$txtDebitAmount[$i]."',
                                    '".$txtRemarks[$i]."',
                                    'Dr'
                             )";
                      //echo  $TrnQuery."<br>";

                  $resultTrnQuery=mysql_query($TrnQuery) or die(mysql_error());
        }

        if($rdopayto=="C")
                $GLCode="10201";
        else
                $GLCode="10202";

        $TrnQueryCR="replace into trn_journal
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
                        '$txtjurnalid',
                        '$i',
                        '$GLCode',
                        'rests',

                        '$TotalDabit',
                        '',
                        'Cr'
                  )
                ";
            //echo $TrnQueryCR."<br>";
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
