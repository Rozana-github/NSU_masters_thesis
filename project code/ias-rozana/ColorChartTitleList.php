<?PHP
      include "Library/SessionValidate.php";
      include "Library/dbconnect.php";
      include "Library/Library.php";
?>




<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>New Page 1</title>
<script language='javascript'>
      function DeleteDataS()
      {
            var i;
            var j=0;
            var txtCount=document.frmNewsEntry.txtCount.value;

            for(i=0;i<txtCount;i++)
            {
                  if(document.frmNewsEntry.elements["txtDeleteLnkStat["+i+"]"].checked==false)
                  {
                        j=j+1;
                  }
            }
            if(txtCount==j)
            {
                  alert("Select at least one title click on check box then press Delete");
            }
            else
            {
                  document.frmNewsEntry.submit();
            }
      }
      
      function DoRankUp(i)
      {
            if(i<=0)
            {
                  alert("Not Possible as it is the top most element.");
                  return;
            }
            else
            {
                  var ACCatID=document.frmNewsEntry.elements["ReservCID["+i+"]"].value;
                  var ACRank=document.frmNewsEntry.elements["ReservRank["+i+"]"].value;
                  var PreviousCatID=document.frmNewsEntry.elements["ReservCID["+(i-1)+"]"].value;
                  var PreviousRank=document.frmNewsEntry.elements["ReservRank["+(i-1)+"]"].value;
                  window.location="AddToColorRankChange.php?ACCatID="+ACCatID+"&ACRank="+ACRank+"&PreviousCatID="+PreviousCatID+"&PreviousRank="+PreviousRank+"";
            }
      }

      function DoRankDown(i)
      {
            var ItValid=document.frmNewsEntry.txtCount.value;
            var CUnValiID=ItValid-1;

            if(i>=CUnValiID)
            {
                  alert("Not Possible as it is the bottom most element.");
                  return;
            }
            else
            {
                  var ACCatID=document.frmNewsEntry.elements["ReservCID["+i+"]"].value;
                  var ACRank=document.frmNewsEntry.elements["ReservRank["+i+"]"].value;
                  var NextCatID=document.frmNewsEntry.elements["ReservCID["+(i+1)+"]"].value;
                  var NextRank=document.frmNewsEntry.elements["ReservRank["+(i+1)+"]"].value;
                  window.location="AddToColorRankChange.php?ACCatID="+ACCatID+"&ACRank="+ACRank+"&PreviousCatID="+NextCatID+"&PreviousRank="+NextRank+"";
            }
      }

</script>
<LINK href="Application/Style/generic_form.css" type=text/css rel=stylesheet>
<LINK href="Application/Style/eng_form.css" type=text/css rel=stylesheet>
</head>


