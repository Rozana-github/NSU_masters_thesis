
<html>
<head>
<meta http-equiv='Content-Language' content='en-us'>
<meta http-equiv='Content-Type' content='text/html; charset=windows-1252'>
<title>Requisition Authorization Form</title>
<LINK href="Style/generic_form.css" type='text/css' rel='stylesheet'>
<link rel='stylesheet' type='text/css' href='Style/eng_form.css' />
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
    else
       document.frm.submit();
  }
  else
   {
    if(document.frm1.nodename.value=='')
      alert('You must enter a node name');
   
    else
       document.frm1.submit();
   }
 }

</script>
</head>

<body>

<?PHP

if($pid==null)
   echo "<script>
            
            showError();
          
         </script>"; 
else
{

 include_once("Library/dbconnect.php");

 $parent_query = "select description
                  from mas_cost_center
                  where id='$id'
                  ";
                  
 $rset = mysql_query($parent_query) or die("Error: ".mysql_error());

 $row = mysql_fetch_array($rset);

 extract($row);
 
 echo "
      <form name='frm' method='post' action='CCadd.php'>
            <input type='hidden' name='parent' value='$id'>
            <table border='0' width='90%' align='center' cellpadding='0' cellspacing='0'>
                  <tr>
                        <td class='top_left_curb'></td>
                        <td colspan='2' class='header_cell_e' align='center'>Add A CC Head</td>
                        <td class='top_right_curb'></td>
                  </tr>
                  <tr>
                        <td class='lb' rowspan='2'></td>
                        <td class='caption_e'>Head Name</td>
                        <td class='td_e'><input type='text' class='input_e' name='nodename' size='30'></td>
                        <td class='rb' rowspan='2'></td>
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
      <form name='frm1' method='post' action='CCedit.php'>
            <input type='hidden' name='parent' value='$id'>
                  <table border='0' width='90%' align='center' cellpadding='0' cellspacing='0'>
                        <tr>
                              <td class='top_left_curb'></td>
                              <td colspan='2' class='header_cell_e' align='center'>Edit A CC Head</td>
                              <td class='top_right_curb'></td>
                        </tr>
                        <tr>
                              <td class='lb' rowspan='2'></td>
                              <td class='caption_e'>Head Name</td>
                              <td class='td_e'><input type='text' name='nodename' class='input_e' size='30' value='$description'></td>
                              <td class='rb' rowspan='2'></td>
                        </tr>
                        <tr>
                              <td colspan='2' class='button_cell_e' align='center'><center>
                                    <input type='button' name='editBtn' class='forms_button_e' value='UPDATE' onClick='doSubmit(1)'>
                                    <input type='reset' class='forms_button_e' value='Clear'></center>
                              </td>
                        </tr>
                        <tr>
                              <td class='bottom_l_curb'></td>
                              <td class='bottom_f_cell' colspan='2'></td>
                              <td class='bottom_r_curb'></td>
                        </tr>
                  </table>
      </form>";

}

?>

</body>
</html>
