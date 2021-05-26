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

                for($i=0;$i<$txtTotalrow;$i++)
                {
                //Insert into mas_invoice

                            $inserttrn_emp_sal="replace into trn_emp_sal
                                                      (
                                                            emp_id,
                                                            sal_month,
                                                            sal_year,
                                                            sal_grad_id,
                                                            basic_salary,
                                                            house_rent,
                                                            medical_allowance,
                                                            convance,
                                                            food_allowance,
                                                            utility_allowance,
                                                            special_allowance,
                                                            maintenance_allowance,
                                                            inflation_allowance,
                                                            other_allowance,
                                                            provident_fund,
                                                            income_tax,
                                                            transport,
                                                            loan,
                                                            interest,
                                                            without_pay,
                                                            wellfare_fund,
                                                            remarks,
                                                            net_pay,
                                                            genaration_date

                                                      )
                                                      values
                                                      (
                                                            '".$txtEmployeeid[$i]."',
                                                            '".$cboMonth."',
                                                            '".$cboYear."',
                                                            '".$txtsalgrad[$i]."',
                                                            '".$txtbasic[$i]."',
                                                            '".$txthouse[$i]."',
                                                            '".$txtmedical[$i]."',
                                                            '".$txtconvance[$i]."',
                                                            '".$txtfood[$i]."',
                                                            '".$txtutility[$i]."',
                                                            '".$txtspecial[$i]."',
                                                            '".$txtmaintenance[$i]."',
                                                            '".$txtiflation[$i]."',
                                                            '".$txtothers[$i]."',
                                                            '".$txtprovident[$i]."',
                                                            '".$txtincome[$i]."',
                                                            '".$txttransport[$i]."',
                                                            '".$txtloan[$i]."',
                                                            '".$txtinterest[$i]."',
                                                            '".$txtwithoutpay[$i]."',
                                                            '".$txtwelfare[$i]."',
                                                            '".$txtremarks[$i]."',
                                                            '".$txtnetpay[$i]."',
                                                            sysdate()
                                                      )" ;
                                           //echo $inserttrn_emp_sal;
                                           mysql_query($inserttrn_emp_sal) or die(mysql_error());
                                           
                                                if($txtloanid[$i]!='')
                                                {

                                                            $updatetrn_emp_loan="update
                                                                                       trn_emp_loan
                                                                                 set
                                                                                       interest_amount ='".$txtinterest[$i]."',
                                                                                       status='1'
                                                                                 where
                                                                                       emp_id='".$txtEmployeeid[$i]."'
                                                                                       and loan_id='".$txtloanid[$i]."'
                                                                                       and installment_year='".$cboYear."'
                                                                                       and installment_month= '".$cboMonth."'
                                                                                 ";

                                                      //echo $updatetrn_emp_loan;
                                                      mysql_query($updatetrn_emp_loan)or die(mysql_error());
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

