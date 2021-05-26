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
<link rel='stylesheet' type='text/css' href='Style/interface_styles.css' />

<script language="JavaScript" src="Script/NumberFormat.js"></script>

<script language="JavaScript" src="Script/calendar1.js"></script>

<script language='JavaScript'>


function Submitfrom()
{
      if(document.frmEmployeeEntry.txtempno.value=='' )
      {
            alert("You Must Enter Employee No");
            document.frmEmployeeEntry.txtempno.focus();
      }
      else if(document.frmEmployeeEntry.txtempname.value=='' )
      {
            alert("You Must Enter Employee Name");
            document.frmEmployeeEntry.txtempname.focus();
      }
      else
      {
            document.frmEmployeeEntry.submit();
      }
}
function CreateNewParty()
{
        var popit=window.open('EmployeeInfoEntry.php','console','status,scrollbars,width=700,height=300');
}

function EditPartyEntry(val)
{
        var popit=window.open("EmpInfoUpdate.php?EmployeeID="+val+"",'console','status,scrollbars,width=700,height=300');
}


</script>

</head>

<body class='body_e'>




<form name='frmEmployeeEntry' method='post' action='AddToEmployeeEntry.php'>



<?PHP
      echo "<input type='hidden' name='mkdecession' value=''>";
      $employeequery="
                      SELECT
                                mas_order_planed.plan_object_id ,
                                mas_order_planed.order_object_id ,
                                date_format(mas_order_planed.planed_date,'%d-%m-%Y') as planed_date,
                                date_format(mas_order.order_date,'%d-%m-%Y') as orderdate,
                                mas_order.job_no,
                                mas_customer.company_name,
                                trn_order_description.order_description,
                                trn_order_description.order_quntity,
                                trn_order_description.order_rate,
                                trn_order_description.order_amount,
                                productionqty as productionqty,
                                sum(mas_order_delivery.delivered_qty) as delivered_qty
                        FROM
                                mas_order_planed
                                INNER JOIN mas_order_production ON mas_order_production.plan_object_id = mas_order_planed.plan_object_id
                                INNER JOIN mas_order ON mas_order.order_object_id = mas_order_planed.order_object_id
                                LEFT JOIN mas_customer ON mas_customer.customer_id = mas_order.customer_id
                                LEFT JOIN trn_order_description ON trn_order_description.order_object_id = mas_order.order_object_id
                                left join  mas_order_delivery on mas_order_delivery.plan_object_id=mas_order_production.plan_object_id
                        where
                                mas_order.order_date < STR_TO_DATE('$cboYear-$cboMonth-$cboDay','%Y-%m-%d')
                        group by
                                mas_order.order_object_id
                        order by
                                mas_order.order_date
                  ";
       //echo $employeequery;
      $rsemployee=mysql_query($employeequery) or die();
      $numrows=mysql_num_rows($rsemployee);
      if($numrows>0)
      {

            $i=0;
            drawCompanyInformation("Delivery Statement ","");
            echo "
                   <table border='0' width='100%'  cellspacing='0' cellpadding='0'>

                              <TR>
                                    <Td class='title_cell_e_l'>Order Date</Td>
                                    <Td class='title_cell_e'>Job No</Td>
                                    <Td class='title_cell_e'>Job Name</Td>
                                    <Td class='title_cell_e'>Company</Td>
                                    <Td class='title_cell_e'>Order qty</Td>
                                    <Td class='title_cell_e'>Order rate</Td>
                                    <Td class='title_cell_e'>Amount</Td>
                                    <Td class='title_cell_e'>Produced qty</Td>
                                    <Td class='title_cell_e'>Delivered qty</Td>
                                    <Td class='title_cell_e'>Ready to Delivered</Td>
                                    <Td class='title_cell_e'>Not Produce</Td>

                              </TR>

                  ";
            while($rows=mysql_fetch_array($rsemployee))
            {
                  extract($rows);
                  

                   if(($i%2)==0)
                              {
                                    $cls="even_td_e";
                                    $lcls="even_left_td_e";
                              }
                              else
                              {
                                    $cls="odd_td_e";
                                    $lcls="odd_left_td_e";
                              }
                              $readyfordelivery=$productionqty-$delivered_qty;
                              $notproduce= $order_quntity-$productionqty;

                   echo"
                              <TR >
                                    <Td class='$lcls'>$orderdate</Td>
                                    <Td class='$cls'>$job_no</Td>
                                    <Td class='$cls'>$order_description&nbsp;</Td>
                                    <Td class='$cls'>$company_name &nbsp;</Td>
                                    <Td class='$cls' align='right'>$order_quntity&nbsp;</Td>
                                    <Td class='$cls' align='right'>$order_rate&nbsp;</Td>
                                    <Td class='$cls' align='right'>$order_amount&nbsp;</Td>
                                    <Td class='$cls' align='right'>$productionqty&nbsp;</Td>
                                    <Td class='$cls' align='right'>$delivered_qty&nbsp;</Td>
                                    <Td class='$cls' align='right'>$readyfordelivery&nbsp;</Td>
                                    <Td class='$cls' align='right'>$notproduce&nbsp;</Td>

                                </tr>";

                        $i++;
                  
                  



            }
            echo  "
                  </TABLE>";

      }
?>




</form>



</body>

</html>
