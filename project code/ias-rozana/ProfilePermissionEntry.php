<?PHP
        include "Library/SessionValidate.php";
?>
<html>

<head>
<meta http-equiv='Content-Language' content='en-us'>
<meta http-equiv='Content-Type' content='text/html; charset=windows-1252'>
<title>Permission Entry Form</title>
<LINK href="Application/Style/generic_form.css" type='text/css' rel='stylesheet'>
<link rel='stylesheet' type='text/css' href='Application/Style/eng_form.css' />
<link rel='StyleSheet' href='dtree/dtree.css' type='text/css' />
<script type='text/javascript' src='dtree/dtree.js'></script>
<script language='javascript'>
	function showPresentPermission(){
		document.frm.action="UserPermission.php";
		document.frm.submit();
	}
</script>
<script language='javascript'>
	id_array = new Array();
	pid_array = new Array();

	function drawTree(idlist,pidlist,namelist,urllist,PresentStatus){
		setRecord(idlist,pidlist);

		id = new Array();
		pid = new Array();
		nam = new Array();
		url = new Array();
		PreSta=new Array();

		id = idlist.split(' ');
		pid = pidlist.split(' ');
		nam = namelist.split(',');
		url = urllist.split(' ');
		PreSta=PresentStatus.split('**');
		d = new dTree('d','dtree/');
		
		for(var i=0;i<id.length;i++){
			if(PreSta[i]!="-100")
				nam[i]+=" <input type='checkbox' class='check_input' name='c["+id[i]+"]' value='1' onclick=\"operateNode('"+id[i]+"','"+pid[i]+"')\" checked>";
			else
				nam[i]+=" <input type='checkbox' class='check_input' name='c["+id[i]+"]' value='1' onclick=\"operateNode('"+id[i]+"','"+pid[i]+"')\">";
		
			d.add(parseInt(id[i]),parseInt(pid[i]),nam[i],'','','main');
		}

            document.write(d);
            d.openAll();
	}
//----------------------------------------------------------------

	function pickChildren(id){
		for(var i = 0; i < id_array.length; i++){
			if(pid_array[i] == id){
				document.frm.elements["c["+id_array[i]+"]"].checked = true;
				pickChildren(id_array[i]);
			}
		}
	}

 //------------------------------------------------------------
	function operateNode(id,pid){
		if(document.frm.elements["c["+id+"]"].checked == true){
			pickChildren(id);
			pickParent(id,pid);
		}else{
			dropChildren(id);
			dropParent(id,pid);
		}
	}

//-------------------------------------------------------------------
	function dropChildren(id){
		for(var i=0;i<id_array.length;i++){
			if(pid_array[i] == id){
				document.frm.elements["c["+id_array[i]+"]"].checked = false;
				dropChildren(id_array[i]);
			}
		}
	}	

//-------------------------------------------------------------------------------
//-------------------------------------------------------------------------------
	function pickParent(id,pid){
		if(id!="0"){
			if(document.frm.elements["c["+id+"]"].checked==true)
				document.frm.elements["c["+pid+"]"].checked = true;
			else
				document.frm.elements["c["+pid+"]"].checked = false;
			
			ppid = getParentID(pid);
			if(isChildChecked(id))
				document.frm.elements["c["+id+"]"].checked = true;
			
			pickParent(pid,ppid);
		}
      //  document.frm.elements["c[0]"].checked = true;
	}
      //-----------------------------------------------------------
	function dropParent(id,pid){
		num = 0;
		numOfChild = countChild(pid);
		for(var i=0;i<id_array.length;i++){
			if(pid_array[i] == pid){
				if(document.frm.elements["c["+id_array[i]+"]"].checked == false)
					num++;
			}
		}
		
		if(num == numOfChild)
			document.frm.elements["c["+pid+"]"].checked = false;
	}
	//-------------------------------------------------------------------------------------
	function setRecord(idlist,pidlist){
		id_array = idlist.split(' ');
		pid_array = pidlist.split(' ');
	}
    
	function doSubmit(){
		document.frm.submit();
	}
	//-----------------------------------------------------------------------------------------
	function getParentID(id){
		for(var i=0;i<id_array.length;i++){
			if(id_array[i]==id)
				pid = pid_array[i];
		}
		return pid;
	}
	//-----------------------------------------------------------------------------------------
    function countChild(id){
		num=0;
		for(var i=0;i<id_array.length;i++){
			if(pid_array[i]==id)
				num++;
		}
		return num;
	}
	//--------------------------------------------------------------------------------------------
	function isChildChecked(id){
		for(var i=0;i<id_array.length;i++){
			if(pid_array[i]==id){
				if(document.frm.elements["c["+id_array[i]+"]"].checked==true)
					return true;
			}
		}
		return false;
	}
	//--------------------------------------------------------------------------------------------
</script>
</head>

<?PHP

include_once("Library/dbconnect.php");

echo "

<body class='body_e'>
<form name='frm' method='post' action='ProfilePermissionSave.php'>
<table border='0' width='60%' align='center' cellpadding='0' cellspacing='0'>
      <tr>
            <td class='top_left_curb'></td>
            <td valign='top' align='center' class='header_cell_e'>Create Profile Permission</td>
            <td class='top_right_curb'></td>
      </tr>";

	if($ProfileID != "-1" && isset($ProfileID)){
		$id_tray 	= "";
		$pid_tray 	= "";
		$name_tray 	= "";
		$url_tray 	= "";
		$UserStatus = "";

		echo "
            <tr>
				<td class='lb'></td>
				<td class='dtree'>";
					$tree_query ="  select
										_nisl_tree_entries.id,
										_nisl_tree_entries.pid,
										_nisl_tree_entries.NodeName,
										_nisl_tree_entries.url,
										_nisl_tree_entries.view_status,
										IFNULL(TEMP.id,-100) AS PresentStatus
                                    from
										_nisl_tree_entries LEFT JOIN(
                                                select
													ProfileID, id, pid
                                                from
													_nisl_profile_permission
                                                where
													ProfileID = '$ProfileID'
										) AS TEMP ON _nisl_tree_entries.id=TEMP.id
                                    order by
										_nisl_tree_entries.NodeName";

					$rset = mysql_query($tree_query) or die(mysql_error());
					while($row = mysql_fetch_array($rset)){
						extract($row);
						$id_tray .=$id." ";
						$pid_tray .=$pid." ";
						$name_tray .=$NodeName.",";
						$url_tray .=$url." ";
						$UserStatus.=$PresentStatus."**";
					}
					echo "
						<script>
							drawTree('$id_tray','$pid_tray','$name_tray','$url_tray','$UserStatus');
						</script>
				</td>
				<td class='rb'></td>
            </tr>
            <tr>
				<td class='lb'></td>
				<td width='98%' align='center' class='button_cell_e'>
					<input type='hidden' name='ProfileID' value='$ProfileID'>
					<input type='hidden' name='idlist'>
					<input type='hidden' name='pidlist'>
					<input type='button' value='Submit' name='saveBtn' class='forms_button_e' onClick='doSubmit()'>
				</td>
				<td class='rb'></td>
            </tr>
            <tr>
				<td class='bottom_l_curb'></td>
				<td class='bottom_f_cell'></td>
				<td class='bottom_r_curb'></td>
            </tr>";
	}
    
	echo "
</table>
</form>
";
?>
</body>

</html>
<?PHP
      mysql_close();
?>
