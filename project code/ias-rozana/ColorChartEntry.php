<?PHP
        include "Library/SessionValidate.php";
?>
<?PHP
        include "Library/dbconnect.php";
        include "Library/Library.php";
?>




<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="author" content="Md.Sharif ur Rahman (Milon)">
<title>New Page 1</title>
<script language='javascript'>



    function SaveData()
    {
        var Segment=document.frmNewsEntry.TxtColor.value;
        if(Segment=='')
        {
            alert("You must inter a color code");
        }
        else
        {
            document.frmNewsEntry.submit();
        }
    }

    function UpdateData()
    {
        var Segment=document.frmNewsEntry.TxtColor.value;
        if(Segment=='')
        {
            alert("You must inter a color code");
        }
        else
        {
            document.frmNewsEntry.submit();
        }
    }

    function ResetVal()
    {
        window.location="ColorChartEntry.php?OparationType=1";
    }
    function BackVal()
    {
        window.location="ColorChartTitleList.php";
    }
</script>
<LINK href="Application/Style/generic_form.css" type=text/css rel=stylesheet>
<LINK href="Application/Style/eng_form.css" type=text/css rel=stylesheet>
</head>


<body class='body_e'>
<?PHP
/*----------------------------------------- Developed By MD.Sharif ur Rahman ----------------------------------------*/
/*----------------------------------------- Created Date '09/1/2008' ------------------------------------------------*/
    if($OparationType==2)
    {
        $SeNTlist="SELECT
                        demo_color_id as News_Id,
                        demo_hex_color
                    FROM
                        _nisl_chart_color
                    where
                        demo_color_id='$News_Id'
                    ";
        $ExSeNTlist=mysql_query($SeNTlist) or die(mysql_error());
        while($rowNewsTl=mysql_fetch_array($ExSeNTlist))
        {
            extract($rowNewsTl);
        }

    }
?>

<form name='frmNewsEntry' method='post' action='AddTo_ColorChartEntry.php'>
<input type='hidden' name='txtIndex' value='0'>
<input type='hidden' name='txtdelIndex' value='0'>
<?PHP
    echo "<input type='hidden' name='txtNews_Id' value='$News_Id'>";
    if($OparationType==2)
    {
        echo "<input type='hidden' name='OparationType' value='3'>";
    }
?>

<table border="0"  width="60%"  id="table1" cellpadding='0' cellspacing='0' align='center'>
      <tr>
            <td class='top_left_curb'></td>
            <td colspan="2" class='header_cell_e' align='center' height='25'>Color Entry Form</td>
            <td class='top_right_curb'></td>
      </tr>
      <tr>
            <td class='lb'></td>
            <td height='24' class='caption_e' colspan="2">
                  <table border="0" width="100%" id="table2" cellpaddin='0' cellspacing='0'>
                        <tr>
                              <td width="50%" valign='top'>
                                    <!------------------------------- ENGLISH --------------------------------------------------->
                                    <table border='0' width='100%' height='100%' cellpadding='0' cellspacing='0'>
                                          <tr>
                                                <td height='10' colspan="2"></td>
                                          </tr>
                                          <tr>
                                                <td class='caption_e'>Color hex:</td>
                                                <td class='td_e'>
                                                <?PHP
                                                      if($OparationType==2)
                                                      {
                                                            echo "<input type='text' name='TxtColor' value='$demo_hex_color' style=\"width: 235\" maxlength='500' class='input_e'>";
                                                      }
                                                      else
                                                      {
                                                            echo "<input type='text' name='TxtColor' value=''maxlength='500' style=\"width: 235\" class='input_e'>";
                                                      }
                                                ?>
                                                </td>
                                          </tr>
                                          <?PHP
                                                if($OparationType==2)
                                                {

                                                }
                                                else
                                                {
                                                      echo "<input type='hidden' name='txtCreatedBy' value='' style=\"width: 235\" maxlength='500' class='input_e'>";
                                                }
                                          ?>
                                          <tr>
                                                <td align='right' colspan="2" height='4' class='td_e'></td>
                                          </tr>
                                          <tr>
                                                <td height='10' colspan="2" class='td_e'></td>
                                          </tr>
                                    </table><!---------------------------- END ENGLISH ------------------------------------------>
                              </td>
                        </tr>
                  </table>
            </td>
            <td class='rb'></td>
      </tr>
      <tr>
            <td class='lb'></td>
            <td height='24' colspan='2' class='button_cell_e' align='center'>
            <?PHP
                  if($OparationType==2)
                  {
                        echo "<input type='button' name='btnUpdate' class='forms_button_e' value=' Update ' onclick='UpdateData()'>";
                  }
                  else
                  {
                        echo "<input type='button' name='btnSubmit' class='forms_button_e' value=' Submit ' onclick='SaveData()'>";
                  }
            ?>    &nbsp;&nbsp;
                  <input type='button' name='btnNew' class='forms_button_e' value=' new ' onclick='ResetVal()'>
                  &nbsp;&nbsp;
                  <input type='button' name='btnBack' class='forms_button_e' value=' Back ' onclick='BackVal()'>
            </td>
            <td class='rb'></td>
      </tr>
      <tr>
            <td class='bottom_l_curb'></td>
            <td class='bottom_f_cell' colspan='2'></td>
            <td class='bottom_r_curb'></td>
      </tr>
</table>

<input type='hidden' name='txtDeleteIndex' value='0'>
</form>
</body>
</html>
<?PHP
        mysql_close();
?>
