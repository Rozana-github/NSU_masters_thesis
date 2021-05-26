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
function canceljob(id)
{
      //alert(id);
      //document.Form1.update.value='1';
      document.Form1.objectid.value=id;
      
      //document.Form1.action="OrderCancel.php";
      document.Form1.submit();
}

</script>


</head>

<body class='body_e'>
<form name='Form1' method='post'  action='Rptorderdetails.php'>
<table border='0' cellspacing='0' cellpadding='0'  width='100%' align='center'>

      <tr>
            <td class='top_left_curb'></td>
            <td colspan='4' class='header_cell_e' align='center'>Order List</td>
            <input type='hidden' name='update' value=''>
            <input type='hidden' name='objectid' value=''>
            <td class='top_right_curb'></td>
      </tr>



        <?PHP
                //echo "2222".$update;

                $searchAllInfo="SELECT
                                    mas_order.order_object_id,
                                    mas_order.job_no,
                                    trn_order_description.order_description,
                                    mas_customer.customer_id,
                                    Company_Name
                              FROM
                                    mas_order
                                    left join trn_order_description on trn_order_description.order_object_id=mas_order.order_object_id
                                    LEFT JOIN mas_customer ON mas_customer.customer_id = mas_order.customer_id


                                ";
                $resultAllInfo=mysql_query($searchAllInfo) or die(mysql_error());

            if(mysql_num_rows($resultAllInfo)>0)
            {
                  echo "
                  <tr>
                        <td class='lb'></td>
                        <td class='title_cell_e'>Job No</Td>
                        <td class='title_cell_e'>Company Name</Td>
                        <td class='title_cell_e'>Job Description</Td>
                        <td class='title_cell_e'>&nbsp;</Td>
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
                        <tr  >
                              <td class='lb'></td>
                              <td class='$clss' >$job_no</Td>
                              <td class='$clss' >$Company_Name</Td>
                              <td class='$clss' >$order_description</Td>
                              <td class='$clss' onClick='canceljob(\"$order_object_id\")' style=\"cursor: hand;\">Print</Td>
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

