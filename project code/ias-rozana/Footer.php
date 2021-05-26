<?PHP
include "Library/dbconnect.php";
?>

<html>
<style>
.Footer_Cell
{
        height: 20;
        background-image: url('Application/img/Footer_Cell_Pic.jpg');
        background-repeat: repeat-x;
}
</style>
<head>

</head>

<body topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0" marginwidth="0" marginheight="0">
<?PHP
    $FootData="select
                    _nisl_system_paramiter.template_id,
                    _nisl_mas_template.template_name AS TName,
                    _nisl_mas_template.template_path AS Path,
                    _nisl_mas_template.footer_backrepet AS FBackRepet,
                    _nisl_mas_template.footer_logo AS FLogo
                from
                    _nisl_system_paramiter
                    LEFT JOIN _nisl_mas_template ON _nisl_mas_template.template_id=_nisl_system_paramiter.template_id
               ";
   $ExFootData=mysql_query($FootData) or die(mysql_error());
   while($Row=mysql_fetch_array($ExFootData))
   {
        extract($Row);
   }

?>
<table border='0' width='100%' height='20' cellpadding='0' cellspacing='0'>
<tr> <?PHP
      echo "
      <td style=\"background-image: url('{$Path}Footer_Cell_BackRepet.jpg'); background-repeat: repeat-x\"  height='20' align='right'>
         &nbsp;
      </td>
      <td width='300px' style=\"background-image: url('{$Path}FooterLogo.jpg')\" align='center'>
            <font face='verdana' size='1' color='#000000'>
				<!--Developed by : <font color='RED'>Port</font> <font color='BLACK'>Of</font> <font color='BLUE' size='1'>Technologies.</font>-->
			</font>
      </td>";
      ?>
</tr>
</table>
</body>
<?PHP
        mysql_close();
?>
