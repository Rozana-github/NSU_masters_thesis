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
<link rel='stylesheet' type='text/css' href='Style/eng_form.css'>
<link rel='stylesheet' type='text/css' href='Style/generic_form.css'>
<link rel='stylesheet' type='text/css' href='Style/interface_styles.css' />

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


                               //echo $employeequery;

                  echo "<table width='70%' id='table1' cellspacing='0' cellpadding='0' align='center'>
                              <tr>
                                    <td class='top_l_curb'></td>
                                          <td class='top_f_cell' colspan='4'></td>
                                          <td class='top_r_curb'></td>
                                    </tr>

                              <tr>
                                    <td class='lb'></td>
                                    <Td  class='button_cell_e' colspan='4' align='center'><h5>Note-8 Sales from Printing work supplies</h5></td>
                                    <td class='rb'></td>
                              </tr>
                              <tr>
                                    <td class='lb'></td>
                                    <Td  class='title_cell_e'  align='center'>SlNo</td>
                                    <Td  class='title_cell_e'  align='center'>Description</td>
                                    <Td  class='title_cell_e'  align='center'>Monthly</td>
                                    <Td  class='title_cell_e'  align='center'>Cumulitive</td>
                                    <td class='rb'></td>
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
                                    <td class='lb'></td>
                                    <Td  class='even_td_e'  align='center'>".$i."</td>
                                    <Td  class='even_td_e'  >Sales</td>
                                    <Td  class='even_td_e'  align='right'>".number_format(abs($Sales),0,'.',',')."</td>
                                    <Td  class='even_td_e'  align='right'>".number_format(abs($cumSales),0,'.',',')."</td>
                                    <td class='rb'></td>
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
                                    <td class='lb'></td>
                                    <Td  class='even_td_e'  align='center'>".$i."</td>
                                    <Td  class='even_td_e'  >Less:Sales Return</td>
                                    <Td  class='even_td_e'  align='right'>".number_format($SalesReturn,0,'.',',')."</td>
                                    <Td  class='even_td_e'  align='right'>".number_format(abs($cumSalesReturn),0,'.',',')."</td>
                                    <td class='rb'></td>
                              </tr>";
                  
                  $total=$Sales+$SalesReturn;
                  $cumtotal=$cumSales+$cumSalesReturn;
                  
                  echo"<tr>
                                    <td class='lb'></td>
                                    <Td  class='even_td_e'  align='center'>&nbsp;</td>
                                    <Td  class='even_td_e'  >Net Sales</td>
                                    <Td  class='even_td_e'  align='right'><b>".number_format(abs($total),0,'.',',')."</b></td>
                                    <Td  class='even_td_e'  align='right'><b>".number_format(abs($cumtotal),0,'.',',')."</b></td>
                                    <td class='rb'></td>
                              </tr>";

            echo "      <tr>
                              <td class='bottom_l_curb'></td>
                              <td class='bottom_f_cell' colspan='4'></td>
                              <td class='bottom_r_curb'></td>
                        </tr>
                  </table>
                  <input type='hidden' name='txttotal' value='".abs($total)."'>
                  <input type='hidden' name='txtcumtotal' value='".abs($cumtotal)."'>
                  
                  <input type='hidden' name='txtMonth' value='$fMonth'>
                  <input type='hidden' name='txtyear' value='$fYear'>";
      
?>
<table width=100%><tr><td class='button_cell_e' align='center'>
<input type='submit' value='Process' class='forms_Button_e' >
</td></tr></table>
</body>
</html>
