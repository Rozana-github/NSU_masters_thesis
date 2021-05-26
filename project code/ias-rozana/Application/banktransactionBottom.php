<?PHP
      include "Library/dbconnect.php";
      include "Library/Library.php";
      include "Library/SessionValidate.php";
?>

<html>
      <head>
            <meta http-equiv='Content-Type' content='text/html; charset=windows-1252'>
            <title>Invoice Posting</title>
            <LINK href="Style/generic_report.css" type='text/css' rel='stylesheet'>
            <link rel='stylesheet' type='text/css' href='Style/eng_report.css' />
      </head>
      <body class='body_e'>
            <?PHP

                  if($cboMonth=='-1')
                  {
                     $query="select
                              mas_journal.journalno,
                              mas_journal.journaltype,
                              date_format(mas_journal.journaldate,'%d-%m-%Y')as journaldate,
                              ifnull(mas_journal.remarks,trn_journal.remarks) as remarks,
                              mas_cost_center.description,

                              IF(trn_journal.ttype='Dr',trn_journal.amount,0) AS DrAmount,
                              IF(trn_journal.ttype='Cr',trn_journal.amount,0) AS CrAmount,
                              trn_journal.ttype,
                              trn_journal.amount,
                              mas_journal.chequeno
                          from
                              mas_journal inner join trn_journal on mas_journal.journalid=trn_journal.journalid
                              left join mas_cost_center on trn_journal.cost_code=mas_cost_center.cost_code
                          where
                              mas_journal.journaldate between STR_TO_DATE('1-1-$cboYear','%e-%c-%Y') AND LAST_DAY(STR_TO_DATE('1-12-$cboYear','%e-%c-%Y')) AND
                              trn_journal.glcode='10202'
                              and mas_journal.accountno='$cboAccount'
                         ";
                  }
                  else
                  {
                  $query="select
                              mas_journal.journalno,
                              mas_journal.journaltype,
                              date_format(mas_journal.journaldate,'%d-%m-%Y')as journaldate,
                              ifnull(mas_journal.remarks,trn_journal.remarks) as remarks,
                              mas_cost_center.description,
                              
                              IF(trn_journal.ttype='Dr',trn_journal.amount,0) AS DrAmount,
                              IF(trn_journal.ttype='Cr',trn_journal.amount,0) AS CrAmount,
                              trn_journal.ttype,
                              trn_journal.amount,
                              mas_journal.chequeno
                          from
                              mas_journal inner join trn_journal on mas_journal.journalid=trn_journal.journalid
                              left join mas_cost_center on trn_journal.cost_code=mas_cost_center.cost_code

                          where
                              mas_journal.journaldate between STR_TO_DATE('1-$cboMonth-$cboYear','%e-%c-%Y') AND LAST_DAY(STR_TO_DATE('1-$cboMonth-$cboYear','%e-%c-%Y')) AND
                              trn_journal.glcode='10202'
                              and mas_journal.accountno='$cboAccount'
                         ";
                   }

                  //echo $query;
                  $rs=mysql_query($query) or die("Error: ".mysql_error());


                        if($cboMonth=='-1')
                                drawCompanyInformation("Bank Transaction of Account: ".pick("trn_bank","account_no","account_object_id='$cboAccount'"),"For the year of ".date(" Y", mktime(0, 0, 0, 1,1,$cboYear)));
                        else
                                drawCompanyInformation("Bank Transaction of Account: ".pick("trn_bank","account_no","account_object_id='$cboAccount'"),"For the period of ".date("F, Y", mktime(0, 0, 0, $cboMonth,1,$cboYear)));

                        echo "<table width='100%' id='table1' cellspacing='0' cellpadding='0' align='center'>
                                    <tr>
                                          <td class='title_cell_e_l' rowspan='2'>Entry No</td>
                                          <td class='title_cell_e' rowspan='2'>Type</td>
                                          <td class='title_cell_e' rowspan='2'>Date</td>
                                          <td class='title_cell_e' rowspan='2'>Particulars</td>
                                          <td class='title_cell_e' rowspan='2'>Cheque No.</td>
                                          <td class='title_cell_e' colspan='2'>Period Transaction</td>
                                          <td class='title_cell_e' colspan='2'>Balance</td>
                                    </tr>
                                    <tr>
                                          <td class='sub_title_cell_e'>Debit</td>
                                          <td class='sub_title_cell_e'>Credit</td>
                                          <td class='sub_title_cell_e'>Debit</td>
                                          <td class='sub_title_cell_e'>Credit</td>
                                    </tr>
                                    ";
                        $i=0;

                        $Total_dr=0;
                        $Total_cr=0;

                        $BlDrAmount=0;
                        $BlCrAmount=0;
                        
                        $MasterBalance=0;

                        $CheckVal=intval(substr($cboAccountHead,0,1));

                        if($CheckVal==0 || $CheckVal==1)
                        {
                              if($cboMonth=='-1')
                              {
                                getPreviousClosing(&$DrAmount,&$CrAmount,$cboAccount,1,$cboYear);
                              }
                              else
                              {
                                getPreviousClosing(&$DrAmount,&$CrAmount,$cboAccount,$cboMonth,$cboYear);
                              }

                              $BlDrAmount=$DrAmount;
                              $BlCrAmount=$CrAmount;

                              $MasterBalance=$BlDrAmount-$BlCrAmount;

                              if(($BlDrAmount-$BlCrAmount)>0)
                              {
                                    $BlDrAmount=$BlDrAmount-$BlCrAmount;
                                    $BlCrAmount=0;
                              }
                              else if(($BlDrAmount-$BlCrAmount)<0)
                              {
                                    $BlCrAmount=$BlCrAmount-$BlDrAmount;
                                    $BlDrAmount=0;
                              }
                              else
                              {
                                    $BlCrAmount=0;
                                    $BlDrAmount=0;
                              }

                              echo "<tr>
                                          <td class='even_left_td_e' align='center' colspan='7'>Opening Balance</td>

                                          <td class='even_td_e' align='right'>".number_format($BlDrAmount,2,'.',',')."</td>
                                          <td class='even_td_e' align='right'>".number_format($BlCrAmount,2,'.',',')."</td>
                                    </tr>";

                              $i++;
                        }
                        
                        while($row=mysql_fetch_array($rs))
                        {
                              extract($row);

                              if(($i%2)==0)
                              {
                                    $class="even_td_e";
                                    $lclass="even_left_td_e";
                              }
                              else
                              {
                                    $class="odd_td_e";
                                    $lclass="odd_left_td_e";
                              }

                              $Total_dr=$Total_dr+$DrAmount;
                              $Total_cr=$Total_cr+$CrAmount;

                              if(strcmp($ttype,"Dr")==0)
                              {
                                    $MasterBalance=$MasterBalance+$amount;
                              }
                              else
                              {
                                    $MasterBalance=$MasterBalance-$amount;
                              }

                              //////////////////////////////////////////
                              if($MasterBalance>0)
                              {
                                    $BlDrAmount=$MasterBalance;
                                    $BlCrAmount=0;
                              }
                              else if($MasterBalance<0)
                              {
                                    $BlCrAmount=$MasterBalance*-1;
                                    $BlDrAmount=0;
                              }
                              else
                              {
                                    $BlDrAmount=0;
                                    $BlCrAmount=0;
                              }
                              //////////////////////////////////////////
                              
                              echo "<tr>
                                          <td class='$lclass' align='center'>$journalno</td>
                                          <td class='$class'>$journaltype</td>
                                          <td class='$class'>$journaldate</td>
                                          <td class='$class'>$remarks &nbsp;</td>
                                          <td class='$class'>$chequeno &nbsp;</td>
                                          <td class='$class' align='right'>".number_format($DrAmount,2,'.',',')."</td>
                                          <td class='$class' align='right'>".number_format($CrAmount,2,'.',',')."</td>
                                          <td class='$class' align='right'>".number_format($BlDrAmount,2,'.',',')."</td>
                                          <td class='$class' align='right'>".number_format($BlCrAmount,2,'.',',')."</td>
                                    </tr>";
                              
                              $i++;
                        }
                        echo "<tr>
                                    <td class='td_e_b_l' colspan='5' align='right'><b>Total</b></td>
                                    <td class='td_e_b' align='right'>".number_format($Total_dr,2,'.',',')."</td>
                                    <td class='td_e_b' align='right'>".number_format($Total_cr,2,'.',',')."</td>
                                    <td class='td_e_b' align='right' colspan='2'>&nbsp;</td>
                              </tr>";
                        echo "</table>";

            ?>
      </body>
</html>

<?PHP
      function getPreviousClosing(&$YearDr,&$YearCr,$glcode,$ClosingMonth,$ClosingYear)
      {
            $query="select
                        proc_month,
                        proc_year,
                        closing_dr,
                        closing_cr
                    from
                        mas_ytd_bank
                    where
                        account_object_id='$glcode' AND
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
?>

<?PHP
      mysql_close();
?>
