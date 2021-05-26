<?PHP
session_start();

        include_once("Library/dbconnect.php");
        include_once("Library/Library.php");

?>

<html xmlns:ycode>

<style>
        yCode\:combobox {behavior: url(combobox.htc); }
</style>

<head>
<meta http-equiv='Content-Type' content='text/html; charset=windows-1252'>
<LINK href="Style/generic_report.css" type='text/css' rel='stylesheet'>
<link rel='stylesheet' type='text/css' href='Style/eng_report.css' />

<script language="JavaScript" src="Script/NumberFormat.js"></script>

<script language="JavaScript" src="Script/calendar1.js"></script>

<script language='JavaScript'>


</script>

</head>

<body >






<?PHP

      $i=0;
      $total=0;


                               //echo $employeequery;

                  if($fMonth=='-1')
                        drawCompanyInformation("Balance Sheet","For the Year ended ".date(" Y", mktime(0, 0, 0, 1,1,$fYear)));
                  else
                        drawCompanyInformation("Balance Sheet","For the Month ended ".date("F, Y", mktime(0, 0, 0, $fMonth,1,$fYear)));
                  echo "<table width='70%' id='table1' cellspacing='0' cellpadding='0' align='center'>


                              <tr>


                                    <Td    colspan='3'>PROPERTY & ASSETS</td>

                              </tr>
                              <tr>

                                    <Td  class='title_cell_e_l'  align='center'>Particulars</td>
                                    <Td  class='title_cell_e'  align='center'>Note</td>
                                    <Td  class='title_cell_e'  align='center'>".date("F,Y",mktime(0,0,0,$fMonth,1,$fYear))."</td>

                              </tr>
                              <tr>

                                    <Td    colspan='3'>&nbsp;</td>

                              </tr>";



                  /*****************   PROPERTY & ASSETS     ***************/
                  /*****************   fixed Asset at cost      ***************/
                  if($fMonth=='-1')
                  {
                  $queryfixedasset="select
                                          ifnull(sum(mas_ytd_fin.closing_dr - mas_ytd_fin.closing_cr),0) as Fixedasset
                                    from
                                          mas_ytd_fin
                                    where
                                          mas_ytd_fin.proc_year = '$fYear'
                                          and mas_ytd_fin.glcode between '10101' and '10110'
                                    ";
                  }
                  else
                  {
                        $queryfixedasset="select
                                          ifnull(sum(mas_ytd_fin.closing_dr - mas_ytd_fin.closing_cr),0) as Fixedasset
                                    from
                                          mas_ytd_fin
                                    where
                                          mas_ytd_fin.proc_year = '$fYear'
                                          AND mas_ytd_fin.proc_month = '$fMonth'
                                          and mas_ytd_fin.glcode between '10101' and '10110'
                                    ";

                        
                  }
                  $rsfixedasset=mysql_query($queryfixedasset)or die(mysql_error());
                  while($rowfixedasset=mysql_fetch_array($rsfixedasset))
                  {
                        extract($rowfixedasset);
                        echo"<tr>
                                    <Td   >Fixed Asset at cost</td>
                                    <Td    align='center'>&nbsp;</td>
                                    <Td    align='right'>".number_format(abs($Fixedasset),0,'.',',')."</td>

                              </tr>";
                  }
                  
                  /*****************   less depreciation    ***************/

                  if($fMonth=='-1')
                  {
                        $querydepreciation="select
                                          ifnull(sum(mas_ytd_fin.closing_cr - mas_ytd_fin.closing_dr),0) as depreciation
                                    from
                                          mas_ytd_fin
                                    where
                                          mas_ytd_fin.proc_year = '$fYear'
                                          and mas_ytd_fin.glcode between '10701' and '10711'
                                    ";
                  }
                  else
                  {
                        $querydepreciation="select
                                          ifnull(sum(mas_ytd_fin.closing_cr - mas_ytd_fin.closing_dr),0) as depreciation
                                    from
                                          mas_ytd_fin
                                    where
                                          mas_ytd_fin.proc_year = '$fYear'
                                          AND mas_ytd_fin.proc_month = '$fMonth'
                                          and mas_ytd_fin.glcode between '10701' and '10711'
                                    ";
                  }
                  
                  $rsdepreciation=mysql_query($querydepreciation)or die(mysql_error());
                  while($rowdepreciation=mysql_fetch_array($rsdepreciation))
                  {
                        extract($rowdepreciation);
                        echo"<tr>
                                    <Td    >Less: Accumulated depreciation</td>
                                    <Td    align='center'>&nbsp;</td>
                                    <Td    align='right'>".number_format(abs($depreciation),0,'.',',')."</td>

                              </tr>";
                  }
                  
                  $fixedassettotal= $Fixedasset-$depreciation;
                  
                  echo"<tr>

                                    <Td    align='right' colspan='3'>".number_format(abs($fixedassettotal),0,'.',',')."</td>

                              </tr>";
                              
                  /* Account Receivable*/
                  
                  if($fMonth=='-1')
                  {
                        $queryaccountreceiv=" select
                                                note_no,
                                                trn_amount
                                            from
                                                mas_ytd_balance
                                            where
                                                mas_ytd_balance.proc_year = '$fYear'
                                                and mas_ytd_balance.glcode ='10400'
                                          ";
                  }
                  else
                  {
                        $queryaccountreceiv=" select
                                                note_no,
                                                trn_amount
                                            from
                                                mas_ytd_balance
                                            where
                                                mas_ytd_balance.proc_year = '$fYear'
                                                AND mas_ytd_balance.proc_month = '$fMonth'
                                                and mas_ytd_balance.glcode ='10400'
                                          ";
                  }
                  
                   $rsaccountreceiv=mysql_query($queryaccountreceiv)or die(mysql_error());
                   while($rowaccountreceiv=mysql_fetch_array($rsaccountreceiv))
                   {
                        extract($rowaccountreceiv);
                         echo"<tr>
                                    <Td    >Account receivable</td>
                                    <Td    align='center'>$note_no</td>
                                    <Td    align='right'>".number_format(abs($trn_amount),0,'.',',')."</td>

                              </tr>";
                   }
                   
                   
                   /*  Receivable of Scrap sales*/

                  if($fMonth=='-1')
                  {
                        $queryscrapsales=" select
                                                ifnull(sum(mas_ytd_fin.closing_dr - mas_ytd_fin.closing_cr),0) as scrapsales
                                            from
                                                mas_ytd_fin
                                            where
                                                mas_ytd_fin.proc_year = '$fYear'
                                                and mas_ytd_fin.glcode ='10901'
                                          ";
                  }
                  else
                  {
                        $queryscrapsales=" select
                                                ifnull(sum(mas_ytd_fin.closing_dr - mas_ytd_fin.closing_cr),0) as scrapsales
                                            from
                                                mas_ytd_fin
                                            where
                                                mas_ytd_fin.proc_year = '$fYear'
                                                AND mas_ytd_fin.proc_month = '$fMonth'
                                                and mas_ytd_fin.glcode ='10901'
                                          ";
                  }
                  
                   $rsscrapsales=mysql_query($queryscrapsales)or die(mysql_error());
                   while($rowscrapsales=mysql_fetch_array($rsscrapsales))
                   {
                        extract($rowscrapsales);
                         echo"<tr>
                                    <Td    >Receivable of Scrap sales </td>
                                    <Td    align='center'>&nbsp;</td>
                                    <Td   align='right'>".number_format(abs($scrapsales),0,'.',',')."</td>

                              </tr>";
                   }
                   
                   //Stock,stores and spares
                   
                    if($fMonth=='-1')
                  {
                        $querystock=" select
                                                note_no,
                                                trn_amount as stock
                                            from
                                                mas_ytd_balance
                                            where
                                                mas_ytd_balance.proc_year = '$fYear'
                                                and mas_ytd_balance.glcode ='10300'
                                          ";
                  }
                  else
                  {
                        $querystock=" select
                                                note_no,
                                                trn_amount as stock
                                            from
                                                mas_ytd_balance
                                            where
                                                mas_ytd_balance.proc_year = '$fYear'
                                                AND mas_ytd_balance.proc_month = '$fMonth'
                                                and mas_ytd_balance.glcode ='10300'
                                          ";
                  }
                  
                   $rsstock=mysql_query($querystock)or die(mysql_error());
                   while($rowstock=mysql_fetch_array($rsstock))
                   {
                        extract($rowstock);
                         echo"<tr>
                                    <Td    >Stock,stores and spares</td>
                                    <Td    align='center'>$note_no</td>
                                    <Td    align='right'>".number_format(abs($stock),0,'.',',')."</td>

                              </tr>";
                   }
                   
                   //Advances,deposits and prepayments
                   if($fMonth=='-1')
                  {
                        $queryadvances=" select
                                                note_no,
                                                trn_amount as Advances
                                            from
                                                mas_ytd_balance
                                            where
                                                mas_ytd_balance.proc_year = '$fYear'
                                                and mas_ytd_balance.glcode ='10600'
                                          ";
                  }
                  else
                  {
                        $queryadvances=" select
                                                note_no,
                                                trn_amount as Advances
                                            from
                                                mas_ytd_balance
                                            where
                                                mas_ytd_balance.proc_year = '$fYear'
                                                AND mas_ytd_balance.proc_month = '$fMonth'
                                                and mas_ytd_balance.glcode ='10600'
                                          ";
                  }
                  
                   $rsAdvances=mysql_query($queryadvances)or die(mysql_error());
                   while($rowAdvances=mysql_fetch_array($rsAdvances))
                   {
                        extract($rowAdvances);
                         echo"<tr>
                                    <Td    >Advances,deposits and prepayments</td>
                                    <Td    align='center'>$note_no</td>
                                    <Td    align='right'>".number_format(abs($Advances),0,'.',',')."</td>

                              </tr>";
                   }
                   
                   //Trade debtors
                   
                   if($fMonth=='-1')
                  {
                        $querydebtors=" select
                                                ifnull(sum(mas_ytd_fin.closing_dr - mas_ytd_fin.closing_cr),0) as debtors
                                            from
                                                mas_ytd_fin
                                            where
                                                mas_ytd_fin.proc_year = '$fYear'
                                                and mas_ytd_fin.glcode ='10501'
                                          ";
                  }
                  else
                  {
                        $querydebtors=" select
                                                ifnull(sum(mas_ytd_fin.closing_dr - mas_ytd_fin.closing_cr),0) as debtors
                                            from
                                                mas_ytd_fin
                                            where
                                                mas_ytd_fin.proc_year = '$fYear'
                                                AND mas_ytd_fin.proc_month = '$fMonth'
                                                and mas_ytd_fin.glcode ='10501'
                                          ";
                  }
                  
                   $rsdebtors=mysql_query($querydebtors)or die(mysql_error());
                   while($rowdebtors=mysql_fetch_array($rsdebtors))
                   {
                        extract($rowdebtors);
                         echo"<tr>
                                    <Td    >Trade debtors </td>
                                    <Td    align='center'>&nbsp;</td>
                                    <Td    align='right'>".number_format(abs($debtors),0,'.',',')."</td>

                              </tr>";
                   }
                   
                   //cash and bank balance
                   
                   if($fMonth=='-1')
                  {
                        $querybankbalance=" select
                                                note_no,
                                                trn_amount as bankbalance
                                            from
                                                mas_ytd_balance
                                            where
                                                mas_ytd_balance.proc_year = '$fYear'
                                                and mas_ytd_balance.glcode ='10200'
                                          ";
                  }
                  else
                  {
                        $querybankbalance=" select
                                                note_no,
                                                trn_amount as bankbalance
                                            from
                                                mas_ytd_balance
                                            where
                                                mas_ytd_balance.proc_year = '$fYear'
                                                AND mas_ytd_balance.proc_month = '$fMonth'
                                                and mas_ytd_balance.glcode ='10200'
                                          ";
                  }
                  
                   $rsbankbalance=mysql_query($querybankbalance)or die(mysql_error());
                   while($rowbankbalance=mysql_fetch_array($rsbankbalance))
                   {
                        extract($rowbankbalance);
                         echo"<tr>
                                    <Td    >cash and bank balance</td>
                                    <Td    align='center'>$note_no</td>
                                    <Td    align='right'>".number_format(abs($bankbalance),0,'.',',')."</td>

                              </tr>";
                   }
                   
                   
                   $fixedassettotal=$fixedassettotal+ $bankbalance+ $debtors+ $Advances+$stock+$scrapsales+ $trn_amount;
                   
                   echo"<tr>

                                    <Td     align='right' colspan='2'>&nbsp;</td>
                                    <Td    class='total_td_e' align='right' >".number_format(abs($fixedassettotal),0,'.',',')."</td>

                              </tr>";
                              
                              
                   echo"<tr>

                                    <Td    colspan='3'><b>FUND & LIABILITIES :</b></td>

                              </tr>
                              <tr>

                                    <Td    colspan='3'>&nbsp;</td>

                              </tr>";
                  //Equity fund
                  if($fMonth=='-1')
                  {
                                    $queryequityfund=" select
                                                ifnull(sum(mas_ytd_fin.closing_dr - mas_ytd_fin.closing_cr),0) as equityfund
                                            from
                                                mas_ytd_fin
                                            where
                                                mas_ytd_fin.proc_year = '$fYear'
                                                AND mas_ytd_fin.proc_month = '$fMonth'
                                                and  mas_ytd_fin.glcode ='20101'
                                          ";
                  }
                  else
                  {
                        $queryequityfund=" select
                                                ifnull(sum(mas_ytd_fin.closing_dr - mas_ytd_fin.closing_cr),0) as equityfund
                                            from
                                                mas_ytd_fin
                                            where
                                                mas_ytd_fin.proc_year = '$fYear'
                                                AND mas_ytd_fin.proc_month = '$fMonth'
                                                and  mas_ytd_fin.glcode ='20101'
                                          ";
                  }

                   $rsequityfund=mysql_query($queryequityfund)or die(mysql_error());
                   while($rowequityfund=mysql_fetch_array($rsequityfund))
                   {
                        extract($rowequityfund);
                         echo"<tr>
                                    <Td    >Equity fund </td>
                                    <Td    align='center'>&nbsp;</td>
                                    <Td   align='right'>".number_format(abs($equityfund),0,'.',',')."</td>

                              </tr>";
                   }
                   
                   //Retained Earnings
                   
                   if($fMonth=='-1')
                  {
                        $queryretained=" select
                                                ifnull(sum(mas_ytd_fin.closing_dr - mas_ytd_fin.closing_cr),0) as retained
                                            from
                                                mas_ytd_fin
                                            where
                                                mas_ytd_fin.proc_year = '$fYear'
                                                and mas_ytd_fin.glcode ='20200'
                                          ";
                  }
                  else
                  {
                        $queryretained=" select
                                                ifnull(sum(mas_ytd_fin.closing_cr - mas_ytd_fin.closing_dr),0) as retained
                                            from
                                                mas_ytd_fin
                                            where
                                                mas_ytd_fin.proc_year = '$fYear'
                                                AND mas_ytd_fin.proc_month = '$fMonth'
                                                and mas_ytd_fin.glcode in ('20201','20202')
                                          ";
                  }
                  
                   $rsretained=mysql_query($queryretained)or die(mysql_error());
                   while($rowretained=mysql_fetch_array($rsretained))
                   {
                        extract($rowretained);
                         echo"<tr>
                                    <Td    >Retained Earnings </td>
                                    <Td    align='center'>&nbsp;</td>
                                    <Td    align='right'>".number_format(abs($retained),0,'.',',')."</td>

                              </tr>";
                   }
                   
                   //Profit for the Period
                   
                  if($fMonth=='-1')
                  {
                        $queryProfit=" select
                                                note_no,
                                                trn_amount as Profit
                                            from
                                                mas_ytd_balance
                                            where
                                                mas_ytd_balance.proc_year = '$fYear'
                                                and mas_ytd_balance.glcode ='30209'
                                          ";
                  }
                  else
                  {
                        $queryProfit=" select

                                             sum(trn_amount) as Profit
                                       from
                                                mas_ytd_balance
                                            where
                                                mas_ytd_balance.proc_year = '$fYear'

                                                and mas_ytd_balance.glcode ='30209'
                                          ";
                  }
                  
                   $rsProfit=mysql_query($queryProfit)or die(mysql_error());
                   while($rowProfit=mysql_fetch_array($rsProfit))
                   {
                        extract($rowProfit);
                         echo"<tr>
                                    <Td    >Profit for the period</td>
                                    <Td    align='center'>6</td>
                                    <Td    align='right'>".number_format(abs($Profit),0,'.',',')."</td>

                              </tr>";
                   }
                       $querydetails=" select
                                             proc_month,
                                             trn_amount
                                       from
                                                mas_ytd_balance
                                            where
                                                mas_ytd_balance.proc_year = '$fYear'

                                                and mas_ytd_balance.glcode ='30209'
                                          ";
                       $rsdetails=mysql_query($querydetails)or die(mysql_error());
                       echo"<tr>
                                    <td>&nbsp;</td>
                                    <Td   class='total_td_e' align='right' colspan='2'>
                                          <table width='70%'  cellspacing='0' cellpadding='0' align='right'>";
                       while($rowdetails=mysql_fetch_array($rsdetails))
                       {
                                        extract($rowdetails);
                                         echo" <tr>
                                          <td>".date(" F ", mktime(0, 0, 0, $proc_month,1,1))."</td>
                                          <td align='right'>".number_format(abs($trn_amount),0,'.',',')."</td>
                                          <tr>";

                       }
                       echo"</table>
                                    </td>

                              </tr>";
                   
                   //Current Account with H.O
                   
                  if($fMonth=='-1')
                  {
                        $querycuraccount=" select
                                                ifnull(sum(mas_ytd_fin.closing_dr - mas_ytd_fin.closing_cr),0) as curaccount
                                            from
                                                mas_ytd_fin
                                            where
                                                mas_ytd_fin.proc_year = '$fYear'
                                                and mas_ytd_fin.glcode ='20301'
                                          ";
                  }
                  else
                  {
                        $querycuraccount=" select
                                                ifnull(sum(mas_ytd_fin.closing_dr - mas_ytd_fin.closing_cr),0) as curaccount
                                            from
                                                mas_ytd_fin
                                            where
                                                mas_ytd_fin.proc_year = '$fYear'
                                                AND mas_ytd_fin.proc_month = '$fMonth'
                                                and mas_ytd_fin.glcode ='20301'
                                          ";
                  }
                    
                   $rscuraccount=mysql_query($querycuraccount)or die(mysql_error());
                   while($rowcuraccount=mysql_fetch_array($rscuraccount))
                   {
                        extract($rowcuraccount);
                         echo"<tr>
                                    <Td    >Current Account with H.O </td>
                                    <Td    align='center'>&nbsp;</td>
                                    <Td    align='right'>".number_format(abs($curaccount),0,'.',',')."</td>

                              </tr>";
                   }
                   
                   //Gratuity & Rendundancy Fund
                   
                  if($fMonth=='-1')
                  {
                        $queryGratuity=" select
                                                ifnull(sum(mas_ytd_fin.closing_dr - mas_ytd_fin.closing_cr),0) as Gratuity
                                            from
                                                mas_ytd_fin
                                            where
                                                mas_ytd_fin.proc_year = '$fYear'
                                                and mas_ytd_fin.glcode ='20401'
                                          ";
                  }
                  else
                  {
                        $queryGratuity=" select
                                                ifnull(sum(mas_ytd_fin.closing_dr - mas_ytd_fin.closing_cr),0) as Gratuity
                                            from
                                                mas_ytd_fin
                                            where
                                                mas_ytd_fin.proc_year = '$fYear'
                                                AND mas_ytd_fin.proc_month = '$fMonth'
                                                and mas_ytd_fin.glcode ='20401'
                                          ";
                  }
                   
                   $rsGratuity=mysql_query($queryGratuity)or die(mysql_error());
                   while($rowGratuity=mysql_fetch_array($rsGratuity))
                   {
                        extract($rowGratuity);
                         echo"<tr>
                                    <Td    >Gratuity & Rendundancy Fund </td>
                                    <Td    align='center'>&nbsp;</td>
                                    <Td    align='right'>".number_format(abs($Gratuity),0,'.',',')."</td>

                              </tr>";
                   }
                   
                   //Liabilities for goods & other finance
                  if($fMonth=='-1')
                  {
                        $queryotherfinance=" select
                                                note_no,
                                                trn_amount as otherfinance
                                            from
                                                mas_ytd_balance
                                            where
                                                mas_ytd_balance.proc_year = '$fYear'
                                                and mas_ytd_balance.glcode ='20500'
                                          ";
                  }
                  else
                  {
                        $queryotherfinance=" select
                                                note_no,
                                                trn_amount as otherfinance
                                            from
                                                mas_ytd_balance
                                            where
                                                mas_ytd_balance.proc_year = '$fYear'
                                                AND mas_ytd_balance.proc_month = '$fMonth'
                                                and mas_ytd_balance.glcode ='20500'
                                          ";
                  }
                    
                   $rsotherfinance=mysql_query($queryotherfinance)or die(mysql_error());
                   while($rowotherfinance=mysql_fetch_array($rsotherfinance))
                   {
                        extract($rowotherfinance);
                         echo"<tr>
                                    <Td    >Liabilities for goods & other finance</td>
                                    <Td    align='center'>$note_no</td>
                                    <Td    align='right'>".number_format(abs($otherfinance),0,'.',',')."</td>

                              </tr>";
                   }
                   
                   //Liabilities for expenses
                   
                  if($fMonth=='-1')
                  {
                              $queryexpenses=" select
                                                ifnull(sum(mas_ytd_fin.closing_dr - mas_ytd_fin.closing_cr),0) as expenses
                                            from
                                                mas_ytd_fin
                                            where
                                                mas_ytd_fin.proc_year = '$fYear'
                                                and mas_ytd_fin.glcode ='20401'
                                          ";
                  }
                  else
                  {
                        $queryexpenses=" select
                                                ifnull(sum(mas_ytd_fin.closing_dr - mas_ytd_fin.closing_cr),0) as expenses
                                            from
                                                mas_ytd_fin
                                            where
                                                mas_ytd_fin.proc_year = '$fYear'
                                                AND mas_ytd_fin.proc_month = '$fMonth'
                                                and mas_ytd_fin.glcode ='20401'
                                          ";
                  }
                    
                   $rsexpenses=mysql_query($queryexpenses)or die(mysql_error());
                   while($rowexpenses=mysql_fetch_array($rsexpenses))
                   {
                        extract($rowexpenses);
                         echo"<tr>
                                    <Td    >Liabilities for expenses </td>
                                    <Td   align='center'>&nbsp;</td>
                                    <Td   align='right'>".number_format(abs($expenses),0,'.',',')."</td>

                              </tr>";
                   }

                   //echo "$totalfund=$expenses+$otherfinance+ $Gratuity+ $curaccount+$Profit+ $retained+$equityfund";
                    $totalfund=abs($expenses)+abs($otherfinance)+ abs($Gratuity)+ abs($curaccount)+abs($Profit)+abs($retained)+abs($equityfund);
                     echo"<tr>

                                    <Td     align='right' colspan='2'>&nbsp;</td>
                                    <Td    class='total_td_e' align='right' >".number_format(abs($totalfund),0,'.',',')."</td>

                              </tr></table>";
                    

                  

      
?>

</body>
</html>
