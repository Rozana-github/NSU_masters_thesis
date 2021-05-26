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

function CreateNewParty()
{
        var popit=window.open('IOEDetailEntry.php','console','status,scrollbars,width=620,height=500');
}

function EditPartyEntry(val)
{
        var popit=window.open("IOEDetailUpdate.php?Serialno="+val+"",'console','status,scrollbars,width=620,height=500');
}
function enablepaydate(val)
{
      //alert(val);
      if(document.frmIOEclear.elements("chkdate["+val+"]").checked )
      {
            //alert(document.frmIOEclear.elements("chkdate["+val+"]").checked);
            document.frmIOEclear.elements["paydate["+val+"]"].disabled = false;
            //alert("readonly "+document.frmIOEclear.elements("paydate["+val+"]").disabled);
            document.frmIOEclear.elements("paydate["+val+"]").focus();
      }
      else
      {
         document.frmIOEclear.elements["paydate["+val+"]"].disabled = true;
      }
}
function Submitfrom()
{
      document.frmIOEclear.submit();
}


</script>

</head>

<body class='body_e'>




<form name='frmIOEclear' method='post' action='AddToIOEClear.php'>



<?PHP

      $employeequery="
                        SELECT
                              mas_ioe.serial_no,
                              mas_ioe.employeeobjectid,
                              mas_ioe.amount,
                              mas_ioe.received_date,
                              DATE_FORMAT(mas_ioe.expected_pay_date, '%d-%m-%Y') As exppaydate,
                              DATE_FORMAT(CURDATE(),'%d-%m-%Y') As currentdate,
                              mas_ioe.purpose,
                              mas_ioe.pay_date,
                              mas_employees.employee_name
                              
                        FROM
                              mas_ioe
                              left join mas_employees on mas_ioe.employeeobjectid=mas_employees.employeeobjectid
                        where
                              mas_ioe.status='0'

                  ";
      $rsemployee=mysql_query($employeequery) or die();
      $numrows=mysql_num_rows($rsemployee);
      if($numrows>0)
      {
           echo "
                   <TABLE  cellSpacing=0 cellPadding=0 width='100%'>

                              <TR>
                                    <td class='top_left_curb'></td>
                                    <Td colspan='6' class='header_cell_e' align='center'>Unpaid IOU</Td>
                                    <td class='top_right_curb'></td>
                              </TR>
                              <TR>
                                    <td class='lb'></td>
                                    <Td  class='title_cell_e'>SLNo</Td>
                                    <Td  class='title_cell_e'>Employee Name</Td>
                                    <Td  class='title_cell_e'>Amount</Td>
                                    <Td  class='title_cell_e'>Expcted Pay Date</Td>
                                    <Td  class='title_cell_e'>Checked</Td>
                                    <Td  class='title_cell_e'>Pay Date</Td>
                                    <td class='rb'></td>
                                    
                              </TR>


                  ";
            $i=0;
            while($rows=mysql_fetch_array($rsemployee))
            {
                  extract($rows);
                  if($i%2==0)
                        $cls='even_td_e';
                  else
                        $cls='odd_td_e';
                  echo"
                              <TR >
                                    <td class='lb'>

                                    </td>
                                    <TD class='$cls'><INPUT type='text' value='$serial_no' name='txtslno[".$i."]' size='10' readOnly  class='input_e'></TD>
                                    <TD class='$cls'>$employee_name&nbsp;</TD>
                                    <TD class='$cls' align='right'>$amount&nbsp;</TD>
                                    <TD class='$cls' align='center'>$exppaydate&nbsp;</TD>
                                    <TD class='$cls' align='center'><INPUT type='checkbox' name='chkdate[".$i."]'  class='td_e' value='ON' onclick='enablepaydate($i)'></TD>
                                    <TD class='$cls' align='center'><INPUT type='text' value='$currentdate' name='paydate[".$i."]' disabled class='input_e'>
                                          &nbsp;<a href=\"javascript:ComplainDate{$i}.popup();\">
                                          <img src=\"img/cal.gif\" width='13' height='13' border='0' alt=\"Click Here to Pick up the date\">
                                          </a></TD>
                                    <td class='rb'>
                                    <script language=\"JavaScript\">

                                          var ComplainDate".$i." = new calendar1(document.forms['frmIOEclear'].elements[\"paydate[".$i."]\"]);
                                          ComplainDate".$i.".year_scroll = true;
                                          ComplainDate".$i.".time_comp = false;

                                    </script>
                                    </td>

                                    
                              </TR>
                        ";
                  $i++;
            }
            echo  "     <tr>
                              <input type='hidden' name='count' value='$i'>
                              <td class='lb'></td>
                              <td colspan='6' align='center' class='button_cell_e'>
                                    <input type='Button' value='Save' name='saveBtn'  class='forms_button_e' onclick='Submitfrom()'>
                              </td>
                              <td class='rb'></td>
                        </tr>
                        <tr>
                              <td class='bottom_l_curb'></td>
                              <td class='bottom_f_cell' colspan='6'></td>
                              <td class='bottom_r_curb'></td>

                        </tr>
                  </TABLE>";

      }
      else
      {
            echo "
                   <TABLE  cellSpacing=0 cellPadding=0 width='100%'>

                              <TR>
                                    <Td width='100%' class='header_cell_e' align='center'>Unpaid IOE</Td>
                              </TR>
                  </table>";
            drawNormalMassage("There is no Unpaid IOE");

      }
?>




</form>



</body>

</html>
