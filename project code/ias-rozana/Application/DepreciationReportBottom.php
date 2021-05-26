<?PHP
      include "Library/dbconnect.php";
      include "Library/Library.php";
      include "Library/SessionValidate.php";
?>

<html>
      <head>
            <meta http-equiv='Content-Type' content='text/html; charset=windows-1252'>
            <title>Invoice Posting</title>
            <link href='Style/generic_report.css' type='text/css' rel='stylesheet' />
            <link href='Style/eng_report.css' type='text/css' rel='stylesheet' />
      </head>
      <body class='body_e'>
          <?PHP

            //Initialize Previous Processed Period
            if($cboMonth==1){$PYear=$cboYear-1;}else{$PYear=$cboYear;}
            //$PYear=$cboYear-1;
            if($cboMonth==1){$PMonth=12;}else{$PMonth=$cboMonth-1;}
            //////////////
                           /*

                           ROUND(((ifnull(TEMP.total_cost,0)+trn_asset_register.purchase_amount)*trn_asset_register.depreciation_rate/100)/12) As K,

                                          ifnull(TEMP.total_depreciation,0)+ROUND(((ifnull(TEMP.total_cost,0)+trn_asset_register.purchase_amount)*trn_asset_register.depreciation_rate/100)/12) As M,
                                          ifnull(TEMP.total_cost,0)+If(TEMP.total_cost>0,0,trn_asset_register.purchase_amount)-ifnull(TEMP.total_depreciation,0)-ROUND(((ifnull(TEMP.total_cost,0)+trn_asset_register.purchase_amount)*trn_asset_register.depreciation_rate/100)/12) As N,
                                          (ifnull(TEMP.total_cost,0)+If(TEMP.total_cost>0,0,trn_asset_register.purchase_amount)*(trn_asset_register.depreciation_rate/100))/12 as O

                           */
                           $query="select
                                          trn_asset_register.assetid,
                                          mas_gl.gl_code,
                                          mas_gl.description As A,

                                          mas_asset.assetobjectid,
                                          mas_asset.description As B,

                                          trn_asset_register.purchase_qty As C,

                                          DATE_FORMAT(trn_asset_register.purchase_date, '%d-%m-%Y') As D,
                                          ifnull(TEMP.total_cost,0) As E,
                                          If(year(trn_asset_register.purchase_date)=$cboYear,trn_asset_register.purchase_amount,0) As F,
                                          TEMP1.total_sales As G,
                                          ifnull(TEMP.total_cost,0)+If(TEMP.total_cost>0,0,trn_asset_register.purchase_amount) as H,
                                          If($cboMonth=1,TEMP.total_depreciation,(TEMP.total_depreciation-TEMP.current_depreciation)) As I,
                                          trn_asset_register.depreciation_rate As J,
                                          If($cboMonth=1,0,TEMP.current_depreciation) As K,
                                          TEMP1.total_dep_adjust As L
                                    from
                                          trn_asset_register
                                          LEFT JOIN mas_asset ON trn_asset_register.assetobjectid=mas_asset.assetobjectid
                                          LEFT JOIN mas_gl on mas_gl.gl_code=mas_asset.gl_code
                                          LEFT JOIN
                                                   (
                                                      select
                                                            assetid,
                                                            ifnull(total_cost,0)as total_cost,
                                                            total_depreciation as total_depreciation,
                                                            opening_depreciation,
                                                            current_depreciation

                                                      from
                                                            trn_asset_depreciation
                                                      where
                                                            trn_asset_depreciation.proc_year=$PYear AND trn_asset_depreciation.proc_month=$PMonth
                                                   )AS TEMP ON trn_asset_register.assetid=TEMP.assetid
                                          LEFT JOIN
                                                                                                 (
                                                                                                        select
                                                                                                                  assetid,
                                                                                                                  sales_amount as total_sales,
                                                                                                                  depreciation_adjust as total_dep_adjust
                                                                                                        from
                                                                                                                  trn_asset_disposal
                                                                                                        where
                                                                                                                  year(trn_asset_disposal.sales_date)=$cboYear
                                                   )AS TEMP1 ON trn_asset_register.assetid=TEMP1.assetid
                                    where
                                          trn_asset_register.purchase_date <= LAST_DAY(STR_TO_DATE(CONCAT('1','-',$cboMonth,'-',$cboYear),'%e-%c-%Y'))
                                    order by
                                          mas_gl.gl_code,trn_asset_register.purchase_date
                                    ";
                                        // trn_asset_depreciation.sales_adjust As G,

                  //      die($query);
                  //echo $query;
                  $rs=mysql_query($query) or die("Error: ".mysql_error());

                  if(mysql_num_rows($rs)>0)
                  {
                        drawCompanyInformation("Fixed Assets Register","For the period of ".date("F, Y", mktime(0, 0, 0, $cboMonth,1,$cboYear)));

                        $querylastday="select LAST_DAY(STR_TO_DATE(CONCAT('1','-',$cboMonth,'-',$cboYear),'%e-%c-%Y')) as lastdateofmonth from dual ";

                        $rslastday=mysql_query($querylastday)or die(mysql_error());
                        while($rowlastday=mysql_fetch_array($rslastday))
                        {
                                extract($rowlastday);
                               $lastday=explode("-",$lastdateofmonth);
                        }

                        echo "        <FORM method='POST' action='ins_deprec.php'>
                                        <table width='100%' id='table1' cellspacing='0' cellpadding='0' align='center'>
                                    <tr>
                                          <td class='title_cell_e'>Name of Assets</td>
                                          <td class='title_cell_e'>Qty</td>
                                          <td class='title_cell_e'>Purchase Date</td>
                                          <td class='title_cell_e'>Cost of Assets 01-01-".($cboYear)."</td>
                                          <td class='title_cell_e'>Additional Cost</td>
                                          <td class='title_cell_e'>Sales/ Adjusted</td>
                                          <td class='title_cell_e'>Total Cost of Assets</td>
                                          <td class='title_cell_e'>Depreci. Upto 01-01-".($cboYear)."</td>
                                          <td class='title_cell_e'>Depreci. for the Month ".date("F, Y", mktime(0, 0, 0, $cboMonth,1,$cboYear))."</td>
                                          <td class='title_cell_e'>%</td>
                                          <td class='title_cell_e'>Deprciation for the Period</td>
                                          <td class='title_cell_e'>Depreci. Adjusted</td>
                                          <td class='title_cell_e'>Total Depreciation upto $lastday[2]-$lastday[1]-$lastday[0]</td>
                                          <td class='title_cell_e'>Written Down Value</td>
                                    </tr>
                              ";
                        $i=0;
                        $grouphead='';
                        //Sub Total Variable
                        $ESUB=0;
                        $FSUB=0;
                        $GSUB=0;
                        $HSUB=0;
                        $ISUB=0;
                        $JSUB=0;
                        $KSUB=0;
                        $LSUB=0;
                        $MSUB=0;
                        $NSUB=0;
                        $OSUB=0;
                                                /////////////////////////
                                                //Grand Total Variable
                        $ETOT=0;
                        $FTOT=0;
                        $GTOT=0;
                        $HTOT=0;
                        $ITOT=0;
                        $JTOT=0;
                        $KTOT=0;
                        $LTOT=0;
                        $MTOT=0;
                        $NTOT=0;
                        $OTOT=0;
                                                /////////////////////////
                        while($row=mysql_fetch_array($rs))
                        {
                              extract($row);
                              $O=round(($H*($J/100))/12);
                              $K=$K+$O;
                              $M=$K+$I;
                              $N=$H-$M;
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

                              if ($grouphead!=$A)
                              {
                                    if ($i>0)
                                    {
                                          echo "<tr>
                                                      <td class='$lclass' align='left' colspan='3'><font size='1'><b>Total</td>
                                                      <td class='$class' align='right'><font size='1'><b>".number_format($ESUB,2,'.',',')."</td>
                                                      <td class='$class' align='right'><font size='1'><b>".number_format($FSUB,2,'.',',')."</td>
                                                      <td class='$class' align='right'><font size='1'><b>".number_format($GSUB,2,'.',',')."</td>
                                                      <td class='$class' align='right'><font size='1'><b>".number_format($HSUB,2,'.',',')."</td>
                                                      <td class='$class' align='right'><font size='1'><b>".number_format($ISUB,2,'.',',')."</td>
                                                      <td class='$class' align='right'><font size='1'><b>".number_format($OSUB,2,'.',',')."</td>
                                                      <td class='$class' align='right'><font size='1'><b>".number_format($JSUB,2,'.',',')."</td>
                                                      <td class='$class' align='right'><font size='1'><b>".number_format($KSUB,2,'.',',')."</td>
                                                      <td class='$class' align='right'><font size='1'><b>".number_format($LSUB,2,'.',',')."</td>
                                                      <td class='$class' align='right'><font size='1'><b>".number_format($MSUB,2,'.',',')."</td>
                                                      <td class='$class' align='right'><font size='1'><b>".number_format($NSUB,2,'.',',')."</td>

                                                </tr>";
                                                $ESUB=0;
                                                $FSUB=0;
                                                $GSUB=0;
                                                $HSUB=0;
                                                $ISUB=0;
                                                $JSUB=0;
                                                $KSUB=0;
                                                $LSUB=0;
                                                $MSUB=0;
                                                $NSUB=0;
                                                $OSUB=0;
                                    }

                                          echo "<tr>
                                                      <td class='$lclass' align='left' colspan='14'><b>$A ($gl_code)</td>
                                                </tr>";
                                                $grouphead=$A;
                              }




                              echo "<tr>
                                          <td class='$lclass' align='left'>$B</td>
                                          <td class='$class'>$C</td>
                                          <td class='$class'>$D</td>
                                          <td class='$class' align='right'>".number_format($E,2,'.',',')."</td>
                                          <td class='$class' align='right'>".number_format($F,2,'.',',')."</td>
                                          <td class='$class' align='right'>".number_format($G,2,'.',',')."</td>
                                          <td class='$class' align='right'>".number_format($H,2,'.',',')."</td>
                                          <td class='$class' align='right'>".number_format($I,2,'.',',')."</td>
                                          <td class='$class' align='right'>".number_format($O,2,'.',',')."</td>
                                          <td class='$class' align='right'>".number_format($J,2,'.',',')."</td>
                                          <td class='$class' align='right'>".number_format($K,2,'.',',')."</td>
                                          <td class='$class' align='right'>".number_format($L,2,'.',',')."</td>
                                          <td class='$class' align='right'>".number_format($M,2,'.',',')."</td>
                                          <td class='$class' align='right'>".number_format($N,2,'.',',')."</td>

                                    </tr>";
                              /*echo "<input type='hidden' value='".$assetid."' name='ASSETID[".$i."]'>";
                              echo "<input type='hidden' value='".$A."' name='A[".$i."]'>";
                              echo "<input type='hidden' value='".$B."' name='B[".$i."]'>";
                              echo "<input type='hidden' value='".$C."' name='C[".$i."]'>";
                              echo "<input type='hidden' value='".$D."' name='D[".$i."]'>";
                              echo "<input type='hidden' value='".$E."' name='E[".$i."]'>";
                              echo "<input type='hidden' value='".$F."' name='F[".$i."]'>";
                              echo "<input type='hidden' value='".$G."' name='G[".$i."]'>";
                              echo "<input type='hidden' value='".$H."' name='H[".$i."]'>";
                              echo "<input type='hidden' value='".$I."' name='I[".$i."]'>";
                              echo "<input type='hidden' value='".$J."' name='J[".$i."]'>";
                              echo "<input type='hidden' value='".$K."' name='K[".$i."]'>";
                              echo "<input type='hidden' value='".$L."' name='L[".$i."]'>";
                              echo "<input type='hidden' value='".$M."' name='M[".$i."]'>";
                              echo "<input type='hidden' value='".$N."' name='N[".$i."]'>";
                              echo "<input type='hidden' value='".$O."' name='O[".$i."]'>";

                               */

                                                //Sub Total//
                              $ESUB=$ESUB+$E;
                              $FSUB=$FSUB+$F;
                              $GSUB=$GSUB+$G;
                              $HSUB=$HSUB+$H;
                              $ISUB=$ISUB+$I;
                              $JSUB=$JSUB+$J;
                              $KSUB=$KSUB+$K;
                              $LSUB=$LSUB+$L;
                              $MSUB=$MSUB+$M;
                              $NSUB=$NSUB+$N;
                              $OSUB=$OSUB+$O;
                                                //////////////
                                                //Grand Total//
                              $ETOT=$ETOT+$E;
                              $FTOT=$FTOT+$F;
                              $GTOT=$GTOT+$G;
                              $HTOT=$HTOT+$H;
                              $ITOT=$ITOT+$I;
                              $JTOT=$JTOT+$J;
                              $KTOT=$KTOT+$K;
                              $LTOT=$LTOT+$L;
                              $MTOT=$MTOT+$M;
                              $NTOT=$NTOT+$N;
                              $OTOT=$OTOT+$O;
                                                //////////////

                              $i++;
                        }
                        echo "<tr>
                                    <td class='$lclass' align='left' colspan='3'><b><font size='1'> Total</td>
                                    <td class='$class' align='right'><font size='1'><b>".number_format($ESUB,2,'.',',')."</td>
                                    <td class='$class' align='right'><font size='1'><b>".number_format($FSUB,2,'.',',')."</td>
                                    <td class='$class' align='right'><font size='1'><b>".number_format($GSUB,2,'.',',')."</td>
                                    <td class='$class' align='right'><font size='1'><b>".number_format($HSUB,2,'.',',')."</td>
                                    <td class='$class' align='right'><font size='1'><b>".number_format($ISUB,2,'.',',')."</td>
                                    <td class='$class' align='right'><font size='1'><b>".number_format($OSUB,2,'.',',')."</td>
                                    <td class='$class' align='right'><font size='1'><b>".number_format($JSUB,2,'.',',')."</td>
                                    <td class='$class' align='right'><font size='1'><b>".number_format($KSUB,2,'.',',')."</td>
                                    <td class='$class' align='right'><font size='1'><b>".number_format($LSUB,2,'.',',')."</td>
                                    <td class='$class' align='right'><font size='1'><b>".number_format($MSUB,2,'.',',')."</td>
                                    <td class='$class' align='right'><font size='1'><b>".number_format($NSUB,2,'.',',')."</td>

                              </tr>";

                        echo "<tr>
                                    <td class='$lclass' align='left' colspan='3'><b><font size='1'>Grand Total</td>
                                    <td class='$class' align='right'><font size='1'><b>".number_format($ETOT,2,'.',',')."</td>
                                    <td class='$class' align='right'><font size='1'><b>".number_format($FTOT,2,'.',',')."</td>
                                    <td class='$class' align='right'><font size='1'><b>".number_format($GTOT,2,'.',',')."</td>
                                    <td class='$class' align='right'><font size='1'><b>".number_format($HTOT,2,'.',',')."</td>
                                    <td class='$class' align='right'><font size='1'><b>".number_format($ITOT,2,'.',',')."</td>
                                    <td class='$class' align='right'><font size='1'><b>".number_format($OTOT,2,'.',',')."</td>
                                    <td class='$class' align='right'><font size='1'><b>".number_format($JTOT,2,'.',',')."</td>
                                    <td class='$class' align='right'><font size='1'><b>".number_format($KTOT,2,'.',',')."</td>
                                    <td class='$class' align='right'><font size='1'><b>".number_format($LTOT,2,'.',',')."</td>
                                    <td class='$class' align='right'><font size='1'><b>".number_format($MTOT,2,'.',',')."</td>
                                    <td class='$class' align='right'><font size='1'><b>".number_format($NTOT,2,'.',',')."</td>

                              </tr>";

                        echo "<input type='hidden' value='".$i."' name='counter'>";
                        echo "<input type='hidden' value='".$cboYear."' name='proc_year'>";
                        echo "<input type='hidden' value='".$cboMonth."' name='proc_month'>";
                        echo "</table> </FORM>";
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
