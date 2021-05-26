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
            <script language='javascript'>
                  function ReportPrint()
                  {
                        print();
                  }
            </script>
      </head>
      <body class='body_e'>
            <?PHP
                 $querylc="select
                              mas_lc.opendate as rpt_openDT,
                              mas_lc.lcno as rpt_lcno,
                              mas_lc.lastshipmentdate as rpt_lsDT,
                              mas_lc.dateofmaturity as rpt_NDT,
                              mas_lc.lcvalue,
                              mas_supplier.Company_Name as rpt_CompanyName

                          from
                              mas_lc

                              left join mas_supplier on mas_supplier.supplier_id=mas_lc.partyid

                          where
                              mas_lc.lcobjectid='$cboLc'

                        ";
                //echo $querylc;

                 $query="SELECT
                                mas_journal.`journalno` ,
                                mas_journal.`journaltype` ,
                                date_format( mas_journal.journaldate, '%d-%m-%Y' ) AS journaldate,
                                trn_journal.remarks,
                                IF( trn_journal.ttype = 'Dr', trn_journal.amount, 0 ) AS DrAmount,
                                IF( trn_journal.ttype = 'Cr', trn_journal.amount, 0 ) AS CrAmount,
                                trn_journal.ttype,
                                trn_journal.amount
                        FROM
                                mas_journal
                                INNER JOIN trn_journal ON mas_journal.journalid = trn_journal.journalid
                        WHERE
                                mas_journal.lcno = '$cboLc'

                                ";
                  //echo $query;
                  $rs=mysql_query($query) or die("Error: ".mysql_error());

                  if(mysql_num_rows($rs)>0)
                  {
                       echo "
                        <table width='100%' id='table1' cellspacing='0' cellpadding='0' align='center'>
                              <tr>
                                    <td align='center' HEIGHT='20'>
                                          <div class='hide'>
                                                      <input type='button' name='btnPrint' value='Print' onclick='ReportPrint()'>
                                          </div>
                                    </td>
                              </tr>
                        </table>
                        <br><br><br>
                        ";
                        if($cboMonth=='-1')
                                drawCompanyInformation("LC Ledger of ","");
                        else
                                drawCompanyInformation("LC Ledger of ","");
                                
                       $rslc=mysql_query($querylc)or die(mysql_error());
                    if(mysql_num_rows($rslc)>0)
                  {

                        //||<input type='button' name='btnPrint' value='Print' onclick='ReportPrint()'>


                        echo "<table width='100%' id='table1' cellspacing='0' cellpadding='0' align='center'>

                                    <tr>
                                          <td class='title_cell_e_l'>LC Opening Date</td>
                                          <td class='title_cell_e'>LC No</td>
                                          <td class='title_cell_e'>LC Value$</td>
                                          <td class='title_cell_e'>Name Of Company</td>
                                          <td class='title_cell_e'>Shipment Date</td>
                                          <td class='title_cell_e'>Negotiation Date</td>
                                    </tr>";
                        $i=0;
                        while($rowlc=mysql_fetch_array($rslc))
                        {
                              extract($rowlc);
                              if(($i%2)==0)
                              {
                                    $class='even_td_e';
                                    $lclass="even_left_td_e";
                              }
                              else
                              {
                                    $class='odd_td_e';
                                    $lclass="odd_left_td_e";
                              }
                              $mainitem=pick("mas_item","itemdescription","itemcode='$parent_itemcode'");
                              $subitem=pick("mas_item","itemdescription","itemcode='$itemcode'");
                              $totalAmount=$rpt_rate*$rpt_reqqty;
                              echo "<tr>
                                          <td class='$lclass' align='center'>$rpt_openDT</td>
                                          <td class='$class'>$rpt_lcno</td>

                                          <td class='$class' align='right'>$lcvalue</td>
                                          <td class='$class' align='left'>$rpt_CompanyName</td>
                                          <td class='$class' align='right'>$rpt_lsDT</td>
                                          <td class='$class' align='right'>$rpt_NDT</td>
                                    </tr>";

                              $i++;
                        }
                        echo "</table><br>";
                  }

                        echo "<table width='100%' id='table1' cellspacing='0' cellpadding='0' align='center'>
                                    <tr>
                                          <td class='title_cell_e_l' >Entry No</td>
                                          <td class='title_cell_e' >Type</td>
                                          <td class='title_cell_e'>Date</td>
                                          <td class='title_cell_e' >Particulars</td>
                                          <td class='title_cell_e' >Cost Center/Department</td>
                                          <td class='title_cell_e'>Debit</td>
                                          <td class='title_cell_e'>Credit</td>
                                    </tr>

                                    ";


                        $i=0;
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


                              
                              echo "<tr>
                                          <td class='$lclass' align='center'>$journalno</td>
                                          <td class='$class'>$journaltype</td>
                                          <td class='$class'>$journaldate</td>
                                          <td class='$class'>$remarks &nbsp;</td>
                                          <td class='$class'>$description &nbsp;</td>
                                          <td class='$class' align='right'>".number_format($DrAmount,2,'.',',')."</td>
                                          <td class='$class' align='right'>".number_format($CrAmount,2,'.',',')."</td>

                                    </tr>";
                              
                              $i++;
                        }
                        echo "<tr>
                                    <td class='td_e_b_l' colspan='5' align='right'><b>Total</b></td>
                                    <td class='td_e_b' align='right'>".number_format($Total_dr,2,'.',',')."</td>
                                    <td class='td_e_b' align='right'>".number_format($Total_cr,2,'.',',')."</td>

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
?>

<?PHP
      mysql_close();
?>
