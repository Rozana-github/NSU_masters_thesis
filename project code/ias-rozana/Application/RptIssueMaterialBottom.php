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

                        $query="SELECT
                                    mas_item.itemcode ,
                                    mas_item.parent_itemcode,
                                    issueditem,
                                    sum( issue_quantity ) as issuedqty

                              FROM
                                    trn_store_out
                                    LEFT JOIN mas_item ON mas_item.itemcode = trn_store_out.itemcode

                              WHERE
                                    issue_date = STR_TO_DATE('$cboDay-$cboMonth-$cboYear','%e-%c-%Y')
                              GROUP BY
                                    mas_item.itemcode

                              ";


                  //echo $query;
                  $rs=mysql_query($query) or die("Error: ".mysql_error());

                  if(mysql_num_rows($rs)>0)
                  {
                        drawCompanyInformation("Material Issue Report","For the Date of ".date("jS F, Y", mktime(0, 0, 0, $cboMonth,$cboDay,$cboYear)));

                        echo "<table width='100%' id='table1' cellspacing='0' cellpadding='0' align='center'>
                                    <tr>
                                          <td class='title_cell_e_l' >SlNo</td>
                                          <td class='title_cell_e' >Product Name</td>
                                          <td class='title_cell_e' >Issued Item</td>
                                          <td class='title_cell_e' >Opening Balance</td>
                                          <td class='title_cell_e' >Issued Quantity</td>
                                          <td class='title_cell_e' >Closing Balance</td>

                                    </tr>

                                    ";
                        $i=0;
                        $totalopen=0;
                        $totalisssue=0;
                        $totalclose=0;
                        
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

                              
                                    $querybalance="
                                                SELECT
                                                      opening_balance ,
                                                      closing_balance
                                                FROM
                                                      trn_store_out
                                                WHERE
                                                      store_out_id = (
                                                                        SELECT
                                                                              max( store_out_id)
                                                                        FROM
                                                                              trn_store_out
                                                                        WHERE
                                                                              itemcode = '$itemcode' )
                                          ";
                               $rsbalance=mysql_query($querybalance)or die(mysql_error());
                               while($rowbalance=mysql_fetch_array($rsbalance))
                               {
                                    extract($rowbalance);
                               }

                              $mainitem=pick("mas_item","itemdescription","itemcode=$parent_itemcode");
                              $subitem=pick("mas_item","itemdescription","itemcode=$itemcode");
                              $issueditem=pick("mas_item","itemdescription","itemcode=$issueditem");
                              $totalopen=$totalopen+$opening_balance;
                              $totalclose=$totalclose+$closing_balance;
                              $totalisssue=$totalisssue+$issuedqty;
                              echo "<tr>
                                          <td class='$lclass' align='center'>".($i+1)."</td>
                                          <td class='$class'>".$mainitem."-".$subitem."</td>
                                          <td class='$class'>$issueditem</td>
                                          <td class='$class' align='right'>".number_format($opening_balance,2,'.',',')."</td>
                                          <td class='$class' align='right'>".number_format($issuedqty,2,'.',',')."&nbsp;</td>
                                          <td class='$class' align='right'>".number_format($closing_balance,2,'.',',')." &nbsp;</td>

                                    </tr>";
                              
                              $i++;
                        }
                        echo "<tr>
                                    <td class='td_e_b_l' colspan='3' align='right'><b>Total</b></td>
                                    <td class='td_e_b' align='right'>".number_format($totalopen,2,'.',',')."</td>
                                    <td class='td_e_b' align='right'>".number_format($totalisssue,2,'.',',')."</td>
                                    <td class='td_e_b' align='right'>".number_format($totalclose,2,'.',',')."</td>

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
