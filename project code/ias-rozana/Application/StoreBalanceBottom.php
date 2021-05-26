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
            
<script language="JavaScript" src="Script/NumberFormat.js"></script>

<script language="JavaScript">

            
 function CalculateVat(i)
     {
        var totalValue;

        totalValue=(parseFloat(document.Form1.elements["txtquantity["+i+"]"].value)*parseFloat(document.Form1.elements["txtrate["+i+"]"].value));

        document.Form1.elements["txttotalrate["+i+"]"].value=totalValue;

     }

 function sendData()
                  {
                        document.Form1.submit();
                  }
            
 </script>
            
      </head>
      
      <form name='Form1' method='post' action='Add_To_StoreBalance.php'>
      <body class='body_e'>
            <?PHP
                        if($cboItem!='-1')
                        {
                        $query="SELECT
                                    mas_item.itemcode,
                                    mas_item.parent_itemcode,
                                    sum( quantity_disburse ) AS storeqty,
                                    trn_store_in .purchase_rate,
                                    trn_store_in.store_in_id
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
                                    trn_store_in.purchase_rate,
                                    trn_store_in.store_in_id
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


                        echo "<table width='100%' id='table1' cellspacing='0' cellpadding='0' align='center'>
                                    <tr>
                                          <td class='title_cell_e_l'>SlNo</td>
                                          <td class='title_cell_e'>Product Name</td>
                                          <td class='title_cell_e'>Store Quantity</td>
                                          <td class='title_cell_e'>Rate</td>
                                          <td class='title_cell_e'>Total Value</td>

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
                                          <td class='$class' align='center'>".($i+1)."</td>
                                          <td class='$class'>".$mainitem."-".$subitem."</td>
                                          <td class='$class' align='center'><input type='text' style='text-align:right' name='txtquantity[$i]'onblur='CalculateVat($i)' value='".number_format($storeqty,2,'.','')."' class='input_e' ></td>
                                          <td class='$class' align='center'><input type='text' style='text-align:right' name='txtrate[$i]' onblur='CalculateVat($i)' value='".number_format($purchase_rate,2,'.','')."' class='input_e'></td>
                                          <td class='$class' align='center'><input type='text' style='text-align:right' name='txttotalrate[$i]' value='".number_format($value,2,'.','')."' class='input_e' readonly></td>
                                    </tr>

                                                <input type='hidden' value='$store_in_id' name='hidstoreinid[$i]'>


                                        ";
                              $i++;
                        }
                        echo "
                                   <tr></tr>
                                   <input type='hidden' value='$i' name='totalrow'>
                                         <tr>
                                         <td class='$class' align='center' colspan='5'>
                                         <input value='Update' type='button' name='btnsubmit' class='forms_button_e' onclick='sendData()'>
                                         </td>
                                   </tr>

                        </table>";
                  }
                  else
                  {
                        drawNormalMassage("Data Not Found.");
                  }
            ?>
            
       </form>
      </body>
</html>


<?PHP
      mysql_close();
?>
