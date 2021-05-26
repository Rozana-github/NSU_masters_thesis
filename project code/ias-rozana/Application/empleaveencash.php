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
  var xmlHttp = false;
      try
      {
            xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
      }
      catch (e)
      {
            try
            {
                  xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            catch (e2)
            {
                  xmlHttp = false;
            }
      }
      if (!xmlHttp && typeof XMLHttpRequest != 'undefined')
      {
            xmlHttp = new XMLHttpRequest();
      }

  function setEmployee()
      {

                  var department=document.frmEmployeeEntry.cboDepartment.value;
                  var employee=document.frmEmployeeEntry.cboemployee.value;

                  var FunctionName="createCombo";
                  var ComboName="cboemployee";
                  var SelectA="Employee";
                  var TableName="mas_employees";
                  var ID="employeeobjectid";
                  var Name="employee_name";
                  var Condition=escape("where department_id='"+department+"'");
                  var selectedValue="employee";

                  var URLQuery="FunctionName="+FunctionName+"&ComboName="+ComboName+"&SelectA="+SelectA+"&TableName="+TableName+"&ID="+ID+"&Name="+Name+"&Condition="+Condition+"&selectedValue="+selectedValue+"&OnChangeEvent='setSalary()'";
                  callServer(URLQuery);
      }
      function callServer(URLQuery)
      {
            var url = "Library/AjaxLibrary.php";

            xmlHttp.open("POST", url, true);

            xmlHttp.setRequestHeader("Method", "POST " + url + " HTTP/1.1");
            xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            xmlHttp.onreadystatechange = ShowBankAccount;
            xmlHttp.send(URLQuery);
      }
      function ShowBankAccount()
      {
            if (xmlHttp.readyState == 4)
            {
                  var response1 = xmlHttp.responseText;
                  window.ename.innerHTML="";
                  window.ename.innerHTML=response1;
            }
      }
      

      function setSalary()
      {
            var employee=document.frmEmployeeEntry.cboemployee.value;
            var cboYear=document.frmEmployeeEntry.cboYear.value;

            var url = "AjaxCode/Searchsalary.php";
            var str="cboemployee="+employee+"&cboYear="+cboYear;
            xmlHttp.open("POST", url, true);

            xmlHttp.setRequestHeader("Method", "POST " + url + " HTTP/1.1");
            xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xmlHttp.onreadystatechange = Showsalary;
            xmlHttp.send(str);
      }
      //--------------------------- Item----------------------------*/
      function Showsalary()
      {
            if (xmlHttp.readyState == 4)
            {
                  var response = xmlHttp.responseText;

                 salaryvalue=new Array();
                 salaryvalue=response.split('-');
                 document.frmEmployeeEntry.txtsalary.value=salaryvalue[0];
                 document.frmEmployeeEntry.txtavailableleave.value=salaryvalue[1];
            }
      }


function sendData()
{

            if(document.frmEmployeeEntry.cboDepartment.value == '-1')
            {
                  alert("Select Department");
                  document.frmEmployeeEntry.cboDepartment.focus();
            }
            else if(document.frmEmployeeEntry.cboemployee.value == '-1')
            {
                  alert("Select Employee");
                  document.frmEmployeeEntry.cboemployee.focus();
            }
            else
                  document.frmEmployeeEntry.submit();

}



function setamount()
{
      var grosssalary=parseFloat(document.frmEmployeeEntry.txtsalary.value);
      var availableleave=parseInt(document.frmEmployeeEntry.txtavailableleave.value);
      var takenleave=parseInt(document.frmEmployeeEntry.txtadjustleave.value);
      var encashamount=0;
      if(availableleave>takenleave)
      {
            encashamount=(grosssalary/30)*takenleave;
            document.frmEmployeeEntry.txtamount.value=encashamount;
            
      }
      else
      {
            alert("You exit the Leave Limit");
            document.frmEmployeeEntry.txtadjustleave.focus();
      }
}

</script>

</head>

<body class='body_e' onload='setEmployee()'>




<form name='frmEmployeeEntry' method='post' action='Addtoleaveencash.php' >


<table width='100%' id='table1' cellspacing='0' cellpadding='0' align='center'>
                  <tr>
                        <td class='top_left_curb'></td>
                        <td colspan='4' class='header_cell_e' align='center'>Leave Encash</td>
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
                              <select name='cboDepartment' class='select_e' onchange='setEmployee()'>
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
                        <td class='lb'></td>
                        <td class='caption_e' >Employee Name</td>
                        <td class='td_e' >
                              <span id='ename'>
                                    <select name='cboemployee' class='select_e' >
                                          <option value='-1'>Select Employee</option>
                                    </select>
                              </span>
                        </td>
                        <?PHP
                            /*  if($cboemployee!='-1')
                              {
                                    $queryempsalary="SELECT
                                                      (basic_salary + house_allowance + medical_allowance + convance + food_allowance + utility_allowance + special_allowance + maintenance_allowance + inflation_allowance + others_allowance) - ( transport + income_tax ) AS salary,
                                                      mas_emp_leave.balance
                                                  FROM
                                                      mas_emp_sal_info
                                                      left join mas_emp_leave on mas_emp_leave.emp_id=mas_emp_sal_info.employee_id and leave_year='$cboYear'
                                                  where
                                                      mas_emp_sal_info.employee_id='$cboemployee'
                                                  ";
                                    $rssalary=mysql_query($queryempsalary)or die(mysql_error());
                                    while($rowsalary=mysql_fetch_array($rssalary))
                                    {
                                          extract($rowsalary);
                                    }

                              }*/
                        ?>
                        <td class='caption_e' >Salary</td>
                        <td class='td_e'>
                              <?PHP
                                    echo"<input type='text' value='$salary' name='txtsalary' class='input_e' onfocus='setSalary()'>";
                              ?>
                        </td>
                        <td class='rb'></td>
                  </tr>
                  <tr>
                        <td class='lb'></td>
                        <td class='caption_e' >Available Leave</td>
                        <td class='td_e' >
                              <?PHP
                                    echo"<input type='text' value='$balance' name='txtavailableleave' class='input_e' readonly>";
                              ?>
                        </td>
                        <td class='caption_e' >Adjust Leave</td>
                        <td class='td_e'><input type='text' value='' name='txtadjustleave' class='input_e' onchange='setamount()'>
                        <td class='rb'></td>
                  </tr>
                  <tr>
                        <td class='lb'></td>
                        <td class='caption_e' >Amount</td>
                        <td class='td_e' colspan='3' >
                              <input type='text' value='' name='txtamount' class='input_e'>
                        <td class='rb'></td>
                  </tr>
                  <tr>
                        <td class='lb'></td>
                        <td colspan='4' class='button_cell_e' align='center'>
                              <input type='button' value='submit' class='forms_Button_e' onclick='sendData()'>
                        </td>
                        <td class='rb'></td>
                  </tr>
                  <tr>
                        <td class='bottom_l_curb'></td>
                        <td class='bottom_f_cell' colspan='4'></td>
                        <td class='bottom_r_curb'></td>
                  </tr>
            </table>
            


</form>



</body>

</html>
