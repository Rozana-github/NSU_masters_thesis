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
                  function goRptLcPipeLineDetail(lcobjectid)
                  {
                        window.location="RptLcPipeLineDetail.php?Lcobject="+lcobjectid+"";
                  }

                  function ReportPrint()
                  {
                        print();
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

                                                </div>
                                          </td>
                                    </tr>
                              </table>
                        ";
                        $query="select
                                    mas_lc.lcobjectid,
                                    mas_lc.lcno,
                                    mas_lc.partyid,
                                    mas_supplier.company_name,
                                    date_format(mas_lc.opendate,'%d-%m-%Y') as opendate,
                                    date_format(lastshipmentdate,'%d-%m-%Y') as lastshipmentdate
                                    
                              from
                                    mas_lc
                                    left join mas_supplier on mas_lc.partyid=mas_supplier.supplier_id
                              where
                                    lcstatus='0'
                              order by
                                    company_name,lcno
                              ";


                  //echo $query;
                  $rs=mysql_query($query) or die("Error: ".mysql_error());

                  if(mysql_num_rows($rs)>0)
                  {
                        drawCompanyInformation("LC Pipe Line Report");

                        echo"<table width='100%' id='table1' cellspacing='0' cellpadding='0' align='center'>
                                    <tr>
                                          <td class='title_cell_e_l' colspan='2' width='20%'>LC No</td>
                                          <td class='title_cell_e' colspan='2' width='40%'>Company Name</td>
                                          <td class='title_cell_e' colspan='2' width='20%'>Open Date</td>
                                          <td class='title_cell_e' colspan='2' width='20%'>Shipment Date</td>
                                    </tr>
                              </table>";
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


                               echo "
                                    <table width='100%' id='table1' cellspacing='0' cellpadding='0' align='center'>
                                    <tr>
                                          <td colspan='2'  class='sub_title_cell_e_l' width='20%'>$lcno</td>
                                          <td  colspan='2' class='sub_title_cell_e' width='40%'>$company_name</td>
                                          <td  colspan='2' class='sub_title_cell_e' width='20%'>$opendate</td>
                                          <td  colspan='2' class='sub_title_cell_e' width='20%'>$lastshipmentdate</td>

                                    </tr>
                                    ";
                                    
                              $querydetail="SELECT
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
                                                lcobjectid = '$lcobjectid'

                              ";
                              //echo $querydetail;
                               echo " <table width='98%' id='table1' cellspacing='0' cellpadding='0' align='center'>
                                    <tr>
                                          <td class='sub_title_cell_e_l' >SlNo</td>
                                          <td class='sub_title_cell_e' >Product Name</td>
                                          <td class='sub_title_cell_e' >Quantity</td>
                                          <td class='sub_title_cell_e' >Unit</td>
                                          <td class='sub_title_cell_e' >Rate</td>
                                          <td class='sub_title_cell_e' >Remarks</td>

                                    </tr>
                                    ";
                              $rsdetail=mysql_query($querydetail) or die("Error: ".mysql_error());
                              $j=0;
                              while($rowdetail=mysql_fetch_array($rsdetail))
                              {
                                    extract($rowdetail);

                                    if(($j%2)==0)
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

                                    $totalquantity+=$reqqty;
                                    echo "<tr>
                                          <td class='$lclass' align='center'>".($j+1)."</td>
                                          <td class='$class'>".$mainitem."-".$subitem."</td>
                                          <td class='$class' align='right'>".number_format($reqqty,2,'.',',')."</td>
                                          <td class='$class' >$units &nbsp;</td>
                                          <td class='$class' align='right'>".number_format($rate,2,'.',',')."</td>
                                          <td class='$class' >$remarks &nbsp;</td>

                                          </tr>";

                                    $j++;
                              }

                               echo "</table>";
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
