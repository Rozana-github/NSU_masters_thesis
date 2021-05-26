<?php //include("sysconf.php"); ?>
<html>
<head>
<meta name='GENERATOR' content='xxx'>
<meta name='ProgId' content='FrontPage.Editor.Document'>
<script language="JavaScript1.2">
defaultconf1='';
defaultconf2='';
function expandf(){
    if (document.all){
        if (document.all.fs1.rows!="10,*" || document.all.fs2.cols!="2,*")
            {
             document.all.fs1.rows="10,*";
             document.all.fs2.cols="2,*";
            }
        else
            {
            document.all.fs1.rows=defaultconf1;
            document.all.fs2.cols=defaultconf2;
            }
       }
    }
</script>
</head>

<?PHP
if(isset($_SESSION['SUserName'])){
echo "
<frameset rows='66,*,20' border=0 frameborder=0 framespacing=0 ID='fs1'>
	<frame name='banner' scrolling='no' noresize target='contents' frameborder='no' src='top.php'>

	<frameset cols='200,*' ID='fs2'>
		<frame name='contents' scrolling='auto' border='0' noresize target='main' src='lefttree.php'>
		<frame name='main' border='0' scrolling='auto' src='blank.php'>
	</frameset>

	<frame name='FrmFooter' scrolling='no' frameborder='no' noresize target='contents' src='Footer.php'>

	<noframes>
		<body>
			<p>This page uses frames, but your browser doesn't support them.</p>
		</body>
	</noframes>
</frameset>";
}
else
   echo "<script>
            window.location.href = \"ErrorMessage.php?error=You are not authorized to view this content\";    
        </script>";
?>
</html>