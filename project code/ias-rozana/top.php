<?PHP
include "Library/SessionValidate.php";
include "Library/dbconnect.php" ;
?>
<html>
<head>
<meta http-equiv='Content-Language' content='en-us'>
<meta http-equiv='Content-Type' content='text/html; charset=windows-1252'>
<script language="JavaScript1.2">
 if (document.all)
   window.parent.defaultconf1=window.parent.document.all.fs1.rows;
   window.parent.defaultconf2=window.parent.document.all.fs2.cols;

 function expando()
  {
    window.parent.expandf()

  }

  document.ondblclick=expando


</script>


</head> 

<body topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0" marginwidth="0" marginheight="0">



<?PHP
if(isset($_SESSION['SUserName'])) 
{
    $FootData="select
                    _nisl_system_paramiter.template_id,
                    _nisl_system_paramiter.company_logo as logo,
                    _nisl_mas_template.template_name AS TName,
                    _nisl_mas_template.template_path AS Path,
                    _nisl_mas_template.footer_backrepet AS FBackRepet,
                    _nisl_mas_template.footer_logo AS FLogo,
                    _nisl_mas_template.border_color AS BorderColor
                from
                    _nisl_system_paramiter
                    LEFT JOIN _nisl_mas_template ON _nisl_mas_template.template_id=_nisl_system_paramiter.template_id
               ";
   $ExFootData=mysql_query($FootData) or die(mysql_error());
   while($Row=mysql_fetch_array($ExFootData))
   {
        extract($Row);
   }


  echo "
       <table border='0' cellpadding='0' cellspacing='0' width='100%' height='100%'>
            <tr>
                  <td width='40' style=\"background-image: url('{$Path}ApplicationTopBackRepet.jpg'); background-repeat: repeat-x;padding-left: 6px; padding-bottom: 10p\"  align='right'>
                        <img src='images/Company_logo/$logo'  style=\"border: 2px solid {$BorderColor}\" >
                  </td>
                  <td width='560px' Style=\"background-image: url('{$Path}ApplicationTopBackRepet.jpg'); background-repeat: repeat-x;\">";
                        //<img border='0' src='Library/TopBanner.php'>
                        $imgTop=$Path.'TopBanner.png';
                        
                  echo "
                        <img border='0' src=$imgTop>
                  </td>
                  <td Style=\"background-image: url('{$Path}ApplicationTopBackRepet.jpg'); background-repeat: repeat-x;\">
                        <table border='0' align='center' width='100%' cellspacing='0' cellpadding='0' >
                              <tr>
                                    <td align='right' style=\"padding-right: 5px\">
                                          <b><i><font face='verdana' color='7AC047' size='1px'>Welcome </font>
                                          <font face='verdana' color='FFFFFF' size='1px'>".$_SESSION['SUserName']."</i></b></font>
                                    </td>
                              </tr>
                              <tr>
                                    <td align='right' style=\"padding-right: 5px\">
                                          <a href='Logout.php'><b><font face='verdana' size='1px' color='#FC8F30'>Logout</font></b></a>
                                    </td>
                              </tr>
                        </table>
                  </td>
            </tr>
      </table>
    ";
    
}
?>
</body>
</html>
<?PHP
        mysql_close();
?>
