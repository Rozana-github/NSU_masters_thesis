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
 function ReportPrint()
            {
                  print();
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
       echo "
      <table width='100%' id='table1' cellspacing='0' cellpadding='0' align='center'>
            <tr>
                  <td align='center' HEIGHT='20'>
                        <div class='hide'>
                              <input type='button' name='btnPrint' value='Print' onclick='ReportPrint()'>
                        </div>
                  </td>
            </tr>
      </table>";

      $employeequery="
                             SELECT
                             mas_employees.employeeobjectid,
                             mas_employees.employeeno,
                             mas_employees.employee_name,
                             mas_designation.description,
                             mas_loan.loan_description,
                             mas_emp_loan.loan_amount,
                             DATE_FORMAT(mas_emp_loan.loan_issue_date,'%d-%m-%Y') As issue_date,
                             DATE_FORMAT(mas_emp_loan.loan_close_date,'%d-%m-%Y') As close_date,
                             ifNull(sum( trn_emp_loan.installment_amount),0) AS given_amount

                              FROM mas_emp_loan
                              LEFT JOIN mas_employees ON mas_employees.employeeobjectid = mas_emp_loan.emp_id
                              LEFT JOIN mas_loan ON mas_loan.loan_id = mas_emp_loan.loan_id
                              LEFT JOIN trn_emp_loan ON mas_emp_loan.loan_id = trn_emp_loan.loan_id
                              
                              AND mas_emp_loan.emp_id = trn_emp_loan.emp_id
                              AND trn_emp_loan.status = '1'
                              LEFT JOIN mas_designation ON mas_designation.designationid= mas_employees.designationid
                              GROUP BY mas_emp_loan.emp_id

                  ";
       //echo $employeequery;
      $rsemployee=mysql_query($employeequery) or die();
      $numrows=mysql_num_rows($rsemployee);

      if($numrows>0)
      {

            $i=0;
            drawCompanyInformation("Basic Employee Lone Information","");
            echo "
                   <table border='0' width='100%'  cellspacing='0' cellpadding='0'>

                              <TR>
                                    <Td class='title_cell_e_l'>Employee Name</Td>
                                    <Td class='title_cell_e_l'>Designation</Td>
                                    <Td class='title_cell_e'>Lone Name</Td>
                                    <Td class='title_cell_e'>Amount</Td>
                                    <Td class='title_cell_e'>Issue Date </Td>
                                    <Td class='title_cell_e'>Closing Date </Td>
                                    <Td class='title_cell_e'>Paid Amount</Td>
                                    <Td class='title_cell_e'>Balance</Td>

                                    
                              </TR>

                  ";
            while($rows=mysql_fetch_array($rsemployee))
            {
                  extract($rows);
                  
            $balance=0;
            $balance=$loan_amount-$given_amount;
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
                                    <TD class='$lcls'>$employee_name&nbsp;</TD>
                                    <TD class='$lcls'>$description&nbsp;</TD>
                                    <TD class='$cls' align='center'>$loan_description&nbsp;</TD>
                                    <TD class='$cls' align='center'>$loan_amount&nbsp;</TD>
                                    <TD class='$cls' align='center'>$issue_date&nbsp;</TD>
                                    <TD class='$cls' align='center'>$close_date&nbsp;</TD>
                                    <TD class='$cls' align='center'>$given_amount&nbsp;</TD>
                                    <TD class='$cls' align='center'>$balance&nbsp;</TD>


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
