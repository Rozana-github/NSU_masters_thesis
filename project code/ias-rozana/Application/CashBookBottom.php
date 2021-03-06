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



                  $query="select
                              mas_journal.journalno,
                              mas_journal.journaltype,
                              date_format(mas_journal.journaldate,'%d-%m-%Y')as journaldate,
                              trn_journal.remarks,
                              IF(trn_journal.ttype='Dr',trn_journal.amount,0) AS DrAmount,
                              IF(trn_journal.ttype='Cr',trn_journal.amount,0) AS CrAmount,
                              trn_journal.ttype,
                              trn_journal.amount,
                              trn_journal.remarks,
                              mas_gl.description,
                              mas_gl.gl_code
                          from
                              mas_journal
                              inner join trn_journal on mas_journal.journalid=trn_journal.journalid
                              left join mas_cost_center on trn_journal.cost_code=mas_cost_center.cost_code
                              left join mas_gl on mas_gl.gl_code=trn_journal.glcode
                          where
                              mas_journal.journaldate between STR_TO_DATE('$cboFDay-$cboFMonth-$cboFYear','%e-%c-%Y') AND STR_TO_DATE('$cboTDay-$cboTMonth-$cboTYear','%e-%c-%Y')
                              and trn_journal.glcode in ('10201','10202')

                         ";



                  $rs=mysql_query($query) or die("Error: ".mysql_error());

                  if(mysql_num_rows($rs)>0)
                  {

                                drawCompanyInformation("Cash Book","From  $cboFDay-$cboFMonth-$cboFYear To $cboTDay-$cboTMonth-$cboTYear");

                        echo "<table width='100%' id='table1' cellspacing='0' cellpadding='0' align='center'>
                                    <tr>
                                          <td class='title_cell_e_l' rowspan='2'>Date</td>
                                          <td class='title_cell_e' rowspan='2'>Vr No.</td>
                                          <td class='title_cell_e' rowspan='2'>Particulars</td>
                                          <td class='title_cell_e' rowspan='2'>Cost Center/Department</td>
                                          <td class='title_cell_e' rowspan='2'>Type</td>
                                          <td class='title_cell_e' colspan='2'>Debit</td>
                                          <td class='title_cell_e' colspan='2'>Credit</td>
                                          <td class='title_cell_e' colspan='2'>Balance</td>
                                    </tr>
                                    <tr>
                                          <td class='sub_title_cell_e'>Cash</td>
                                          <td class='sub_title_cell_e'>Bank</td>
                                          <td class='sub_title_cell_e'>Cash</td>
                                          <td class='sub_title_cell_e'>Bank</td>
                                          <td class='sub_title_cell_e'>Cash</td>
                                          <td class='sub_title_cell_e'>Bank</td>
                                    </tr>
                                    ";
                        $i=0;




                              $opencashdr=0;
                              $opencashcr=0;
                              $openbankdr=0;
                              $openbankcr=0;


                              getPreviousClosing(&$DrAmount,&$CrAmount,"10201",$cboFMonth,$cboFYear);
                              
                              $opencashdr=$DrAmount;
                              $opencashcr=$CrAmount;
                              
                              $queryopencash="select
                                                IF(trn_journal.ttype='Dr',trn_journal.amount,0) AS DrCashAmount,
                                                IF(trn_journal.ttype='Cr',trn_journal.amount,0) AS CrCashAmount,
                                                trn_journal.ttype as trtype,
                                                mas_gl.gl_code as opengl
                                          from
                                                mas_journal
                                                inner join trn_journal on mas_journal.journalid=trn_journal.journalid
                                                left join mas_cost_center on trn_journal.cost_code=mas_cost_center.cost_code
                                                left join mas_gl on mas_gl.gl_code=trn_journal.glcode
                                          where
                                                mas_journal.journaldate < STR_TO_DATE('$cboFDay-$cboFMonth-$cboFYear','%e-%c-%Y')
                                                and trn_journal.glcode ='10201'
                                     ";
                                $rsopencash=mysql_query($queryopencash) or die("Error: ".mysql_error());
                                while($rowopencash=mysql_fetch_array($rsopencash))
                                {
                                    extract($rowopencash);
                                    $opencashdr=$opencashdr+$DrCashAmount;
                                    $opencashcr=$opencashcr+$CrCashAmount;
                                }


                  //echo $query;


                              
                              getPreviousClosing(&$DrAmount,&$CrAmount,"10202",$cboFMonth,$cboFYear);

                              $openbankdr=$DrAmount;
                              $openbankcr=$CrAmount;
                              
                               $queryopenbank="select
                                                IF(trn_journal.ttype='Dr',trn_journal.amount,0) AS DrBankAmount,
                                                IF(trn_journal.ttype='Cr',trn_journal.amount,0) AS CrBankAmount,
                                                trn_journal.ttype as trtype,
                                                mas_gl.gl_code as opengl
                                          from
                                                mas_journal
                                                inner join trn_journal on mas_journal.journalid=trn_journal.journalid
                                                left join mas_cost_center on trn_journal.cost_code=mas_cost_center.cost_code
                                                left join mas_gl on mas_gl.gl_code=trn_journal.glcode
                                          where
                                                mas_journal.journaldate < STR_TO_DATE('$cboFDay-$cboFMonth-$cboFYear','%e-%c-%Y')
                                                and trn_journal.glcode ='10202'
                                     ";
                                $rsopenbank=mysql_query($queryopenbank) or die("Error: ".mysql_error());
                                while($rowopenbank=mysql_fetch_array($rsopenbank))
                                {
                                    extract($rowopenbank);
                                    $openbankdr=$openbankdr+$DrBankAmount;
                                    $openbankcr=$openbankcr+$CrBankAmount;
                                }
                              

                        $opencdr=0;
                        $openccr=0;
                        $openbdr=0;
                        $openbcr=0;
                        $openbalancecash=0;
                        $openbalancebank=0;

                        if(($opencashdr-$opencashcr)>0)
                        {
                              $opencdr=$opencashdr-$opencashcr;

                        }
                        else
                              $openccr=abs($opencashdr-$opencashcr);
                        if(($openbankdr-$openbankcr)>0)
                        {
                              $openbdr=$openbankdr-$openbankcr;

                        }
                        else
                              $openbcr=abs($openbankdr-$openbankcr);


                        $openbalancecash=$opencdr-$openccr;
                        $openbalancebank=$openbdr-$openbcr;
                              echo "<tr>
                                          <td class='even_left_td_e'  >$cboFDay-$cboFMonth-$cboFYear</td>
                                          <td class='even_td_e' align='center' colspan='4'>Opening Balance</td>
                                          <td class='even_td_e' align='right'>".number_format($opencdr,2,'.',',')."</td>
                                          <td class='even_td_e' align='right'>".number_format($openbdr,2,'.',',')."</td>
                                          <td class='even_td_e' align='right'>".number_format($openccr,2,'.',',')."</td>
                                          <td class='even_td_e' align='right'>".number_format($openbcr,2,'.',',')."</td>
                                          <td class='even_td_e' align='right'>".number_format($openbalancecash,2,'.',',')."</td>
                                          <td class='even_td_e' align='right'>".number_format($openbalancebank,2,'.',',')."</td>
                                    </tr>";

                              $i++;
                              $totalopencashdr=$opencdr;
                              $totalopencashcr=$openccr;
                              $totalopenbankdr=$openbdr;
                              $totalopenbankcr=$openbcr;
                              $totalcashbalance=$openbalancecash;
                              $totalbankbalance=$openbalancebank;
                        
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




                              $drcash=0.0;
                              $drbank=0.0;
                              $crcash=0.0;
                              $crbank=0.0;
                              $cashbalance=0.0;
                              $bankbalance=0.0;
                              //////////////////////////////////////////
                              if($gl_code=='10201'& $ttype=='Dr')
                              {
                                 $drcash=$DrAmount;
                              }
                              else if($gl_code=='10201'& $ttype=='Cr')
                              {
                                   $crcash=$CrAmount;
                              }
                              else if($gl_code=='10202'& $ttype=='Dr')
                              {
                                 $drbank=$DrAmount;
                              }
                              else if($gl_code=='10202'& $ttype=='Cr')
                              {
                                   $crbank=$CrAmount;
                              }
                              $totalopencashdr=$totalopencashdr+$drcash;
                              $totalopencashcr=$totalopencashcr+$crcash;
                              $totalopenbankdr=$totalopenbankdr+$drbank;
                              $totalopenbankcr=$totalopenbankcr+$crbank;
                              $cashbalance=$drcash-$crcash;
                              $bankbalance=$drbank-$crbank;
                              $totalcashbalance=$totalcashbalance+$cashbalance;
                              $totalbankbalance=$totalbankbalance+$bankbalance;

                              
                              echo "<tr>
                                          <td class='$lclass'>$journaldate</td>
                                          <td class='$class' align='center'>$journalno</td>
                                          <td class='$class'>$remarks&nbsp;</td>
                                          <td class='$class'> &nbsp;</td>
                                          <td class='$class'>$journaltype</td>


                                          <td class='$class' align='right'>".number_format($drcash,2,'.',',')."</td>
                                          <td class='$class' align='right'>".number_format($drbank,2,'.',',')."</td>
                                          <td class='$class' align='right'>".number_format($crcash,2,'.',',')."</td>
                                          <td class='$class' align='right'>".number_format($crbank,2,'.',',')."</td>
                                          <td class='$class' align='right'>".number_format($totalcashbalance,2,'.',',')."</td>
                                          <td class='$class' align='right'>".number_format($totalbankbalance,2,'.',',')."</td>
                                    </tr>";
                              
                              $i++;
                        }
                        echo "<tr>
                                    <td class='td_e_b_l' colspan='5' align='right'><b>Total</b></td>
                                    <td class='td_e_b' align='right'>".number_format($totalopencashdr,2,'.',',')."</td>
                                    <td class='td_e_b' align='right'>".number_format($totalopenbankdr,2,'.',',')."</td>
                                    <td class='td_e_b' align='right'>".number_format($totalopencashcr,2,'.',',')."</td>
                                    <td class='td_e_b' align='right'>".number_format($totalopenbankcr,2,'.',',')."</td>
                                    <td class='td_e_b' align='right'>".number_format($totalcashbalance,2,'.',',')."</td>
                                    <td class='td_e_b' align='right'>".number_format($totalbankbalance,2,'.',',')."</td>

                              </tr>";
                        echo "</table>";
                  }
                  else
                  {
                        drawNormalMassage("Data Not Found.");
                  }
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
                        mas_ytd_fin
                    where
                        glcode in ($glcode) AND
                        STR_TO_DATE(CONCAT('1','-',proc_month,'-',proc_year),'%e-%c-%Y')=DATE_SUB(STR_TO_DATE('1-$ClosingMonth-$ClosingYear','%e-%c-%Y'), INTERVAL 1 MONTH)
                    ";

            //echo $query;
            $rs=mysql_query($query) or die("Error: ".mysql_error());

            if(mysql_num_rows($rs)>0)
            {
                  $totaldr=0;
                  $totalcr=0;
                  while($row=mysql_fetch_array($rs))
                  {
                        extract($row);
                        $totaldr=$totaldr+$closing_dr;
                        $totalcr=$totalcr+$closing_cr;
                  }
                  $YearDr=$totaldr;
                  $YearCr=$totalcr;
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
