<?PHP
        include "Library/SessionValidate.php";
?>
<?PHP
    include "Library/dbconnect.php";
    include "Library/Library.php";
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8">
<title>$HeightId=</title>
<script language='javascript'>
 function back()
 {
       window.location="Library/TopBanner.php";
       window.parent.banner.location="top.php";
       window.parent.FrmFooter.location="Footer.php";
       window.location="TopBanner.php";
       window.location="System_Paramiter.php";
 }
</script>

</head>
<link rel='stylesheet' type='text/css' href='Application/Style/Apperance_1.css' />
<body>
<form name='frmaddToNews' method='post' target='bottomfrm'>
<?PHP
     /*------------------------------- Developed BY: Md.Sharif Ur Rahman -----------------------------------------*/
     /*------------------------------- Get DATA For Template Modification ----------------------------------------*/
        $GetTemTV="select
                        template_id,
                        template_name,
                        template_path,
                        tree_mp_backcolor,
                        footer_backrepet,
                        footer_logo
                    from
                        _nisl_mas_template
                    where
                        template_id='$txtTemplateNam'
                ";
        $ExGetTemTV=mysql_query($GetTemTV) or die(mysql_error());
        while($Row=mysql_fetch_array($ExGetTemTV))
        {
            extract($Row);
        }
        $GetFcolor="select
                        title_font_color
                    from
                        _nisl_font_color
                    where
                        title_f_color_id='$txtFontcolor'
                    ";
        $ExGetFcolor=mysql_query($GetFcolor) or die(mysql_error());
        while($Row2=mysql_fetch_array($ExGetFcolor)){
            extract($Row2);
        }
        /*------------------------------------ END ------------------------------------------------------------*/
        $SaveData="replace into
                            _nisl_system_paramiter(
                                    Pnam_ID,
                                    project_name,
                                    font_size,
                                    font_name,
                                    template_id,
                                    template_name,
                                    title_f_color_id,
                                    title_f_shade_id,
                                    tree_mp_backcolor,
                                    footer_backrepet,
                                    footer_logo,
                                    company_logo
                                    )
                            values(
                                    '$txtPnamID',
                                    '$txtPNam',
                                    '$txtFSize',
                                    '$txtFontNam',
                                    '$txtTemplateNam',
                                    '$template_name',
                                    '$txtFontcolor',
                                    '$txtTFShadecolor',
                                    '$tree_mp_backcolor',
                                    '$footer_backrepet',
                                    '$footer_logo',
                                    '$txtcompanylogo'
                                    )
                        ";
        mysql_query($SaveData) or die(mysql_error());

        drawMassage("Your Project Name Setup Successfully","onClick=back()");


?>
 </form>
</body>

</html>
<?PHP
        mysql_close();
?>
