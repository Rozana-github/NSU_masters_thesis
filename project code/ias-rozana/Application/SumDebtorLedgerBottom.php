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
                              mas_customer.Company_Name,
                              mas_customer.customer_id,
                              sum(IF(trn_journal.ttype='Dr',trn_journal.amount,0)) AS DrAmount,
                              sum(IF(trn_journal.ttype='Cr',trn_journal.amount,0)) AS CrAmount

                          from
                              mas_journal
                              inner join trn_journal on mas_journal.journalid=trn_journal.journalid
                              inner join mas_customer on mas_journal.partyid=mas_customer.customer_id
                          where
                              mas_journal.journaldate between STR_TO_DATE('1-$cboMonth-$cboYear','%e-%c-%Y') AND LAST_DAY(STR_TO_DATE('1-$cboMonth-$cboYear','%e-%c-%Y')) AND
                              trn_journal.glcode in ('10501','10401','20503')
                          group by
                              mas_journal.partyid

                         ";
                         


                  //echo $query;

                  $rs=mysql_query($query) or die("Error: ".mysql_error());

                  if(mysql_num_rows($rs)>0)
                  {
                        drawCompanyInformation("Debtor Ledger ","For the period of ".date("F, Y", mktime(0, 0, 0, $cboMonth,1,$cboYear)));

                        echo "<table width='100%' id='table1' cellspacing='0' cellpadding='0' align='center'>
                                    <tr>
                                          <td class='title_cell_e_l' rowspan='2'>SlNo</td>
                                          <td class='title_cell_e' rowspan='2'>Company Name</td>
                                          <td class='title_cell_e' colspan='2'>Opening Balance</td>
                                          <td class='title_cell_e' colspan='2'>Period Transaction</td>
                                          <td class='title_cell_e' colspan='2'>Balance</td>
                                    </tr>
                                    <tr>
                                          <td class='sub_title_cell_e'>Debit</td>
                                          <td class='sub_title_cell_e'>Credit</td>
                                          <td class='sub_title_cell_e'>Debit</td>
                                          <td class='sub_title_cell_e'>Credit</td>
                                          <td class='sub_title_cell_e'>Debit</td>
                                          <td class='sub_title_cell_e'>Credit</td>
                                    </tr>
                                    ";
                        $i=0;
                        $Total_dr=0;
                        $Total_cr=0;
                        $open_total_dr=0;
                        $open_total_cr=0;
                        $blace_total_dr=0;
                        $blace_total_cr=0;
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



                              $BlDrAmount=0;
                              $BlCrAmount=0;
                              $openDrAmount=0;
                              $openCrAmount=0;

                              $MasterBalance=0;


                              getDebtorsPreviousClosing(&$openDrAmount,&$openCrAmount,$customer_id,$cboMonth,$cboYear);
                        


                              //$MasterBalance=$BlDrAmount-$BlCrAmount;





                              if((($openDrAmount+$DrAmount)- ($openCrAmount+$CrAmount))>0)
                              {
                                    $BlDrAmount=($openDrAmount+$DrAmount)- ($openCrAmount+$CrAmount);
                                    $BlCrAmount=0;
                              }
                              else if((($openCrAmount+$CrAmount)-($openDrAmount+$DrAmount))>0)
                              {
                                    $BlCrAmount=($openCrAmount+$CrAmount)-($openDrAmount+$DrAmount);
                                    $BlDrAmount=0;
                              }
                              else
                              {
                                    $BlDrAmount=0;
                                    $BlCrAmount=0;
                              }
                              $Total_dr=$Total_dr+$DrAmount;
                              $Total_cr=$Total_cr+$CrAmount;
                              $open_total_dr=$open_total_dr+$openDrAmount;
                              $open_total_cr=$open_total_cr+$openCrAmount;
                              $blace_total_dr=$blace_total_dr+$BlDrAmount;
                              $blace_total_cr=$blace_total_cr+$BlCrAmount;
                              
                                    



                              echo "<tr>
                                          <td class='$lclass' align='center' >".($i+1)."</td>
                                          <td class='$class' align='center' >$Company_Name</td>

                                          <td class='$class' align='right'>".number_format($openDrAmount,2,'.',',')."</td>
                                          <td class='$class' align='right'>".number_format($openCrAmount,2,'.',',')."</td>
                                          <td class='$class' align='right'>".number_format($DrAmount,2,'.',',')."</td>
                                          <td class='$class' align='right'>".number_format($CrAmount,2,'.',',')."</td>
                                          <td class='$class' align='right'>".number_format($BlDrAmount,2,'.',',')."</td>
                                          <td class='$class' align='right'>".number_format($BlCrAmount,2,'.',',')."</td>
                                    </tr>";
                              
                              $i++;
                        }
                        echo "<tr>
                                    <td class='td_e_b_l' colspan='2' align='right'><b>Total</b></td>
                                    <td class='td_e_b' align='right'>".number_format($open_total_dr,2,'.',',')."</td>
                                    <td class='td_e_b' align='right'>".number_format($open_total_cr,2,'.',',')."</td>
                                    <td class='td_e_b' align='right'>".number_format($Total_dr,2,'.',',')."</td>
                                    <td class='td_e_b' align='right'>".number_format($Total_cr,2,'.',',')."</td>
                                    <td class='td_e_b' align='right'>".number_format($blace_total_dr,2,'.',',')."</td>
                                    <td class='td_e_b' align='right'>".number_format($blace_total_cr,2,'.',',')."</td>

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

<?PHP
      mysql_close();
?>
