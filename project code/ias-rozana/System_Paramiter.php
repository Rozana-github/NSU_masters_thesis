<?PHP
        include "Library/SessionValidate.php";
?>
<?PHP

    include "Library/dbconnect.php";
?>
<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>System paramiter</title>
<LINK href="Application/Style/generic_form.css" type=text/css rel=stylesheet>
<LINK href="Application/Style/eng_form.css" type=text/css rel=stylesheet>

<script language='javascript'>
      function checkAndSubmit()
      {
            var PNam=document.frmSP.txtPNam.value;
            var FSize=document.frmSP.txtFSize.value;

            if(PNam=='' || FSize=='')
            {
                  alert("fill every input box currectly");
            }
            else
            {
                  document.frmSP.submit();
            }
      }
      function ResetVal()
      {
            window.location="System_Paramiter.php";
      }

</script>

</head>

<body class='body_e'>
<form name='frmSP' method='post' action='AddTo_System_Paramiter.php'>
<?PHP
    $PickData="select
                     Pnam_ID,
                     project_name,
                     company_logo,
                     font_size,
                     font_name,
                     template_id AS STEMPLid,
                     title_f_color_id AS TempTFColor,
                     title_f_shade_id AS TTFShColor
               from
                    _nisl_system_paramiter
               ";
    $ExPickData=mysql_query($PickData) or die(mysql_error());
    while($row=mysql_fetch_array($ExPickData))
    {
        extract($row);
    }
echo "
<input type='hidden' name='txtPnamID' value='$Pnam_ID'>
<input type='hidden' name='txtcompanylogo' value='$company_logo'>
<table border='0' align='center' width='60%' id='table1' cellpadding='0' cellspacing='0'>
      <tr>
            <td class='top_left_curb'></td>
            <td class='header_cell_e' colspan='2'>System paramiter</td>
            <td class='top_right_curb'></td>
      </tr>
      <tr>
            <td class='lb' rowspan='7'>&nbsp;</td>
            <td class='caption_e'>Project Name:</td>
            <td class='td_e'><input type='text' name='txtPNam' value='$project_name' size='32' class='input_e'></td>
            <td class='rb' rowspan='7'>&nbsp;</td>
      </tr>
      <tr>
            <td class='caption_e'>Font Size:</td>
            <td class='td_e'><input type='text' name='txtFSize' value='$font_size' size='32' class='input_e'></td>
      </tr>
      <tr>
            <td class='caption_e'>Select A Font:</td>
            <td class='td_e'>";
            /*-------------------------------------------- FONT -------------------------------------------*/
            echo "<select name='txtFontNam' class='select_e'>";
            $handle = opendir('Font');
            while($file=readdir($handle))
            {
                if ($file != "." && $file != ".." )
                {
                    if(is_file("Font/$file"))
                    {
                        if($font_name==$file)
                        {
                            echo "<option value=$file selected>$file</option>";
                        }
                        else
                        {
                            echo "<option value=$file>$file</option>";
                        }
                    }
                    else
                    {
                    }
                }
            }
            /*------------------------------------------ END -----------------------------------------------*/
            echo "</select>";

            echo "
            </td>
      </tr>
      <tr>";
        /*---------------------------------------------- Template -----------------------------------------*/
            echo "
            <td class='caption_e'>Select A Template:</td>
            <td class='td_e'>";
            echo "<select name='txtTemplateNam' class='select_e'>";
                $GetTeml="select
                                template_id,
                                template_name,
                                template_path,
                                tree_mp_backcolor,
                                footer_backrepet,
                                footer_logo
                            from
                                _nisl_mas_template
                        ";
                $ExGetTeml=mysql_query($GetTeml) or die(mysql_error());
                while($Row2=mysql_fetch_array($ExGetTeml))
                {
                    extract($Row2);
                    if($STEMPLid==$template_id)
                        echo "<option value=$template_id selected>$template_name</option>";
                    else

                        echo "<option value=$template_id>$template_name</option>";
                }
                
            echo "</td>";
        
        /*---------------------------------------------- END ----------------------------------------------*/
      echo "
      </tr>
      <tr>
            <td class='caption_e'>Font color:</td>
            <td class='td_e'>
                  <select name='txtFontcolor' class='select_e'>
                  <option value='-1'>select a color</option>";
                  $GetFcolor="select
                                    title_f_color_id,
                                    color_name,
                                    title_font_color
                              from
                                    _nisl_font_color
                              ";
                  $EXGetFcolor=mysql_query($GetFcolor) or die(mysql_error());
                  while($Row3=mysql_fetch_array($EXGetFcolor))
                  {
                        extract($Row3);
                        if($TempTFColor==$title_f_color_id)
                        {
                              echo "<option style=\"border: 1px solid #000000; background-color: #$title_font_color\" value='$title_f_color_id' selected>
                                    $color_name
                              </option>";
                        }
                        else
                        {
                              echo "<option style=\"border: 1px solid #000000; background-color: #$title_font_color\" value='$title_f_color_id'>
                                    $color_name
                              </option>";
                        }
                  }
                  echo "
                  </select>
            </td>
      </tr>
      <tr>
            <td class='caption_e'>Font shade color:</td>
            <td class='td_e'>
                  <select name='txtTFShadecolor' class='select_e'>
                  <option value='-1'>select a color</option>";

                  $EXGetFhc=mysql_query($GetFcolor) or die(mysql_error());
                  while($Row4=mysql_fetch_array($EXGetFhc))
                  {
                        extract($Row4);
                        if($TTFShColor==$title_f_color_id)
                        {
                              echo "<option style=\"border: 1px solid #000000; background-color: #$title_font_color\" value='$title_f_color_id' selected>
                                    $color_name
                              </option>";
                        }
                        else
                        {
                              echo "<option style=\"border: 1px solid #000000; background-color: #$title_font_color\" value='$title_f_color_id'>
                                    $color_name
                              </option>";
                        }
                  }
                  echo "
                  </select>
            </td>
      </tr>
      <tr>
            <td colspan='2' align='center' class='button_cell_e'>
                  <input type='button' value='Submit' name='saveBtn' class='forms_button_e' onClick='checkAndSubmit()'>
                  <input type='reset' value='Reset' name='saveBtn' class='forms_button_e'>
            </td>
      </tr>
      <tr>
            <td class='bottom_l_curb'></td>
            <td class='bottom_f_cell' colspan='2'></td>
            <td class='bottom_r_curb'></td>
      </tr>
</table>";
//frm_bottom_cell
?>
</form>
</body>

</html>
<?PHP
      mysql_close();
?>
