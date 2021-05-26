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
      </head>
      <body class='body_e'>
            <?PHP
                        if($cboItem!='-1')
                        {
                        $query="SELECT
                                    mas_item.itemcode,
                                    mas_item.parent_itemcode,
                                    sum( quantity_disburse ) AS storeqty,
                                    purchase_rate
                              FROM
                                    trn_store_in
                                    LEFT JOIN mas_item ON mas_item.itemcode = trn_store_in.itemcode
                              WHERE
                                    mas_item.parent_itemcode='$cboItem'
                              GROUP BY
                                    mas_item.itemcode,purchase_rate

                              ";
                        }
                        else
                        {
                           $query="SELECT
                                    mas_item.itemcode,
                                    mas_item.parent_itemcode,
                                    sum( quantity_disburse ) AS storeqty,
                                    purchase_rate
                              FROM
                                    trn_store_in
                                    LEFT JOIN mas_item ON mas_item.itemcode = trn_store_in.itemcode

                              GROUP BY
                                    mas_item.itemcode,purchase_rate

                              ";
                        }


                  //echo $query;
                  $rs=mysql_query($query) or die("Error: ".mysql_error());

                  if(mysql_num_rows($rs)>0)
                  {
                        drawCompanyInformation("Store Balance Report","");

                        echo "<table width='100%' id='table1' cellspacing='0' cellpadding='0' align='center'>
                                    <tr>
                                          <td class='title_cell_e_l' >SlNo</td>
                                          <td class='title_cell_e' >Product Name</td>
                                          <td class='title_cell_e' >Store Quantity</td>
                                          <td class='title_cell_e' >Rate</td>
                                          <td class='title_cell_e' >Total Value</td>

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

                              $value=$storeqty*$purchase_rate;
                              $totalvalue+=$value;
                              $totalquantity+=$storeqty;
                              echo "<tr>
                                          <td class='$lclass' align='center'>".($i+1)."</td>
                                          <td class='$class'>".$mainitem."-".$subitem."</td>
                                          <td class='$class' align='right'>".number_format($storeqty,2,'.',',')."</td>
                                          <td class='$class' align='right'>".number_format($purchase_rate,2,'.',',')."</td>
                                          <td class='$class' align='right'>".number_format($value,2,'.',',')."</td>

                                    </tr>";
                              
                              $i++;
                        }
                        echo "<tr>
                                    <td class='td_e_b_l' colspan='2' align='right'><b>Total</b></td>
                                    <td class='$class' align='right'>".number_format($totalquantity,2,'.',',')."</td>
                                    <td class='$class' align='right'>&nbsp;</td>
                                    <td class='td_e_b' align='right'>".number_format($totalvalue,2,'.',',')."</td>

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
