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
  
                //update mas_customer
                $updateMasSupplier="update mas_supplier set
                                        company_name='".$txtcname."',
                                        contact_person='".$txtCPerson."',
                                        designation='".$txtDesignation."',
                                        office_address='".$txtCAddress."',
                                        city='".$txtcity."',
                                        country='".$txtCountry."',
                                        post_code='".$txtPostCode."',
                                        email='".$txtEmail."',
                                        phone='".$txtphone."',
                                        fax='".$txtFax."',
                                        mobile='".$txtMobile."',
                                        urladd='".$txtURL."',
                                        type='3',
                                        sstatus='".$cboStatus."'
                                where
                                        supplierobject_id='".$txtCustomerID."'

                             ";
                $resultUpdateMasSupplier=mysql_query($updateMasSupplier) or die(mysql_error());

        if(mysql_query("COMMIT"))
        {
                drawMassage("Operation Done","onClick='back()'");
        }
        else
        {
                drawMassage("Operation Not Done","onClick='back()'");
        }


?>

</form>
</body>

</html>

