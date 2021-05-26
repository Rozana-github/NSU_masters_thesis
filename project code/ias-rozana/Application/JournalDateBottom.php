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
                  if($cboAccountHead=='-1')
                  {
                        $query="select
                              mas_journal.journalno,
                              mas_journal.journaltype,
                              date_format(mas_journal.journaldate, '%d-%m-%Y') as journaldate,
                              mas_journal.remarks,
                              mas_gl.description,

                              IF(trn_journal.ttype='Dr',trn_journal.amount,0) AS DrAmount,
                              IF(trn_journal.ttype='Cr',trn_journal.amount,0) AS CrAmount,
                              trn_journal.ttype,
                              trn_journal.amount
                          from
                              mas_journal
                              inner join trn_journal on mas_journal.journalid=trn_journal.journalid
                              inner join mas_gl on trn_journal.glcode=mas_gl.gl_code
                          where

                              mas_journal.journaldate between STR_TO_DATE('$cbofDay-$cbofMonth-$cbofYear','%e-%c-%Y') AND STR_TO_DATE('$cbotDay-$cbotMonth-$cbotYear','%e-%c-%Y')

                          order by
                              mas_journal.journaldate,mas_journal.journaltype,mas_journal.journalno
                         ";

                  }
                  else
                  {
                        $query="select
                                    mas_journal.journalno,
                                    mas_journal.journaltype,
                                    date_format(mas_journal.journaldate, '%d-%m-%Y') as journaldate,
                                    mas_journal.remarks,
                                    mas_gl.description,
                                    IF(trn_journal.ttype='Dr',trn_journal.amount,0) AS DrAmount,
                                    IF(trn_journal.ttype='Cr',trn_journal.amount,0) AS CrAmount,
                                    trn_journal.ttype,
                                    trn_journal.amount
                              from
                                    mas_journal
                                    inner join trn_journal on mas_journal.journalid=trn_journal.journalid
                                    inner join mas_gl on trn_journal.glcode=mas_gl.gl_code
                              where
                                    trn_journal.glcode='$cboAccountHead' and
                                    mas_journal.journaldate between STR_TO_DATE('$cbofDay-$cbofMonth-$cbofYear','%e-%c-%Y') AND STR_TO_DATE('$cbotDay-$cbotMonth-$cbotYear','%e-%c-%Y')
                              order by
                                    mas_journal.journaldate,mas_journal.journaltype,mas_journal.journalno
                              ";
                  }

                  //echo $query;
                  $rs=mysql_query($query) or die("Error: ".mysql_error());

                  if(mysql_num_rows($rs)>0)
                  {
                        drawCompanyInformation("Journal Report","For the period of ".date("jS F, Y", mktime(0, 0, 0, $cbofMonth,$cbofDay,$cbofYear))." To ".date("jS F, Y", mktime(0, 0, 0, $cbotMonth,$cbotDay,$cbotYear)));

                        echo "<table width='100%' id='table1' cellspacing='0' cellpadding='0' align='center'>
                                    <tr>
                                          <td class='title_cell_e_l' rowspan='2'>Entry No</td>
                                          <td class='title_cell_e' rowspan='2'>Type</td>
                                          <td class='title_cell_e' rowspan='2'>Date</td>
                                          <td class='title_cell_e' rowspan='2'>Description</td>
                                          <td class='title_cell_e' colspan='2'>Period Transaction</td>

                                    </tr>
                                    <tr>
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
                                          <td class='$class'>$description &nbsp;</td>
                                          <td class='$class' align='right'>".number_format($DrAmount,2,'.',',')."</td>
                                          <td class='$class' align='right'>".number_format($CrAmount,2,'.',',')."</td>

                                    </tr>";
                              
                              $i++;
                        }
                        echo "<tr>
                                    <td class='td_e_b_l' colspan='4' align='right'><b>Total</b></td>
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
      mysql_close();
?>
