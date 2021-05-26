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
                                        mas_estimation.estimation_id ,
                                        mas_estimation.order_object_id ,
                                        mas_estimation.estimate_amount ,
                                        date_format(mas_estimation.estimate_date,'%d-%m-%Y') as estimate_date ,
                                        mas_order.job_no,
                                        trn_order_description.order_quntity,
                                        trn_order_description.order_rate,
                                        trn_order_description.order_amount,
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
                              mas_estimation.estimate_date between STR_TO_DATE('$cboYear-$cboMonth-1','%Y-%m-%d') and STR_TO_DATE('$cboYear-$cboMonth-$cboDay','%Y-%m-%d')
                        order by
                              mas_estimation.estimate_date ,mas_order.job_no
                  ";
       //echo $employeequery;
      $rsemployee=mysql_query($employeequery) or die();
      $numrows=mysql_num_rows($rsemployee);
      if($numrows>0)
      {

            $i=0;
            drawCompanyInformation("Production Statement upto  ".date("d F, Y", mktime(0, 0, 0, $cboMonth,$cboDay,$cboYear)),"");
            echo "
                   <table border='0' width='100%'  cellspacing='0' cellpadding='0'>

                              <TR>
                                    <Td class='title_cell_e_l'>E.Date</Td>
                                    <Td class='title_cell_e'>Job No</Td>
                                    <Td class='title_cell_e'>Job Name</Td>
                                    <Td class='title_cell_e'>Company</Td>
                                    <Td class='title_cell_e'>Order</Td>
                                    <Td class='title_cell_e'>Kg</Td>
                                    <Td class='title_cell_e'>Rate</Td>
                                    <Td class='title_cell_e'>Amount</Td>
                                    <Td class='title_cell_e'>Pet</Td>
                                    <Td class='title_cell_e'>Bopp</Td>
                                    <Td class='title_cell_e'>Mbopp</Td>
                                    <Td class='title_cell_e'>LLDPE</Td>
                                    <Td class='title_cell_e'>Mpet</Td>
                                    <Td class='title_cell_e'>Mcpp</Td>
                                    <Td class='title_cell_e'>Foil</Td>
                                    <Td class='title_cell_e'>PA</Td>
                                    <Td class='title_cell_e'>Ohter</Td>
                                    <Td class='title_cell_e'>Ink</Td>
                                    <Td class='title_cell_e'>Bopp.Add</Td>
                                    <Td class='title_cell_e'>PA.Adhe</Td>
                                    <Td class='title_cell_e'>solv.ink</Td>
                                    <Td class='title_cell_e'>solv.Adhe</Td>





                                    
                              </TR>

                  ";
            while($rows=mysql_fetch_array($rsemployee))
            {
                  extract($rows);
                  
                  $queryamount=" SELECT
                                        trn_prod_estimation.prod_item_object_id ,
                                        description,
                                        sum( amount_kg ) as amt
                                FROM
                                        trn_prod_estimation
                                        LEFT JOIN prod_item_setup ON prod_item_setup.prod_item_object_id = trn_prod_estimation.prod_item_object_id
                                WHERE
                                        trn_prod_estimation.estimation_id ='".$estimation_id."'
                                        and trn_prod_estimation.prod_item_object_id!='18'
                                GROUP BY
                                        trn_prod_estimation.prod_item_object_id
                                ORDER BY
                                        trn_prod_estimation.prod_item_object_id";
                              $rsamt=mysql_query($queryamount)or die(mysql_error());
                  
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

                   echo"
                              <TR >
                                    <Td class='$lcls'>$estimate_date</Td>
                                    <Td class='$cls'>$job_no</Td>
                                    <Td class='$cls'>$order_description</Td>
                                    <Td class='$cls'>$company_name &nbsp;</Td>
                                    <Td class='$cls' align='right'>$order_quntity</Td>
                                    <Td class='$cls' align='right'>$estimate_amount</Td>
                                    <Td class='$cls' align='right'>$order_rate</Td>
                                    <Td class='$cls' align='right'>$order_amount</Td> ";
                             if(mysql_num_rows($rsamt)>0)
                             {
                                while($rowamt=mysql_fetch_array($rsamt))
                                {
                                        extract($rowamt);
                                        echo "<TD class='$cls'  align='right'>".number_format($amt,2,'.','')."</TD> ";
                                }
                             }
                             else
                             {
                                for($j=0;$j<14;$j++)
                                {
                                   echo "<TD class='$cls'  align='right'>".number_format($amt,2,'.','')."</TD> ";
                                }
                             }

                    echo"

                              </TR>
                        ";
                        $i++;
                  
                  



            }
            echo  "
                  </TABLE>";

      }
?>




</form>



</body>

</html>
