<?PHP
        include_once("Library/dbconnect.php");
        include_once("Library/Library.php");

?>

<html>

<head>

<meta http-equiv='Content-Language' content='en-us'>
<meta http-equiv='Content-Type' content='text/html; charset=windows-1252'>
<title>Supplier Entry Form</title>
<link rel='stylesheet' type='text/css' href='css/interface_styles.css' />
<script language="javascript">

function back()
{
        window.close();
        window.opener.location.href="CreditorEntry.php";

}
</script>
</head>

<body>
<form name='Form1' method='post'  action=''>

<?PHP
  mysql_query("BEGIN") or die("Operation cant be start");

                //Insert into mas_supplier
                $insertMasSuppier="insert into mas_supplier
                                        (
                                        supplier_id,
                                        company_name,
                                        contact_person,
                                        designation,
                                        office_address,
                                        city,
                                        country,
                                        post_code,
                                        email,
                                        phone,
                                        fax,
                                        mobile,
                                        urladd,
                                        type,
                                        sstatus
                                        )
                                        values
                                        (
                                       '$txtCustomerID',
                                       '$txtcname',
                                       '$txtCPerson',
                                       '$txtDesignation',
                                       '$txtCAddress',
                                       '$txtcity',
                                       '$txtCountry',
                                       '$txtPostCode',
                                       '$txtEmail',
                                       '$txtphone',
                                       '$txtFax',
                                       '$txtMobile',
                                       '$txtURL',
                                       '$rdoType',
                                       '$rdoStatus'
                                        )
                                ";
                $resultMasSupplier=mysql_query($insertMasSuppier) or die(mysql_error());
        /*-------------------------- Modified by sharif ------------------------*/
        if(mysql_query("COMMIT"))
        {
                drawMassage("Operation Done","onClick='back()'");
        }
        else
        {
                drawMassage("Operation Not Done","onClick='back()'");
        }
        /*--------------------------End Modified by sharif ------------------------*/
?>

</form>
</body>

</html>

