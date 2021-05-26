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
<link rel='stylesheet' type='text/css' href='Style/eng_report.css'>

<link rel='stylesheet' type='text/css' href='Style/interface_styles.css' />

<script language="JavaScript" src="Script/NumberFormat.js"></script>

<script language="JavaScript" src="Script/calendar1.js"></script>

<script language='JavaScript'>


</script>

</head>

<body >

<form name='frmNotes' method='post' action='AddToNote9Process.php' target='bottomfrmForReport'>




<?PHP

      $j=0;
      $totalcall=0;

                               //echo $employeequery;

                  echo "<table width='70%' id='table1' cellspacing='0' cellpadding='0' align='center'>
                              <tr>

                                    <Td  class='button_cell_e' colspan='2' align='center'><h5>Note-9 Cost of Goods Sold</h5></td>

                              </tr>
                              <tr>

                                    <Td  class='title_cell_e_l'  align='center'>Particulars</td>
                                    <Td  class='title_cell_e'  align='center'>".date("F, Y", mktime(0, 0, 0, $fMonth,1,$fYear))."</td>


                              </tr>";


                  if($fmonth==1)
                  {
                        $privmonth=12;
                        $privyear=$fYear-1;
                  }
                  else
                  {
                        $privmonth=$fMonth-1;
                        $privyear=$fYear;
                  }
                  /*****************  start of Opening Raw Meterial      ***************/
                  $queryopeningrawmaterial="select
                                                ifnull(sum(amount),0) as OpeningRawMaterial
                                            from
                                                mas_closing_flr
                                            where
                                                flr_year = '$privyear'
                                                and flr_month = '$privmonth'

                                          ";
                  $rsopeningrawmaterial=mysql_query($queryopeningrawmaterial)or die(mysql_error());
                  while($rowopeningrawmaterial=mysql_fetch_array($rsopeningrawmaterial))
                  {
                        extract($rowopeningrawmaterial);
                        echo"<tr>

                                    <Td  class='even_left_td_e'  >Opening Raw Material on the Floor</td>
                                    <Td  class='even_td_e'  align='right'>".number_format(abs($OpeningRawMaterial),0,'.',',')."</td>

                              </tr>";

                  }
                  /*****************  start of Add:Issued from store     ***************/
                  /*$queryissuedstore="select
                                          ifnull(sum(mas_ytd_fin.month_dr - mas_ytd_fin.month_cr),0) as issuedstore
                                    from
                                          mas_ytd_fin
                                    where
                                          mas_ytd_fin.proc_year = '$fYear'
                                          AND mas_ytd_fin.proc_month = '$fMonth'
                                          and mas_ytd_fin.glcode between '10301' and '10308'
                                    ";*/
                   $queryissuedstore="select
                                          ifnull(sum(mas_ytd_fin.month_dr - mas_ytd_fin.month_cr),0) as issuedstore
                                    from
                                          mas_ytd_fin
                                    where
                                          mas_ytd_fin.proc_year = '$fYear'
                                          AND mas_ytd_fin.proc_month = '$fMonth'
                                          and mas_ytd_fin.glcode ='40203'
                                    ";
                   $rsissuedstore=mysql_query($queryissuedstore)or die(mysql_error());
                   while($rowissuedstore=mysql_fetch_array($rsissuedstore))
                   {
                        extract($rowissuedstore);
                        echo"<tr>

                                    <Td  class='even_left_td_e'  >Add: Issued from Store</td>
                                    <Td  class='even_td_e'  align='right'>".number_format(abs($issuedstore),0,'.',',')."</td>

                              </tr>";
                   }

                   $totalopening=$OpeningRawMaterial+$issuedstore;
                   echo"<tr>

                                    <Td  class='even_left_td_e'  align='center'>&nbsp;</td>
                                    <Td  class='even_td_e'  align='right'><b>".number_format(abs($totalopening),0,'.',',')."</b></td>

                              </tr>
                             ";

                   /********* Start of closing Row Materials for the Current Month Balance  **********/

                   $querycurrentrawmaterial="select
                                                      ifnull(sum(amount),0) as CurrentRawMaterial
                                                from
                                                      mas_closing_flr
                                                where
                                                      flr_year = '$fYear'
                                                      AND flr_month = '$fMonth'
                                          ";
                  $rscurrentrawmaterial=mysql_query($querycurrentrawmaterial)or die(mysql_error());
                  while($rowcurrentrawmaterial=mysql_fetch_array($rscurrentrawmaterial))
                  {
                        extract($rowcurrentrawmaterial);
                        echo"<tr>

                                    <Td  class='even_left_td_e'  >Less: Closing Raw Material on the Floor</td>
                                    <Td  class='even_td_e'  align='right'>".number_format(abs($CurrentRawMaterial),0,'.',',')."</td>

                              </tr>";

                  }
                  
                  $rawmaterialconsumption=$totalopening-$CurrentRawMaterial;
                  
                  echo"<tr>

                                    <Td  class='even_left_td_e'  >Raw Material Consumption</td>
                                    <Td  class='even_td_e'  align='right'><b>".number_format(abs($rawmaterialconsumption),0,'.',',')."</b></td>

                              </tr>
                               <tr>

                                    <Td  class='even_left_td_e'  align='center'>&nbsp;</td>
                                    <Td  class='even_td_e'  align='right'>&nbsp;</b></td>

                              </tr>";
                              
                  /*************************  Start of different charges      ******************************/
                  
                  $queryothers="SELECT
                                    mas_gl.description,
                                    mas_ytd_fin.glcode,
                                    sum(mas_ytd_fin.month_dr - mas_ytd_fin.month_cr) AS balance
                              FROM
                                    mas_ytd_fin
                                    INNER JOIN mas_gl ON mas_ytd_fin.glcode = mas_gl.gl_code
                              WHERE
                                    mas_ytd_fin.proc_year = '$fYear'
                                    AND mas_ytd_fin.proc_month = '$fMonth'
                                    and mas_ytd_fin.glcode >'40000'
                                    and mas_ytd_fin.glcode != '40203'
                                    and mas_ytd_fin.cost_code between '102' and '110'
                              group by
                                    mas_ytd_fin.glcode
                        ";
                 $otherstotal=0;
                 $rsothers=mysql_query($queryothers)or die(mysql_error());
                 while($rowothers=mysql_fetch_array($rsothers))
                 {
                        extract($rowothers);
                        echo"<tr>

                                    <Td  class='even_left_td_e'  >$description</td>
                                    <Td  class='even_td_e'  align='right'>".number_format(abs($balance),0,'.',',')."</td>

                              </tr>";
                        $otherstotal=$otherstotal+$balance;
                 }
                 /************************* Start of Production Over Head *****************************************/
                 $queryoverhead="SELECT
                                    ifnull(sum(mas_ytd_fin.month_dr - mas_ytd_fin.month_cr),0) AS Productionoverhead
                              FROM
                                    mas_ytd_fin

                              WHERE
                                    mas_ytd_fin.proc_year = '$fYear'
                                    AND mas_ytd_fin.proc_month = '$fMonth'
                                    and mas_ytd_fin.glcode >'40000'
                                    and mas_ytd_fin.cost_code = '101'

                        ";
                  $rsoverhead=mysql_query($queryoverhead)or die(mysql_error());
                  while($rowoverhead=mysql_fetch_array($rsoverhead))
                  {
                        extract($rowoverhead);
                        echo"<tr>

                                    <Td  class='even_left_td_e'  >Production Over head</td>
                                    <Td  class='even_td_e'  align='right'>".number_format(abs($Productionoverhead),0,'.',',')."</td>

                              </tr>";
                  }

                  $otherstotal=$otherstotal+$Productionoverhead;
                  echo"<tr>

                                    <Td  class='even_left_td_e'  align='center'>&nbsp;</td>
                                    <Td  class='even_td_e'  align='right'><b>".number_format(abs($otherstotal),0,'.',',')."<b></td>

                              </tr>";

                  $total1=0;      //others total+raw material consumptions
                  
                  $total1= $otherstotal+$rawmaterialconsumption;
                  echo"<tr>

                                    <Td  class='even_left_td_e'  >Total</td>
                                    <Td  class='even_td_e'  align='right'><b>".number_format(abs($total1),0,'.',',')."<b></td>

                              </tr>
                               <tr>

                                    <Td  class='even_left_td_e'  align='center'>&nbsp;</td>
                                    <Td  class='even_td_e'  align='right'>&nbsp;</b></td>

                              </tr>";
                              
                 /***************************** Opening Work-in-Progress      ***************************************/
                 
                 $queryopeningwork="select
                                                ifnull(sum(t_cost),0) as Openingwork
                                            from
                                                mas_wip
                                            where
                                                wip_year = '$privyear'
                                                AND wip_month = '$privmonth'
                                                and e_type in ('2','3')

                                          ";
                 $rsopeningwork=mysql_query($queryopeningwork)or die(mysql_error());
                 while($rowopeningwork=mysql_fetch_array($rsopeningwork))
                 {
                        extract($rowopeningwork);
                        echo"<tr>

                                    <Td  class='even_left_td_e'  >Add: Opening work-in-progress</td>
                                    <Td  class='even_td_e'  align='right'>".number_format(abs($Openingwork),0,'.',',')."</td>

                              </tr>";
                        
                 }
                 $total1=$total1+$Openingwork;
                 echo"<tr>

                                    <Td  class='even_left_td_e'  align='center'>&nbsp;</td>
                                    <Td  class='even_td_e'  align='right'><b>".number_format(abs($total1),0,'.',',')."<b></td>

                              </tr>";
                /*                 start of closing work-in-progress                    */
                $queryclosingwork="select
                                          ifnull(sum(t_cost),0) as closingwork
                                    from
                                          mas_wip
                                    where
                                          wip_year = '$fYear'
                                          AND wip_month = '$fMonth'
                                          and e_type in ('2','3')
                                    ";
                 $rsclosingwork=mysql_query($queryclosingwork)or die(mysql_error());
                 while($rowclosingwork=mysql_fetch_array($rsclosingwork))
                 {
                        extract($rowclosingwork);
                        echo"<tr>

                                    <Td  class='even_left_td_e'  >Less: Closing work-in-progress</td>
                                    <Td  class='even_td_e'  align='right'>".number_format(abs($closingwork),0,'.',',')."</td>

                              </tr>";

                 }
                 $total1=$total1-$closingwork;
                 echo"<tr>

                                    <Td  class='even_left_td_e'  >cost of production</td>
                                    <Td  class='even_td_e'  align='right'><b>".number_format(abs($total1),0,'.',',')."<b></td>

                              </tr>
                               <tr>

                                    <Td  class='even_left_td_e'  align='center'>&nbsp;</td>
                                    <Td  class='even_td_e'  align='right'>&nbsp;</b></td>

                              </tr>";

                 /********** Openting stock of F.Goods *******************/
                 
                $queryopeningstock="select
                                                ifnull(sum(t_cost),0) as Openingstock
                                            from
                                                mas_wip
                                            where
                                                wip_year = '$privyear'
                                                AND wip_month = '$privmonth'
                                                and e_type in ('1')
                                          ";
                 $rsopeningstock=mysql_query($queryopeningstock)or die(mysql_error());
                 while($rowopeningstock=mysql_fetch_array($rsopeningstock))
                 {
                        extract($rowopeningstock);
                        echo"<tr>

                                    <Td  class='even_left_td_e'  >Add: Opening stock of F.Goods</td>
                                    <Td  class='even_td_e'  align='Right'>".number_format(abs($Openingstock),0,'.',',')."</td>

                              </tr>";

                 }
                 $total1=$total1+$Openingstock;
                 echo"<tr>

                                    <Td  class='even_left_td_e'  >&nbsp;</td>
                                    <Td  class='even_td_e'  align='right'><b>".number_format(abs($total1),0,'.',',')."<b></td>

                              </tr>";


                /******************* Closing stock of F.Goods  *************************/
                
                $queryclosingstock="select
                                          ifnull(sum(t_cost),0) as closingstock
                                    from
                                          mas_wip
                                    where
                                          wip_year='$fYear'
                                          and wip_month = '$fMonth'
                                          and e_type in ('1')
                                    ";
                 $rsclosinstock=mysql_query($queryclosingstock)or die(mysql_error());
                 while($rowclosingstock=mysql_fetch_array($rsclosinstock))
                 {
                        extract($rowclosingstock);
                        echo"<tr>

                                    <Td  class='even_left_td_e'  >Less: Closing stock of F.Goods</td>
                                    <Td  class='even_td_e'  align='right'>".number_format(abs($closingstock),0,'.',',')."</td>

                              </tr>";

                 }
                 $total1=$total1-$closingstock;
                 echo"<tr>

                              <Td  class='even_left_td_e'  >cost of Goods sold</td>
                              <Td  class='even_td_e'  align='right'><b>".number_format(abs($total1),0,'.',',')."<b></td>

                        </tr>";


            echo "
                  </table>
                  ";
      
?>

</body>
</html>
