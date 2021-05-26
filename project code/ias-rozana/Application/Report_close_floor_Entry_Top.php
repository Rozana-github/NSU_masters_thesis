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

<link rel='stylesheet' type='text/css' href='Style/eng_report.css' />


<script language="JavaScript" src="Script/NumberFormat.js"></script>

<script language="JavaScript" src="Script/calendar1.js"></script>

<script language='JavaScript'>




function CalTotalPrice()
{
        var TotalQuantity=parseFloat(document.frmMasAssetEntry.text_Quantity.value);

        //alert(TotalQuantity);
        var UnitPrice=parseFloat(document.frmMasAssetEntry.text_Rate.value);
        //alert(UnitPrice);

        var TotalPrice=parseFloat(TotalQuantity*UnitPrice);

        //alert(TotalPrice);
        var tp = new NumberFormat(TotalPrice);
        tp.setPlaces(2);
        tp.setSeparators(false);
        var TotalPrice = tp.toFormatted();

        document.frmMasAssetEntry.text_Amount.value=result=TotalPrice;
}


function NewDoc()
{
      window.location="Report_close_floor_Entry_Top.php";
}

function ShowDetail()
      {
           document.frmMasAssetEntry.action="Report_close_floor_Entry_Top.php";
           //document.frmMasAssetEntry.target="SelectQuery";
           document.frmMasAssetEntry.submit();
      }



</script>

</head>

<body class='body_e'>
<?PHP/*-------------------------- Developed By: MD.SHARIF UR RAHMAN ---------------------------------------------*/?>



<form name='frmMasAssetEntry' method='post' action='' >

<?PHP
   if($deletrow=='1')
                    {
                    $querydel="delete from mas_closing_flr where object_id='$objectid'";
                         mysql_query($querydel) or die(mysql_error());
                      }
?>

       <table width='100%' id='table1' cellspacing='0' cellpadding='0' align='center'>
       

            <tr>
                  <td class='top_left_curb'></td>
                  <Td  class='header_cell_e' colspan='5' align='center'>Closeing Floor Report</Td>
                  <td class='top_right_curb'></td>
            </tr>
            <tr>

                  <td class='lb'></td>
                  <td class='td_e' align='center' colspan='5'> <b>Month</b>

                  <?PHP
                       echo "<select name='fMonth' class='select_e' onchange='ShowDetail()' >
                                ";
                                    comboMonth($fMonth);
                        echo "</select>
                              <select name='fYear'  class='select_e'onchange='ShowDetail()>";
                                    comboYear("","",$fYear);
                        echo"</select>" ;
                  ?>
                  </td>
                  <td class='rb'></td>
            </tr>

      </table>

      
      <?PHP
      


                         $query="SELECT
                                          mas_closing_flr.object_id,
                                          mas_closing_flr.product_id ,
                                          mas_closing_flr.product_qty ,
                                          mas_closing_flr.rate,
                                          mas_closing_flr.amount,
                                          mas_closing_flr.remarks,
                                          mas_closing_flr.flr_year,
                                          mas_closing_flr.flr_month,
                                          mas_item.itemdescription
                                    FROM mas_closing_flr
                                    LEFT JOIN mas_item ON mas_item.itemcode = mas_closing_flr.product_id
                                   where
                                        flr_month='$fMonth'
                                   and
                                        flr_year='$fYear'
                                ";

                        // echo $query;
                         $rs=mysql_query($query) or die("Error: ".mysql_error());

                         $j=0;
                               if(mysql_num_rows($rs)>0)
                               
                        {
                                     drawCompanyInformation("Closeing Floor Report");

                                   echo "<table width='95%' id='table1' cellspacing='0' cellpadding='0' align='center'>
                                        <tr>
                                                <td class='title_cell_e'>SL. No</td>
                                                <td class='title_cell_e' >Product Name</td>
                                                <td class='title_cell_e' >Quantity</td>
                                                <td class='title_cell_e' >Rate</td>
                                                <td class='title_cell_e' >Amount</td>
                                                <td class='title_cell_e' >Remarks</td>

                                        </tr>
                                    ";
                                
                                        $i=0;
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
                                                  
                                                            <tr>
                                                            <input type='hidden' name='himonth[$j]' value='$flr_month'>
                                                            <input type='hidden' name='hiyear[$j]' value='$flr_year'>
                                                            <input type='hidden' name='hiname[$j]' value='$product_id'>
                                                            <input type='hidden' name='hirquantity[$j]' value='$product_qty'>
                                                            <input type='hidden' name='hirate[$j]' value='$rate'>
                                                            <input type='hidden' name='hiamount[$j]' value='$amount'>
                                                            <input type='hidden' name='hiremarks[$j]' value='$remarks'>                     
                                                  
                                                <td class='$class' align='center'>".($i+1)."</td>
                                                <td class='$class'> ".$itemdescription."&nbsp;</td>
                                                <td class='$class' align='right'>".number_format($product_qty,2,'.',',')."</td>
                                                <td class='$class' align='right'>".number_format($rate,2,'.',',')."</td>
                                                <td class='$class'align='right'>".number_format($amount,2,'.',',')."</td>
                                                <td class='$class' align='right'>".($remarks)."</td>

                                             </tr>";

                                        $i++;
                                                  $j++;
                                }
                                echo "</table>";



                        }
                        else
                        {
                                drawNormalMassage("Data Not Found.");
                        }
                ?>

</form>
</body>
</html>
