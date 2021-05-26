<?PHP
session_start();
        include_once("Library/dbconnect.php");
        include_once("Library/Library.php");

        mysql_query("BEGIN") or die("Operation can't be open");
?>

<html>

<head>

<meta http-equiv='Content-Language' content='en-us'>
<meta http-equiv='Content-Type' content='text/html; charset=windows-1252'>
<title>Supplier Entry Form</title>
<link rel='stylesheet' type='text/css' href='css/interface_styles.css' />

</head>

<body>
<form name='Form1' method='post'  action=''>

<?PHP

                if($txtdesignation=='')
                {
                //Insert into mas_invoice
                  $insertMasDesignation="insert into mas_designation
                                        (
                                          description
                                        )
                                        values
                                        (
                                          '".$txtdescription."'

                                       )
                                ";
                 }
                 else
                 {
                  $insertMasDesignation="
                                    update
                                          mas_designation
                                    set
                                         description='".$txtdescription."'
                                          
                                    where
                                          designationid='".$txtdesignation."'

                                          
                  ";
                 }
                // echo $insertMasEmployee;
                $resultMasEmployee=mysql_query($insertMasDesignation) or die(mysql_error());
                
               //------search invoice recent id-----------



?>


<?PHP
        if(mysql_query("COMMIT"))
      {
            drawMassage("Data Saved Succssfully","");
      }
      else
      {
            drawMassage("Data Saved Error","");
      }
?>

</form>
</body>

</html>

