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

</script>


</head>

<body class='body_e'>
<form name='Form1' method='post'  action='AddToIOEEntry.php'>

<?PHP



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
                              createCombo("Employee","mas_employees","employeeobjectid","employee_name","","");
                        ?>
                        </select>

                </td>
                <td class='td_e'><b>Amount</b></td>
                <td class='td_e'>
                        <input type='text' name='txtamount' value='' class='input_e'>
                </td>
                <td class='rb'></td>
        </tr>
        <tr>
                <td class='lb'></td>
                <td class='td_e'><b>Received Date</b></td>
                <td class='td_e'>
                        <?PHP
                              echo "<select name='rDay' class='select_e'>";
                                          comboDay("");
                              echo "</select>
                                    <select name='rMonth' class='select_e'>";
                                          comboMonth("");
                              echo "</select>
                                    <select name='rYear' class='select_e'>";
                                          comboYear("");
                              echo"</select>";
                        ?>
                </td>
                <td class='td_e'><b>Expected Pay Date</b></td>
                <td class='td_e'>
                        <?PHP
                              echo "<select name='epDay' class='select_e'>";
                                          comboDay("");
                              echo "</select>
                                    <select name='epMonth' class='select_e'>";
                                          comboMonth("");
                              echo "</select>
                                    <select name='epYear' class='select_e'>";
                                          comboYear("");
                              echo"</select>";


                        ?>
                </td>
                <td class='rb'></td>
        </tr>
        <tr>
                <td class='lb'></td>
                <td class='td_e'><b>Purpose</b></td>
                <td class='td_e' colspan='3'>
                        <input type='text' name='txtpurpose' value='' class='input_e'>
                </td>
                <td class='rb'></td>
        </tr>
        <tr>
                <td class='lb'></td>
                <td class='td_e'><b>Remarks</b></td>
                <td class='td_e' colspan='3'>
                        <input type='text' name='txtremarks' value='' class='input_e'>
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
                                    echo" <Option value='1'>By Bill</Option>
                                          <Option value='2'>By Bill & Cash</Option>
                                          <Option value='3'>By Cash</Option>";
                              ?>
                        </select>
                </td>
                <td class='td_e' colspan='2'>&nbsp;</td>
                <td class='rb'></td>
        </tr>

        <tr>
                <td class='lb'></td>
                <td  colspan='4' align='center' class='button_cell_e'>
                   <input type='submit' value='Submit' class='forms_Button_e'>
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

