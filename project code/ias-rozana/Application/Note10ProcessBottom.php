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

<form name='frmNotes' method='post' action='AddToNote10Process.php' target='bottomfrmForReport'>




<?PHP

      $j=0;
      $totalcall=0;

                               //echo $employeequery;

                  echo "<table width='70%' id='table1' cellspacing='0' cellpadding='0' align='center'>
                              <tr>
                                    <td class='top_l_curb'></td>
                                          <td class='top_f_cell' colspan='2'></td>
                                          <td class='top_r_curb'></td>
                                    </tr>

                              <tr>
                                    <td class='lb'></td>
                                    <Td  class='button_cell_e' colspan='2' align='center'><h5>Note-9 Cost of Goods Sold</h5></td>
                                    <td class='rb'></td>
                              </tr>
                              <tr>
                                    <td class='lb'></td>
                                    <Td  class='title_cell_e'  align='center'>Particulars</td>
                                    <Td  class='title_cell_e'  align='center'>".date("F", mktime(0, 0, 0, 1,1,1))."-".date("F, Y", mktime(0, 0, 0, $fMonth,1,$fYear))."</td>

                                    <td class='rb'></td>
                              </tr>";


                  /*if($fmonth==1)
                  {
                        $privmonth=12;
                        $privyear=$fYear-1;
                  }
                  else
                  {
                        $privmonth=$fMonth-1;
                        $privyear=$fYear;
                  }*/
                  
                    $privyear=$fYear-1;
                  
                  /*****************  start of Opening  Stock      ***************/
                  $queryopeningrawmaterial="select
                                          ifnull(sum(mas_ytd_fin.closing_dr - mas_ytd_fin.closing_cr),0) as OpeningRawMaterial
                                    from
                                          mas_ytd_fin
                                    where
                                          mas_ytd_fin.proc_year = '$privyear'
                                          AND mas_ytd_fin.proc_month = '12'
                                          and mas_ytd_fin.glcode between '10301' and '10308'

                                          ";
                  $rsopeningrawmaterial=mysql_query($queryopeningrawmaterial)or die(mysql_error());
                  while($rowopeningrawmaterial=mysql_fetch_array($rsopeningrawmaterial))
                  {
                        extract($rowopeningrawmaterial);
                        echo"<tr>
                                    <td class='lb'></td>
                                    <Td  class='even_td_e'  >Opening Stock</td>
                                    <Td  class='even_td_e'  align='right'>".number_format(abs($OpeningRawMaterial),0,'.',',')."</td>
                                    <td class='rb'></td>
                              </tr>";

                  }
                  /*****************  start of Add:Purchase     ***************/
                  /*$queryPurchase="select
                                          ifnull(sum(mas_ytd_fin.closing_dr - mas_ytd_fin.closing_cr),0) as Purchase
                                    from
                                          mas_ytd_fin
                                    where
                                          mas_ytd_fin.proc_year <= '$fYear'
                                          AND mas_ytd_fin.proc_month = '$fMonth'
                                          and mas_ytd_fin.glcode between '10301' and '10308'
                                    ";
                   $rsPurchase=mysql_query($queryPurchase)or die(mysql_error());
                   while($rowPurchase=mysql_fetch_array($rsPurchase))
                   {
                        extract($rowPurchase);
                        echo"<tr>
                                    <td class='lb'></td>
                                    <Td  class='even_td_e'  >Add:Purchase</td>
                                    <Td  class='even_td_e'  align='right'>".number_format(abs($Purchase),0,'.',',')."</td>
                                    <td class='rb'></td>
                              </tr>";
                   } */
                   
                    /************* Cummalitive Consume for the given period************/

                        $queryissuedstore="select
                                          ifnull(sum(mas_ytd_fin.closing_dr - mas_ytd_fin.closing_cr),0) as issuedstore
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
                        $Consumerawmaterials=$issuedstore;
                   }
                   /************* Cummalitive Consume for the given period************/
                        $queryclosingstock="select
                                          ifnull(sum(mas_ytd_fin.closing_dr - mas_ytd_fin.closing_cr),0) as closingstock
                                    from
                                          mas_ytd_fin
                                    where
                                          mas_ytd_fin.proc_year = '$fYear'
                                          AND mas_ytd_fin.proc_month = '$fMonth'
                                          and mas_ytd_fin.glcode between '10301' and '10308'
                                    ";
                   $rsclosingstock=mysql_query($queryclosingstock)or die(mysql_error());
                   while($rowclosingstock=mysql_fetch_array($rsclosingstock))
                   {
                       extract($rowclosingstock);
                   }
                         $Purchase=($closingstock-$OpeningRawMaterial)+$Consumerawmaterials;
                         
                         echo"<tr>
                                    <td class='lb'></td>
                                    <Td  class='even_td_e'  >Add:Purchase</td>
                                    <Td  class='even_td_e'  align='right'>".number_format(abs($Purchase),0,'.',',')."</td>
                                    <td class='rb'></td>
                              </tr>";

                   $totalopening=$OpeningRawMaterial+$Purchase;
                   echo"<tr>
                                    <td class='lb'></td>
                                    <Td  class='even_td_e'  align='center'>&nbsp;</td>
                                    <Td  class='even_td_e'  align='right'><b>".number_format(abs($totalopening),0,'.',',')."</b></td>
                                    <td class='rb'></td>
                              </tr>";
                   /********** less closing stock *************************/
                    $queryclosingstock="select
                                          ifnull(sum(mas_ytd_fin.closing_dr - mas_ytd_fin.closing_cr),0) as closingstock
                                    from
                                          mas_ytd_fin
                                    where
                                          mas_ytd_fin.proc_year = '$fYear'
                                          AND mas_ytd_fin.proc_month = '$fMonth'
                                          and mas_ytd_fin.glcode between '10301' and '10308'
                                    ";
                   $rsclosingstock=mysql_query($queryclosingstock)or die(mysql_error());
                   while($rowclosingstock=mysql_fetch_array($rsclosingstock))
                   {
                       extract($rowclosingstock);
                       echo"<tr>
                                    <td class='lb'></td>
                                    <Td  class='even_td_e'  >Less: Closing Stock</td>
                                    <Td  class='even_td_e'  align='right'><b>".number_format(abs($closingstock),0,'.',',')."</b></td>
                                    <td class='rb'></td>
                              </tr>";
                   }
                   $totalopening=$totalopening-$closingstock;
                   echo"<tr>
                                    <td class='lb'></td>
                                    <Td  class='even_td_e'  align='center'>&nbsp;</td>
                                    <Td  class='even_td_e'  align='right'><b>".number_format(abs($totalopening),0,'.',',')."</b></td>
                                    <td class='rb'></td>
                              </tr>";
                    /******** Less Sales of wastage Materials *******************************/
                     /*$querywastmaterial="select
                                          ifnull(sum(mas_ytd_fin.closing_dr - mas_ytd_fin.closing_cr),0) as wastmaterial
                                    from
                                          mas_ytd_fin
                                    where
                                          mas_ytd_fin.proc_year = '$fYear'
                                          AND mas_ytd_fin.proc_month = '$fMonth'
                                          and mas_ytd_fin.glcode ='30210'
                                    ";
                   $rswastmaterial=mysql_query($querywastmaterial)or die(mysql_error());
                   while($rowwastmaterial=mysql_fetch_array($rswastmaterial))
                   {
                       extract($rowwastmaterial);
                       echo"<tr>
                                    <td class='lb'></td>
                                    <Td  class='even_td_e'  >Less: Sales of Wastage Materials</td>
                                    <Td  class='even_td_e'  align='right'><b>".number_format(abs($wastmaterial),0,'.',',')."</b></td>
                                    <td class='rb'></td>
                              </tr>";
                   } */
                    
                   $totalopening=$totalopening-$wastmaterial;
                   echo"<tr>
                                    <td class='lb'></td>
                                    <Td  class='even_td_e'  ><b>Raw Material Consumption</b></td>
                                    <Td  class='even_td_e'  align='right'><b>".number_format(abs($totalopening),0,'.',',')."</b></td>
                                    <td class='rb'></td>
                              </tr>";
                   /********* Start of closing Row Materials for the Current Month Balance  **********/

                   /*$querycurrentrawmaterial="select
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
                                    <td class='lb'></td>
                                    <Td  class='even_td_e'  >Less: Closing Raw Material on the Floor</td>
                                    <Td  class='even_td_e'  align='right'>".number_format(abs($CurrentRawMaterial),0,'.',',')."</td>
                                    <td class='rb'></td>
                              </tr>";

                  }
                  
                  $rawmaterialconsumption=$totalopening-$CurrentRawMaterial;
                  
                  echo"<tr>
                                    <td class='lb'></td>
                                    <Td  class='even_td_e'  >Raw Material Consumption</td>
                                    <Td  class='even_td_e'  align='right'><b>".number_format(abs($rawmaterialconsumption),0,'.',',')."</b></td>
                                    <td class='rb'></td>
                              </tr>";
                   */
                  /*************************  Start of different charges      ******************************/
                  
                  $queryothers="SELECT
                                    mas_gl.description,
                                    mas_ytd_fin.glcode,
                                    sum(mas_ytd_fin.closing_dr - mas_ytd_fin.closing_cr) AS balance
                              FROM
                                    mas_ytd_fin
                                    INNER JOIN mas_gl ON mas_ytd_fin.glcode = mas_gl.gl_code
                              WHERE
                                    mas_ytd_fin.proc_year <= '$fYear'
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
                                    <td class='lb'></td>
                                    <Td  class='even_td_e'  >$description</td>
                                    <Td  class='even_td_e'  align='right'>".number_format(abs($balance),0,'.',',')."</td>
                                    <td class='rb'></td>
                              </tr>";
                        $otherstotal=$otherstotal+$balance;
                 }
                 /************************* Start of Production Over Head *****************************************/
                 $queryoverhead="SELECT
                                    ifnull(sum(mas_ytd_fin.closing_dr - mas_ytd_fin.closing_cr),0) AS Productionoverhead
                              FROM
                                    mas_ytd_fin

                              WHERE
                                    mas_ytd_fin.proc_year <= '$fYear'
                                    AND mas_ytd_fin.proc_month = '$fMonth'
                                    and mas_ytd_fin.glcode >'40000'
                                    and mas_ytd_fin.cost_code = '101'

                        ";
                  $rsoverhead=mysql_query($queryoverhead)or die(mysql_error());
                  while($rowoverhead=mysql_fetch_array($rsoverhead))
                  {
                        extract($rowoverhead);
                        echo"<tr>
                                    <td class='lb'></td>
                                    <Td  class='even_td_e'  >Production Over head</td>
                                    <Td  class='even_td_e'  align='right'>".number_format(abs($Productionoverhead),0,'.',',')."</td>
                                    <td class='rb'></td>
                              </tr>";
                  }

                  $otherstotal=$otherstotal+$Productionoverhead;
                  echo"<tr>
                                    <td class='lb'></td>
                                    <Td  class='even_td_e'  align='center'>&nbsp;</td>
                                    <Td  class='even_td_e'  align='right'><b>".number_format(abs($otherstotal),0,'.',',')."<b></td>
                                    <td class='rb'></td>
                              </tr>";

                  $total1=0;      //others total+raw material consumptions
                  
                  $total1= $totalopening+$otherstotal+$rawmaterialconsumption;
                  echo"<tr>
                                    <td class='lb'></td>
                                    <Td  class='even_td_e'  >Total</td>
                                    <Td  class='even_td_e'  align='right'><b>".number_format(abs($total1),0,'.',',')."<b></td>
                                    <td class='rb'></td>
                              </tr>";
                              
                 /***************************** Opening Work-in-Progress      ***************************************/
                 
                 $queryopeningwork="select
                                          ifnull(sum(mas_ytd_fin.closing_dr - mas_ytd_fin.closing_cr),0) as Openingwork
                                    from
                                          mas_ytd_fin
                                    where
                                          mas_ytd_fin.proc_year = '$fYear'
                                          AND mas_ytd_fin.proc_month = '$fMonth'
                                          and mas_ytd_fin.glcode ='10312'

                                          ";
                 $rsopeningwork=mysql_query($queryopeningwork)or die(mysql_error());
                 while($rowopeningwork=mysql_fetch_array($rsopeningwork))
                 {
                        extract($rowopeningwork);
                        echo"<tr>
                                    <td class='lb'></td>
                                    <Td  class='even_td_e'  >Add: Opening work-in-progress</td>
                                    <Td  class='even_td_e'  align='right'>".number_format(abs($Openingwork),0,'.',',')."</td>
                                    <td class='rb'></td>
                              </tr>";
                        
                 }
                 $total1=$total1+$Openingwork;
                 echo"<tr>
                                    <td class='lb'></td>
                                    <Td  class='even_td_e'  align='center'>&nbsp;</td>
                                    <Td  class='even_td_e'  align='right'><b>".number_format(abs($total1),0,'.',',')."<b></td>
                                    <td class='rb'></td>
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
                                    <td class='lb'></td>
                                    <Td  class='even_td_e'  >Less: Closing work-in-progress</td>
                                    <Td  class='even_td_e'  align='right'>".number_format(abs($closingwork),0,'.',',')."</td>
                                    <td class='rb'></td>
                              </tr>";

                 }
                 $total1=$total1-$closingwork;
                 echo"<tr>
                                    <td class='lb'></td>
                                    <Td  class='even_td_e'  >&nbsp;</td>
                                    <Td  class='even_td_e'  align='right'><b>".number_format(abs($total1),0,'.',',')."<b></td>
                                    <td class='rb'></td>
                              </tr>";

                 /********** Openting stock of F.Goods *******************/
                 
                $queryopeningstock="select
                                          ifnull(sum(mas_ytd_fin.closing_dr - mas_ytd_fin.closing_cr),0) as Openingstock
                                    from
                                          mas_ytd_fin
                                    where
                                          mas_ytd_fin.proc_year = '$fYear'
                                          AND mas_ytd_fin.proc_month = '$fMonth'
                                          and mas_ytd_fin.glcode ='10309'
                                          ";
                 $rsopeningstock=mysql_query($queryopeningstock)or die(mysql_error());
                 while($rowopeningstock=mysql_fetch_array($rsopeningstock))
                 {
                        extract($rowopeningstock);
                        echo"<tr>
                                    <td class='lb'></td>
                                    <Td  class='even_td_e'  >Add: Opening stock of F.Goods</td>
                                    <Td  class='even_td_e'  align='Right'>".number_format(abs($Openingstock),0,'.',',')."</td>
                                    <td class='rb'></td>
                              </tr>";

                 }
                 $total1=$total1+$Openingstock;
                 echo"<tr>
                                    <td class='lb'></td>
                                    <Td  class='even_td_e'  >&nbsp;</td>
                                    <Td  class='even_td_e'  align='right'><b>".number_format(abs($total1),0,'.',',')."<b></td>
                                    <td class='rb'></td>
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
                                    <td class='lb'></td>
                                    <Td  class='even_td_e'  >Less: Closing stock of F.Goods</td>
                                    <Td  class='even_td_e'  align='right'>".number_format(abs($closingstock),0,'.',',')."</td>
                                    <td class='rb'></td>
                              </tr>";

                 }
                 $total1=$total1-$closingstock;
                 echo"<tr>
                              <td class='lb'></td>
                              <Td  class='even_td_e'  >cost of Goods sold</td>
                              <Td  class='even_td_e'  align='right'><b>".number_format(abs($total1),0,'.',',')."<b></td>
                              <td class='rb'></td>
                        </tr>";


            echo "      <tr>
                              <td class='bottom_l_curb'></td>
                              <td class='bottom_f_cell' colspan='2'></td>
                              <td class='bottom_r_curb'></td>
                        </tr>
                  </table>
                  <input type='hidden' name='txttotal' value='".abs($total1)."'>
                  <input type='hidden' name='txtMonth' value='$fMonth'>
                  <input type='hidden' name='txtyear' value='$fYear'>";
      
?>
<table width=100%><tr><td class='button_cell_e' align='center'>
<input type='submit' value='Process' class='forms_Button_e' >
</td></tr></table>
</body>
</html>
