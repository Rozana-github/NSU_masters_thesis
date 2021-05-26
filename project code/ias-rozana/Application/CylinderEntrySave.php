<?PHP
      include "Library/SessionValidate.php";
      include "Library/dbconnect.php";
      include "Library/Library.php";

?>
<?PHP
      mysql_query("BEGIN") or die("Begin Error.");
?>

<html>
      <head>
            <meta http-equiv='Content-Type' content='text/html; charset=windows-1252'>
            <title>Invoice Posting</title>
            <link href='Style/generic_form.css' type='text/css' rel='stylesheet' />
            <link href='Style/eng_form.css' type='text/css' rel='stylesheet' />
            <script language='JavaScript'>
            function back()
            {

                  window.location="CylinderEntry.php";
            }
      </script>
      </head>
      <body class='body_e'>
                <?PHP
                        //************************************* INSERT ********************************************
                        $insertsql="Replace INTO
                                        mas_cylinder
                                        (
                                                job_name ,
                                                customer_id ,
                                                cylinder_width ,
                                                printing_area ,
                                                circumferance ,
                                                ups ,
                                                cylinder_repeat ,
                                                cylinder_qty ,
                                                remarks ,
                                                entry_by ,
                                                entry_date
                                        )
                                        VALUES
                                        (
                                                '".$_POST['txtjobname']."',
                                                '".$_POST['cbocustomer']."',
                                                '".$_POST['txtwidth']."',
                                                '".$_POST['txtprintarea']."',
                                                '".$_POST['txtcircumferance']."',
                                                '".$_POST['txtups']."',
                                                '".$_POST['txtrepeat']."',
                                                '".$_POST['txtqty']."',
                                                '".$_POST['txtremarks']."',
                                                '".$SUserID."',
                                                sysdate()
                                        )
                                ";
                        mysql_query($insertsql)or die(mysql_error());
                        if(mysql_query("COMMIT"))
                        {
                                drawMassage("Operation Done","onClick='back()'");
                        }
                        else
                        {
                                drawMassage("Operation Not Done","onClick='back()'");
                        }
                ?>
      </body>
</html>
<?PHP
        mysql_close();
?>



