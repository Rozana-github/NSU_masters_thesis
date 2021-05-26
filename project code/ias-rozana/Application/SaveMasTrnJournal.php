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
$MasVoucherEntryQuery="insert into mas_journal
                                (
                                journalno,
                                journaldate,
                                journaltype,
                                partyid,
                                supplierid,
                                remarks,
                                journal_status,
                                entry_by,
                                entry_date
                                )
                                values
                                (
                                '$journalno',
                                '$VoucherDate',
                                '$vtype',
                                '$cmbCustomer',
                                '$cmbSupplier',
                                '$mremarks',
                                 '0',
                                '$SUserID',
                                CURDATE()
                                )";

$resultVoucherEntry=mysql_query($MasVoucherEntryQuery) or die(mysql_error());

       //---------------update mas_latestjournalnumber table----------
       $updateLatestJournalNo="update mas_latestjournalnumber set
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

        for($i=1;$i<$TotalIndex;$i++)
        {
               // $ChartOfAccuntTemp=explode("-",$txtChartofAccount[$i]);
                //$ChartOfAccunt=$ChartOfAccuntTemp[sizeof($ChartOfAccuntTemp)-1];
                if($txtCreditAmount[$i]!='0')
                {
                $TrnQueryCr="insert into trn_journal
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
                                '$JournalId',
                                '$i',
                                '$txtglcode[$i]',
                                'rests',
                                '".$cmbCostCenter1[$i]."',
                                '$txtCreditAmount[$i]',
                                '$txtRemarks[$i]',
                                'Cr'
                               )
                        ";
                //echo $TrnQueryCr;
                $resultQueryCr=mysql_query($TrnQueryCr) or die(mysql_error());
                }

                //$ChartOfAccuntTemp=explode("-",$txtChartofAccount[$i]);
                //$ChartOfAccunt=$ChartOfAccuntTemp[sizeof($ChartOfAccuntTemp)-1];
                else
                {
                $TrnQueryDr="insert into trn_journal
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
                                '$JournalId',
                               '$i',
                               '$txtglcode[$i]',
                               'rests',
                               '".$cmbCostCenter1[$i]."',
                               '$txtDebitAmount[$i]',
                               '$txtRemarks[$i]',
                               'Dr'
                               )
                        ";
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
