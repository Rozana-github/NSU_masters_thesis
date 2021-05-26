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
            
 </script>
            
      </head>
      
<form name='Form1' method='post' action=''>


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

                         drawCompanyInformation("Closeing Floor Report");
                               if(mysql_num_rows($rs)>0)
                        {

                                   echo "<table width='95%' id='table1' cellspacing='0' cellpadding='0' align='center'>
                                        <tr>
                                                <td class='title_cell_e_l'>SL. No</td>
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

                                                            <tr >


                                                <td class='$lclass' align='center'>".($i+1)."</td>
                                                <td class='$class'> ".$itemdescription."&nbsp;</td>
                                                <td class='$class' align='right'>".number_format($product_qty,2,'.',',')."</td>
                                                <td class='$class' align='right'>".number_format($rate,2,'.',',')."</td>
                                                <td class='$class'align='right'>".number_format($amount,2,'.',',')."</td>
                                                <td class='$class' align='right'>".($remarks)."&nbsp;</td>

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

</form>
      </body>
</html>


<?PHP
      mysql_close();
?>
