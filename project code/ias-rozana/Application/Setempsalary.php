<?PHP
        include_once("Library/dbconnect.php");
        include_once("Library/Library.php");

?>

<html>

<head>
<meta http-equiv='Content-Language' content='en-us'>
<meta http-equiv='Content-Type' content='text/html; charset=windows-1252'>
<title>Employee Entry Form</title>
<link rel='stylesheet' type='text/css' href='Style/interface_styles.css' />
<link rel='stylesheet' type='text/css' href='Style/generic_form.css'>
<link rel='stylesheet' type='text/css' href='Style/eng_form.css'>
<script language="JavaScript">
function Submitfrom()
{
      if(document.frmEmployeeEntry.txtBasic.value=='' )
      {
            alert("You Must Enter Designation");
            document.frmEmployeeEntry.txtBasic.focus();
      }
      else
      {
            document.frmEmployeeEntry.submit();
      }
}
function goback()
{
      window.location="EmployeeSalaryEntry.php";
}
function goemployee()
{
    window.location="MasSalGradEntry.php";
}

</script>


</head>

<body class='body_e'>
<form name='frmEmployeeEntry' method='post'  action='AddToSetEmpSalary.php'>

<?PHP

            $queryexist="select * from mas_emp_sal_info where employee_id='$empid'";
            $rsexist=mysql_query($queryexist);
            if(mysql_num_rows($rsexist)>0)
            {
            if(mysql_num_rows($rsexist))
            {
                  $update=1;
            }
            if($update==1)
            {
                  $query="select
                              grad_id,
                              basic_salary,
                              house_allowance,
                              medical_allowance,
                              convance,
                              food_allowance,
                              utility_allowance,
                              special_allowance,
                              maintenance_allowance,
                              inflation_allowance,
                              transport,
                              others_allowance,
                              incement_amount,
                              entry_date,
                              increment_date,
                              income_tax,
                              welf_fair,
                              pf_status,
                              ot_status,
                              remarks
                        from
                              mas_emp_sal_info
                        where
                              employee_id='$empid';
";
            }

             //echo $query;
            $rs=mysql_query($query)or die(mysql_error());
            while($row=mysql_fetch_array($rs))
            {
                  extract($row);
                  $efdate=explode("-",$effective_date);
                  
            }
            }


?>


