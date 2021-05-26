<?PHP
session_start();
        include_once("Library/dbconnect.php");
        include_once("Library/Library.php");

mysql_query("BEGIN") or die("Operation cant be start");

echo "<link rel='stylesheet' type='text/css' href='css/styles.css'/>";

//$VoucherDateTemp=explode("-",$txtVoucherDate);

$VoucherDate=$txtVoucherYear."-".$txtVoucherMonth."-".$txtVoucherDay;

//$cqdateTemp = explode("-",$txtChequeDate);

//$cqdate=$cqdateTemp[2].'-'.$cqdateTemp[1].'-'.$cqdateTemp[0];


//echo  $MaxMasJournalId;
if($update==1)
{
$MasVoucherEntryQuery="update mas_journal
                              set
                                    journaldate=STR_TO_DATE('$txtChequeDate','%d-%m-%Y'),
                                    remarks='$mremarks',
                                    journal_status='0',
                                    update_by='$SUserID',
                                    update_date= sysdate()
                              where
                                    journalno='$journalno'
                             ";
                     //echo  $MasVoucherEntryQuery."<br>";

        $resultMasVoucher=mysql_query($MasVoucherEntryQuery) or die(mysql_error());


        $deletrow="delete from trn_journal where journalid='$txtjurnalid'";
        mysql_query($deletrow) or die(mysql_error());
}
else
{
$MasVoucherEntryQuery="Insert into
                              mas_journal
                              (
                                    journalno,
                                    journaltype,
                                    journaldate,
                                    supplierid,
                                    remarks,
                                    journal_status,
                                    entry_by,
                                    entry_date
                              )
                              values
                              (
                                    '$journalno',
                                    '$vtype',
                                    '$VoucherDate',
                                    '$cboSupplier',
                                    '$mremarks',
                                    '0',
                                    '$SUserID',
                                    sysdate()
                              )";
                              echo $MasVoucherEntryQuery."<br>";
                  mysql_query($MasVoucherEntryQuery) or die(mysql_error());

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


}         // $ChartOfAccuntTemp=explode("-",$txtChartofAccount[$i]);
                //$ChartOfAccunt=$ChartOfAccuntTemp[sizeof($ChartOfAccuntTemp)-1];

         for($i=0;$i<$TotalIndex;$i++)
         {
                $j=$i+1;
                if($dramount[$i]!='')
                {
                  $TrnQueryDr="insert into
                                    trn_journal
                                    (
                                          journalid,
                                          slno,
                                          glcode,
                                          cost_code,
                                          amount,
                                          ttype
                                    )
                                    values
                                    (
                                          '$JournalId',
                                          '$j',
                                          '".$txtgl[$i]."',
                                          '".$txtcostcenter[$i]."',
                                          '".$dramount[$i]."',
                                          'Dr'
                                    )
                              ";
                  echo $TrnQueryDr."<br>";
                  mysql_query($TrnQueryDr) or die(mysql_error());
               }
               else
               {
                $TrnQueryCr="insert into trn_journal

                                    (
                                          journalid,
                                          slno,
                                          glcode,
                                          cost_code,
                                          amount,
                                          ttype
                                    )
                                    values
                                    (
                                          '$JournalId',
                                          '$j',
                                          '".$txtgl[$i]."',
                                          '".$txtcostcenter[$i]."',
                                          '".$cramount[$i]."',
                                          'Cr'
                                    )
                        ";
                       echo $TrnQueryCr."<br>";
                        mysql_query($TrnQueryCr) or die(mysql_error());
                  }
         }

      
      $insertmas_hr_jv="replace into
                              mas_asset_dep_jv
                              (
                                    proc_month,
                                    proc_year,
                                    jv_no

                              )
                              values
                              (
                                    '$cboMonth',
                                    '$cboYear',
                                    '$journalno'

                              )
                        ";
                        echo $insertmas_hr_jv;
          mysql_query($insertmas_hr_jv)or die(mysql_error());

      
       if(mysql_query("COMMIT"))
        {
                drawMassage("Data Saved Succssfully","");
        }
        else
        {
                drawMassage("Data Saved Error","");

        }


?>
