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
<link rel='stylesheet' type='text/css' href='Style/interface_styles.css' />

<script language="JavaScript" src="Script/NumberFormat.js"></script>

<script language="JavaScript" src="Script/calendar1.js"></script>

<script language='JavaScript'>



function Createnewdesignation()
{
        window.location="MasLeaveEntry.php";
}

function printestimation(val)
{
        window.location="EstimationReport.php?estimation_id="+val+"";
}


</script>

</head>

<body class='body_e'>




<form name='frmEmployeeEntry' method='post' action=''>


<?PHP
      echo "<input type='hidden' name='mkdecession' value=''>";
      $employeequery="SELECT
                        mas_estimation.estimation_id ,
                        mas_estimation.order_object_id ,
                        mas_estimation.estimate_amount ,
                        date_format(mas_estimation.estimate_date,'%d-%m-%Y') as estimate_date ,
                        mas_order.job_no,
                        mas_customer.company_name
                    FROM
                        mas_estimation
                        LEFT JOIN mas_order ON mas_order.order_object_id = mas_estimation.order_object_id
                        left join mas_customer on mas_customer.customer_id=mas_order.customer_id
                    ";
      //echo $employeequery;
      $rsemployee=mysql_query($employeequery) or die(mysql_error());
      $numrows=mysql_num_rows($rsemployee);
      if($numrows>0)
      {

            $i=0;
            echo "
                   <table border='0' width='90%' align='center'  cellspacing='0' cellpadding='0'>

                              <TR>
                                    <Td class='title_cell_e'>SL No.</Td>
                                    <Td class='title_cell_e'>Job No</Td>
                                    <Td class='title_cell_e'>Company Nme</Td>
                                    <Td class='title_cell_e'>Quantity</Td>
                                    <Td class='title_cell_e'>Estimation Date</Td>

                              </TR>

                  ";
            while($rows=mysql_fetch_array($rsemployee))
            {
                  extract($rows);
                  if($i%2==0)
                        $cls='even_td_e';
                  else
                        $cls='odd_td_e';

                   echo"
                              <TR  id=set1_row1 onClick='printestimation(\"$estimation_id\")' style=\"cursor: hand;\">

                                    <TD class='$cls' style=\"cursor: hand;\"  align='center'>".($i+1)."</TD>
                                    <TD class='$cls' style=\"cursor: hand;\"  >$job_no</TD>
                                    <TD class='$cls' style=\"cursor: hand;\"  >$company_name</TD>
                                    <TD class='$cls' style=\"cursor: hand;\"  align='right'>$estimate_amount</TD>
                                    <TD class='$cls' style=\"cursor: hand;\"  >$estimate_date</TD>

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
