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

                if($mkdecession=='')
                {
                //Insert into mas_invoice
                  $insertMasEmployee="insert into mas_employees
                                        (
                                          employeeno,
                                          employee_name,
                                          fathers_name,
                                          mothers_name,
                                          date_of_birth,
                                          date_of_join_hr,
                                          date_of_joining_bpp,
                                          designationid,
                                          emp_current_address,
                                          emp_permanent_address,
                                          contact_number,
                                          blood_group,
                                          email_address,
                                          emp_type,
                                          status,
                                          entry_date
                                          

                                          
                                          
                                        )
                                        values
                                        (
                                          '".$txtempno."',
                                          '".$txtempname."',
                                          '".$txtfathername."',
                                          '".$txtmothername."',
                                          STR_TO_DATE('$BYear-$BMonth-$BDay','%Y-%c-%e'),
                                          STR_TO_DATE('$JYear-$JMonth-$JDay','%Y-%c-%e'),
                                          STR_TO_DATE('$BPYear-$BPMonth-$BPDay','%Y-%c-%e'),
                                          '".$cbodesignation."',
                                          '".$txtcuraddress."',
                                          '".$txtperaddress."',
                                          '".$txtcontactno."',
                                          '".$txtbloodgroup."',
                                          '".$txtemail."',
                                          '".$cbotype."',
                                          '".$cbostatus."',
                                          sysdate()
                                       )
                                ";
                 }
                 else
                 {
                  $insertMasEmployee="
                                    update
                                          mas_employees
                                    set
                                          employeeno='".$txtempno."',
                                          employee_name='".$txtempname."',
                                          fathers_name='".$txtfathername."',
                                          mothers_name='".$txtmothername."',
                                          date_of_birth=STR_TO_DATE('$BYear-$BMonth-$BDay','%Y-%c-%e'),
                                          date_of_join_hr= STR_TO_DATE('$JYear-$JMonth-$JDay','%Y-%c-%e'),
                                          date_of_joining_bpp=STR_TO_DATE('$BPYear-$BPMonth-$BPDay','%Y-%c-%e'),
                                          designationid='".$cbodesignation."',
                                          emp_current_address='".$txtcuraddress."',
                                          emp_permanent_address='".$txtperaddress."',
                                          contact_number='".$txtcontactno."',
                                          blood_group='".$txtbloodgroup."',
                                          email_address='".$txtemail."',
                                          emp_type='".$cbotype."',
                                          status='".$cbostatus."'
                                          
                                    where
                                          employeeobjectid='".$mkdecession."'

                                          
                  ";
                 }
                // echo $insertMasEmployee;
                $resultMasEmployee=mysql_query($insertMasEmployee) or die(mysql_error());
                
               //------search invoice recent id-----------

        echo"
        <DIV class=form_background style=\"position: absolute; WIDTH: 570px; height:300px;\">
        <DIV class=form_groove_outer>
        <DIV class=form_groove_inner>

                <table border='0' width='100%' align='center' cellspacing='0' cellpadding='3'>
                        <tr>
                                <td align='center' width='100%'>
                                        <b><font size='2'>Information save Successfully</b></font>
                                </td>
                        </tr>
                        <tr>
                                <td align='center' width='100%'>
                                        <input type='button' name='btnBack' value='Back' onClick=\"window.location.href='EmployeeEntry.php' \"; >
                                </td>
                        </tr>
                </table>
        </DIV>
        </DIV>";

?>


<?PHP
        mysql_query("COMMIT") or die("Operation can't be Successfull");
?>

</form>
</body>

</html>

