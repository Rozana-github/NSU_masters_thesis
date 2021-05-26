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
            <link type='text/css' media='print' rel='stylesheet' href='Style/print.css' />
            
            <script language='javascript'>
                  function ReportPrint()
                  {
                        print();
                  }
                  function goback()
                  {
                        window.location="RptLcPipeLineMain.php";
                  }
            </script>
      </head>
      <body class='body_e'>
            <?PHP

                        echo "
                              <table width='100%' id='table1' cellspacing='0' cellpadding='0' align='center'>
                                    <tr>
                                          <td align='center' HEIGHT='20'>
                                                <div class='hide'>
                                                      <input type='button' name='btnPrint' value='Print' onclick='ReportPrint()'>
                                                      <input type='button' name='btnPrint' value='Back' onclick='goback()'>
                                                </div>
                                          </td>
                                    </tr>
                              </table>
                        ";
                        $query="SELECT
                                          lcobjectdetailid ,
                                          mas_item.itemcode,
                                          mas_item.parent_itemcode,
                                          unitid ,
                                          rate ,
                                          reqqty ,
                                          remarks
                                    FROM
                                          trn_lc
                                          LEFT JOIN mas_item ON mas_item.itemcode = trn_lc.itemcode
                                    WHERE
                                          lcobjectid = '$Lcobject'

                              ";


                  //echo $query;
                  $rs=mysql_query($query) or die("Error: ".mysql_error());

                  if(mysql_num_rows($rs)>0)
                  {
                        drawCompanyInformation("Store Balance Report","For the Lc No ".$Lcobject);

                        echo "<table width='100%' id='table1' cellspacing='0' cellpadding='0' align='center'>
                                    <tr>
                                          <td class='title_cell_e_l' >SlNo</td>
                                          <td class='title_cell_e' >Product Name</td>
                                          <td class='title_cell_e' >Quantity</td>
                                          <td class='title_cell_e' >Unit</td>
                                          <td class='title_cell_e' >Rate</td>
                                          <td class='title_cell_e' >Remarks</td>

                                    </tr>

                                    ";
                        $i=0;
                        $totalopen=0;
                        $totalquantity=0;
                        $totalvalue=0;
                        
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

                              $mainitem=pick("mas_item","itemdescription","itemcode='$parent_itemcode'");
                              $subitem=pick("mas_item","itemdescription","itemcode='$itemcode'");
                              $units=pick("mas_unit","unitdesc","unitid='$unitid'");

                              $value=$storeqty*$purchase_rate;
                              $totalvalue+=$value;
                              $totalquantity+=$reqqty;
                              echo "<tr>
                                          <td class='$lclass' align='center'>".($i+1)."</td>
                                          <td class='$class'>".$mainitem."-".$subitem."</td>
                                          <td class='$class' align='right'>".number_format($reqqty,2,'.',',')."</td>
                                          <td class='$class' >$units</td>
                                          <td class='$class' align='right'>".number_format($rate,2,'.',',')."</td>
                                          <td class='$class' >$remarks &nbsp;</td>

                                    </tr>";
                              
                              $i++;
                        }
                        echo "<tr>
                                    <td class='td_e_b_l' colspan='2' align='right'><b>Total</b></td>
                                    <td class='$class' align='right'>".number_format($totalquantity,2,'.',',')."</td>
                                    <td class='$class' align='right' colspan='3'>&nbsp;</td>



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
