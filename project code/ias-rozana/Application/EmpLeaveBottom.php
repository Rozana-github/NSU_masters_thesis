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

function checkvalue()
{
      var totalrow=parseInt(document.frmEmployeeEntry.txtTotalrow.value);

      for(i=0;i<totalrow;i++)
      {
            if(document.frmEmployeeEntry.elements["cboleave["+i+"]"].value!='-1')
            {
                   if(document.frmEmployeeEntry.elements["txtstartDay["+i+"]"].value=='')
                  {
                        alert("Start day can't be blank");
                        document.frmEmployeeEntry.elements["txtstartDay["+i+"]"].focus();
                        return false;
                        continue;
                  }
                  else if(document.frmEmployeeEntry.elements["txtstartMonth["+i+"]"].value=='')
                  {
                        alert("Start Month can't be blank");
                        document.frmEmployeeEntry.elements["txtstartMonth["+i+"]"].focus();
                        return false;
                        continue;
                  }
                  else if(document.frmEmployeeEntry.elements["txtstartYear["+i+"]"].value=='')
                  {
                        alert("Start Year can't be blank");
                        document.frmEmployeeEntry.elements["txtstartYear["+i+"]"].focus();
                        return false;
                        continue;
                  }

                  else if(document.frmEmployeeEntry.elements["txtendDay["+i+"]"].value=='')
                  {
                        alert("End day can't be blank");
                        document.frmEmployeeEntry.elements["txtendDay["+i+"]"].focus();
                        return false;
                        continue;
                  }
                  else if(document.frmEmployeeEntry.elements["txtendMonth["+i+"]"].value=='')
                  {
                        alert("End Month can't be blank");
                        document.frmEmployeeEntry.elements["txtendMonth["+i+"]"].focus();
                        return false;
                        continue;
                  }
                  else if(document.frmEmployeeEntry.elements["txtendYear["+i+"]"].value=='')
                  {
                        alert("End Year can't be blank");
                        document.frmEmployeeEntry.elements["txtendYear["+i+"]"].focus();
                        return false;
                        continue;
                  }
            }
      }
      return true;
}

function Submitfrom()
{
      if(checkvalue())
      {
            document.frmEmployeeEntry.submit();
     }

}



</script>

</head>

<body class='body_e'>




<form name='frmEmployeeEntry' method='post' action='AddToEmpLeave.php'>


<?PHP
      //echo "<input type='hidden' name='mkdecession' value=''>";
      if($cboDepartment!='' && $cboDepartment!='-1')
      {
      $employeequery="  SELECT
                              trn_employees.emp_id,
                              mas_employees.employee_name,
                              mas_designation.description


                        FROM
                              trn_employees
                              LEFT JOIN mas_employees ON mas_employees.employeeobjectid = trn_employees.emp_id and trn_employees.jobstatus='1'
                              left join mas_designation on mas_employees.designationid=mas_designation.designationid

                        where
                              trn_employees.department_id='$cboDepartment'


                        ";
      }
      else
      {
        $employeequery="   SELECT
                              trn_employees.emp_id,
                              mas_employees.employee_name,
                              mas_designation.description


                        FROM
                              trn_employees
                              LEFT JOIN mas_employees ON mas_employees.employeeobjectid = trn_employees.emp_id and trn_employees.jobstatus='1'
                              left join mas_designation on mas_employees.designationid=mas_designation.designationid
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
                                    <Td class='title_cell_e'>Leave Name</td>
                                    <Td class='title_cell_e'>Start Date</td>
                                    <Td class='title_cell_e'>End Date</td>
                                    <Td class='title_cell_e'>Remarks</td>
                              </TR>

                  ";
            while($rows=mysql_fetch_array($rsemployee))
            {
                  extract($rows);
                  if($i%2==0)
                        $cls='even_td_e';
                  else
                        $cls='odd_td_e';

                   echo"
                              <TR  id=set1_row1 >
                                    <input type='hidden' value='$emp_id' name='txtEmployeeid[$i]'>
                                    <TD class='$cls' >".($i+1)."</TD>
                                    <TD class='$cls' >$employee_name</TD>
                                    <TD class='$cls' >$description</TD>
                                    <TD class='$cls'  align='right'>
                                          <select name='cboleave[$i]' class='select_e'>";
                                                createCombo("Leave","mas_leave","leave_id","leave_name","","");
                                    echo" </select>
                                    </td>



                                    <TD class='$cls'  align='center'>";


                                     echo"
                                          d<input type='text' name='txtstartDay[$i]' value='' size='2' maxlength='2' class='input_e'>
                                          m<input type='text' name='txtstartMonth[$i]' value='' size='2' maxlength='2' class='input_e'>
                                          y<input type='text' name='txtstartYear[$i]' value='' size='4' maxlength='4' class='input_e'>
                                    ";

                                    echo"</td>
                                    <TD class='$cls'  align='center'>";


                                     echo"
                                          d<input type='text' name='txtendDay[$i]' value='' size='2' maxlength='2' class='input_e'>
                                          m<input type='text' name='txtendMonth[$i]' value='' size='2' maxlength='2' class='input_e'>
                                          y<input type='text' name='txtendYear[$i]' value='' size='4' maxlength='4' class='input_e'>
                                    ";
                                    echo"</td>
                                    
                                        <TD class='$cls'  align='center'>
                                          <input type='text' name='txtremark[$i]' value='' class='input_e' size='15'>
                                        </td>
                                        </tr>
                        ";
                        $i++;
                  

            }
            echo  " <input type='hidden' value='$i' name='txtTotalrow'>
                  <td  colspan='7' align='center' class='button_cell_e'>
                   <input type='button' value='Submit' class='forms_Button_e' onclick='Submitfrom()'>
                </td>
                  </TABLE>";

      }
?>




</form>



</body>

</html>
