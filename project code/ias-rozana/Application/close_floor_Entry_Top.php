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

<link rel='stylesheet' type='text/css' href='Style/eng_form.css'>
<link rel='stylesheet' type='text/css' href='Style/generic_form.css'>


<script language="JavaScript" src="Script/NumberFormat.js"></script>

<script language="JavaScript" src="Script/calendar1.js"></script>

<script language='JavaScript'>

function Submit()
{
      var ProductName=document.frmMasAssetEntry.text_productid.value;
      if(ProductName=='-1')
      {
            alert("Select A Product name");
            document.frmMasAssetEntry.text_productid.focus();
      }
      else
      {
            frmMasAssetEntry.submit();
      }
}
function deleterow(object_id)
      {
            document.frmMasAssetEntry.action="close_floor_Entry_Top.php?deletrow=1&objectid="+object_id+"";

            document.frmMasAssetEntry.submit();
           // alert(object_id);
      }

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
      window.location="close_floor_Entry_Top.php";
}

function ShowDetail()
      {
           document.frmMasAssetEntry.action="close_floor_Entry_Top.php";
           //document.frmMasAssetEntry.target="SelectQuery";
           document.frmMasAssetEntry.submit();
      }
       
function setvalue(j)
      {
          document.frmMasAssetEntry.fMonth.value=document.frmMasAssetEntry.elements["himonth["+j+"]"].value;
          document.frmMasAssetEntry.fYear.value=document.frmMasAssetEntry.elements["hiyear["+j+"]"].value;
          document.frmMasAssetEntry.text_productid.value=document.frmMasAssetEntry.elements["hiname["+j+"]"].value;
            document.frmMasAssetEntry.text_Quantity.value=document.frmMasAssetEntry.elements["hirquantity["+j+"]"].value;
          document.frmMasAssetEntry.text_Rate.value=document.frmMasAssetEntry.elements["hirate["+j+"]"].value;
          document.frmMasAssetEntry.text_Amount.value=document.frmMasAssetEntry.elements["hiamount["+j+"]"].value;
          document.frmMasAssetEntry.text_Remarks.value=document.frmMasAssetEntry.elements["hiremarks["+j+"]"].value;          
          document.frmMasAssetEntry.btnSave.value='Update';

          
      }       


</script>

</head>

<body class='body_e'>
<?PHP/*-------------------------- Developed By: MD.SHARIF UR RAHMAN ---------------------------------------------*/?>



<form name='frmMasAssetEntry' method='post' action='Add_to_close_floor_Entry.php' >

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
                  <Td  class='header_cell_e' colspan='5' align='center'>Closeing Floor</Td>
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
      <table border='0' width='100%' align='center' cellpadding='' cellspacing='0'>


             <tr>
                     <td class='lb'>
                    <td class='title_cell_e'>Product</td>
                    <td class='title_cell_e'>Quantity</td>
                    <td class='title_cell_e'>Rate</td>
                    <td class='title_cell_e'>Amount</td>
                    <td class='title_cell_e'>Remarks</td>
                    <td class='rb'>
            </tr>
     <tr>

          <td class='lb'>
          <td><select name='text_productid' class='title_cell_e'>
                  <?PHP
                              createCombo("Product Name","mas_item","itemcode","itemdescription","where parent_itemcode ='0'","");
                  ?>
                  </select>
          </td>
          <td class='title_cell_e'><input type="text" name="text_Quantity" size="" onChange='CalTotalPrice()'></td>
          <td class='title_cell_e'><input type="text" name="text_Rate" size="" onChange='CalTotalPrice()'></td>
          <td class='title_cell_e'><input type="text" name="text_Amount" size="" readonly></td>
          <td class='title_cell_e'><input type="text" name="text_Remarks" size=""></td>
          <td class='rb'>
     </tr>
     <tr>
                  <td class='lb'>
                  <td colspan='5' class='button_cell_e' align='center'>
                                       
                       <input type='submit' name='btnSave' value='Save' class='forms_button_e'>       
                   <input type='button' name='btnNew' value='new' class='forms_button_e' onclick='NewDoc()'>
                  </td>
                  <td class='rb'>
            <tr>
            <tr>
                  <td class='bottom_l_curb'></td>
                  <td class='bottom_f_cell' colspan='5'></td>
                  <td class='bottom_r_curb'></td>
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

                                   echo "<table width='95%' id='table1' cellspacing='0' cellpadding='0' align='center'>
                                        <tr>
                                                <td class='title_cell_e'>SL. No</td>
                                                <td class='title_cell_e' >Product Name</td>
                                                <td class='title_cell_e' >Quantity</td>
                                                <td class='title_cell_e' >Rate</td>
                                                <td class='title_cell_e' >Amount</td>
                                                <td class='title_cell_e' >Remarks</td>
                                                <td class='title_cell_e' >Delete</td>
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
                                                  
                                                            <tr style=\"cursor:hand\" onclick='setvalue($j)'>
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
                                                <td class='$class' align='middle'><input type='button' name='btndelet' class='forms_button_e' value='Delete'onclick='deleterow($object_id)'></td>
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
