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

            document.frmEmployeeEntry.submit();

}
function doPrint()
                  {
                        window.parent.RptCylinderInfoBottom.focus();
                        window.parent.RptCylinderInfoBottom.print();
                  }



</script>

</head>

<body class='body_e'>




<form name='frmEmployeeEntry' method='post' action='RptCylinderInfoBottom.php' target='RptCylinderInfoBottom'>


<table width='100%' id='table1' cellspacing='0' cellpadding='0' align='center'>
                  <tr>
                        <td class='top_left_curb'></td>
                        <td colspan='3' class='header_cell_e' align='center'>Company Selection</td>
                        <td class='top_right_curb'></td>
                  </tr>
                  <tr>
                        <td class='lb'></td>
                        <td class='caption_e'>Customer:</td>
                        <td class='td_e'>
                                <select name='cbocustomer' class='select_e' >
                                <?PHP
                                        createCombo("Customer","mas_customer","customer_id","company_name","order by company_name",$cbocustomer);
                                ?>
                                </select>
                        </td>

                        <td class='button_cell_e' align='center'>
                              <input value='Submit' type='button' name='btnsubmit' class='forms_button_e' onclick='sendData()'>
                              <input value='Print' type='button' name='btnprint' class='forms_button_e' onclick='doPrint()'>
                        </td>
                        <td class='rb'></td>
                  </tr>
                  <tr>
                        <td class='bottom_l_curb'></td>
                        <td class='bottom_f_cell' colspan='3'></td>
                        <td class='bottom_r_curb'></td>
                  </tr>
            </table>


</form>



</body>

</html>
