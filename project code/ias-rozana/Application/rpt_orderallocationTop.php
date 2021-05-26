<?PHP
	include "Library/dbconnect.php";
	include "Library/Library.php";
?>
<html>

<head>

<title>Calendar Example 1</title>

<link rel='stylesheet' type='text/css' href='Style/eng_form.css'>
<link rel='stylesheet' type='text/css' href='Style/generic_form.css'>

<script language="javascript">
function viewCalender()
{
      var sYear = document.frm1.ddlYear.options[document.frm1.ddlYear.selectedIndex].value;
      var sMonth = document.frm1.ddlMonth.options[document.frm1.ddlMonth.selectedIndex].value;
      
	  //document.frm1.action="rpt_orderallocationBottom.php?calender1_month="+sMonth+"&calender1_year="+sYear;
	  //document.frm1.action="blank.php";
	  //document.frm1.submit();
	  window.parent.bottom.location="rpt_orderallocationBottom.php?calender1_month="+sMonth+"&calender1_year="+sYear;
      //document.bottom.location="rpt_orderallocationBottom.php?calender1_month="+sMonth+"&calender1_year="+sYear;
}      
</script>

</head>

<body>
<form name="frm1" method="get" target="bottom">
<table align="center" width="100%">
<tr>
      <td align="center" height="30" class='header_cell_e' colspan='5'><b>Production Schadule</b></td>
</tr>
<tr>
      <td class='caption_e'>
            Year:
      </td>
      <td class='td_e'><select name="ddlYear" class='select_e'>
            <?PHP 
            comboYear("1971","20037",$ddlYear);
            ?>
            </select> 
      </td>
      <td class='caption_e'>
            Month:</td>
      <td class='td_e'> <select  name="ddlMonth" class='select_e'>
            <?PHP 
			comboMonth($ddlMonth);
            ?>
            </select>
      </td>
      <td class='td_e' align='center'>
            <input type="button" name="btnView" value="View" class="forms_button_e" onclick="viewCalender()">
      </td>
</tr>
</table>
</form>
</body>
</html>