<body class='body_e'>
<form name='frmNewsEntry' method='post' action='AddToNewsDelete.php'>
<?PHP
 /*--------------------------------------- Developed By MD.Sharif ur Rahman ----------------------------------------*/
      $SeNTlist="SELECT
                        demo_color_id AS News_Id,
                        demo_hex_color,
                        display_rank
                  FROM
                        _nisl_chart_color
                  order by
                         display_rank
                ";
      $ExSeNTlist=mysql_query($SeNTlist) or die(mysql_error());
      if (mysql_num_rows($ExSeNTlist)>0)
      {
            echo "
            <table border='0'  width='100%'  id='table1' cellpadding='0' cellspacing='0' align='center'>
                  <tr>
                        <td class='top_left_curb'></td>
                        <td colspan='6' class='header_cell_e' align='center' height='25'>
                              Color Title list
                        </td>
                        <td class='top_right_curb'></td>
                  </tr>
                  <tr>
                        <td rowspan='2' class='lb'></td>
                        <td colspan='6' height='22' class='td_e'>
                              <a href='ColorChartEntry.php?' ><img src='Application/img/AddaNewsButton.gif' border='0'></a>
                        </td>
                        <td rowspan='2' class='rb'></td>
                  </tr>
                  <tr>
                        <td height='20' width='15%' class='td_e'></td>
                        <td align='center' class='title_cell_e'>Srial No</td>
                        <td align='center' class='title_cell_e'>Color code</td>
                        <td align='center' class='title_cell_e'>Color</td>
                        <td width='100px' align='center' class='title_cell_e'>Rank Change!</td>
                        <td class='td_e'>&nbsp;</td>
                  </tr>
                ";
                  $i=0;
                  while ($rowNewsTl=mysql_fetch_array($ExSeNTlist))
                  {
                        extract($rowNewsTl);
                        if ($i%2==0)
                                $class="even_td_e";
                        else
                                $class="odd_td_e";
                        $SLNo=$i+1;
                        echo "
                        <tr>
                            <td class='lb'></td>
                            <td class='td_e'>&nbsp;</td>
                            <td class='$class'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <a href='ColorChartEntry.php?OparationType=2&News_Id=".urlencode($News_Id)."'>
                                        $SLNo
                                    </a>
                            </td>
                            <td height='22' align='center' class='$class'>
                                    <a href='ColorChartEntry.php?OparationType=2&News_Id=".urlencode($News_Id)."'>
                                        $demo_hex_color
                                    </a>
                            </td>
                            <td style=\"background-color:$demo_hex_color\">
                             &nbsp;
                            </td>
                            <td height='22' align='center' class='$class'>";
                                    echo "<a onclick='DoRankUp($i)'><img src='images/TopArrow.jpg' border='0'></img></a>&nbsp;";
                                    echo "<a onclick='DoRankDown($i)'><img src='images/BottomArrow.jpg' border='0'></img></a>
                            </td>
                            <td class='td_e'>&nbsp;</td>
                            <td class='rb'></td>
                        </tr>
                        <input type='hidden' name='txtNews_ID[$i]' value='$News_Id'>";
                        echo "<input type='hidden' name='ReservCID[$i]' value='$News_Id'>";
                        echo "<input type='hidden' name='ReservRank[$i]' value='$display_rank'>";

                        $i++;
                  }
                  echo "<input type='hidden' name='txtCount' value='$i'>";
                  echo "
                  <tr>
                        <td class='lb'></td>
                        <td height='10' colspan='6' class='td_e'></td>
                        <td class='rb'></td>
                  </tr>
                  <tr>
                        <td class='lb'></td>
                        <td colspan='6' class='td_e'></td>
                        <td class='rb'></td>
                  </tr>
                  <tr>
                        <td class='bottom_l_curb' bgcolor='cccccc'></td>
                        <td class='bottom_f_cell'colspan='6' bgcolor='cccccc'></td>
                        <td class='bottom_r_curb' bgcolor='cccccc'></td>
                  </tr>
                  ";
      }
      else
      {
            echo "
            <table border='0'  width='85%'  id='table1' cellpadding='0' cellspacing='0' align='center'>
            <tr>
                  <td class='top_left_curb'></td>
                  <td class='header_cell_e' align='center' height='25'>
                        Color Title list
                  </td>
                  <td class='top_right_curb'></td>
            </tr>
            <tr>
                  <td rowspan='3' class='lb'></td>
                  <td height='22'>
                        <a href='ColorChartEntry.php?' ><img src='Application/img/AddaNewsButton.gif' border='0'></a>
                  </td>
                  <td rowspan='3' class='rb'></td>
            </tr>
            <tr>
                  <td class='Header_Cell' align='center' height='25'>Data Report</td>
            </tr>
            <tr>
                  <td height='10' align='center'> Data Not Avilable</td>
            </tr>
            <tr>
                  <td class='bottom_l_curb'></td>
                  <td class='bottom_f_cell'></td>
                  <td class='bottom_r_curb'></td>
            </tr>

            ";
      }
?>

</table>

</form>
</body>
</html>
<?PHP
        mysql_close();
?>
