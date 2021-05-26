<?PHP
session_start();
        include_once("Library/dbconnect.php");
        include_once("Library/Library.php");

        mysql_query("BEGIN") or die("Operation can't be open");
?>

<html>

<head>

<meta http-equiv='Content-Language' content='en-us'>
<meta http-equiv='Content-Type' content='text/html; charset=windows-1252'>
<title>Supplier Entry Form</title>
<link rel='stylesheet' type='text/css' href='css/interface_styles.css' />

<script language='JavaScript'>
            function back()
            {
                  window.location="WIPEntry.php";
            }
        </script>

</head>

<body>
<form name='Form1' method='post'  action=''>

<?PHP


                //Insert into mas_invoice
                  $insertmas_wip="replace into
                                          mas_wip
                                          (
                                                `pdate`,
                                                `wip_month`,
                                                `wip_year`,
                                                `job_no`,
                                                `job_name`,
                                                `company_id`,
                                                `job_quantity`,
                                                `pet_quantity`,
                                                `pet_rate`,
                                                `bopp_quantity`,
                                                `bopp_rate`,
                                                `ink_quantity`,
                                                `ink_rate`,
                                                `adive_quantity`,
                                                `adive_rate`,
                                                `solvt_quantity`,
                                                `solvt_rate`,
                                                `mcpp_quantity`,
                                                `mcpp_rate`,
                                                `mpet_quantity`,
                                                `mpet_rate`,
                                                `foil_quantity`,
                                                `foil_rate`,
                                                `lf_quantity`,
                                                `lf_rate`,
                                                `mf_quantity`,
                                                `mf_rate`,
                                                `tm_cost`,
                                                `oh`,
                                                `t_cost`,
                                                `e_type`,
                                                `entry_date`
                                          )
                                          values
                                          (

                                                STR_TO_DATE('$txtpDate','%d-%m-%Y'),
                                                '$cboMonth',
                                                '$cboYear',
                                                '$txtjobno',
                                                '$txtjobname',
                                                '$cbocompany',
                                                '$txtjobquantity',
                                                '$txtpetqty',
                                                '$txtpetrate',
                                                '$txtbpqty',
                                                '$txtbprate',
                                                '$txtinkqty',
                                                '$txtinkrate',
                                                '$txtadveqty',
                                                '$txtadverate',
                                                '$txtsolvtqty',
                                                '$txtsolvtrate',
                                                '$txtMcppqty',
                                                '$txtMcpprate',
                                                '$txtmpetqty',
                                                '$txtmpetrate',
                                                '$txtfoilqty',
                                                '$txtfoilrate',
                                                '$txtlfqty',
                                                '$txtlfrate',
                                                '$txtmfqty',
                                                '$txtmfrate',
                                                '$txttmcost',
                                                '$txtoh',
                                                '$txttcost',
                                                '$cboetype',
                                                sysdate()
                                          )
                                ";
                                //echo $insertmas_wip."<br>";
                              $resultmas_wip=mysql_query($insertmas_wip) or die(mysql_error());

                
               //------search invoice recent id-----------



?>


<?PHP
        if(mysql_query("COMMIT"))
      {
            drawMassage("Data Saved Succssfully","onClick='back()'");
      }
      else
      {
            drawMassage("Data Saved Error","onClick='back()");
      }
?>

</form>
</body>

</html>

