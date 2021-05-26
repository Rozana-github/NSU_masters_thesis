<?PHP
//LOAD PHP FILE FOR DATABASE CONNECTIVITY
   include "Library/dbconnect.php" ;
?>

<HTML>
    <HEAD>
        <title>Login Form</title>
      <!--LOAD CSS FILE FOR FORMATTING HTML CODE-->

<style>
    a, A:link, a:visited, a:active
        {color: #0000aa; text-decoration: none; font-family: Tahoma, Verdana; font-size: 11px}
    A:hover
        {color: #ff0000; text-decoration: none; font-family: Tahoma, Verdana; font-size: 11px}
    p, tr, td, ul, li
        {color: #000000; font-family: Tahoma, Verdana; font-size: 11px}
    th
        {background: #DBEAF5; color: #000000;}
    .header1, h1
        {color: #ffffff; background: #808080; font-weight: bold; font-family: Tahoma, Verdana; font-size: 13px; margin: 0px; padding-left: 2px; height: 21px}
    .header2, h2
        {color: #000000; background: #DBEAF5; font-weight: bold; font-family: Tahoma, Verdana; font-size: 12px;}
    .intd
        {color: #000000; font-family: Tahoma, Verdana; font-size: 11px; padding-left: 15px;}
    .wcell
        {background: #FFFFFF; vertical-align: top}
    .ctrl
        {font-family: Tahoma, Verdana, sans-serif; font-size: 12px; width: 100%;}
    .btnform
        {border: 0px; font-family: verdana; font-size: 12px; background-color: #CCCCCC; width: 100%;
             height:18px; text-align: center; cursor: hand;font-weight:bold;}
    .btn
        {background-color: #DBEAF5; padding: 0px;}
    textarea, select
        {font: 10px Verdana, arial, helvetica, sans-serif; background-color: #DBEAF5;}
INPUT     
    {
    width: 100%; 
    BORDER-RIGHT: #a7a7a7 1px solid; 
    BORDER-TOP: #a7a7a7 1px solid; 
    BACKGROUND: #FFFFFF;
    FONT: 200 11px "Verdana"; 
    BORDER-LEFT: #a7a7a7 1px solid; 
    COLOR: #000000; 
    BORDER-BOTTOM: #a7a7a7 1px solid 
    text-align: left;
    list-style-type: square;
    border: 1px outset #000000;
    padding-top: 1; 
    font-weight:bold;
    }

        
    /* classes for validator */
    .tfvHighlight
        {font-weight: bold; color: red;}
    .tfvNormal
        {font-weight: normal;    color: black;}
        
.BUTTONGRAY
    { 
    height:18px; 
    width: 100%;
    BORDER-RIGHT: #a7a7a7 1px solid; 
    BORDER-TOP: #a7a7a7 1px solid; 
    BACKGROUND: #CCCCCC; 
    FONT: 200 12px 'Verdana';
    BORDER-LEFT: #a7a7a7 1px solid; 
    COLOR: #000000; 
    BORDER-BOTTOM: #a7a7a7 1px solid 
    text-align: left;
    list-style-type: square;
    border: 1px outset #000000;
    padding-top: 1; 
    font-weight:bold;
    CURSOR: hand; 
    }

.BUTTON_SPIN
    { 
    height:18px; 
    font-weight:bold;
    width: 100%;
    BORDER-RIGHT: #a7a7a7 1px solid; 
    BORDER-TOP: #a7a7a7 1px solid; 
    BACKGROUND: #CCCCCC;
    FONT: 200 12px 'Verdana';
    BORDER-LEFT: #a7a7a7 1px solid; 
    COLOR: #000000; 
    BORDER-BOTTOM: #a7a7a7 1px solid 
    text-align: left;
    list-style-type: square;
    border: 1px outset #000000;
    padding-top: 1; 
    }
    
.forms_Button
{
        border:none;
        width:70px;
        height:20px;
        text-align:center;
        background-image:url(../images/button/sweeterBtn.gif);
        font-family:Arial, Helvetica, sans-serif;
        font-size:11px;
        color:#333333;
        vertical-align: middle;
}

 </style>

        <SCRIPT language='javascript'>
            function highlightButton(s) {
                if ('INPUT'==event.srcElement.tagName)
                event.srcElement.className=s
                }
        </SCRIPT>
      
    </HEAD>
    <BODY  background='images\page_bg.gif' >
<!-- Form -- onmouseover='highlightButton('buttongray')' onmouseout='highlightButton('button_spin')'>-->        
<?PHP
    $FootData="select
                    _nisl_system_paramiter.template_id,
                    _nisl_system_paramiter.company_logo AS logo,
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
	while($Row=mysql_fetch_array($ExFootData)){
		extract($Row);
	}

	/*----------------------------------- Md. Tajmilur Rahman --------------------------------------------*/
echo "
<form action='Authenticate.php' method='post' name='login'  >
<table border='0' height='100%' cellpadding='0' cellspacing='0' align='center'>
<tr>
	<td height='100%' valign='middle'>
		<table style=\"border: 1px solid #008000\" cellpadding='0' cellspacing='0' align='center'>
		<tr>
			<td style=\"background-image: url('{$Path}ApplicationTopBackRepet.jpg'); background-repeat: repeat-x;padding-left: 6px; padding-bottom: 10p\"  align='right'>
				<img src='images/Company_logo/$logo'  style=\"border: 2px solid {$BorderColor}\" >
			</td>
			<td align='center'>";
				$imgTop=$Path.'TopBanner.png';
				echo "
				<img border='0' src=$imgTop>
			</td>
		</tr>
		<tr>
			<td height='50px' colspan='2'></td>
		</tr>
		<tr>
			<td align='center' colspan='2'>
				<table cellpadding='0' cellspacing='0' border='0' width='320' align='center'>
				<tr>
					<td bgcolor='#808080' width='10'><img src='images/pixel.gif' width='10' height='1' border='0'></td>
					<td class='header1' nowrap>User Login<img src='images/pixel.gif' width='10' height='1' border='0'></td>
					<td><img src='images/formtab_r.gif' width='10' height='21' border='0'></td>
					<td background='images/line_t.gif' width='100%'>&nbsp;</td>
					<td background='images/line_t.gif'><img src='images/pixel.gif' width='10' height='1' border='0'></td>
				</tr>
				<tr>
					<td background='images/line_l.gif'><img src='images/pixel.gif' border='0'></td>
					<td colspan='3'>
						<img src='images/pixel.gif' width='1' height='10' border='0'><br>
						<div align='center' id='error_registration' style='display: block;'></div>
						<table cellpadding='0' cellspacing='0' border='0' width='100%'>
						<tr bgcolor='#ffffff'>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
						<tr bgcolor='#ffffff'>
							<td id='t_title' width='30%'>&nbsp;<B>Name:</B></td>
							<td width='70%'><input  type='text' name='title' size='30' class='ctrl'></td>
						</tr>
						<tr bgcolor='#ffffff'>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
						<tr bgcolor='#ffffff'>
							<td id='t_company'  width='30%'>&nbsp;<B>Password:</B></td>
							<td valign=top  width='70%'><input type='password' name='pass' size='12' class='ctrl'></td>
						</tr>
						<tr bgcolor='#ffffff'>
							<td>&nbsp;</td>";
							if(isset($_SESSION["SUserName"])){
								echo "
							<td align='center'><font size='1' color='#FF0000'>Invalid User Name or Password</font></td>";
							}
							else 
								echo "
							<td>&nbsp;</td>";
							echo "
						</tr>
						<tr bgcolor='#ffffff'>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
						</table>
					<td>&nbsp;</td>
					<td background='images/line_l.gif'><img src='images/pixel.gif' border='0'></td>
					<td colspan='3'>
						<img src='images/pixel.gif' width='1' height='10' border='0'><br>
						<div align='center' id='error_registration' style='display: block;'></div>
					</td>
				</tr>
				<tr>
					<td bgcolor='#808080' width='10'><img src='images/pixel.gif' width='100%' height='1' border='0' colspan=4></td>
					<td bgcolor='#808080' width='10'><img src='images/pixel.gif' width='100%' height='1' border='0' colspan=4></td>
					<td bgcolor='#808080' width='10'><img src='images/pixel.gif' width='100%' height='1' border='0' colspan=4></td>
					<td bgcolor='#808080' width='10'><img src='images/pixel.gif' width='100%' height='1' border='0' colspan=4></td>
					<td bgcolor='#808080' width='10'><img src='images/pixel.gif' width='100%' height='1' border='0' colspan=4></td>
				</tr>
				<tr>
					<td width='10'><img src='images/formtab_b.gif' width='10' height='20' border='0'></td>
					<td bgcolor='#808080' colspan='4' align='right'>
						<table cellpadding='0' cellspacing='0' border='0'>
						<tr>
							<td class='btn' width='100'><input type='reset' name='Reset' value='Reset' class='btnform'></td>
							<td width='1'><img src='images/pixel.gif' width='1' height='18' border='0'></td>
							<td class='btn' width='100'><input type='submit' name='Submit' value='Login' class='btnform'></td>
							<td width='1'><img src='images/pixel.gif' width='1' height='18' border='0'></td>
						</tr>
						</table>
					</td>
				</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td height='50px' colspan='2'></td>
		</tr>
		<tr>
			<td height='20' colspan='2'>";
				include "Footer.php";
				echo "
			</td>
		</tr>
		</table>
	</td>
</tr>
</table>
</form>
";
?>
</BODY>
</html>


