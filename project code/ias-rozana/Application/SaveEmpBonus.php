<?PHP
session_start();
        include_once("Library/dbconnect.php");
        include_once("Library/Library.php");

mysql_query("BEGIN") or die("Operation cant be start");

echo "<link rel='stylesheet' type='text/css' href='css/styles.css'/>";

      for($i=0;$i<$txtTotalrow;$i++)
      {
            $inserttrn_emp_bonus="replace into
                                    trn_emp_bonus
                                    (
                                          emp_id,
                                          b_month,
                                          b_year,
                                          b_amount,
                                          remarks,
                                          genarate_date

                                    )
                                    values
                                    (
                                          '".$txtEmployeeid[$i]."',
                                          '".$cboMonth."',
                                          '".$cboYear."',
                                          '".$txtbonus[$i]."',
                                          '".$txtremarks[$i]."',
                                          sysdate()
                                    )";
            mysql_query($inserttrn_emp_bonus)or die(mysql_error());
      }
      
       if(mysql_query("COMMIT"))
        {
                drawMassage("Data Saved Succssfully","");
        }
        else
        {
                drawMassage("Data Saved Error","");

        }


?>
