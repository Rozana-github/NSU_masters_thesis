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
            if($cboMonth==1){$PYear=$cboYear-1;}else{$PYear=$cboYear;}
            if($cboMonth==1){$PMonth=12;}else{$PMonth=$cboMonth-1;}
            
            /*

                              AND
            */
                  if($cboMonth != '-1')
                  {
                  $query="SELECT
                              mas_gl.gl_code,
                              mas_gl.description As A,
                              proc_month,
                              sum( trn_asset_depreciation.`opening_cost` ) As E,
                              sum( trn_asset_depreciation.`addition_cost` ) As F ,
                              sum( trn_asset_depreciation.`sales_adjust` ) As G ,
                              sum( trn_asset_depreciation.`total_cost` )As H ,
                              sum( trn_asset_depreciation.`opening_depreciation` ) As I ,
                              avg( trn_asset_depreciation.`depreciation_rate` ) As J ,
                              sum( trn_asset_depreciation.`current_depreciation` ) As K ,
                              sum( trn_asset_depreciation.`depreication_adjust` ) As L ,
                              sum( trn_asset_depreciation.`total_depreciation` ) As M ,
                              sum( trn_asset_depreciation.`wdv` ) as N,
                              sum(trn_asset_depreciation.dep_for_month) as O
                        FROM
                              `trn_asset_depreciation`
                              INNER JOIN trn_asset_register ON trn_asset_register.assetid = trn_asset_depreciation.assetid
                              INNER JOIN mas_asset ON trn_asset_register.assetobjectid = mas_asset.assetobjectid
                              INNER JOIN mas_gl ON mas_gl.gl_code = mas_asset.gl_code
                        WHERE
                              `proc_year` ='$cboYear' and
                              `proc_month` ='$cboMonth'
                        GROUP BY mas_gl.gl_code
                        ";
                  }
                  else
                  {
                        $query="SELECT
                              mas_gl.gl_code,
                              mas_gl.description As A,
                              proc_month,
                              sum( trn_asset_depreciation.`opening_cost` ) As E,
                              sum( trn_asset_depreciation.`addition_cost` ) As F ,
                              sum( trn_asset_depreciation.`sales_adjust` ) As G ,
                              sum( trn_asset_depreciation.`total_cost` )As H ,
                              sum( trn_asset_depreciation.`opening_depreciation` ) As I ,
                              avg( trn_asset_depreciation.`depreciation_rate` ) As J ,
                              sum( trn_asset_depreciation.`current_depreciation` ) As K ,
                              sum( trn_asset_depreciation.`depreication_adjust` ) As L ,
                              sum( trn_asset_depreciation.`total_depreciation` ) As M ,
                              sum( trn_asset_depreciation.`wdv` ) as N,
                              sum(trn_asset_depreciation.dep_for_month) as O
                        FROM
                              `trn_asset_depreciation`
                              INNER JOIN trn_asset_register ON trn_asset_register.assetid = trn_asset_depreciation.assetid
                              INNER JOIN mas_asset ON trn_asset_register.assetobjectid = mas_asset.assetobjectid
                              INNER JOIN mas_gl ON mas_gl.gl_code = mas_asset.gl_code
                        WHERE
                              `proc_year` ='$cboYear'

                        GROUP BY
                                mas_gl.gl_code,proc_month
                        ";
                  }


                  //echo $query;
                  $rs=mysql_query($query) or die("Error: ".mysql_error());

                  if(mysql_num_rows($rs)>0)
                  {
                        drawCompanyInformation("Fixed Assets Summary Register","For the period of ".date("F, Y", mktime(0, 0, 0, $cboMonth,1,$cboYear)));
                        $querylastday="select LAST_DAY(STR_TO_DATE(CONCAT('1','-',$cboMonth,'-',$cboYear),'%e-%c-%Y')) as lastdateofmonth from dual ";

                        $rslastday=mysql_query($querylastday)or die(mysql_error());
                        while($rowlastday=mysql_fetch_array($rslastday))
                        {
                                extract($rowlastday);
                               $lastday=explode("-",$lastdateofmonth);
                        }

                                echo "<table width='100%' id='table1' cellspacing='0' cellpadding='0' align='center'>
                                    <tr>
                                          <td class='title_cell_e' >Name of Assets</td>
                                          <td class='title_cell_e' >Month</td>

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
                              if($cboMonth=='-1')
                              {
                              if ($grouphead!=$A)
                              {
                                    if ($i>0)
                                    {
                                          echo "<tr>
                                                      <td class='$lclass' align='left' colspan='2'><font size='1'><b>Total</td>
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

                                          /*echo "<tr>
                                                      <td class='$lclass' align='left' colspan='13'><b>$A ($gl_code)</td>
                                                </tr>"; */
                                                $grouphead=$A;
                              }
                              }

                               echo "<tr>
                                                        <td class='$lclass' align='left' ><b>$A ($gl_code)</td>
                                                        <td class='$class' align='left' ><b>$proc_month-$cboYear</td>
                                                        <td class='$class' align='right'><b>".number_format($E,2,'.',',')."</td>
                                                        <td class='$class' align='right'><b>".number_format($F,2,'.',',')."</td>
                                                        <td class='$class' align='right'><b>".number_format($G,2,'.',',')."</td>
                                                        <td class='$class' align='right'><b>".number_format($H,2,'.',',')."</td>
                                                        <td class='$class' align='right'><b>".number_format($I,2,'.',',')."</td>
                                                        <td class='$class' align='right'><b>".number_format($O,2,'.',',')."</td>
                                                        <td class='$class' align='right'><b>".number_format($J,2,'.',',')."</td>
                                                        <td class='$class' align='right'><b>".number_format($K,2,'.',',')."</td>
                                                        <td class='$class' align='right'><b>".number_format($L,2,'.',',')."</td>
                                                        <td class='$class' align='right'><b>".number_format($M,2,'.',',')."</td>
                                                        <td class='$class' align='right'><b>".number_format($N,2,'.',',')."</td>
                                                       </tr>";

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


                              $i++;
                        }
                         if($cboMonth=='-1')
                        {
                         echo "<tr>
                                                      <td class='$lclass' align='left' colspan='2'><font size='1'><b>Total</td>
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
                                        }

                                                echo "<tr>
                                                        <td class='$lclass' align='left' colspan='2' ><b>Grand Total</td>
                                                        <td class='$class' align='right'><b>".number_format($ETOT,2,'.',',')."</td>
                                                        <td class='$class' align='right'><b>".number_format($FTOT,2,'.',',')."</td>
                                                        <td class='$class' align='right'><b>".number_format($GTOT,2,'.',',')."</td>
                                                        <td class='$class' align='right'><b>".number_format($HTOT,2,'.',',')."</td>
                                                        <td class='$class' align='right'><b>".number_format($ITOT,2,'.',',')."</td>
                                                        <td class='$class' align='right'><b>".number_format($OTOT,2,'.',',')."</td>
                                                        <td class='$class' align='right'><b>".number_format($JTOT,2,'.',',')."</td>
                                                        <td class='$class' align='right'><b>".number_format($KTOT,2,'.',',')."</td>
                                                        <td class='$class' align='right'><b>".number_format($LTOT,2,'.',',')."</td>
                                                        <td class='$class' align='right'><b>".number_format($MTOT,2,'.',',')."</td>
                                                        <td class='$class' align='right'><b>".number_format($NTOT,2,'.',',')."</td>
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
