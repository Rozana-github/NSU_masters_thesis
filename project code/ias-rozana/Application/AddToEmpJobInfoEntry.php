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
                        if(isset($C1[$i]))
                        {
                        $queryupdate="update
                                                trn_employees
                                        set
                                                jobstatus ='0'
                                        where
                                                emp_id='".$txtEmployeeid[$i]."'
                                        ";
                        mysql_query($queryupdate) or die(mysql_error());
                        $inserttrnemployee="replace into
                                                trn_employees
                                                (
                                                        emp_id,
                                                        department_id,
                                                        sal_grad_id,
                                                        emp_status,
                                                        jobstatus,
                                                        update_date
                                                )
                                                values
                                                (
                                                        '".$txtEmployeeid[$i]."',
                                                        '".$cbomainDepartment."',
                                                        '".$cboSalGrad[$i]."',
                                                        '".$cboStatus[$i]."',
                                                        '1',
                                                        sysdate()
                                                )
                                        ";
                                //echo $inserttrnemployee."<br>";
                              $resulttrnemployee=mysql_query($inserttrnemployee) or die(mysql_error());
                        }
                              if(isset($C1[$i]))
                              {
                                    $updatemas_employees="update
                                                                  mas_employees
                                                            set
                                                                  department_id='$cbomainDepartment'
                                                            where
                                                                  employeeobjectid= '".$txtEmployeeid[$i]."'
                                                         ";
                                    mysql_query($updatemas_employees)or die(mysql_error());
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

