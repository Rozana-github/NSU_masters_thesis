<?PHP
session_start();
        include_once("Library/dbconnect.php");
        include_once("Library/Library.php");

mysql_query("BEGIN") or die("Operation cant be start");

echo "<link rel='stylesheet' type='text/css' href='css/styles.css'/>";

//$VoucherDateTemp=explode("-",$txtVoucherDate);

$VoucherDate=$txtVoucherYear."-".$txtVoucherMonth."-".$txtVoucherDay;

$cqdateTemp = explode("-",$txtChequeDate);

$cqdate=$cqdateTemp[2].'-'.$cqdateTemp[1].'-'.$cqdateTemp[0];


//echo  $MaxMasJournalId;
$MasVoucherEntryQuery="update
                              mas_journal
                        set
                              journalno='$journalno',
                                journaldate='$VoucherDate',
                                journaltype='$vtype',
                                partyid='$cmbCustomer',
                                supplierid='$cmbSupplier',
                                remarks='$mremarks',
                                journal_status='0',
                                update_by ='$SUserID',
                                update_date=CURDATE()
                        where
                              journalid ='$txtjurnalid'";
//echo $MasVoucherEntryQuery."<br>";
$resultVoucherEntry=mysql_query($MasVoucherEntryQuery) or die(mysql_error());

       //---------------update mas_latestjournalnumber table----------
      /* $updateLatestJournalNo="update mas_latestjournalnumber set
                                        JV='".$journalno."'
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
            */
        $deletrow="delete from trn_journal where journalid='$txtjurnalid'";
        mysql_query($deletrow) or die(mysql_error());
        for($i=0;$i<$TotalIndex;$i++)
        {
               // $ChartOfAccuntTemp=explode("-",$txtChartofAccount[$i]);
                //$ChartOfAccunt=$ChartOfAccuntTemp[sizeof($ChartOfAccuntTemp)-1];
                if($cmbCostCenter1[$i]=='-1')
                  $cmbCostCenter1[$i]='';
                  
                if($txtCreditAmount[$i]!='0')
                {
                $TrnQueryCr="replace into trn_journal
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
                                '$txtCreditAmount[$i]',
                                '$txtRemarks[$i]',
                                'Cr'
                               )
                        ";
                //echo $TrnQueryCr."<br>";
                $resultQueryCr=mysql_query($TrnQueryCr) or die(mysql_error());
                }

                //$ChartOfAccuntTemp=explode("-",$txtChartofAccount[$i]);
                //$ChartOfAccunt=$ChartOfAccuntTemp[sizeof($ChartOfAccuntTemp)-1];
                else
                {
                $TrnQueryDr="replace into trn_journal
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
                               '$txtDebitAmount[$i]',
                               '$txtRemarks[$i]',
                               'Dr'
                               )
                        ";
                        //echo   $TrnQueryDr."<br>";
             $resultQueryDr=mysql_query($TrnQueryDr) or die(mysql_error());
             }
      }
      
       if(mysql_query("COMMIT"))
        {
                drawMassage("Data Saved Succssfully","");
        }
        else
        {
                drawMassage("Data Saved Error","");

        }


?>
