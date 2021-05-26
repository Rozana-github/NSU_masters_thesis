<?PHP
include "Library/SessionValidate.php";
include "Library/dbconnect.php";
include "Library/Library.php";

?>
<html>

<head>

<title>Calendar Example 1</title>

<link rel="stylesheet" type="text/css" href="Style/calendar.css" />
<link rel='stylesheet' type='text/css' href='Style/eng_form.css'>
<link rel='stylesheet' type='text/css' href='Style/generic_form.css'>
<script language="JavaScript" src="Script/calendar1.js"></script>
<script language="javascript">
function viewCalender()
{
      var sYear = document.frm1.ddlYear.options[document.frm1.ddlYear.selectedIndex].value;
      var sMonth = document.frm1.ddlMonth.options[document.frm1.ddlMonth.selectedIndex].value;
      
      window.location="ordrallocation.php?calender1_month="+sMonth+"&calender1_year="+sYear;
}
function orderallocationentryPopUp(index)
{
        var serialNo = document.frm1.elements["sNo["+index+"]"].value;
        var popit=window.open('ordrallocationentry.php?serial_no='+serialNo+'','console','status,scrollbars,width=800,height=500');
}

function submitAllocation(index)
{
      if(document.frm1.elements["txtAllocationDate["+index+"]"].value=='')
          {
                alert('Empty Date.');
          }
          else
          {
                var allocationDate = document.frm1.elements["txtAllocationDate["+index+"]"].value; 
                var serialNo = document.frm1.elements["sNo["+index+"]"].value; 
                var dateString = allocationDate.split('-',3);
                var starttime=document.frm1.elements["cbostarthour["+index+"]"].value;
                var endtime=document.frm1.elements["cboendhour["+index+"]"].value;
                var machine=document.frm1.elements["cbomachine["+index+"]"].value;
                var qtym=document.frm1.elements["qtymm["+index+"]"].value;
                var qtyk=document.frm1.elements["qtykg["+index+"]"].value;
                var mainitem=document.frm1.elements["cbomainitem["+index+"]"].value;
                var subitem=document.frm1.elements["cbosubitem["+index+"]"].value;
                var remarks=document.frm1.elements["txtremarks["+index+"]"].value;
                window.location='ordrallocation.php?calender1_Day='+dateString[0]+'&calender1_month='+dateString[1]+'&calender1_year='+dateString[2]+'&aDate='+allocationDate+'&sNo='+serialNo+'&item='+mainitem+'&subitem='+subitem+'&qtykg='+qtyk+'&qtymm='+qtym+'&stime='+starttime+'&etime='+endtime+'&mname='+machine+'&planremarks='+remarks;
                }
}
function printorder(id)
{
      window.location="Rptorderdetails.php?objectid="+id;
}

function redirectPage(day,month,year)
{
      window.location="ordrallocation.php?calender1_Day="+day;//+"calender1_month="+month+"&calender1_year="+year;
}
</script>
</head>

<body>
<form name="frm1" method="post">
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
<?PHP

include "includes/PHP4/calendar.php";

//Create an Object of Calender
$calendar = new Calendar("calender1");

//Draw the calender
echo $calendar->Output();

?>
<br>
<table align="center" width="100%" cellpadding="0" cellspacing="0">
<tr>
      <td align="center" height="30" class='header_cell_e'><b>Allocated Data</b></td>
</tr>
<tr>
      <td align="center">
            <table width="100%" align="center" cellpadding="0" cellspacing="0">
            <tr>

                  <td align="center" class='title_cell_e'>Name</td>

                  <td align="center" class='title_cell_e'>&nbsp;</td>
            </tr>
            <?PHP
            //include "dbconnect.php";
            
            $query="select
                        order_object_id as serial_no,
                        job_no as Name
                  from
                        mas_order
                  where
                        order_status='0' and
                        product_status='0'
                  ";
            $rset=mysql_query($query)or die(mysql_error);
            $i=0;
            while($row=mysql_fetch_array($rset))
            {
                  extract($row);
                  
                  echo "
                  <tr>
                        <input type='hidden' name='sNo[$i]' value='$serial_no'>
                        <td align='center' class='td_e'>$Name</td>

                        <td align=center' class='td_e'>
                              <input type='button' name='btnSubmit[$i]'  class='forms_button_e' value='Allocate' onclick='orderallocationentryPopUp($i)'>
                        </td>
                  </tr>";
                  $i++;
            }
            ?>
            <tr>

                  <td align="center" bgcolor="#F1F1F1">&nbsp;</td>

                  <td align="center" bgcolor="#F1F1F1">&nbsp;</td>
            </tr>
            </table>
      </td>
</tr>
</table>
<?PHP

?>
</form>
<script language="JavaScript">
        // create calendar object(s) just after form tag closed
        // specify form element as the only parameter (document.forms['formname'].elements['inputname']);
        // note: you can have as many calendar objects as you need for your application
            //alert(document.forms['frm1'].elements['txtAllocationDate'].name);
            /*function calenderCall(target)
            {
                  var allocationDate = new calendar1(document.forms['frm1'].elements['txtAllocationDate'+target]);
                  allocationDate.year_scroll = true;
                  allocationDate.time_comp = false;
                  allocationDate.popup();
            }*/
</script>
</body>
</html>
