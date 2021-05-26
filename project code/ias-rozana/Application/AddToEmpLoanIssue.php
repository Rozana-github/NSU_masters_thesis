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


                  if($cboloan[$i]!='-1')
                  {
                        $insertmas_emp_loan=" replace into
                                                mas_emp_loan
                                                (
                                                      emp_id,
                                                      loan_id,
                                                      loan_amount,
                                                      loan_issue_date,
                                                      loan_start_date,
                                                      loan_close_date,
                                                      number_of_installment,
                                                      balance,
                                                      status
                                                )
                                                values
                                                (
                                                      '".$txtEmployeeid."',
                                                      '".$cboloan."',
                                                      '".$loanamount."',
                                                      '$txtissudate',
                                                      '$txteffectdate',
                                                      (SELECT DATE_ADD(STR_TO_DATE('$txteffectdate','%Y-%c-%e'), INTERVAL ".($Totalrow-1)." MONTH)),
                                                      '".$txtinstallment."',
                                                      '".$loanamount."',
                                                      '1'
                                                )
                                          ";
                        //echo $insertmas_emp_loan."<br>";
                        mysql_query($insertmas_emp_loan) or die(mysql_error());



                        for($j=0;$j<$Totalrow;$j++)
                        {

                              $inserttrn_emp_loan="replace into
                                                            trn_emp_loan
                                                            (
                                                                  emp_id,
                                                                  loan_id,
                                                                  installment_year,
                                                                  installment_month,
                                                                  installment_amount,
                                                                  interest_amount,
                                                                  principal_amount,
                                                                  balance,
                                                                  remarks,
                                                                  status

                                                            )
                                                            values
                                                            (
                                                                  '".$txtEmployeeid."',
                                                                  '".$cboloan."',
                                                                  '".$installmentyear[$j]."',
                                                                  '".$installmentmonth[$j]."',
                                                                  '".$intallment[$j]."',
                                                                  '".$interest[$j]."',
                                                                  '".$principal[$j]."',
                                                                  '".$Balance[$j]."',
                                                                  '".$txtremarks[$j]."',
                                                                  '0'
                                                            )
                                                ";
                                                //echo $inserttrn_emp_loan."<br>";
                                mysql_query($inserttrn_emp_loan)or die(mysql_error());


                        }
                  }






                
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

