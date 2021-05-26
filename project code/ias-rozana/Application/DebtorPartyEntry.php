<?PHP
        include_once("Library/dbconnect.php");
        include_once("Library/Library.php");

?>

<html>

<head>
<meta http-equiv='Content-Language' content='en-us'>
<meta http-equiv='Content-Type' content='text/html; charset=windows-1252'>
<title>Debtor Entry Form</title>
<link rel='stylesheet' type='text/css' href='Style/interface_styles.css' />
<link rel='stylesheet' type='text/css' href='Style/eng_form.css'>
<link rel='stylesheet' type='text/css' href='Style/generic_form.css'>
<script language="JavaScript">

</script>


</head>

<body class='body_e'>
<form name='Form1' method='post'  action='AddToDeborPartyEntry.php'>

<?PHP

//select maximum customer id
$CustomerId="select
                   ifnull(lpad(max(cast(customer_id as unsigned))+1,4,0),0) as CustomerID
             from
                   mas_customer
            ";
$resultCustomer=mysql_query($CustomerId) or die(mysqL_error());
while($rowCustomer=mysql_fetch_array($resultCustomer))
{
   extract($rowCustomer);

}
if($CustomerID==0)
        $MaxCustomerId="0001";
else
        $MaxCustomerId=$CustomerID;


?>

<table border='0' width='100%'  cellspacing='0' cellpadding='3'>
        <tr>
                <td class='top_left_curb'></td>
                <td colspan='4' class='header_cell_e' align='center'>Debtor Entry Form</td>
                <td class='top_right_curb'></td>
        </tr>

        <tr>
                <td class='lb'></td>
                <td width='20%' style='text-align:right' class='td_e'><b>Company Name</b></td>
                <td width='30%' class='td_e'>
                        <input type='text' name ='txtcname' value='' class='input_e'>
                </td>
                <td width='25%' style='text-align:right' class='td_e'><b>Customer ID</b></td>
                <td width='25%' class='td_e'>
                <?PHP
                        echo"<input type='text' name='txtCustomerID' value='$MaxCustomerId' class='input_e'>";
                ?>
                </td>
                <td class='rb'></td>
        </tr>
        <tr>
                <td class='lb'></td>
                <td width='25%' style='text-align:right' class='td_e'><b>Contact Person </b></td>
                <td width='25%' class='td_e'>
                        <input type='text' name='txtCPerson' value='' class='input_e'>
                </td>
                <td width='25%' align='right' class='td_e'><b>Designation</b></td>
                <td width='25%' class='td_e'>
                        <input type='text' name='txtDesignation' value='' class='input_e'>
                </td>
                <td class='rb'></td>
        </tr>
        <tr>
                <td class='lb'></td>
                <td width='20%' style='text-align:right' class='td_e'><b>Address</b></td>
                <td width='70%' colspan='3'>
                        <textarea rows='2' name='txtCAddress' cols='46' class='input_e'></textarea>
                </td>
                <td class='rb'></td>
        </tr>
        <tr>
                <td class='lb'></td>
                <td width='20%' style='text-align:right' class='td_e'><b>City</b></td>
                <td width='30%'><input type='text' name='txtcity' value='' class='input_e'></td>
                <td width='25%' align='right' class='td_e'><b>Post Code</b></td>
                <td width='25%' class='td_e'>
                        <input type='text' name='txtPostCode' value='' class='input_e'>
                </td>
                <td class='rb'></td>
        </tr>
        <tr>
                <td class='lb'></td>
                <td width='20%' style='text-align:right' class='td_e'><b>Country</b></td>
                <td width='30%' class='td_e'>
                        <input type='text' name='txtCountry' value='' class='input_e'>
                </td>
                <td width='50%' colspan='2' class='td_e'>&nbsp;</td>
                <td class='rb'></td>
        </tr>
        <tr>
                <td class='lb'></td>
                <td width='20%' style='text-align:right' class='td_e'><b>Phone</b></td>
                <td width='30%' class='td_e'>
                        <input type='text' name='txtphone' value='' class='input_e'>
                </td>
                <td width='25%' style='text-align:right' class='td_e'><b>Mobile</b></td>
                <td width='25%' class='td_e'>
                        <input type='text' name='txtMobile' value='' class='input_e'>
                </td>
                <td class='rb'></td>
        </tr>
        <tr>
                <td class='lb'></td>
                <td width='20%' style='text-align:right' class='td_e'><b>Email</b></td>
                <td width='30%'>
                        <input type='text' name='txtEmail' value='' class='input_e'>
                </td>
                <td width='25%' align='right' class='td_e'><b>Fax</b></td>
                <td width='25%' class='td_e' >
                        <input type='text' name='txtFax' value='' class='input_e'>
                </td>
                <td class='rb'></td>
        </tr>
        <tr>
                <td class='lb'></td>
                <td width='20%' style='text-align:right' class='td_e'><b>&nbsp;Type</b></td>
                <td width='30%' class='td_e'>
                        Brac:<input type='radio' name='rdoType' value='1'  class='select_e'>
                        Non Brac:<input type='radio' name='rdoType' value='2' checked class='select_e'>
                </td>
                <td width='25%' align='right' class='td_e'><b>Status</b></td>
                <td width='25%' class='td_e'>
                        Active:<input type='radio' name='rdoStatus' value='0' checked class='select_e'>
                        Inactive:<input type='radio' name='rdoStatus' value='1' class='select_e'>
                </td>
                <td class='rb'></td>
        </tr>
        <tr>
                <td class='lb'></td>
                <td width='25%' align='right' class='td_e'>
                   <b>URL</b>
                </td>
                <td width='75%' colspan='3' class='td_e'>
                   <input type='text' name='txtURL' value='' class='input_e'>
                </td>
                <td class='rb'></td>
        </tr>
        <tr>
                <td class='lb'></td>
                <td width='100%' colspan='4' align='center' class='button_cell_e'>
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

