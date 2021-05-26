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


function sendData()
{

           /* if(document.frmEmployeeEntry.cboDepartment.value == '-1')
            {
                  alert("Select Department");
                  document.frmEmployeeEntry.cboDepartment.focus();
            }
            else */
                  document.frmEmployeeEntry.submit();

}
function finddata()
{
      document.frmEmployeeEntry.action="employeegratuaty.php";
      document.frmEmployeeEntry.submit();
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




<form name='frmEmployeeEntry' method='post' action='Addtoempgratuaty.php' >


<table width='100%' id='table1' cellspacing='0' cellpadding='0' align='center'>
                  <tr>
                        <td class='top_left_curb'></td>
                        <td colspan='4' class='header_cell_e' align='center'>Employee Gratuaty</td>
                        <td class='top_right_curb'></td>
                  </tr>
                  <tr>
                        <td class='lb'></td>

                        <td class='caption_e'>Month</td>
                        <td class='td_e'>
                              <select name='cboMonth' class='select_e'>
                                    <?PHP
                                          comboMonth($cboMonth);
                                    ?>
                              </select>
                              <select name='cboYear' class='select_e'>
                                    <?PHP
                                          comboYear("","",$cboYear);
                                    ?>
                              </select>
                        
                        </td>
                        <td class='caption_e'>Department</td>
                        <td class='td_e'>
                              <select name='cboDepartment' class='select_e' onchange='finddata()'>
                              <?PHP
                                    $query="select
                                                cost_code,
                                                description
                                            from
                                                mas_cost_center

                                            order by
                                                description
                                           ";
                                    createQueryCombo("Department",$query,"-1","$cboDepartment");
                              ?>
                              </select>
                        </td>

                  </tr>
                  <tr>
                        <td class='bottom_l_curb'></td>
                        <td class='bottom_f_cell' colspan='4'></td>
                        <td class='bottom_r_curb'></td>
                  </tr>
            </table>
            
            <?PHP
                  if(isset($cboDepartment))
                  {
                        if($cboDepartment!='-1')
                        {
                              $queryemployee="SELECT
                                                      employeeobjectid,
                                                      employee_name,
                                                      date_of_join_hr,
                                                      basic_salary,
                                                      DATEDIFF(STR_TO_DATE(LAST_DAY('$cboYear-$cboMonth-1'),'%Y-%m-%d'),date_of_join_hr)/365 as jobduration
                                             FROM
                                                      mas_employees
                                                      LEFT JOIN mas_emp_sal_info ON employeeobjectid = employee_id
                                             WHERE
                                                      department_id='$cboDepartment'
                                                      and DATE_ADD( date_of_join_hr, INTERVAL 6 MONTH ) <= STR_TO_DATE(LAST_DAY('$cboYear-$cboMonth-1'),'%Y-%m-%d')
                                          ";
                             //echo $queryemployee;
                            $rsemployee=mysql_query($queryemployee)or die(mysql_error());
                            if(mysql_num_rows($rsemployee)>0)
                            {
                              $i=0;
                              echo"<table width='100%' id='table1' cellspacing='0' cellpadding='0' align='center'>
                                    <tr>
                                          <td class='top_left_curb'></td>
                                          <td colspan='5' class='header_cell_e' align='center'>Employee List</td>
                                          <td class='top_right_curb'></td>
                                    </tr>
                                    <tr>
                                                <td class='lb'></td>
                                                <td colspan='1' class='title_cell_e' align='center'>Sl.No</td>
                                                <td colspan='1' class='title_cell_e' align='center'>Employee Name</td>
                                                <td colspan='1' class='title_cell_e' align='center'> basic</td>
                                                <td colspan='1' class='title_cell_e' align='center'> gratuaty</td>
                                                <td colspan='1' class='title_cell_e' align='center'>Remarks</td>
                                                <td class='rb'></td>
                                          </tr>";
                              while($rowemployee=mysql_fetch_array($rsemployee))
                              {
                                    extract($rowemployee);
                                    if($i%2==0)
                                        $cls='even_td_e';
                                    else
                                        $cls='odd_td_e';
                                    if($jobduration>0 && $jobduration<3)
                                    {
                                          $gratuaty=$basic_salary*2;
                                          $Remarks="Gratuaty For 1st year";
                                    }
                                    else if($jobduration=3 )
                                    {
                                          $gratuaty=$basic_salary;
                                          $Remarks="Gratuaty For 3rd year";
                                    }
                                    else if($jobduration>3 && $jobduration <= 10)
                                    {
                                          $gratuaty=$basic_salary*1.5;
                                          $Remarks="Gratuaty For 4-10 year";
                                    }
                                    else if($jobduration>10 && $jobduration <= 25)
                                    {
                                          $gratuaty=$basic_salary*2;
                                          $Remarks="Gratuaty For 10-25 year";
                                    }
                                    echo"<tr>
                                                <td class='lb'></td>
                                                <input type='hidden' value='$employeeobjectid' name='txtempid[$i]' >
                                                <TD class='$cls' >".($i+1)."</TD>
                                                <td colspan='1' class='$cls' align='left'>$employee_name</td>
                                                <td colspan='1' class='$cls' align='right'>".number_format($basic_salary,2,'.','')."</td>
                                                <td colspan='1' class='$cls' align='center'><input type='text' style='text-align: right' value='".number_format($gratuaty,2,'.','')."' name='txtgratuaty[$i]' class='input_e' size='10'></td>
                                                <td colspan='1' class='$cls' align='center'><input type='text' size='30' value='$Remarks' name='txtremarks[$i]' class='input_e'></td>
                                                <td class='rb'></td>
                                          </tr>";
                                   $i++;

                                    
                              }
                              echo"
                                    <input type='hidden' value='$i' name='totalrow'>
                                 <tr>
                                          <td class='lb'></td>
                                          <td colspan='5' class='button_cell_e' align='center'>
                                                <input type='button' value='submit' class='forms_Button_e' onclick='sendData()'>
                                          </td>
                                          <td class='rb'></td>
                                    </tr>
                                    <tr>
                                          <td class='bottom_l_curb'></td>
                                          <td class='bottom_f_cell' colspan='5'></td>
                                          <td class='bottom_r_curb'></td>
                                    </tr>
                                    </table>
                              " ;
                            }
                        }
                        
                  }

            ?>


</form>



</body>

</html>
