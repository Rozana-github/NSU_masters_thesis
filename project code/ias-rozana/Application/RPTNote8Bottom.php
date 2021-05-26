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

<form name='frmNotes' method='post' action='AddToNote8Process.php' target='bottomfrmForReport'>




<?PHP

      $i=0;
      $total=0;


                 if($fMonth=='-1')
                        drawCompanyInformation("","For the Year ended ".date("Y", mktime(0, 0, 0, 1,1,$fYear)));
                 else
                        drawCompanyInformation("","For the Month ended ".date("F, Y", mktime(0, 0, 0, $fMonth,1,$fYear)));

                  echo "<table width='70%' id='table1' cellspacing='0' cellpadding='0' align='center'>

                              <tr>

                                    <Td   colspan='3' ><h5>Note-8 Sales from Printing work supplies</h5></td>

                              </tr>
                              <tr>

                                    <Td  class='title_cell_e_l'  align='center'>SlNo</td>
                                    <Td  class='title_cell_e'  align='center'>Description</td>
                                    <Td  class='title_cell_e'  align='center'>Monthly</td>
                                    <Td  class='title_cell_e'  align='center'>Cumulitive</td>

                              </tr>";



                   /*****************  Sales of the Month      ***************/
                  $queryopeningrawmaterial="select
                                                ifnull(sum(mas_ytd_fin.month_dr - mas_ytd_fin.month_cr),0) as Sales
                                            from
                                                mas_ytd_fin
                                            where
                                                mas_ytd_fin.proc_year = '$fYear'
                                                AND mas_ytd_fin.proc_month = '$fMonth'
                                                and mas_ytd_fin.glcode in ('30101','30102')
                                          ";
                  $rsopeningrawmaterial=mysql_query($queryopeningrawmaterial)or die(mysql_error());
                  while($rowopeningrawmaterial=mysql_fetch_array($rsopeningrawmaterial))
                  {
                        extract($rowopeningrawmaterial);
                        $i++;


                  }
                  $queryopeningrawmaterial="select
                                                ifnull(sum(mas_ytd_fin.closing_dr - mas_ytd_fin.closing_cr),0) as cumSales
                                            from
                                                mas_ytd_fin
                                            where
                                                mas_ytd_fin.proc_year = '$fYear'
                                                AND mas_ytd_fin.proc_month = '$fMonth'
                                                and mas_ytd_fin.glcode in ('30101','30102')
                                          ";
                  $rsopeningrawmaterial=mysql_query($queryopeningrawmaterial)or die(mysql_error());
                  while($rowopeningrawmaterial=mysql_fetch_array($rsopeningrawmaterial))
                  {
                        extract($rowopeningrawmaterial);



                  }
                  echo"<tr>

                                    <Td   align='center'>".$i."</td>
                                    <Td    >Sales</td>
                                    <Td   align='right'>".number_format(abs($Sales),0,'.',',')."</td>
                                    <Td    align='right'>".number_format(abs($cumSales),0,'.',',')."</td>

                              </tr>";
                  /*****************  start of VAT Paid     ***************/
                  /*$queryissuedstore="select
                                          ifnull(sum(mas_ytd_fin.closing_dr - mas_ytd_fin.closing_cr),0) as VAT
                                    from
                                          mas_ytd_fin
                                    where
                                          mas_ytd_fin.proc_year = '$fYear'
                                          AND mas_ytd_fin.proc_month = '$fMonth'
                                          and mas_ytd_fin.glcode = '10601'
                                    ";
                   $rsissuedstore=mysql_query($queryissuedstore)or die(mysql_error());
                   while($rowissuedstore=mysql_fetch_array($rsissuedstore))
                   {
                        extract($rowissuedstore);

                   }
                   $i++;
                        echo"<tr>
                                    <td class='lb'></td>
                                    <Td  class='even_td_e'  align='center'>".$i."</td>
                                    <Td  class='even_td_e'  >VAT Paid</td>
                                    <Td  class='even_td_e'  align='right'>".number_format(abs($VAT),0,'.',',')."</td>
                                    <td class='rb'></td>
                              </tr>"; */

                   //$total=$Sales-$VAT;
                   /*echo"<tr>
                                    <td class='lb'></td>
                                    <Td  class='even_td_e'  align='center'>&nbsp;</td>
                                    <Td  class='even_td_e'  align='center'>&nbsp;</td>
                                    <Td  class='even_td_e'  align='right'><b>".number_format(abs($total),0,'.',',')."</b></td>
                                    <td class='rb'></td>
                              </tr>";*/

                   /********* Start of Less:Sales Return  **********/

                   $querycurrentrawmaterial="select
                                                ifnull(sum(mas_ytd_fin.month_dr - mas_ytd_fin.month_cr),0) as SalesReturn
                                            from
                                                mas_ytd_fin
                                            where
                                                mas_ytd_fin.proc_year = '$fYear'
                                                AND mas_ytd_fin.proc_month = '$fMonth'
                                                and mas_ytd_fin.glcode = '30201'
                                          ";
                  $rscurrentrawmaterial=mysql_query($querycurrentrawmaterial)or die(mysql_error());
                  while($rowcurrentrawmaterial=mysql_fetch_array($rscurrentrawmaterial))
                  {
                        extract($rowcurrentrawmaterial);


                  }
                  $querycurrentrawmaterial="select
                                                ifnull(sum(mas_ytd_fin.closing_dr - mas_ytd_fin.closing_cr),0) as cumSalesReturn
                                            from
                                                mas_ytd_fin
                                            where
                                                mas_ytd_fin.proc_year = '$fYear'
                                                AND mas_ytd_fin.proc_month = '$fMonth'
                                                and mas_ytd_fin.glcode = '30201'
                                          ";
                  $rscurrentrawmaterial=mysql_query($querycurrentrawmaterial)or die(mysql_error());
                  while($rowcurrentrawmaterial=mysql_fetch_array($rscurrentrawmaterial))
                  {
                        extract($rowcurrentrawmaterial);


                  }
                  $i++;
                        echo"<tr>

                                    <Td    align='center'>".$i."</td>
                                    <Td    >Less:Sales Return</td>
                                    <Td    align='right'>".number_format($SalesReturn,0,'.',',')."</td>
                                    <Td    align='right'>".number_format(abs($cumSalesReturn),0,'.',',')."</td>

                              </tr>";

                  $total=$Sales+$SalesReturn;
                  $cumtotal=$cumSales+$cumSalesReturn;

                  echo"<tr>

                                    <Td    align='center'>&nbsp;</td>
                                    <Td    >Net Sales</td>
                                    <Td    align='right'><b>".number_format(abs($total),0,'.',',')."</b></td>
                                    <Td    align='right'><b>".number_format(abs($cumtotal),0,'.',',')."</b></td>

                              </tr>";

            echo "
                  </table>
                  ";
      
?>

</body>
</html>