<table border='0' width='100%'  cellspacing='0' cellpadding='0'>
        <tr>
                <td class='top_left_curb'></td>
                <td colspan='2' align='center' class='header_cell_e'>Employee Detail Salary Entry Form</td>
                <td class='top_right_curb'></td>
        </tr>

        <tr>
                <td class='lb'></td>
                <td class='caption_e'><b>Employee Name</b></td>
                <td class='td_e'>
                        <?PHP
                        echo "<input type='hidden' value='$empid' name='txtempid'>
                              <input type='hidden' value='$grad' name='txtgrad'>
                              <input type='hidden' value='$update' name='txtupdate'>";


                              echo "<input type='text' name ='txtname' value='".pick("mas_employees","employee_name","employeeobjectid=$empid")."' class='input_e' readonly>";
                        ?>
                </td>

                <td class='rb'></td>
        </tr>
        <tr>
                <td class='lb'></td>
                <td class='caption_e'><b>Basic</b></td>
                <td class='td_e'>
                        <?PHP


                              echo "<input type='text' name ='txtBasic' value='$basic_salary' class='input_e' >";

                        ?>
                </td>

                <td class='rb'></td>
        </tr>
        

        <tr>
                <td class='lb'></td>
                <td class='caption_e'><b>House Allowance</b></td>
                <td class='td_e'>
                        <?PHP


                              echo "<input type='text' name ='txtHouse' value='$house_allowance' class='input_e' >";

                        ?>
                </td>

                <td class='rb'></td>
        </tr>

        
        <tr>
                <td class='lb'></td>
                <td class='caption_e'><b>Medical Allowance</b></td>
                <td class='td_e'>
                        <?PHP


                              echo "<input type='text' name ='txtMedical' value='$medical_allowance' class='input_e' >";

                        ?>
                </td>

                <td class='rb'></td>
        </tr>
        <tr>
                <td class='lb'></td>
                <td class='caption_e'><b>convance</b></td>
                <td class='td_e'>
                        <?PHP


                              echo "<input type='text' name ='txtConvance' value='$convance' class='input_e' >";

                        ?>
                </td>

                <td class='rb'></td>
        </tr>
        <tr>
                <td class='lb'></td>
                <td class='caption_e'><b>Food</b></td>
                <td class='td_e'>
                        <?PHP


                              echo "<input type='text' name ='txtFood' value='$food_allowance' class='input_e' >";

                        ?>
                </td>

                <td class='rb'></td>
        </tr>
        <tr>
                <td class='lb'></td>
                <td class='caption_e'><b>Utility Allowance</b></td>
                <td class='td_e'>
                        <?PHP


                              echo "<input type='text' name ='txtUtility' value='$utility_allowance' class='input_e' >";

                        ?>
                </td>

                <td class='rb'></td>
        </tr>
        <tr>
                <td class='lb'></td>
                <td class='caption_e'><b>Special Allowance</b></td>
                <td class='td_e'>
                        <?PHP


                              echo "<input type='text' name ='txtSpecial' value='$special_allowance' class='input_e' >";

                        ?>
                </td>

                <td class='rb'></td>
        </tr>

        
         <tr>
                <td class='lb'></td>
                <td class='caption_e'><b>Maintainnance Allowance</b></td>
                <td class='td_e'>
                        <?PHP


                              echo "<input type='text' name ='txtMaintainnance' value='$maintenance_allowance' class='input_e' >";

                        ?>
                </td>

                <td class='rb'></td>
        </tr>
        <tr>
                <td class='lb'></td>
                <td class='caption_e'><b>Inflation allowance</b></td>
                <td class='td_e'>

                        <?PHP


                              echo "<input type='text' name ='txtInflation' value='$inflation_allowance' class='input_e' >";

                        ?>
                </td>

                <td class='rb'></td>
        </tr>
        <tr>
                <td class='lb'></td>
                <td class='caption_e'><b>Transport</b></td>
                <td class='td_e'>
                        <?PHP


                              echo "<input type='text' name ='txtTransport' value='$transport' class='input_e' >";

                        ?>
                </td>

                <td class='rb'></td>
        </tr>
        <tr>
                <td class='lb'></td>
                <td class='caption_e'><b>Others Allowance</b></td>
                <td class='td_e'>

                        <?PHP


                              echo "<input type='text' name ='txtOthers' value='$others_allowance' class='input_e' >";
                              //createCombo("Other Amount","mas_others_allowance","others_allowance_id","amount"," where effective_date <= sysdate()","$othersid");


                        ?>

                </td>

                <td class='rb'></td>
        </tr>
        <tr>
                <td class='lb'></td>
                <td class='caption_e'><b>Income Tax</b></td>
                <td class='td_e'>

                        <?PHP


                              echo "<input type='text' name ='txtIncome' value='$income_tax' class='input_e' >";
                              //createCombo("Other Amount","mas_others_allowance","others_allowance_id","amount"," where effective_date <= sysdate()","$othersid");


                        ?>

                </td>

                <td class='rb'></td>
        </tr>
        <tr>
                <td class='lb'></td>
                <td class='caption_e'><b>Welfare</b></td>
                <td class='td_e'>

                        <?PHP


                              echo "<input type='text' name ='txtwelfair' value='$welf_fair' class='input_e' >";
                              //createCombo("Other Amount","mas_others_allowance","others_allowance_id","amount"," where effective_date <= sysdate()","$othersid");


                        ?>

                </td>

                <td class='rb'></td>
        </tr>
        <tr>
                <td class='lb'></td>
                <td class='caption_e'><b>Provident Fund</b></td>
                <td class='td_e'>

                        <?PHP
                             if($pf_status==1)
                             {
                                    echo"<input type='radio' value='1' checked  name='pf'>Yes
                                          <input type='radio' value='0'  name='pf'>No";
                              }
                              else
                              {
                                   echo"<input type='radio' value='1'   name='pf'>Yes
                                          <input type='radio' value='0'  checked name='pf'>No";
                              }


                              //echo "<input type='text' name ='txtIncome' value='$Income' class='input_e' >";
                              //createCombo("Other Amount","mas_others_allowance","others_allowance_id","amount"," where effective_date <= sysdate()","$othersid");


                        ?>

                </td>

                <td class='rb'></td>
        </tr>
        <tr>
                <td class='lb'></td>
                <td class='caption_e'><b>Over Time</b></td>
                <td class='td_e'>

                        <?PHP

                              if($ot_status==1)
                             {
                                    echo"<input type='radio' value='1' checked  name='ot'>Yes
                                          <input type='radio' value='0'  name='ot'>No";
                              }
                              else
                              {
                                   echo"<input type='radio' value='1'   name='ot'>Yes
                                          <input type='radio' value='0'  checked name='ot'>No";
                              }
                              //echo "<input type='text' name ='txtIncome' value='$Income' class='input_e' >";
                              //createCombo("Other Amount","mas_others_allowance","others_allowance_id","amount"," where effective_date <= sysdate()","$othersid");


                        ?>

                </td>

                <td class='rb'></td>
        </tr>
        <tr>
                <td class='lb'></td>
                <td class='caption_e'><b>Remarks</b></td>
                <td class='td_e'>

                        <?PHP


                              echo "<input type='text' name ='txtRemarks' value='$remarks' class='input_e' >";
                              //createCombo("Other Amount","mas_others_allowance","others_allowance_id","amount"," where effective_date <= sysdate()","$othersid");


                        ?>

                </td>

                <td class='rb'></td>
        </tr>



        <tr>
                <td class='lb'></td>
                <td  colspan='2' align='center' class='button_cell_e'>
                   <input type='Button' value='Submit' class='forms_Button_e' onclick='Submitfrom()'>

                   <input type='Button' value='Back' class='forms_Button_e' onclick='goback()'>
                </td>
                <td class='rb'></td>
        </tr>


        <tr>
            <td class='bottom_l_curb'></td>
            <td class='bottom_f_cell' colspan='2'></td>
            <td class='bottom_r_curb'></td>

        </tr>

</table>

</form>
</body>

</html>

