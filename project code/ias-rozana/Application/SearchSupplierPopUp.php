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

function selectSupplierID(val)
{
        window.close();
        window.opener.location.href="SupplierInvoiceEntry.php?SelectedtxtSupplierID="+val+"";
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
                        <td  width='20%' class='title_cell_e'>Supplier ID</td>
                        <td  width='40%' class='title_cell_e'>Supplier Name</td>
                        <td  width='40%' class='title_cell_e'>Supplier Address</td>
        </tr>

        <?PHP
                //search all information
                $searchAllInfo="select
                                        *
                                from
                                        mas_supplier
                                ";
                                echo $searchAllInfo;
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
                        <tr onClick='selectSupplierID(\"$supplierobject_id\")' style=\"cursor: hand;\">
                                <td  width='20%' class='$class' >
                                        $supplier_id
                                </td>
                                <td  width='40%' class='$class'>$company_name</td>
                                <td  width='40%' class='$class'>$office_address</td>
                        </tr>
                        ";
                        $i++;
                }
        ?>

</table>
</form>
</body>

</html>

