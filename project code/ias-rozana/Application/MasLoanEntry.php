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
      if(document.frmEmployeeEntry.txtloan.value=='' )
      {
            alert("You Must Enter Designation");
            document.frmEmployeeEntry.txtloan.focus();
      }
      else
      {
            document.frmEmployeeEntry.submit();
      }
}
function goback()
{
      window.location="MasLoanList.php";
}
function goemployee()
{
    window.location="MasLoanEntry.php";
}

</script>


</head>

<body class='body_e'>
<form name='frmEmployeeEntry' method='post'  action='AddToLoanEntry.php'>

<?PHP
      if($updatevalue=='1')
      {
            $query="select
                              loan_id,
                              loan_description,
                              loan_type,
                              status,
                              inerest_rate,
                              remarks,
                              effctive_date

                        from
                              mas_loan
                        where
                              loan_id='$loanID'";
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
                <td colspan='2' align='center' class='header_cell_e'>Loan Detail Entry Form</td>
                <td class='top_right_curb'></td>
        </tr>

        <tr>
                <td class='lb'></td>
                <td class='caption_e'><b>Loan Name</b></td>
                <td class='td_e'>
                        <?PHP
                        echo "<input type='hidden' value='$loanID' name='txtloanid'>";
                        if($updatevalue=='1')
                              echo "<input type='text' name ='txtloan' value='$loan_description' class='input_e' >";
                        else
                              echo "<input type='text' name ='txtloan' value='' class='input_e' >";
                        ?>
                </td>

                <td class='rb'></td>
        </tr>
        <tr>
                <td class='lb'></td>
                <td class='caption_e'><b>Loan Type</b></td>
                <td class='td_e'>
                        <?PHP

                        if($updatevalue=='1')
                              echo "<input type='text' name ='txtType' value='$loan_type' class='input_e' >";
                        else
                              echo "<input type='text' name ='txtType' value='' class='input_e' >";
                        ?>
                </td>

                <td class='rb'></td>
        </tr>
        

        <tr>
                <td class='lb'></td>
                <td class='caption_e'><b>Interest Rate</b></td>
                <td class='td_e'>
                        <?PHP

                        if($updatevalue=='1')
                              echo "<input type='text' name ='txtrate' value='$inerest_rate' class='input_e' >";
                        else
                              echo "<input type='text' name ='txtrate' value='' class='input_e' >";
                        ?>
                </td>

                <td class='rb'></td>
        </tr>
        <tr>
                <td class='lb'></td>
                <td class='caption_e'><b>Effctive Date</b></td>
                <td class='td_e'>
                        <?PHP

                        if($updatevalue=='1')
                        {
                               echo "<select name='EDay'  class='select_e'>";
                                          comboDay($efdate[2]);
                              echo "</select>
                                    <select name='EMonth' class='select_e'>";
                                          comboMonth($efdate[1]);
                              echo "</select>
                                    <select name='EYear' class='select_e'>";
                                          comboYear($efdate[0]);
                              echo"</select>";
                        }
                        else
                        {
                               echo "<select name='EDay'  class='select_e'>";
                                          comboDay("");
                              echo "</select>
                                    <select name='EMonth' class='select_e'>";
                                          comboMonth("");
                              echo "</select>
                                    <select name='EYear' class='select_e'>";
                                          comboYear("");
                              echo"</select>";
                        }

                        ?>
                </td>

                <td class='rb'></td>
        </tr>
        <tr>
                <td class='lb'></td>
                <td class='caption_e'><b>Remarks</b></td>
                <td class='td_e'>
                        <?PHP

                        if($updatevalue=='1')
                              echo "<input type='text' name ='txtremarks' value='$remarks' class='input_e' >";
                        else
                              echo "<input type='text' name ='txtremarks' value='' class='input_e' >";
                        ?>
                </td>

                <td class='rb'></td>
        </tr>
        <tr>
                <td class='lb'></td>
                <td class='caption_e'><b>Status</b></td>
                <td class='td_e'>
                        <select name='cboStatus' class='select_e'>
                              <?PHP
                              if($updatevalue=='1')
                              {
                                     if($status=='1')
                                    {
                                          echo "<option value='1' selected>Active</option>
                                                <option value='0'>Inactive</option>";
                                    }
                                    if($status=='0')
                                    {
                                          echo "
                                                <option value='1'>Active</option>
                                                <option value='0' selected>Inactive</option>
                                                ";
                                    }
                              }
                              else
                              {
                                    echo"<option value='1'>Active</option>
                                          <option value='0'>Inactive</option>";
                              }
                              ?>
                        </select>
                </td>

                <td class='rb'></td>
        </tr>




        <tr>
                <td class='lb'></td>
                <td  colspan='2' align='center' class='button_cell_e'>
                   <input type='Button' value='Submit' class='forms_Button_e' onclick='Submitfrom()'>
                   <input type='Button' value='New' class='forms_Button_e' onclick='goemployee()'>
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

