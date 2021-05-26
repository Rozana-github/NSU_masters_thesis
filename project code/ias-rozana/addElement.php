<?PHP
        include "Library/SessionValidate.php";
?>
<html>
<head>
<meta http-equiv='Content-Language' content='en-us'>
<meta http-equiv='Content-Type' content='text/html; charset=windows-1252'>
<title>Requisition Authorization Form</title>
<LINK href="Application/Style/generic_form.css" type='text/css' rel='stylesheet'>
<link rel='stylesheet' type='text/css' href='Application/Style/eng_form.css' />
<script language='Javascript'>

 function showError()
 {

   err = "Please Choose a Parent from the tree";

 }

 function doSubmit(type)
 {
  if(type==0)
  {
    if(document.frm.nodename.value=='')
      alert('You must enter a node name');
    else if(document.frm.nodeurl.value=='')
      alert('You must enter an URL for the node');
    else
       document.frm.submit();
  }
  else
   {
    if(document.frm1.nodename.value=='')
      alert('You must enter a node name');
    else if(document.frm1.nodeurl.value=='')
      alert('You must enter an URL for the node');
    else
       document.frm1.submit();
   }
 }

</script>
</head>

<body class='body_e'>

<?PHP

if($pid==null)
   echo "<script>
            
            showError();
          
         </script>"; 
else
{

 include_once("Library/dbconnect.php");

 $parent_query = "select NodeName,url
                  from _nisl_tree_entries
                  where id='$id'
                  ";
                  
 $rset = mysql_query($parent_query) or die(mysql_error());

 $row = mysql_fetch_array($rset);

 extract($row);
 echo "
<form name='frm' method='post' action='add.php'>
<input type='hidden' name='parent' value='$id'>
<table border='0' width='80%' align='center' cellpadding='0' cellspacing='0'>
      <tr>
            <td class='top_left_curb'></td>
            <td colspan='2' class='header_cell_e' valign='top'>Node Addable Form</td>
            <td class='top_right_curb'></td>
      </tr>
      <tr>
            <td rowspan='6' class='lb'></td>
            <td colspan='2' class='title_cell_e' align='center'>Add a Node to the Navigation Tree</td>
            <td rowspan='6' class='rb'></td>
      </tr>
      <tr>
            <td class='td_e' align='right'>Parent</td>
            <td class='td_e'><b>&nbsp;&nbsp;$NodeName</b></td>
      </tr>

      <tr>
            <td class='caption_e'>Node Name:</td>
            <td class='td_e'>
                  <input type='text' name='nodename' size='40' class='input_e'>
            </td>
      </tr>
      <tr>
            <td class='caption_e'>Node URL:</td>
            <td class='td_e'>
                  <input type='text' name='nodeurl' size='40' value='Application/' class='input_e'>
            </td>
      </tr>
      <tr>
            <td colspan='2' class='td_e'>&nbsp;</td>
      </tr>
      <tr>
            <td colspan='2' class='button_cell_e' align='center'>
                  <input type='button' name='addBtn' class='forms_button_e' value='ADD' onClick='doSubmit(0)'>
                  <input type='reset' class='forms_button_e' value='Clear'>
            </td>
      </tr>
      <tr>
            <td class='bottom_l_curb'></td>
            <td class='bottom_f_cell' colspan='2'></td>
            <td class='bottom_r_curb'></td>
      </tr>
   
</table>
</form>
<form name='frm1' method='post' action='edit.php'>
<input type='hidden' name='parent' value='$id'>
<table border='0' width='80%' align='center' cellpadding='0' cellspacing='0'>
      <tr>
            <td class='top_left_curb'></td>
            <td colspan='2' class='header_cell_e' valign='top'>Node Editable Form</td>
            <td class='top_right_curb'></td>
      </tr>
      <tr>
            <td rowspan='5' class='lb'></td>
            <td colspan='2' class='title_cell_e' align='center'>Edit a Node in the Navigation Tree</td>
            <td rowspan='5' class='rb'></td>
      </tr>
      <tr>
            <td class='caption_e'>Node Name</td>
            <td class='td_e'><input type='text' name='nodename' size='40' value='$NodeName' class='input_e'></td>
      </tr>
      <tr>
            <td class='caption_e'>Node URL</td>
            <td class='td_e'><input type='text' name='nodeurl' size='40' value='$url' class='input_e'></td>
      </tr>
      <tr>
            <td colspan='2' class='td_e'>&nbsp;</td>
      </tr>
      <tr>
            <td colspan='2' class='button_cell_e' align='center'>
                  <input type='button' name='editBtn' class='forms_button_e' value='UPDATE' onClick='doSubmit(1)'>
                  <input type='reset' class='forms_button_e' value='Clear'>
            </td>
      </tr>
      <tr>
            <td class='bottom_l_curb'></td>
            <td class='bottom_f_cell' colspan='2'></td>
            <td class='bottom_r_curb'></td>
      </tr>
</table>
</form>";
      mysql_close();

}

?>

</body>
</html>

