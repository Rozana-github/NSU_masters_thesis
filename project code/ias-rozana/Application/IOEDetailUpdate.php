<?PHP
        include_once("Library/dbconnect.php");
        include_once("Library/Library.php");

?>

<html>

<head>
<meta http-equiv='Content-Language' content='en-us'>
<meta http-equiv='Content-Type' content='text/html; charset=windows-1252'>
<title>IOE Entry Form</title>
<link rel='stylesheet' type='text/css' href='Style/interface_styles.css' />
<link rel='stylesheet' type='text/css' href='Style/generic_form.css'>
<link rel='stylesheet' type='text/css' href='Style/eng_form.css'>
<script language="JavaScript">
function Submitfrom()
{
      if(document.frmEmployeeEntry.cboemp.value=='-1' )
      {
            alert("You Must Enter Employee No");
            document.frmEmployeeEntry.cboemp.focus();
      }
      else if(document.frmEmployeeEntry.txtamount.value=='' )
      {
            alert("You Must Enter Amount");
            document.frmEmployeeEntry.txtamount.focus();
      }
      else
      {
            document.frmEmployeeEntry.submit();
      }
}


</script>


</head>

<body class='body_e'>
<form name='frmEmployeeEntry' method='post'  action='AddToIOEUpdate.php'>

<?PHP
      $searchinfo="
                  SELECT
                        mas_ioe.serial_no,
                        mas_ioe.employeeobjectid,
                        mas_ioe.amount,
                        mas_ioe.received_date,
                        mas_ioe.expected_pay_date,
                        mas_ioe.purpose,
                        mas_ioe.remarks,
                        mas_ioe.pay_date,
                        mas_ioe.method_of_pay,
                        mas_employees.employee_name
                  FROM
                        mas_ioe
                        left join mas_employees on mas_ioe.employeeobjectid=mas_employees.employeeobjectid
                  where
                        mas_ioe.serial_no='".$Serialno."'
                        and mas_ioe.status='0'
                  ";
      $rsallinfo=mysql_query($searchinfo)or die(mysql_error());
      if(mysql_num_rows($rsallinfo)<=0)
      {
            die(drawNormalMassage("This IOE has been cleared"));
      }
      else
      {
            while($rowinfo=mysql_fetch_array($rsallinfo))
            {
                  extract($rowinfo);
                  $receivedate=explode("-",$received_date);
                  $exppaydate=explode("-",$expected_pay_date);
                  $rday=intval($receivedate[2]);
                  $rmonth=intval($receivedate[1]);
                  $ryear=intval($receivedate[0]);
                  $epday=intval($$exppaydate[2]);
                  $epmonth=intval($$exppaydate[1]);
                  $epmonth=intval($$exppaydate[0]);
            }
      }


?>


<table border='0' width='100%'  cellspacing='0' cellpadding='0'>
        <tr>
                <td class='top_left_curb'></td>
                <td colspan='4' class='header_cell_e' align='center'>IOU Entry Form</td>
                <td class='top_right_curb'></td>
        </tr>

        <tr>
                <td class='lb'></td>
                <td class='td_e'><b>Employee </b></td>
                <td class='td_e'>
                        <select name='cboemp' class='select_e'>
                        <?PHP
                              createCombo("Employee","mas_employees","employeeobjectid","employee_name","","$employeeobjectid");
                        ?>
                        </select>

                </td>
                <td class='td_e'><b>Amount</b></td>
                <td class='td_e'>
                        <?PHP
                              echo"<input type='text' name='txtamount' value='$amount' class='input_e'>";
                        ?>
                </td>
                <td class='rb'></td>
        </tr>
        <tr>
                <td class='lb'></td>
                <td class='td_e'><b>Received Date</b></td>
                <td class='td_e'>
                        <?PHP
                              echo "<select name='rDay' class='select_e'>";
                                          comboDay("$rday");
                              echo "</select>
                                    <select name='rMonth' class='select_e'>";
                                          comboMonth("$rmonth");
                              echo "</select>
                                    <select name='rYear' class='select_e'>";
                                          comboYear("$ryear");
                              echo"</select>";
                        ?>
                </td>
                <td class='td_e'><b>Expected Pay Date</b></td>
                <td class='td_e'>
                        <?PHP
                              echo "<select name='epDay' class='select_e'>";
                                          comboDay("$epday");
                              echo "</select>
                                    <select name='epMonth' class='select_e'>";
                                          comboMonth("epmonth");
                              echo "</select>
                                    <select name='epYear' class='select_e'>";
                                          comboYear("epyear");
                              echo"</select>";


                        ?>
                </td>
                <td class='rb'></td>
        </tr>
        <tr>
                <td class='lb'></td>
                <td class='td_e'><b>Purpose</b></td>
                <td class='td_e' colspan='3'>
                        <?PHP
                              echo"<input type='text' name='txtpurpose' value='$purpose' class='input_e'>";
                        ?>
                </td>
                <td class='rb'></td>
        </tr>
        <tr>
                <td class='lb'></td>
                <td class='td_e' ><b>Remarks</b></td>
                <td class='td_e' colspan='3'>
                        <?PHP
                              echo"<input type='text' name='txtremarks' value='$remarks' class='input_e'>";
                        ?>
                </td>
                <td class='rb'></td>
        </tr>

        <tr>
                <td class='lb'></td>
                <td class='td_e'><b>Designation</b></td>
                <td class='td_e'>
                        <select name='cbopaymathod' class='select_e'>
                              <Option value='-1'>Select Pyament Mathod</Option>
                              <?PHP
                                    echo" <Option value='1'";
                                    if($method_of_pay=='1')
                                          echo" selected" ;
                                    echo" >By Bill</Option>";
                                    echo"<Option value='2'" ;
                                    if($method_of_pay=='2')
                                          echo " selected";
                                    echo" >By Bill & Cash</Option>";
                                    echo"<Option value='3'";
                                    if($method_of_pay=='3')
                                          echo" selected";
                                    echo" >By Cash</Option>";
                              ?>
                        </select>
                </td>
                <td class='td_e' colspan='2'>&nbsp;</td>
                <td class='rb'></td>
                <?PHP
                   echo"<input type='hidden' name='txtslno' value='$serial_no'>";
                ?>
        </tr>

        <tr>
                <td class='lb'></td>
                <td colspan='4' align='center' class='button_cell_e'>
                   <input type='Button' value='Submit' class='forms_Button_e' onclick='Submitfrom()'>
                </td>
                <td class='rb'></td>
        </tr>
        <tr>
            <td class='bottom_l_curb'></td>
            <td class='bottom_f_cell' colspan='4'></td>
            <td class='bottom_r_curb'></td>

        </tr>

</table>
</div>
</div>
</form>
</body>

</html>

