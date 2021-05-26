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


function Submitfrom()
{

            document.frmEmployeeEntry.submit();

}



</script>

</head>

<body class='body_e'>




<form name='frmEmployeeEntry' method='post' action='SaveEmpBonus.php'>


<?PHP
      echo "<input type='hidden' name='mkdecession' value=''>
      <input type='hidden' name='cboMonth' value='$cboMonth'>
      <input type='hidden' name='cboYear' value='$cboYear'>";
      if($cboDepartment!='' && $cboDepartment!='-1')
      {
      $employeequery="  SELECT
                              trn_employees.emp_id,
                              mas_employees.employee_name,
                              trn_employees.sal_grad_id,
                              ifnull(basic_salary,0) basic_salary ,
                              mas_designation.description,
                              date_format(mas_employees.date_of_join_hr,'%d-%m-%Y') as joindate
                        FROM
                              trn_employees
                              inner join mas_emp_sal_info ON mas_emp_sal_info.employee_id = trn_employees.emp_id and trn_employees.jobstatus='1'
                              inner JOIN mas_employees ON mas_employees.employeeobjectid = trn_employees.emp_id and mas_employees.date_of_join_hr < STR_TO_DATE('1-$cboMonth-$cboYear','%d-%m-%Y')
                              left join mas_designation on mas_employees.designationid=mas_designation.designationid

                        where
                              trn_employees.department_id='$cboDepartment'
                              and mas_employees.emp_type='1'


                        ";
      }
      else
      {
       $employeequery="   SELECT
                              trn_employees.emp_id,
                              mas_employees.employee_name,
                              trn_employees.sal_grad_id,
                              ifnull(basic_salary,0) basic_salary ,
                              mas_designation.description,
                              date_format(mas_employees.date_of_join_hr,'%d-%m-%Y') as joindate
                        FROM
                              trn_employees
                              inner join mas_emp_sal_info ON mas_emp_sal_info.employee_id = trn_employees.emp_id and trn_employees.jobstatus='1'
                              inner JOIN mas_employees ON mas_employees.employeeobjectid = trn_employees.emp_id and mas_employees.date_of_join_hr < STR_TO_DATE('1-$cboMonth-$cboYear','%d-%m-%Y')
                              left join mas_designation on mas_employees.designationid=mas_designation.designationid

                        where
                              mas_employees.emp_type='1'
                        ";

      }
      //echo $employeequery;
      $rsemployee=mysql_query($employeequery) or die(mysql_error());
      $numrows=mysql_num_rows($rsemployee);
      if($numrows>0)
      {

            $i=0;
            echo "
                   <table border='0' width='100%'  cellspacing='0' cellpadding='0'>

                              <TR>
                                    <Td class='title_cell_e'>Sl.No</Td>
                                    <Td class='title_cell_e'>Employee Name</Td>
                                    <Td class='title_cell_e'>Designation</Td>
                                    <Td class='title_cell_e'>Join Date</Td>
                                    <Td class='title_cell_e'>Basic</TD>

                                    <Td class='title_cell_e'>Bonus Amount</td>
                                    <td class='title_cell_e'>Remarks</td>

                              </TR>

                  ";
                  $totalbonus=0;
            while($rows=mysql_fetch_array($rsemployee))
            {
                  extract($rows);
                  if($i%2==0)
                        $cls='even_td_e';
                  else
                        $cls='odd_td_e';

                 $bonusamount=($basic_salary*2)/12;
                   echo"
                              <TR  id=set1_row1  >
                                    <input type='hidden' value='$emp_id' name='txtEmployeeid[$i]'>


                                    <td class='$cls'>".($i+1)."</td>
                                    <TD class='$cls' >$employee_name</TD>
                                    <TD class='$cls' >$description</TD>
                                    <TD class='$cls'  align='center'>$joindate</TD>

                                    <TD class='$cls'  align='right'>$basic_salary</td>



                                    <TD class='$cls'  align='center'>
                                          <input type='text' name='txtbonus[$i]' value='".number_format($bonusamount,'1','.','')."' style='text-align: right' class='input_e' size='8'>
                                    </td>
                                    <TD class='$cls'  align='center'>
                                          <input type='text' name='txtremarks[$i]' value='' class='input_e' >
                                    </td>
                              </tr>";


                                    


                        $i++;
                  
                  



            }
            echo  " <input type='hidden' value='$i' name='txtTotalrow'>
                  <td  colspan='15' align='center' class='button_cell_e'>
                   <input type='button' value='Submit' class='forms_Button_e' onclick='Submitfrom()'>
                </td>
                  </TABLE>";

      }
?>




</form>



</body>

</html>
