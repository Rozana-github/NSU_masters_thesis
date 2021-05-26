<?PHP
      include "Library/dbconnect.php";
      include "Library/Library.php";
      include "Library/SessionValidate.php";
?>

<html>
      <head>
            <meta http-equiv='Content-Type' content='text/html; charset=windows-1252'>
            <title>Invoice Posting</title>
            <script language='javascript'>
                  function ReportPrint()
                  {
                        print();
                  }
            </script>

            <LINK rel='stylesheet' type='text/css' href='Style/generic_report.css'>
            <link rel='stylesheet' type='text/css' href='Style/eng_report.css' />
            <link type='text/css' media='print' rel='stylesheet' href='Style/print.css' />
      </head>
      <body class='body_e'>
            <?PHP
                  $query="select
                              date_format(mas_lc.opendate,'%d-%m-%Y') as rpt_openDT,
                              mas_lc.lcno as rpt_lcno,
                              date_format(mas_lc.lastshipmentdate,'%d-%m-%Y') as rpt_lsDT,
                              mas_lc.dateofmaturity as rpt_NDT,
                              date_format(mas_lc.doc_receivedate,'%d-%m-%Y') as doc_receivedate,
                              mas_lc.name_cf_agent,
                              date_format(mas_lc.barthingdate,'%d-%m-%Y') as barthingdate,
                              date_format(mas_lc.amend_date,'%d-%m-%Y') as amend_date,
                              date_format(mas_lc.amend_neg_date,'%d-%m-%Y') as amend_neg_date ,
                              trn_lc.rate as rpt_rate,
                              trn_lc.reqqty as rpt_reqqty,
                              mas_supplier.Company_Name as rpt_CompanyName,
                              mas_item.itemcode,
                              mas_item.parent_itemcode
                          from
                              mas_lc
                              left join trn_lc on trn_lc.lcobjectid=mas_lc.lcobjectid
                              left join mas_supplier on mas_supplier.supplier_id=mas_lc.partyid
                              left join mas_item on mas_item.itemcode=trn_lc.itemcode
                          where
                              mas_lc.lcstatus='0'
                          order by
                              mas_lc.opendate
                         ";
                  $rs=mysql_query($query) or die("Error: ".mysql_error());

                  if(mysql_num_rows($rs)>0)
                  {
                        echo "
                        <table width='100%' id='table1' cellspacing='0' cellpadding='0' align='center'>
                              <tr>
                                    <td align='center' HEIGHT='20'>
                                          <div class='hide'>
                                                      <input type='button' name='btnPrint' value='Print' onclick='ReportPrint()'>
                                          </div>
                                    </td>
                              </tr>
                        </table>
                        ";
                        //||<input type='button' name='btnPrint' value='Print' onclick='ReportPrint()'>
                        drawCompanyInformation("LC Statement for BRAC Printing Pack Pipe Line","Printed Date: ".date("l dS of F Y"));

                        echo "<table width='100%' id='table1' cellspacing='0' cellpadding='0' align='center'>

                                    <tr>
                                          <td class='title_cell_e_l'>LC Opening Date</td>
                                          <td class='title_cell_e'>LC No</td>
                                          <td class='title_cell_e'>Names of items</td>
                                          <td class='title_cell_e'>Rate</td>
                                          <td class='title_cell_e'>Quantity</td>
                                          <td class='title_cell_e'>Total Amount$</td>
                                          <td class='title_cell_e'>Name Of Company</td>
                                          <td class='title_cell_e'>Shipment Date</td>
                                          <td class='title_cell_e'>Negotiation Date</td>
                                          <td class='title_cell_e'>Doc Recived Date</td>
                                          <td class='title_cell_e'>Birth Date at Ctg</td>
                                          <td class='title_cell_e'>Amendment Date</td>
                                          <td class='title_cell_e'>A. Negotiation Date</td>
                                          <td class='title_cell_e'>Name C&F Agent</td>
                                    </tr>";
                        $i=0;
                        while($row=mysql_fetch_array($rs))
                        {
                              extract($row);
                              if(($i%2)==0)
                              {
                                    $class='even_td_e';
                                    $lclass="even_left_td_e";
                              }
                              else
                              {
                                    $class='odd_td_e';
                                    $lclass="odd_left_td_e";
                              }
                              $mainitem=pick("mas_item","itemdescription","itemcode='$parent_itemcode'");
                              $subitem=pick("mas_item","itemdescription","itemcode='$itemcode'");
                              $totalAmount=$rpt_rate*$rpt_reqqty;
                              echo "<tr>
                                          <td class='$lclass' align='center'>$rpt_openDT</td>
                                          <td class='$class'>$rpt_lcno</td>
                                          <td class='$class'>$mainitem-$subitem</td>
                                          <td class='$class'>$rpt_rate</td>
                                          <td class='$class' align='right'>$rpt_reqqty</td>
                                          <td class='$class' align='right'>$totalAmount</td>
                                          <td class='$class' align='right'>$rpt_CompanyName</td>
                                          <td class='$class' align='right'>$rpt_lsDT</td>
                                          <td class='$class' align='right'>$rpt_NDT</td>
                                          <td class='$class' align='right'>$doc_receivedate</td>
                                          <td class='$class' align='right'>$barthingdate</td>
                                          <td class='$class' align='right'>$amend_date</td>
                                          <td class='$class' align='right'>$amend_neg_date</td>
                                          <td class='$class' align='right'>$name_cf_agent</td>
                                    </tr>";
                              
                              $i++;
                        }
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
