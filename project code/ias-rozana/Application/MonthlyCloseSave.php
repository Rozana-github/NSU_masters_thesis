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
            <link href='Style/generic_form.css' type='text/css' rel='stylesheet' />
            <link href='Style/eng_form.css' type='text/css' rel='stylesheet' />
      </head>
      <body class='body_e'>
            <?PHP
                  if($NewEntryFlag==1)
                  {
                        if(strcmp($chkTrialBalance,"ON")==0)
                        {
                              $query="update mas_monthly_process set trial_balance='1', update_by='$SUserID', update_date=DATE(NOW())";
                              mysql_query($query) or die("Error: ".mysql_error());
                        }
                        if(strcmp($chkDebtorLedger,"ON")==0)
                        {
                              $query="update mas_monthly_process set debtor='1', update_by='$SUserID', update_date=DATE(NOW())";
                              mysql_query($query) or die("Error: ".mysql_error());
                        }
                        if(strcmp($chkCreditorLedger,"ON")==0)
                        {
                              $query="update mas_monthly_process set creditor='1', update_by='$SUserID', update_date=DATE(NOW())";
                              mysql_query($query) or die("Error: ".mysql_error());
                        }
                  }
                  else
                  {
                        if(strcmp($chkTrialBalance,"ON")==0)
                              $TrialBalance=1;
                        else
                              $TrialBalance=0;
                        if(strcmp($chkDebtorLedger,"ON")==0)
                              $DebtorLedger=1;
                        else
                              $DebtorLedger=0;
                        if(strcmp($chkCreditorLedger,"ON")==0)
                              $CreditorLedger=1;
                        else
                              $CreditorLedger=0;

                        $query="INSERT INTO mas_monthly_process
                                (
                                    proc_year,
                                    proc_month,
                                    trial_balance,
                                    debtor,
                                    creditor,
                                    entry_by,
                                    entry_date
                                )
                                VALUES
                                (
                                    '$ClosingYear',
                                    '$ClosingMonth',
                                    '$TrialBalance',
                                    '$DebtorLedger',
                                    '$CreditorLedger',
                                    '$SUserID',
                                    DATE(NOW())
                                )";

                        mysql_query($query) or die("Error: ".mysql_error());

                  }
                  if(strcmp($chkTrialBalance,"ON")==0)
                  {
                  ///////Start Trial balance process for ASSET, EQUITES, REVENUE //////////////
                        $query="select
                                    trn_journal.glcode,

                                    SUM(IF(trn_journal.ttype='Dr',amount,0)) AS DrAmount,
                                    SUM(IF(trn_journal.ttype='Cr',amount,0)) AS CrAmount
                                from
                                    trn_journal
                                where
                                    trn_journal.journalid in
                                    (
                                          select
                                                mas_journal.journalid
                                          from
                                                mas_journal
                                          where
                                                mas_journal.journaldate between STR_TO_DATE('1-$ClosingMonth-$ClosingYear','%e-%c-%Y') AND LAST_DAY(STR_TO_DATE('1-$ClosingMonth-$ClosingYear','%e-%c-%Y'))
                                    )
                                    AND (LEFT(glcode,1)='1' OR LEFT(glcode,1)='2' OR LEFT(glcode,1)='3' )
                                group by
                                    trn_journal.glcode

                                    ";
                        //echo $query;
                  
                        $rs=mysql_query($query) or die("Error: ".mysql_error());
                        
                        $StrGLList="";
                        
                        if(mysql_num_rows($rs)>0)
                        {
                              while($row=mysql_fetch_array($rs))
                              {
                                    extract($row);

                                    $StrGLList=$StrGLList."'".$glcode."',";
                                    
                                    $YearDr=0;
                                    $YearCr=0;

                                    getPreviousClosing($YearDr,$YearCr,$glcode,$ClosingMonth,$ClosingYear);
                                    
                                    //echo $YearDr."**";
                                    //echo $YearCr."<br>";
                                    $query="REPLACE INTO mas_ytd_fin
                                            (
                                                proc_year,
                                                proc_month,
                                                glcode,

                                                companyid,
                                                year_dr,
                                                year_cr,
                                                month_dr,
                                                month_cr,
                                                closing_dr,
                                                closing_cr,
                                                entry_by,
                                                entry_date
                                            )
                                            VALUES
                                            (
                                                '$ClosingYear',
                                                '$ClosingMonth',
                                                '$glcode',

                                                '0',
                                                '$YearDr',
                                                '$YearCr',
                                                '$DrAmount',
                                                '$CrAmount',
                                                '".($YearDr+$DrAmount)."',
                                                '".($YearCr+$CrAmount)."',
                                                '$SUserID',
                                                DATE(NOW())
                                            )";

                                    mysql_query($query) or die("Error: ".mysql_error());
                              }
                        }
                  ///////End Trial balance process for ASSET, EQUITES, REVENUE //////////////
                  ///////Start Trial balance process for EXIPENDITURE //////////////
                        $query="select
                                    trn_journal.glcode,
                                    trn_journal.cost_code,
                                    SUM(IF(trn_journal.ttype='Dr',amount,0)) AS DrAmount,
                                    SUM(IF(trn_journal.ttype='Cr',amount,0)) AS CrAmount
                                from
                                    trn_journal
                                where
                                    trn_journal.journalid in
                                    (
                                          select
                                                mas_journal.journalid
                                          from
                                                mas_journal
                                          where
                                                mas_journal.journaldate between STR_TO_DATE('1-$ClosingMonth-$ClosingYear','%e-%c-%Y') AND LAST_DAY(STR_TO_DATE('1-$ClosingMonth-$ClosingYear','%e-%c-%Y'))
                                    )
                                    AND (LEFT(glcode,1)='4')
                                group by
                                    trn_journal.glcode,trn_journal.cost_code
                                    ";
                        //echo $query;

                        $rs=mysql_query($query) or die("Error: ".mysql_error());



                        if(mysql_num_rows($rs)>0)
                        {
                             $i=0;
                              while($row=mysql_fetch_array($rs))
                              {
                                    extract($row);

                                    $StrGLList=$StrGLList."'".$glcode."',";

                                    $YearDr=0;
                                    $YearCr=0;
                                    //echo $glcode ."  ";
                                    $i++;

                                    getPreviousClosingExpenses($YearDr,$YearCr,$glcode,$ClosingMonth,$ClosingYear,$cost_code);

                                    //echo $YearDr."**";
                                    //echo $YearCr."<br>";
                                    $query="REPLACE INTO mas_ytd_fin
                                            (
                                                proc_year,
                                                proc_month,
                                                glcode,
                                                cost_code,
                                                companyid,
                                                year_dr,
                                                year_cr,
                                                month_dr,
                                                month_cr,
                                                closing_dr,
                                                closing_cr,
                                                entry_by,
                                                entry_date
                                            )
                                            VALUES
                                            (
                                                '$ClosingYear',
                                                '$ClosingMonth',
                                                '$glcode',
                                                '$cost_code',
                                                '0',
                                                '$YearDr',
                                                '$YearCr',
                                                '$DrAmount',
                                                '$CrAmount',
                                                '".($YearDr+$DrAmount)."',
                                                '".($YearCr+$CrAmount)."',
                                                '$SUserID',
                                                DATE(NOW())
                                            )";
                                        // $query."<br>";

                                    mysql_query($query) or die("Error: ".mysql_error());
                              }
                             // echo $i;

                  ///////End Trial balance process for EXPENDITURE //////////////

                              drawNormalMassage("Trial Balance From Journal Processed Successfully.");
                        }
                        /*else
                        {
                              drawNormalMassage("No Data Found To Be Processed For Trial Balance.");
                        } */
                        if($StrGLList=="")
                        {
                              $StrCondition="";
                        }
                        else
                        {
                              $StrCondition=" AND gl_code not in(".rtrim($StrGLList,",").") ";
                        }
                        $query="select
                                    gl_code
                                from
                                    mas_gl
                                where
                                    (LEFT(gl_code,1)='1' OR LEFT(gl_code,1)='2' OR LEFT(gl_code,1)='3' ) AND
                                    id not in (select distinct pid from mas_gl)
                                    $StrCondition";
                        //echo $query;
                        $rs=mysql_query($query) or die("Error: ".mysql_error());
                        if(mysql_num_rows($rs)>0)
                        {
                              while($row=mysql_fetch_array($rs))
                              {
                                    extract($row);
                                    
                                    $YearDr=0;
                                    $YearCr=0;
                                    $glcode=$gl_code;
                                    getPreviousClosing($YearDr,$YearCr,$glcode,$ClosingMonth,$ClosingYear);

                                    //echo $glcode.$YearDr."**";
                                   // echo $YearCr."<br>";
                                    $query="REPLACE INTO mas_ytd_fin
                                            (
                                                proc_year,
                                                proc_month,
                                                glcode,
                                                companyid,
                                                year_dr,
                                                year_cr,
                                                month_dr,
                                                month_cr,
                                                closing_dr,
                                                closing_cr,
                                                entry_by,
                                                entry_date
                                            )
                                            VALUES
                                            (
                                                '$ClosingYear',
                                                '$ClosingMonth',
                                                '$gl_code',

                                                '0',
                                                '$YearDr',
                                                '$YearCr',
                                                '0',
                                                '0',
                                                '".($YearDr+0)."',
                                                '".($YearCr+0)."',
                                                '$SUserID',
                                                DATE(NOW())
                                            )";

                                    //echo $query."<br>";
                                    mysql_query($query) or die("Error: ".mysql_error());
                              }

                              drawNormalMassage("Trial Balance For Extra GL Processed Successfully.");
                        }
                        else
                        {
                              drawNormalMassage("No GL Left To Be Processed For Trial Balance.");
                        }
                  }

                  else
                  {
                        echo "Trial Balance Not Selected.";
                  }
                  
                  /*************************************** Starting of Debtor ledger ************************/

                  if(strcmp($chkDebtorLedger,"ON")==0)
                  {
                        /*$bebtorquery="SELECT
                                          mas_customer.customerobject_id,
                                          mas_customer.customer_id,
                                          mas_customer.Company_Name,
                                          sum(if( trn_journal.ttype = 'Dr', amount, 0 )) AS dramount,
                                          sum(if( trn_journal.ttype = 'Cr', amount, 0 )) AS cramount
                                    FROM
                                        mas_customer
                                        inner join mas_journal on mas_journal.partyid=mas_customer.customer_id
                                        inner join trn_journal on trn_journal.journalid=mas_journal.journalid
                                    where
                                        trn_journal.glcode in ('10501','20503')
                                    and
                                         mas_journal.journaldate between STR_TO_DATE('1-$ClosingMonth-$ClosingYear','%e-%c-%Y') AND LAST_DAY(STR_TO_DATE('1-$ClosingMonth-$ClosingYear','%e-%c-%Y'))
                                    group by
                                               mas_customer.customer_id
                                    ";
                        $rsdebtor=mysql_query($bebtorquery)or die(mysql_error());
                        
                        if(mysql_num_rows($rsdebtor)>0)
                        {
                              while($rowdebtor=mysql_fetch_array($rsdebtor))
                              {
                                    extract($rowdebtor);
                                    $yeardr=0;
                                    $yearcr=0;
                                    getDebtorsPreviousClosing($yeardr,$yearcr,$customerobject_id,$ClosingMonth,$ClosingYear);
                                    $insertmas_customer_balance="replace into mas_customer_balance
                                                                              (
                                                                                    customerobject_id,
                                                                                    proc_year,
                                                                                    proc_month,
                                                                                    year_dr,
                                                                                    year_cr,
                                                                                    month_dr,
                                                                                    month_cr,
                                                                                    closing_dr,
                                                                                    closing_cr,
                                                                                    entry_by,
                                                                                    entry_date
                                                                              )
                                                                              values
                                                                              (
                                                                                    '$customerobject_id',
                                                                                    '$ClosingYear',
                                                                                    '$ClosingMonth',
                                                                                    '$yeardr',
                                                                                    '$yearcr',
                                                                                    '$dramount',
                                                                                    '$cramount',
                                                                                    '".($yeardr+$dramount)."',
                                                                                    '".($yearcr+$cramount)."',
                                                                                    '$SUserID',
                                                                                    DATE(NOW())
                                                                                    
                                                                              )";
                                    mysql_query($insertmas_customer_balance) or die("Error: ".mysql_error());
                              }
                              drawNormalMassage("Debtor Ledger Processed Successfully.");
                              
                        }
                        else
                        {
                              drawNormalMassage("No Customer Left To Be Processed For Debtor Ledger.");
                        } */
                        $bebtorquery="  select
                                                a.customer_id,
                                                a.invoiceamount,
                                                (ifnull(b.collection,0)+ifnull(b.ait,0)+ifnull(b.sales_return,0)) as totalcollection
                                        from
                                        (
                                                SELECT
                                                        mas_invoice.customer_id,
                                                        sum(mas_invoice.net_bill) as invoiceamount
                                                FROM
                                                        mas_invoice
                                                WHERE
                                                        mas_invoice.invoice_date between STR_TO_DATE('1-$ClosingMonth-$ClosingYear','%e-%c-%Y') AND LAST_DAY(STR_TO_DATE('1-$ClosingMonth-$ClosingYear','%e-%c-%Y'))
                                                group by
                                                        mas_invoice.customer_id
                                        ) as a
                                        left join
                                        (
                                                SELECT
                                                        mas_invoice_collection.customer_id,
                                                        sum(mas_invoice_collection.collection_amount) as collection,
                                                        sum(mas_invoice_collection.ait_amount) as ait,
                                                        sum(mas_invoice_collection.sales_return_amount) as sales_return
                                                FROM
                                                        mas_invoice_collection
                                                WHERE
                                                        mas_invoice_collection.collection_date between STR_TO_DATE('1-$ClosingMonth-$ClosingYear','%e-%c-%Y') AND LAST_DAY(STR_TO_DATE('1-$ClosingMonth-$ClosingYear','%e-%c-%Y'))
                                                group by
                                                        mas_invoice_collection.customer_id
                                        ) as b on a.customer_id=b.customer_id
                                ";
                         $rsdebtor=mysql_query($bebtorquery)or die(mysql_error());

                        if(mysql_num_rows($rsdebtor)>0)
                        {
                              while($rowdebtor=mysql_fetch_array($rsdebtor))
                              {
                                    extract($rowdebtor);
                                    $yeardr=0;
                                    $yearcr=0;
                                    getDebtorsPreviousClosing($yeardr,$yearcr,$customer_id,$ClosingMonth,$ClosingYear);
                                    $insertmas_customer_balance="replace into mas_customer_balance
                                                                              (
                                                                                    customerobject_id,
                                                                                    proc_year,
                                                                                    proc_month,
                                                                                    year_dr,
                                                                                    year_cr,
                                                                                    month_dr,
                                                                                    month_cr,
                                                                                    closing_dr,
                                                                                    closing_cr,
                                                                                    entry_by,
                                                                                    entry_date
                                                                              )
                                                                              values
                                                                              (
                                                                                    '$customer_id',
                                                                                    '$ClosingYear',
                                                                                    '$ClosingMonth',
                                                                                    '$yeardr',
                                                                                    '$yearcr',
                                                                                    '$invoiceamount',
                                                                                    '$totalcollection',
                                                                                    '".($yeardr+$invoiceamount)."',
                                                                                    '".($yearcr+$totalcollection)."',
                                                                                    '$SUserID',
                                                                                    DATE(NOW())

                                                                              )";
                                    mysql_query($insertmas_customer_balance) or die("Error: ".mysql_error());
                              }
                              drawNormalMassage("Debtor Ledger Processed Successfully.");
                              
                              /******************* Start of Bank Transection Process ***************/
                              $querybank=" select
                                                mas_journal.accountno,
                                                sum(IF(trn_journal.ttype='Dr',trn_journal.amount,0)) AS DrAmount,
                                                sum(IF(trn_journal.ttype='Cr',trn_journal.amount,0)) AS CrAmount

                                        from
                                                mas_journal inner join trn_journal on mas_journal.journalid=trn_journal.journalid
                                                left join mas_cost_center on trn_journal.cost_code=mas_cost_center.cost_code

                                        where
                                                mas_journal.journaldate between STR_TO_DATE('1-$ClosingMonth-$ClosingYear','%e-%c-%Y') AND LAST_DAY(STR_TO_DATE('1-$ClosingMonth-$ClosingYear','%e-%c-%Y')) and
                                                trn_journal.glcode='10202' and
                                                mas_journal.accountno not in ('-1','0')
                                        group by
                                                mas_journal.accountno
                                        ";

                                $rsbank=mysql_query($querybank)or die(mysql_error());
                                if(mysql_num_rows($rsbank)>0)
                                {
                                        while($rowbank=mysql_fetch_array($rsbank))
                                        {
                                                extract($rowbank);
                                                $bankyeardr=0;
                                                $bankyearcr=0;
                                                getPreviousClosingbank($bankyeardr,$bankyearcr,$accountno,$ClosingMonth,$ClosingYear);
                                                
                                                $insertmas_ytd_bank="replace into
                                                                                mas_ytd_bank
                                                                                (
                                                                                        proc_year,
                                                                                        proc_month,
                                                                                        account_object_id,
                                                                                        year_dr,
                                                                                        year_cr,
                                                                                        month_dr,
                                                                                        month_cr,
                                                                                        closing_dr,
                                                                                        closing_cr,
                                                                                        entry_by,
                                                                                        entry_date
                                                                                )
                                                                                values
                                                                                (
                                                                                        '$ClosingYear',
                                                                                        '$ClosingMonth',
                                                                                        '$accountno',
                                                                                        '$bankyeardr',
                                                                                        '$bankyearcr',
                                                                                        '$DrAmount',
                                                                                        '$CrAmount',
                                                                                        '".($bankyeardr+$DrAmount)."',
                                                                                        '".($bankyearcr+$CrAmount)."',
                                                                                        '$SUserID',
                                                                                        DATE(NOW())
                                                                                )
                                                                        ";
                                                //echo $insertmas_ytd_bank."<br>";
                                                mysql_query($insertmas_ytd_bank) or die("Error: ".mysql_error());
                                        }
                                        
                                }
                               
                               /******************** end Of Bank Transection Process ***************/

                        }
                  }
                  else
                  {
                        echo "Debtor Ledger Not Selected.";
                  }

                  /*************************************** End of Debtor ledger *****************************/
            ?>
            <?PHP

                function getPreviousClosingbank(&$YearDr,&$YearCr,$accountno,$ClosingMonth,$ClosingYear)
                {
                        $query="select
                                proc_month,
                                proc_year,
                                closing_dr,
                                closing_cr
                            from
                                mas_ytd_bank
                            where
                                account_object_id='$accountno' AND
                                STR_TO_DATE(CONCAT('1','-',proc_month,'-',proc_year),'%e-%c-%Y')=DATE_SUB(STR_TO_DATE('1-$ClosingMonth-$ClosingYear','%e-%c-%Y'), INTERVAL 1 MONTH)
                            ";

            //echo $query;
                    $rs=mysql_query($query) or die("Error: ".mysql_error());

                    if(mysql_num_rows($rs)>0)
                    {
                        while($row=mysql_fetch_array($rs))
                        {
                                extract($row);
                                $YearDr=$closing_dr;
                                $YearCr=$closing_cr;
                        }
                    }
                    else
                    {
                        $YearDr=0;
                        $YearCr=0;
                    }
                }

                  function getPreviousClosing(&$YearDr,&$YearCr,$glcode,$ClosingMonth,$ClosingYear)
                  {
                        $query="select
                                    proc_month,
                                    proc_year,
                                    closing_dr,
                                    closing_cr
                                from
                                    mas_ytd_fin
                                where
                                    glcode='$glcode' AND
                                    STR_TO_DATE(CONCAT('1','-',proc_month,'-',proc_year),'%e-%c-%Y')=DATE_SUB(STR_TO_DATE('1-$ClosingMonth-$ClosingYear','%e-%c-%Y'), INTERVAL 1 MONTH)
                         ";

                        //echo $query;
                        $rs=mysql_query($query) or die("Error: ".mysql_error());
                        if(mysql_num_rows($rs)>0)
                        {
                              while($row=mysql_fetch_array($rs))
                              {
                                    extract($row);
                                    $YearDr=$closing_dr;
                                    $YearCr=$closing_cr;
                              }
                        }
                        else
                        {
                              $YearDr=0;
                              $YearCr=0;
                        }
                  }
                  
                  function getPreviousClosingExpenses(&$YearDr,&$YearCr,$glcode,$ClosingMonth,$ClosingYear,$Cost_code)
                  {
                        $query="select
                                    proc_month,
                                    proc_year,
                                    closing_dr,
                                    closing_cr
                                from
                                    mas_ytd_fin
                                where
                                    glcode='$glcode' AND
                                    STR_TO_DATE(CONCAT('1','-',proc_month,'-',proc_year),'%e-%c-%Y')=DATE_SUB(STR_TO_DATE('1-$ClosingMonth-$ClosingYear','%e-%c-%Y'), INTERVAL 1 MONTH) AND
                                    cost_code=$Cost_code
                               ";

                        //echo $query;
                        $rs=mysql_query($query) or die("Error: ".mysql_error());
                        if(mysql_num_rows($rs)>0)
                        {
                              while($row=mysql_fetch_array($rs))
                              {
                                    extract($row);
                                    $YearDr=$closing_dr;
                                    $YearCr=$closing_cr;
                              }
                        }
                        else
                        {
                              $YearDr=0;
                              $YearCr=0;
                        }
                  }

                  function getDebtorsPreviousClosing(&$yeardr,&$yearcr,$customerobject_id,$ClosingMonth,$ClosingYear)
                  {
                        $query="select
                                    proc_year,
                                    proc_month,
                                    closing_dr,
                                    closing_cr
                              from
                                    mas_customer_balance
                              where
                                    customerobject_id='$customerobject_id'
                                    and STR_TO_DATE(CONCAT('1','-',proc_month,'-',proc_year),'%e-%c-%Y')=DATE_SUB(STR_TO_DATE('1-$ClosingMonth-$ClosingYear','%e-%c-%Y'), INTERVAL 1 MONTH)
                              ";

                        $rs=mysql_query($query) or die("Error: ".mysql_error());
                        if(mysql_num_rows($rs)>0)
                        {
                              while($row=mysql_fetch_array($rs))
                              {
                                    extract($row);
                                    $yeardr=$closing_dr;
                                    $yearcr=$closing_cr;
                              }
                        }
                        else
                        {
                              $yeardr=0;
                              $yearcr=0;
                        }
                  }
            ?>
      </body>
</html>
<?PHP
      mysql_query("COMMIT") or die("Commit Error.");
      mysql_close();
?>
