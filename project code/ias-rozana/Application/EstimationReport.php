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
            <script language='javascript'>
                  function ReportPrint()
                  {
                        print();
                  }
            </script>
      </head>
      <body class='body_e'>
            <?PHP
                 $queryestimationsetup="SELECT
                                                estimate_id ,
                                                order_object_id ,
                                                mas_prod_estimation.prod_object_id ,
                                                prod_item_setup.description,
                                                micron ,
                                                gsm ,
                                                gsm_kg
                                        FROM
                                                mas_prod_estimation
                                                LEFT JOIN prod_item_setup ON prod_item_setup.prod_item_object_id = mas_prod_estimation.prod_object_id
                                        WHERE
                                                estimate_id='".$estimation_id."'
                                ";
                //echo $querylc;


                  $rs=mysql_query($queryestimationsetup) or die("Error: ".mysql_error());

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
                        <br><br><br>
                        ";

                        drawCompanyInformation("Production Estimation ","");
                        
                        $querytotal="SELECT
                                        mas_estimation.estimation_id ,
                                        mas_estimation.order_object_id ,
                                        mas_estimation.estimate_amount ,
                                        date_format(mas_estimation.estimate_date,'%d-%m-%Y') as estimate_date ,
                                        mas_order.job_no,
                                        mas_customer.company_name,
                                        layer,
                                        total_micron,
                                        total_gsm,
                                        total_gsm_kg,
                                        trn_order_description.order_description
                                    FROM
                                        mas_estimation
                                        LEFT JOIN mas_order ON mas_order.order_object_id = mas_estimation.order_object_id
                                        left join mas_customer on mas_customer.customer_id=mas_order.customer_id
                                        left join trn_order_description on trn_order_description.order_object_id=mas_order.order_object_id
                                   where
                                       mas_estimation.estimation_id='".$estimation_id."'
                                ";
                        $rstotal=mysql_query($querytotal)or die(mysql_error());
                        while($rowtotal=mysql_fetch_array($rstotal))
                        {
                                extract($rowtotal);
                        }

                        echo"<table  id='table1' cellspacing='0' cellpadding='0' align='center'>
                                <tr>
                                        <td>Job Name:</td><td>$order_description</td>
                                </tr>
                                <tr>
                                        <td>Job No:</td><td>$job_no</td>
                                </tr>
                                <tr>
                                        <td>Date:</td><td>$estimate_date</td>
                                </tr>

                        </table>
                        <br>
                        ";
                        echo "<table width='60%' id='table1' cellspacing='0' cellpadding='0' align='center'>
                                    <tr>
                                          <td class='title_cell_e_l' >Item</td>
                                          <td class='title_cell_e' >Micron</td>
                                          <td class='title_cell_e'>gsm</td>
                                          <td class='title_cell_e' >gsm/kg</td>

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



                              
                              echo "<tr>
                                          <td class='$lclass' align='left'>$description</td>
                                          <td class='$class' align='right'>$micron</td>
                                          <td class='$class' align='right'>$gsm</td>
                                          <td class='$class' align='right'>$gsm_kg</td>
                                </tr>";
                              
                              $i++;
                        }
                        

                        echo "<tr>
                                          <td class='$lclass' align='center'>Total</td>
                                          <td class='$class' align='right'>$total_micron</td>
                                          <td class='$class' align='right'>$total_gsm</td>
                                          <td class='$class' align='right'>$total_gsm_kg</td>
                                </tr>
                                <tr>
                                          <td class='$lclass' align='center'>Layer</td>
                                          <td class='$class' colspan='3'>$layer</td>

                                </tr>
                                </table>";
                                
                        $spacificquery="SELECT
                                                estimation_id,
                                                prod_item_setup.prod_item_object_id,
                                                prod_item_setup.description,
                                                qty_gsm,
                                                amount_kg,
                                                adhesive_rate,
                                                layer_type
                                        FROM
                                                trn_prod_estimation
                                                INNER JOIN prod_item_setup ON prod_item_setup.prod_item_object_id = trn_prod_estimation.prod_item_object_id
                                        WHERE
                                                estimation_id ='".$estimation_id."'
                                        order by
                                                prod_item_setup.prod_item_object_id
                                        ";
                       $rsspacific=mysql_query($spacificquery)or die(mysql_error());
                       if(mysql_num_rows($rsspacific)>0)
                       {
                                echo "
                                        <br>
                                        <table id='table1' cellspacing='0' cellpadding='0' align='left'>
                                        <tr>
                                                <td>Estimated Quantity:</td><td>$estimate_amount</td>
                                        </tr>
                                        </table>
                                        <br><br>
                                        <table width='95%' id='table1' cellspacing='0' cellpadding='0' align='center'>
                                        <tr>
                                          <td class='title_cell_e_l' colspan='2'>Materials Specification</td>
                                          <td class='title_cell_e' >Required Quantity, gm</td>
                                          <td class='title_cell_e'>Amount, Kgs</td>

                                        </tr>";
                                while($rowspacific=mysql_fetch_array($rsspacific))
                                {
                                        extract($rowspacific);

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
                                        $mic=pick("mas_prod_estimation","micron","prod_object_id ='$prod_item_object_id' and estimate_id='$estimation_id'");
                                        echo "<tr>
                                                <td class='$lclass' >$description</td>";
                                        if($layer_type ==2)
                                                 echo "<td class='$class' align='right'>$adhesive_rate %</td>";
                                        else
                                             echo "<td class='$class' align='right'>$mic micron</td>";

                                        echo"
                                               <td class='$class' align='right' >".number_format($qty_gsm,2,'.','')."</td>
                                                <td class='$class' align='right'>".number_format($amount_kg,2,'.','')."</td>
                                             </tr>
                                             ";
                                }
                                echo "</table>";
                       }
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
