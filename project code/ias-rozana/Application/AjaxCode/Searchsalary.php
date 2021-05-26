<?PHP
    include_once("../Library/dbconnect.php");
    //include "../dbconnect.php";
?>
<?PHP

     //search Item name
              $searchItemName="SELECT
                                    (basic_salary + house_allowance + medical_allowance + convance + food_allowance + utility_allowance + special_allowance + maintenance_allowance + inflation_allowance + others_allowance) - ( transport + income_tax ) AS salary,
                                    mas_emp_leave.balance
                              FROM
                                    mas_emp_leave
                                    left join mas_emp_sal_info on mas_emp_leave.emp_id=mas_emp_sal_info.employee_id and leave_year='$cboYear'
                              where
                                    mas_emp_leave.emp_id='$cboemployee'
                               ";
              //echo $searchItemName;
              $resultItemName=mysql_query($searchItemName) or die(mysql_error());



              if(mysql_num_rows($resultItemName)>0)
                 {

                     while($rowItemName=mysql_fetch_array($resultItemName))
                      {
                           extract($rowItemName);



                      }
                      echo $salary."-".$balance;
                 }

?>


