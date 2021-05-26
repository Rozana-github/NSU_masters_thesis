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


               // $ChartOfAccuntTemp=explode("-",$txtChartofAccount[$i]);
                //$ChartOfAccunt=$ChartOfAccuntTemp[sizeof($ChartOfAccuntTemp)-1];

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
                                          '1',
                                          '$txtsalgl',
                                          '$cboDepartment',
                                          '$txtdr',
                                          'Dr'
                                    )
                              ";
                echo $TrnQueryDr."<br>";
                mysql_query($TrnQueryDr) or die(mysql_error());


                //$ChartOfAccuntTemp=explode("-",$txtChartofAccount[$i]);
                //$ChartOfAccunt=$ChartOfAccuntTemp[sizeof($ChartOfAccuntTemp)-1];

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
                                          '2',
                                          '$txtprovgl',
                                          '$cboDepartment',
                                          '$txtcr',
                                          'Cr'
                                    )
                        ";
                       echo $TrnQueryCr."<br>";
             mysql_query($TrnQueryCr) or die(mysql_error());

      
      $insertmas_hr_jv="insert into
                              mas_hr_jv
                              (
                                    hr_jv_month,
                                    hr_jv_year,
                                    department_id,
                                    jv_no,
                                    jv_type
                              )
                              values
                              (
                                    '$cboMonth',
                                    '$cboYear',
                                    '$cboDepartment',
                                    '$journalno',
                                    '$jvtype'
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
