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
                  $query="select

                                          mas_gl.gl_code,
                                          mas_gl.description As A,


                                          mas_asset.description As B,

                                          sum(trn_asset_register.purchase_qty) As C,

                                          DATE_FORMAT(trn_asset_register.purchase_date, '%d-%m-%Y') As D,
                                          sum(ifnull(TEMP.total_cost,0)) As E,
                                          sum(If(TEMP.total_cost>0,0,trn_asset_register.purchase_amount)) As F,

                                          sum(ifnull(TEMP.total_cost,0))+sum(If(TEMP.total_cost>0,0,trn_asset_register.purchase_amount)) as H,
                                          sum(TEMP.total_depreciation) As I,
                                          avg(trn_asset_register.depreciation_rate) As J,
                                          ROUND(((sum(ifnull(TEMP.total_cost,0))+trn_asset_register.purchase_amount)*avg(trn_asset_register.depreciation_rate)/100)/12) As K,

                                          sum(ifnull(TEMP.total_depreciation,0))+ROUND(((sum(ifnull(TEMP.total_cost,0))+trn_asset_register.purchase_amount)*avg(trn_asset_register.depreciation_rate)/100)/12) As M,
                                          sum(ifnull(TEMP.total_cost,0))+sum(If(TEMP.total_cost>0,0,trn_asset_register.purchase_amount))-sum(ifnull(TEMP.total_depreciation,0))-ROUND(((sum(ifnull(TEMP.total_cost,0))+trn_asset_register.purchase_amount)*avg(trn_asset_register.depreciation_rate)/100)/12) As N

                        from
                              trn_asset_register
                              LEFT JOIN mas_asset ON trn_asset_register.assetobjectid=mas_asset.assetobjectid
                              LEFT JOIN mas_gl on mas_gl.gl_code=mas_asset.gl_code
                              LEFT JOIN
                                    (
                                          select
                                                assetid,
                                                ifnull(total_cost,0)as total_cost,
                                                ifnull(total_depreciation,0)as total_depreciation
                                          from
                                                trn_asset_depreciation
                                          where
                                                trn_asset_depreciation.proc_year=$PYear AND trn_asset_depreciation.proc_month=$PMonth
                                    )AS TEMP ON trn_asset_register.assetid=TEMP.assetid
                        where
                              trn_asset_register.purchase_date < LAST_DAY(STR_TO_DATE(CONCAT('1','-',$cboMonth,'-',$cboYear),'%e-%c-%Y'))
                        group by
                              mas_gl.gl_code
                        order by
                              mas_gl.gl_code";


                  //echo $query;
                  $rs=mysql_query($query) or die("Error: ".mysql_error());

                  if(mysql_num_rows($rs)>0)
                  {
                        drawCompanyInformation("Fixed Assets Summary Register","For the period of ".date("F, Y", mktime(0, 0, 0, $cboMonth,1,$cboYear)));

                        echo "<table width='100%' id='table1' cellspacing='0' cellpadding='0' align='center'>
                                    <tr>
                                          <td class='title_cell_e' colspan='3'>Name of Assets</td>

                                          <td class='title_cell_e'>Cost of Assets</td>
                                          <td class='title_cell_e'>Additional Cost</td>
                                          <td class='title_cell_e'>Sales/Adjusted</td>
                                          <td class='title_cell_e'>Total Cost of Assets</td>
                                          <td class='title_cell_e'>Depreciation</td>
                                          <td class='title_cell_e'>%</td>
                                          <td class='title_cell_e'>Deprciation for the Period</td>
                                          <td class='title_cell_e'>Depreciation Adjusted</td>
                                          <td class='title_cell_e'>Total Depreciation</td>
                                          <td class='title_cell_e'>Written Down Value</td>
                                    </tr>
                              ";
                        $i=0;

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


                               echo "<tr>
                                                        <td class='$lclass' align='left' colspan='3'><b>$A ($gl_code)</td>
                                                        <td class='$class' align='right'><b>".number_format($E,2,'.',',')."</td>
                                                        <td class='$class' align='right'><b>".number_format($F,2,'.',',')."</td>
                                                        <td class='$class' align='right'><b>".number_format($G,2,'.',',')."</td>
                                                        <td class='$class' align='right'><b>".number_format($H,2,'.',',')."</td>
                                                        <td class='$class' align='right'><b>".number_format($I,2,'.',',')."</td>
                                                        <td class='$class' align='right'><b>".number_format($J,2,'.',',')."</td>
                                                        <td class='$class' align='right'><b>".number_format($K,2,'.',',')."</td>
                                                        <td class='$class' align='right'><b>".number_format($L,2,'.',',')."</td>
                                                        <td class='$class' align='right'><b>".number_format($M,2,'.',',')."</td>
                                                        <td class='$class' align='right'><b>".number_format($N,2,'.',',')."</td>
                                                       </tr>";


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


                              $i++;
                        }


                                                echo "<tr>
                                                        <td class='$lclass' align='left' colspan='3'><b>Grand Total</td>
                                                        <td class='$class' align='right'><b>".number_format($ETOT,2,'.',',')."</td>
                                                        <td class='$class' align='right'><b>".number_format($FTOT,2,'.',',')."</td>
                                                        <td class='$class' align='right'><b>".number_format($GTOT,2,'.',',')."</td>
                                                        <td class='$class' align='right'><b>".number_format($HTOT,2,'.',',')."</td>
                                                        <td class='$class' align='right'><b>".number_format($ITOT,2,'.',',')."</td>
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
