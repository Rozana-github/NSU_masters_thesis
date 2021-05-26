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
            <script language='Javascript' >
            function gogenaralledger(cboMonth,cboYear,glcode)
            {
                window.location="GeneralLedgerBottom.php?cboMonth="+cboMonth+"&cboYear="+cboYear+"&cboAccountHead="+glcode;
            }
            </script>
      </head>
      <body class='body_e'>
            <?PHP
                  if($cboMonth=='-1')
                  {
                        $query="select
                              mas_ytd_fin.glcode,
                              mas_gl.description,
                              mas_ytd_fin.proc_month,
                              mas_ytd_fin.proc_year,
                              mas_ytd_fin.year_dr,
                              mas_ytd_fin.year_cr,
                              mas_ytd_fin.month_dr,
                              mas_ytd_fin.month_cr,
                              mas_ytd_fin.closing_dr,
                              mas_ytd_fin.closing_cr,
                              mas_cost_center.description as costcenter
                          from
                              mas_ytd_fin
                              LEFT JOIN mas_gl on mas_ytd_fin.glcode=mas_gl.gl_code
                              left join mas_cost_center on mas_ytd_fin.cost_code=mas_cost_center.cost_code

                          where
                              mas_ytd_fin.proc_year='$cboYear'
                          order by
                               mas_ytd_fin.glcode
                         ";
                  }
                  else
                  {
                  $query="select
                              mas_ytd_fin.glcode,
                              mas_gl.description,
                              mas_ytd_fin.proc_month,
                              mas_ytd_fin.proc_year,
                              mas_ytd_fin.year_dr,
                              mas_ytd_fin.year_cr,
                              mas_ytd_fin.month_dr,
                              mas_ytd_fin.month_cr,
                              mas_ytd_fin.closing_dr,
                              mas_ytd_fin.closing_cr,
                              mas_cost_center.description as costcenter
                          from
                              mas_ytd_fin
                              LEFT JOIN mas_gl on mas_ytd_fin.glcode=mas_gl.gl_code
                              left join mas_cost_center on mas_ytd_fin.cost_code=mas_cost_center.cost_code
                          where
                              mas_ytd_fin.proc_month='$cboMonth' AND
                              mas_ytd_fin.proc_year='$cboYear'
                          order by
                               mas_ytd_fin.glcode
                         ";
                    }

                  //echo $query;
                  $rs=mysql_query($query) or die("Error: ".mysql_error());

                  if(mysql_num_rows($rs)>0)
                  {
                  
                         if($cboMonth=='-1')
                                drawCompanyInformation("Trial Balance","For the year of ".date("Y", mktime(0, 0, 0, 1,1,$cboYear)));
                         else
                                drawCompanyInformation("Trial Balance","For the month of ".date("F, Y", mktime(0, 0, 0, $cboMonth,1,$cboYear)));

                        echo "<table width='95%' id='table1' cellspacing='0' cellpadding='0' align='center'>
                                    <tr>
                                          <td class='title_cell_e_l' rowspan='2'>GL Code</td>
                                          <td class='title_cell_e' rowspan='2'>GL Name</td>

                                          <td class='title_cell_e' colspan='2'>Opening Balance</td>
                                          <td class='title_cell_e' colspan='2'>Current Period Balance</td>
                                          <td class='title_cell_e' colspan='2'>Closing Balance</td>
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

                        $Totalyear_dr=0;
                        $Totalyear_cr=0;

                        $Totalmonth_dr=0;
                        $Totalmonth_cr=0;

                        $Totalclosing_dr=0;
                        $Totalclosing_cr=0;
                        
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
                              ///////////////////////////////////////////////////
                              if(($year_dr-$year_cr)>0)
                              {
                                    $year_dr=$year_dr-$year_cr;
                                    $year_cr=0;
                              }
                              else if(($year_dr-$year_cr)<0)
                              {
                                    $year_cr=$year_cr-$year_dr;
                                    $year_dr=0;
                              }
                              else
                              {
                                    $year_cr=0;
                                    $year_dr=0;
                              }
                              ///////////////////////////////////////////////////
                              if(($month_dr-$month_cr)>0)
                              {
                                    $month_dr=$month_dr-$month_cr;
                                    $month_cr=0;
                              }
                              else if(($month_dr-$month_cr)<0)
                              {
                                    $month_cr=$month_cr-$month_dr;
                                    $month_dr=0;
                              }
                              else
                              {
                                    $month_cr=0;
                                    $month_dr=0;
                              }
                              ///////////////////////////////////////////////////
                              if(($closing_dr-$closing_cr)>0)
                              {
                                    $closing_dr=$closing_dr-$closing_cr;
                                    $closing_cr=0;
                              }
                              else if(($closing-$closing_cr)<0)
                              {
                                    $closing_cr=$closing_cr-$closing_dr;
                                    $closing_dr=0;
                              }
                              else
                              {
                                    $closing_cr=0;
                                    $closing_dr=0;
                              }
                              ///////////////////////////////////////////////////
                              
                              $Totalyear_dr=$Totalyear_dr+$year_dr;
                              $Totalyear_cr=$Totalyear_cr+$year_cr;
                              
                              $Totalmonth_dr=$Totalmonth_dr+$month_dr;
                              $Totalmonth_cr=$Totalmonth_cr+$month_cr;
                              
                              $Totalclosing_dr=$Totalclosing_dr+$closing_dr;
                              $Totalclosing_cr=$Totalclosing_cr+$closing_cr;
                              
                              echo "<tr>
                                          <td class='$lclass' align='center'>$glcode&nbsp;</td>
                                          <td class='$class'  style=\"cursor: hand;\" onclick=gogenaralledger($cboMonth,$cboYear,$glcode)>" .$description. "  &nbsp;&nbsp;   $costcenter &nbsp;</td>


                                          <td class='$class' align='right'>".number_format($year_dr,2,'.',',')."</td>
                                          <td class='$class' align='right'>".number_format($year_cr,2,'.',',')."</td>
                                          <td class='$class' align='right'>".number_format($month_dr,2,'.',',')."</td>
                                          <td class='$class' align='right'>".number_format($month_cr,2,'.',',')."</td>
                                          <td class='$class' align='right'>".number_format($closing_dr,2,'.',',')."</td>
                                          <td class='$class' align='right'>".number_format($closing_cr,2,'.',',')."</td>
                                    </tr>";
                              
                              $i++;
                        }
                        echo "<tr>
                                    <td class='td_e_b_l' colspan='2' align='right'><b>Total</b></td>
                                    <td class='td_e_b' align='right'>".number_format($Totalyear_dr,2,'.',',')."</td>
                                    <td class='td_e_b' align='right'>".number_format($Totalyear_cr,2,'.',',')."</td>
                                    <td class='td_e_b' align='right'>".number_format($Totalmonth_dr,2,'.',',')."</td>
                                    <td class='td_e_b' align='right'>".number_format($Totalmonth_cr,2,'.',',')."</td>
                                    <td class='td_e_b' align='right'>".number_format($Totalclosing_dr,2,'.',',')."</td>
                                    <td class='td_e_b' align='right'>".number_format($Totalclosing_cr,2,'.',',')."</td>
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
