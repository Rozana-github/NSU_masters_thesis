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

</head>

<body>
<form name='Form1' method='post'  action=''>

<?PHP
            if($txtupdate==1)
            {
                  $insertintomas_emp_sal_info="update
                                                      mas_emp_sal_info
                                                set
                                                      basic_salary='$txtBasic',
                                                      house_allowance='$txtHouse',
                                                      medical_allowance='$txtMedical',
                                                      convance='$txtConvance',
                                                      food_allowance='$txtFood',
                                                      utility_allowance='$txtUtility',
                                                      special_allowance='$txtSpecial',
                                                      maintenance_allowance='$txtMaintainnance',
                                                      inflation_allowance='$txtInflation',
                                                      transport='$txtTransport',
                                                      others_allowance='$txtOthers',
                                                      income_tax='$txtIncome',
                                                      welf_fair= '$txtwelfair',
                                                      pf_status='$pf',
                                                      ot_status='$ot',
                                                      remarks='$txtRemarks',
                                                      increment_date=sysdate()
                                                where
                                                      employee_id='$txtempid'

                                                " ;
            }
            else
            {
                  $insertintomas_emp_sal_info="Insert into
                                                      mas_emp_sal_info
                                                      (
                                                            employee_id,
                                                            grad_id,
                                                            basic_salary,
                                                            house_allowance,
                                                            medical_allowance,
                                                            convance,
                                                            food_allowance,
                                                            utility_allowance,
                                                            special_allowance,
                                                            maintenance_allowance,
                                                            inflation_allowance,
                                                            transport,
                                                            others_allowance,
                                                            income_tax,
                                                            welf_fair,
                                                            pf_status,
                                                            ot_status,
                                                            remarks,
                                                            entry_date

                                                      )
                                                      values
                                                      (
                                                            '".$txtempid."',
                                                            '".$txtgrad."',
                                                            '$txtBasic',
                                                            '$txtHouse',
                                                            '$txtMedical',
                                                            '$txtConvance',
                                                            '$txtFood',
                                                            '$txtUtility',
                                                            '$txtSpecial',
                                                            '$txtMaintainnance',
                                                            '$txtInflation',
                                                            '$txtTransport',
                                                            '$txtOthers',
                                                            '$txtIncome',
                                                            '$txtwelfair',
                                                            '$pf',
                                                            '$ot',
                                                            '$txtRemarks',
                                                            sysdate()

                                                      )

                                                                        " ;
            }
                                   //echo $insertintomas_emp_sal_info;
                                   mysql_query($insertintomas_emp_sal_info)or die(mysql_error());


                
               //------search invoice recent id-----------



?>


<?PHP
        if(mysql_query("COMMIT"))
      {
            drawMassage("Data Saved Succssfully","");
      }
      else
      {
            drawMassage("Data Saved Error","");
      }
?>

</form>
</body>

</html>

