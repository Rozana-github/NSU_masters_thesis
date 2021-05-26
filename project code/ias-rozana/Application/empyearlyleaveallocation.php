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
      document.frmEmployeeEntry.action="empyearlyleaveallocation.php";
      document.frmEmployeeEntry.submit();
}

function setbalance(val)
{
      var openingbalance=parseInt(document.frmEmployeeEntry.elements["txtopen["+val+"]"].value)
      var currentbalance=parseInt(document.frmEmployeeEntry.elements["txtcurrent["+val+"]"].value)
      var totalbalance=openingbalance+currentbalance;
      document.frmEmployeeEntry.elements["txtbalance["+val+"]"].value=totalbalance;
}

</script>

</head>

<body class='body_e'>




<form name='frmEmployeeEntry' method='post' action='Addtoempyearlyleaveallocation.php' >


<table width='100%' id='table1' cellspacing='0' cellpadding='0' align='center'>
                  <tr>
                        <td class='top_left_curb'></td>
                        <td colspan='4' class='header_cell_e' align='center'>Employee Leave Allocation</td>
                        <td class='top_right_curb'></td>
                  </tr>
                  <tr>
                        <td class='lb'></td>

                        <td class='caption_e'>Year</td>
                        <td class='td_e'>

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
                     <td class='rb'></td>
                  </tr>
                  <tr>
                        <td class='bottom_l_curb'></td>
                        <td class='bottom_f_cell' colspan='4'></td>
                        <td class='bottom_r_curb'></td>
                  </tr>
            </table>
            
            <?PHP
                  $cbomonth=date("m");
                  $privyear=$cboYear-1;
                  if(isset($cboDepartment))
                  {
                        if($cboDepartment!='-1')
                        {
                              $queryemployee="SELECT
                                                      employeeobjectid,
                                                      employee_name,
                                                      ifnull( a.balance, 0 ) AS opening_balance,
                                                      a.leave_id
                                             FROM
                                                      mas_employees
                                                      LEFT JOIN (
                                                                  select
                                                                        emp_id,
                                                                        leave_id,
                                                                        balance
                                                                  from
                                                                        mas_emp_leave
                                                                  where
                                                                        leave_year=' $privyear'
                                                                  ) as a ON a.emp_id = employeeobjectid
                                             WHERE
                                                      department_id='$cboDepartment' and
                                                      date_of_join_hr <= STR_TO_DATE('$cboYear-$cbomonth-1','%Y-%m-%d')

                                          ";
                             //echo $queryemployee;
                            $rsemployee=mysql_query($queryemployee)or die(mysql_error());
                            if(mysql_num_rows($rsemployee)>0)
                            {
                              $i=0;
                              echo"<table width='100%' id='table1' cellspacing='0' cellpadding='0' align='center'>
                                    <tr>
                                          <td class='top_left_curb'></td>
                                          <td colspan='7' class='header_cell_e' align='center'>Employee List</td>
                                          <td class='top_right_curb'></td>
                                    </tr>
                                    <tr>
                                                <td class='lb'></td>
                                                <td colspan='1' class='title_cell_e' align='center'>Sl.No</td>
                                                <td colspan='1' class='title_cell_e' align='center'>Employee Name</td>
                                                <td colspan='1' class='title_cell_e' align='center'>Leave Name</td>
                                                <td colspan='1' class='title_cell_e' align='center'>Previous Leave</td>
                                                <td colspan='1' class='title_cell_e' align='center'>Current Allocation</td>
                                                <td colspan='1' class='title_cell_e' align='center'>Total Leave</td>
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

                                    echo"<tr>
                                                <td class='lb'></td>
                                                <input type='hidden' value='$employeeobjectid' name='txtempid[$i]' >
                                                <TD class='$cls' >".($i+1)."</TD>
                                                <td colspan='1' class='$cls' align='left'>$employee_name</td>
                                                <td colspan='1' class='$cls' align='left'>
                                                      <select name='livename[$i]' class='select_e'>";
                                                      createCombo("Leave","mas_leave","leave_id","leave_name","","$leave_id");

                                                echo"</select>
                                                </td>
                                                <td colspan='1' class='$cls' align='center'><input type='text' style='text-align: right' value='".number_format($opening_balance,2,'.','')."' name='txtopen[$i]' class='input_e' size='10'></td>
                                                <td colspan='1' class='$cls' align='center'><input type='text' style='text-align: right' value='' name='txtcurrent[$i]' class='input_e' size='10' onblur='setbalance($i)'></td>
                                                <td colspan='1' class='$cls' align='center'><input type='text' style='text-align: right' value='' name='txtbalance[$i]' class='input_e' size='10' readonly></td>
                                                <td colspan='1' class='$cls' align='center'><input type='text' value='' name='txtremarks[$i]' class='input_e'></td>
                                                <td class='rb'></td>
                                          </tr>";
                                   $i++;

                                    
                              }
                              echo"
                                    <input type='hidden' value='$i' name='totalrow'>
                                 <tr>
                                          <td class='lb'></td>
                                          <td colspan='7' class='button_cell_e' align='center'>
                                                <input type='button' value='submit' class='forms_Button_e' onclick='sendData()'>
                                          </td>
                                          <td class='rb'></td>
                                    </tr>
                                    <tr>
                                          <td class='bottom_l_curb'></td>
                                          <td class='bottom_f_cell' colspan='7'></td>
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
