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

<script language="JavaScript">

function selectCustomerID(val,val2)
{
       // alert(val2);
        window.close();
        window.opener.location.href="EditInvoiceDetail.php?SelectedtxtCustomerID="+val+"&txtInvoiceObjectID="+val2+"";
}

</script>


</head>

<body class='body_g'>
<form name='Form1' method='post' action=''>

<table border='0' width='100%' id='table1' cellspacing='0' class='td_e'>
        <tr>
                <td width='100%' align='center' colspan='4' class='header_cell_e'>Customer List</td>

        </tr>
        <tr>
                        <td  width='20%' class='title_cell_e'>Customer ID</td>
                        <td  width='40%' class='title_cell_e'>Customer Name</td>
                        <td  width='40%' class='title_cell_e'>Customer Address</td>
        </tr>

        <?PHP
                //search all information
                $searchAllInfo="select
                                        *
                                from
                                        mas_customer
                                ";
                $resultAllInfo=mysql_query($searchAllInfo) or die(mysql_error());

                $i=1;
                while($rowAllInfo=mysql_fetch_array($resultAllInfo))
                {
                        extract($rowAllInfo);

                        if($i%2==0)
                                $class="even_td_e";
                        else
                                $class="odd_td_e";

                        echo"
                        <tr onClick='selectCustomerID(\"$customerobject_id\",\"$InvoiceObjectID\")' style=\"cursor: hand;\">
                                <td  width='20%' class='$class' >
                                        $customer_id
                                </td>
                                <td  width='40%' class='$class'>$Company_Name</td>
                                <td  width='40%' class='$class'>$Contact_Person</td>
                        </tr>
                        ";
                        $i++;
                }
        ?>

</table>
</form>
</body>

</html>

