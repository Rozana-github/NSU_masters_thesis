<?PHP
        include_once("Library/dbconnect.php");
        include_once("Library/Library.php");

?>

<html>

<head>
<meta http-equiv='Content-Language' content='en-us'>
<meta http-equiv='Content-Type' content='text/html; charset=windows-1252'>

<title>Employee Update Form</title>
<link rel='stylesheet' type='text/css' href='Style/interface_styles.css' >
<link rel='stylesheet' type='text/css' href='Style/generic_form.css'>
<link rel='stylesheet' type='text/css' href='Style/eng_form.css'>
<script language="JavaScript">
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

</script>


</head>

<body class='body_e'>
<form name='frmEmployeeEntry' method='post'  action='AddToEmployeeUpdate.php'>
<?PHP
                //search all information
                $searchAllInfo="
                              select
                                    mas_employees.employeeobjectid,
                                    mas_employees.employeeno,
                                    mas_employees.employee_name,
                                    mas_employees.fathers_name,
                                    mas_employees.mothers_name,
                                    mas_employees.date_of_birth,
                                    mas_employees.date_of_join_hr,
                                    mas_employees.date_of_joining_bpp,
                                    mas_employees.emp_current_address,
                                    mas_employees.emp_permanent_address,
                                    mas_employees.contact_number,
                                    mas_employees.blood_group,
                                    mas_employees.email_address,
                                    mas_employees.emp_type,
                                    mas_employees.status,
                                    mas_employees.designationid,
                                    mas_employees.staff_type,
                                    mas_employees.payment_type,
                                    mas_employees.remarks,
                                    mas_employees.department_id

                              from
                                    mas_employees

                                where
                                        mas_employees.employeeobjectid='".$EmployeeID."'
                                ";
                $resultAllInfo=mysql_query($searchAllInfo) or die(mysql_error());
                while($rowAllInfo=mysql_fetch_array($resultAllInfo))
                {
                    extract($rowAllInfo);
                    $BirthDT=explode("-", $date_of_birth);
                    $Brithday=intval($BirthDT[2]);
                    $Brithmonth=intval($BirthDT[1]);
                    $Brithyear=intval($BirthDT[0]);

                    $JoinDT=explode("-", $date_of_join_hr);
                    $joinday=intval($JoinDT[2]);
                    $joinmonth=intval($JoinDT[1]);
                    $joinyear=intval($JoinDT[0]);

                    $JoinBP=explode("-",$date_of_joining_bpp);
                    $joinBPday=intval($JoinBP[2]);
                    $joinBPmonth=intval($JoinBP[1]);
                    $joinBPyear=intval($JoinBP[0]);

                }
                
        //echo $searchAllInfo;

