<?PHP
        include_once("Library/dbconnect.php");
        include_once("Library/Library.php");

?>
<html>

<head>
<meta http-equiv='Content-Language' content='en-us'>
<meta http-equiv='Content-Type' content='text/html; charset=windows-1252'>
<title>Supplier Entry Form</title>
<link rel='stylesheet' type='text/css' href='Style/eng_form.css'>
<link rel='stylesheet' type='text/css' href='Style/generic_form.css'>
<link rel='stylesheet' type='text/css' href='Style/interface_styles.css' />
<script language="JavaScript">
function CreateNewParty()
{
        var popit=window.open('DebtorPartyEntry.php','console','status,scrollbars,width=650,height=350');
}

function EditPartyEntry(val)
{
        var popit=window.open("DebtorPartyUpdate.php?CustomerID="+val+"",'console','status,scrollbars,width=650,height=350');
}

</script>


</head>

<body class='body_e'>
<form name='Form1' method='post'  action='AddToEmployeeEntry.php'>
<table border='0' cellspacing='0' cellpadding='0'  width='100%' align='center'>

      <tr>
            <td class='top_left_curb'></td>
            <td colspan='4' class='header_cell_e' align='center'>Debtor List</td>
            <td class='top_right_curb'></td>
      </tr>
      <tr>
            <td class='lb'></td>
            <td align='center' class='title_cell_e2' colspan='4'>
                  <INPUT type='button' value='New Debtor' onClick="CreateNewParty()" class='forms_button_e' style="WIDTH:100px">
            </td>
            <td class='rb'></td>
      </tr>


        <?PHP
                $searchAllInfo="select
                                       customerobject_id,
                                       customer_id,
                                       company_name,
                                       contact_person,
                                       office_address
                                from
                                        mas_customer
                                ";
                $resultAllInfo=mysql_query($searchAllInfo) or die(mysql_error());

            if(mysql_num_rows($resultAllInfo)>0)
            {
                  echo "
                  <tr>
                        <td class='lb'></td>
                        <td class='title_cell_e'>Customer ID</Td>
                        <td class='title_cell_e'>Company Name</Td>
                        <td class='title_cell_e'>Contact Person</Td>
                        <td class='title_cell_e'>Office Address</Td>
                        <td class='rb'></td>
                  </tr>";
                $i=1;
                while($rowAllInfo=mysql_fetch_array($resultAllInfo))
                {
                        extract($rowAllInfo);
                        if($i%2==0)
                              $clss='even_td_e';
                        else
                              $clss='odd_td_e';
                              
                        echo"
                        <tr  id=set1_row1 onClick='EditPartyEntry(\"$customerobject_id\")' style=\"cursor: hand;\">
                              <td class='lb'></td>
                              <td class='$clss' style=\"cursor: hand;\">$customer_id</Td>
                              <td class='$clss' style=\"cursor: hand;\">$company_name</Td>
                              <td class='$clss' style=\"cursor: hand;\">$contact_person</Td>
                              <td class='$clss' style=\"cursor: hand;\">$office_address</Td>
                              <td class='rb'></td>
                        </tr>
                        ";
                        $i++;
                }
                        echo "
                        <tr>
                              <td class='bottom_l_curb'></td>
                              <td class='bottom_f_cell' colspan='4'></td>
                              <td class='bottom_r_curb'></td>
                        </tr>";
                        
            }
            else
            {
                  echo "Data Not Avilable";
            }
        ?>
</TABLE>
</form>
</body>

</html>

