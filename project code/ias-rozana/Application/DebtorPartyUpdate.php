<?PHP
        include_once("Library/dbconnect.php");
        include_once("Library/Library.php");

?>

<html>

<head>
<meta http-equiv='Content-Language' content='en-us'>
<meta http-equiv='Content-Type' content='text/html; charset=windows-1252'>
<title>Supplier Entry Form</title>
<link rel='stylesheet' type='text/css' href='Style/interface_styles.css' />
<link rel='stylesheet' type='text/css' href='Style/eng_form.css'>
<link rel='stylesheet' type='text/css' href='Style/generic_form.css'>
<script language="JavaScript">

</script>


</head>

<body class='body_e'>
<form name='Form1' method='post'  action='AddToDeborPartyUpdate.php'>
<?PHP
                //search all information
                $searchAllInfo="select
                                        *
                                from
                                        mas_customer
                                where
                                        customerobject_id='".$CustomerID."'
                                ";
                $resultAllInfo=mysql_query($searchAllInfo) or die(mysql_error());
                while($rowAllInfo=mysql_fetch_array($resultAllInfo))
                {
                    extract($rowAllInfo);
                }
                
                //echo $searchAllInfo;

echo"

<table border='0' width='100%'  cellspacing='0' cellpadding='3'>
        <tr>
                  <td class='top_left_curb'></td>
                  <td colspan='4' width='100%' class='header_cell_e' align='center'>Party Update Form</td>
                  <td class='top_right_curb'></td>
        </tr>

        <tr>
                <td class='lb'></td>
                <td width='20%' style='text-align:right' class='td_e'><b>Company Name</b></td>
                <td width='30%' class='td_e'>
                        <input type='text' name ='txtcname' value='$company_name' class='input_e'>
                </td>
                <td width='25%' style='text-align:right' class='td_e'><b>Customer ID</b></td>
                <td width='25%' align='left' class='td_e'>
                        <input type='text' name='txtCustomerID' value='$customer_id' readOnly class='input_e'>
                </td>
                <td class='rb'></td>
        </tr>
        <tr>
                <td class='lb'></td>
                <td width='20%' style='text-align:right' class='td_e'><b>Contact Person</b></td>
                <td width='30%' class='td_e'>
                        <input type='text' name='txtCPerson' value='$contact_person' class='input_e'>
                </td>
                <td width='25%' align='right' class='td_e'><b>Designation</b></td>
                <td width='25%' align='left' class='td_e'>
                        <input type='text' name='txtDesignation' value='$designation' class='input_e'>
                </td>
                <td class='rb'></td>
        </tr>
        <tr>
                <td class='lb'></td>
                <td width='20%' style='text-align:right' class='td_e'><b>Address</b></td>
                <td width='70%' colspan='3' class='td_e'>
                        <textarea rows='2' name='txtCAddress' cols='46' class='input_e'>$office_address</textarea>
                </td>
                <td class='rb'></td>
        </tr>
        <tr>
                <td class='lb'></td>
                <td width='20%' style='text-align:right' class='td_e'><b>City</b></td>
                <td width='30%' class='td_e'><input type='text' name='txtcity' value='$city' class='input_e'></td>
                <td width='25%' align='right' class='td_e'><b>Post Code</b></td>
                <td width='25%' align='left' class='td_e'>
                        <input type='text' name='txtPostCode' value='$post_code' class='input_e'>
                </td>
                <td class='rb'></td>
        </tr>
        <tr>
                <td class='lb'></td>
                <td width='20%' style='text-align:right' class='td_e'><b>Country</b></td>
                <td width='30%' class='td_e'>
                        <input type='text' name='txtCountry' value='$country' class='input_e'>
                </td>
                <td width='50%' colspan='2' class='td_e'>&nbsp;</td>
                <td class='rb'></td>
        </tr>
        <tr>
                <td class='lb'></td>
                <td width='20%' style='text-align:right' class='td_e'><b>Phone</b></td>
                <td width='30%' class='td_e'>
                        <input type='text' name='txtphone' value='$phone' class='input_e'>
                </td>
                <td width='25%' style='text-align:right' class='td_e'><b>Mobile</b></td>
                <td width='25%' align='left' class='td_e'>
                        <input type='text' name='txtMobile' value='$mobile' class='input_e'>
                </td>
                <td class='rb'></td>
        </tr>
        <tr>
                <td class='lb'></td>
                <td width='20%' style='text-align:right' class='td_e'><b>Email</b></td>
                <td width='30%' class='td_e'>
                        <input type='text' name='txtEmail' value='$email' class='input_e'>
                </td>
                <td width='25%' align='right' class='td_e'><b>Fax</b></td>
                <td width='25%' align='left' class='td_e'>
                        <input type='text' name='txtFax' value='$fax' class='input_e'>
                </td>
                <td class='rb'></td>
        </tr>
        <tr>
                <td class='lb'></td>
                <td width='20%' style='text-align:right' class='td_e'><b>&nbsp;Type</b></td>
                <td width='30%' class='td_e'>";
                if($type==1)
                {
                        $BracStatus="checked";
                        $NoBracStatus="";
                }
                else
                {
                        $NoBracStatus="checked";
                        $BracStatus="";
                }

                        echo"Brac:<input type='radio' name='rdoType' value='1' $BracStatus>
                        Non Brac:<input type='radio' name='rdoType' value='2' $NoBracStatus>";

echo"           </td>
                <td width='25%' align='right' class='td_e'><b>Status</b></td>
                <td width='25%' align='left' class='td_e'>";
                if($sstatus==0)
                {
                        $ActiveStatus="checked";
                        $InactiveStatus="";
                }
                else
                {
                        $InactiveStatus="checked";
                        $ActiveStatus="";
                }

                        echo"Active:<input type='radio' name='rdoStatus' value='0' $ActiveStatus>
                        Inactive:<input type='radio' name='rdoStatus' value='1' $InactiveStatus>";
echo"           </td>
                <td class='rb'></td>
        </tr>
        <tr>
                <td class='lb'></td>
                <td width='25%' align='right' class='td_e'>
                   <b>URL</b>
                </td>
                <td width='75%' colspan='3' align='left' class='td_e'>
                   <input type='text' name='txtURL' value='$urladd' style='width:350px' class='input_e'>
                </td>
                <td class='rb'></td>
        </tr>
        <tr>
                <td class='lb'></td>
                <td width='100%' colspan='4' align='center' class='button_cell_e'>
                   <input type='submit' value='Update' class='forms_Button_e'>
                </td>
                <td class='rb'></td>
        </tr>
        <tr>
                  <td class='bottom_l_curb'></td>
                  <td class='bottom_f_cell' colspan='4'></td>
                  <td class='bottom_r_curb'></td>

        </tr>

</table>

";
echo"<input type='hidden' name='txtCustomerID' value='$CustomerID'>";
?>
</form>
</body>

</html>