echo"
<table border='0' width='100%'  cellspacing='0' cellpadding='3'>
        <tr>
                <td class='top_left_curb'></td>
                <td colspan='4' width='100%' align='center' class='header_cell_e'>Employee Update Form</td>
                <td class='top_right_curb'></td>
        </tr>

        <tr>
                <td class='lb'></td>
                <td  class='td_e'><b>Employee No</b></td>
                <td  class='td_e'>
                        <input type='text' name ='txtempno' value='$employeeno' class='input_e' size='10'>
                </td>
                <td  class='td_e'><b>Employee Name</b></td>
                <td  class='td_e'>
                        <input type='text' name='txtempname' value='$employee_name'  class='input_e'>
                </td>


                <td class='rb' ></td>
        </tr>

        <tr>
                <td class='lb'></td>
                <td  class='td_e'><b>Father Name</b></td>
                <td   class='td_e'>
                        <input type='text' name='txtfathername' value='$fathers_name' class='input_e' >
                </td>
                <td class='td_e'><b>Mother Name</b></td>
                <td class='td_e' >
                        <input type='text' name='txtmothername' value='$mothers_name' class='input_e'>
                </td>
                <td class='rb'></td>
        </tr>
        <tr>
                <td class='lb'></td>
                <td  class='td_e'><b>Date Of Birth</b></td>
                <td  class='td_e'>";

                              echo "<select name='BDay'  class='select_e'>";
                                          comboDay("$Brithday");
                              echo "</select>
                                    <select name='BMonth' class='select_e'>";
                                          comboMonth("$Brithmonth");
                              echo "</select>
                                    <select name='BYear' class='select_e';>";
                                          comboYear("$Brithyear");
                              echo"</select>";

               echo" </td>
                <td  class='td_e'><b>Joining Date:</b></td>
                <td  class='td_e'>";

                              echo "<select name='JDay' class='select_e'>";
                                          comboDay("$joinday");
                              echo "</select>
                                    <select name='JMonth' class='select_e'>";
                                          comboMonth("$joinmonth");
                              echo "</select>
                                    <select name='JYear' class='select_e';>";
                                          comboYear("$joinyear");
                              echo"</select>";



                echo"</td>
                        <td class='rb'></td>
                  </tr>
                  <tr>
                  <td class='lb'></td>
                  <td class='td_e'><b>Joining Date at BPP</b></td>
                  <td class='td_e'>";

                              echo "<select name='BPDay' class='select_e'>";
                                          comboDay("$joinBPday");
                              echo "</select>
                                    <select name='BPMonth' class='select_e'>";
                                          comboMonth("$joinBPmonth");
                              echo "</select>
                                    <select name='BPYear' class='select_e'>";
                                          comboYear("$joinBPyear");
                              echo"</select>";



                echo"</td>
                <td class='td_e'><b>Designation</b></td>
                <td class='td_e'>
                        <select name='cbodesignation' class='select_e'>";

                                    createCombo("Designation","mas_designation","designationid","description","","$designationid");

                echo"        </select>
                </td>

                <td class='rb'></td>
        </tr>
        <tr>
                <td class='lb'></td>
                <td class='td_e'><b>Department</b></td>
                <td class='td_e'>
                        <select name='cboDepartment' class='select_e'>";

                                    createCombo("Department","mas_cost_center","cost_code","description","","$department_id");

                  echo "</select>
                </td>
                <td class='td_e'><b>Staf Type</b></td>
                <td class='td_e'>
                        <select name='cbostafftype' class='select_e'>";
                             if($staff_type=='1')
                             {
                              echo "<option value='1' selected>Admin</option>
                                    <option value='2'>Factory</option>";
                             }
                             else if($staff_type=='2')
                             {
                                    echo "
                                    <option value='1'>Admin</option>
                                    <option value='2' selected>Factory</option>
                                    ";
                             }
                             else
                             {
                                   echo "<option value='1'>Admin</option>
                                    <option value='2'>Factory</option>";
                             }
                  echo "</select>
                </td>

                <td class='rb'></td>
        </tr>

        <tr>
                <td class='lb'></td>
                <td class='td_e'><b>Current Address</b></td>
                <td class='td_e' >
                        <textarea name='txtcuraddress'  class='input_e' >$emp_current_address</textarea>
                </td>
                <td class='td_e'><b>Permanent Address</b></td>
                <td class='td_e' >
                        <textarea name='txtperaddress'  class='input_e'>$emp_permanent_address</textarea>
                </td>
                <td class='rb'></td>
        </tr>
        <tr>
                <td class='lb'></td>
                <td class='td_e'><b>Contact Number</b></td>
                <td class='td_e' >
                        <input type='text' name='txtcontactno' value='$contact_number' class='input_e'>
                </td>
                <td class='td_e'><b>Blood Group</b></td>
                <td class='td_e' >
                        <input type='text' name='txtbloodgroup' value='$blood_group' class='input_e' Size='10'>
                </td>

                <td class='rb'></td>
        </tr>
        <tr>
                <td class='lb'></td>
                <td class='td_e'><b>Email Address</b></td>
                <td class='td_e' colspan='3'>
                        <input type='text' name='txtemail' value='$email_address' class='input_e' Size='30'>
                </td>

                <td class='rb'></td>
        </tr>
         <tr>
                <td class='lb'></td>
                <td class='td_e'><b>Type</b></td>
                <td class='td_e' >
                       <select name='cbotype' class='select_e'>";
                              if($emp_type=='1')
                              {
                              echo"
                              <option value='1' selected>Regular</option>
                              <option value='2'>Casual</option>
                              <option value='3'>Project</option>";
                              }
                              else if($emp_type=='2')
                              {
                              echo"
                              <option value='1' >Regular</option>
                              <option value='2' selected>Casual</option>
                              <option value='3'>Project</option>";
                              }
                              else if($emp_type=='3')
                              {
                              echo"
                              <option value='1'>Regular</option>
                              <option value='2'>Casual</option>
                              <option value='3' selected>Project</option>";
                              }
                              else
                              {
                                 echo"
                              <option value='1'>Regular</option>
                              <option value='2'>Casual</option>
                              <option value='3'>Project</option>";
                              }
            echo"        </select>
                </td>
                <td class='td_e'><b>Payment Type</b></td>
                <td class='td_e' >
                        <select name='cbopaytype' class='select_e'>";
                             if($payment_type=='1')
                             {
                              echo "<option value='1' selected>Cash</option>
                                    <option value='2'>Bank</option>";
                             }
                             else if($payment_type=='2')
                             {
                                    echo "
                                    <option value='1'>Cash</option>
                                    <option value='2' selected>Bank</option>
                                    ";
                             }
                             else
                             {
                                   echo "<option value='1'>Cash</option>
                                    <option value='2'>Bank</option>";
                             }

                              
                             
                       echo " </select>

                </td>

                <td class='rb'></td>
        </tr>
        <tr>
                <td class='lb'></td>
                <td class='td_e'><b>Remarks</b></td>
                <td class='td_e' >
                       <input type='text' name='txtremarks' value='$remarks' class='input_e' Size='30'>
                </td>
                <td class='td_e'><b>Status</b></td>
                <td class='td_e' >
                        <select name='cbostatus' class='select_e'>";
                              if($status=='1')
                             {
                              echo "<option value='1' selected>Active</option>
                                    <option value='0'>Inactive</option>";
                             }
                             else if($status=='0')
                             {
                                    echo "
                                    <option value='1'>Active</option>
                                    <option value='0' selected>Inactive</option>
                                    ";
                             }
                             else
                             {
                                   echo "<option value='1'>Active</option>
                                    <option value='0'>Inactive</option>";
                             }



                       echo "
                        </select>

                </td>

                <td class='rb'></td>
        </tr>





        <tr>
                <td class='lb'></td>
                <td  colspan='4' align='center' class='button_cell_e'>
                   <input type='button' value='Update' class='forms_Button_e' onclick='Submitfrom()'>
                </td>
                <td class='rb'></td>
                
        </tr>
        <tr>
            <td class='bottom_l_curb'></td>
            <td class='bottom_f_cell' colspan='4'></td>
            <td class='bottom_r_curb'></td>
        </tr>

</table>

";
echo"<input type='hidden' name='txtempID' value='$employeeobjectid'>";
?>
</form>
</body>

</html>

