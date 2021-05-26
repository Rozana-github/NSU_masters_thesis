<?PHP
      include "Library/dbconnect.php";
      include "Library/Library.php";
      include "Library/SessionValidate.php";
?>

<html>
      <head>
            <meta http-equiv='Content-Type' content='text/html; charset=windows-1252'>
            <title>Invoice Posting</title>
            <script language='javascript'>
                  function callcylinderentry()
                  {
                        document.MyForm.action='CylinderEntry.php';
                        document.MyForm.submit();
                  }
                  function updatecylinder(val)
                  {
                        document.MyForm.txtjobname.value=document.MyForm.elements["jobname["+val+"]"].value;
                        document.MyForm.txtwidth.value=document.MyForm.elements["width["+val+"]"].value;
                        document.MyForm.txtprintarea.value=document.MyForm.elements["printarea["+val+"]"].value;
                        document.MyForm.txtcircumferance.value=document.MyForm.elements["circumferance["+val+"]"].value;
                        document.MyForm.txtups.value=document.MyForm.elements["ups["+val+"]"].value;
                        document.MyForm.txtrepeat.value=document.MyForm.elements["cylinderrepeat["+val+"]"].value;
                        document.MyForm.txtqty.value=document.MyForm.elements["cylinderqty["+val+"]"].value;
                        document.MyForm.txtremarks.value=document.MyForm.elements["remarks["+val+"]"].value;

                        
                  }
                  function submitform()
                  {
                        if(document.MyForm.txtjobname.value == '')
                        {
                                alert("Job Name is Empty");
                                document.MyForm.txtjobname.focus();
                        }
                        else if(document.MyForm.txtwidth.value == '')
                        {
                                alert("Width is Empty");
                                document.MyForm.txtwidth.focus();
                        }
                        else if(document.MyForm.txtprintarea.value == '')
                        {
                                alert("Printarea is Empty");
                                document.MyForm.txtprintarea.focus();
                        }
                        else if(document.MyForm.txtcircumferance.value == '')
                        {
                                alert("Circumferance is Empty");
                                document.MyForm.txtcircumferance.focus();
                        }
                        else
                                document.MyForm.submit();
                  }

            </script>
            <LINK href="Style/generic_form.css" type='text/css' rel='stylesheet'>
            <link rel='stylesheet' type='text/css' href='Style/eng_form.css' />
      </head>
      <body class='body_e'>
            <form name="MyForm" method='POST' action='CylinderEntrySave.php' >
            <table width='100%' id='table1' cellspacing='0' cellpadding='0' align='center'>
                  <tr>
                        <td class='top_left_curb'></td>
                        <td colspan='2' class='header_cell_e' align='center'>Cylinder Information Entry</td>
                        <td class='top_right_curb'></td>
                  </tr>
                  <tr>
                        <td class='lb'></td>


                        <td class='caption_e'>Customer:</td>
                        <td class='td_e'>
                                <select name='cbocustomer' class='select_e' onchange='callcylinderentry()'>
                                <?PHP
                                        createCombo("Customer","mas_customer","customer_id","company_name","order by company_name",$cbocustomer);
                                ?>
                                </select>
                        </td>
                        <td class='rb'></td>
                        
                  </tr>


            </table>
            <?PHP

                if(isset($cbocustomer))
                {
                        echo "<table width='100%'  cellspacing='0' cellpadding='0' align='center'>

                                <tr>
                                        <td class='lb'></td>
                                        <td class='caption_e'>Job Name</td>
                                        <td class='td_e' colspan='3'>
                                                <input type='text' name='txtjobname' value='' class='input_e'>
                                        </td>
                                        <td class='rb'></td>
                                </tr>
                                <tr>
                                        <td class='lb'></td>
                                        <td class='caption_e'>Cylinder Width</td>
                                        <td class='td_e' >
                                                <input type='text' name='txtwidth' value='' class='input_e' size='8' style='text-align:right'> mm
                                        </td>
                                        <td class='caption_e'>Printing Area</td>
                                        <td class='td_e' >
                                                <input type='text' name='txtprintarea' value='' class='input_e' size='8' style='text-align:right'> mm
                                        </td>
                                        <td class='rb'></td>
                                </tr>
                                <tr>
                                        <td class='lb'></td>
                                        <td class='caption_e'>Cylinder Circumferance</td>
                                        <td class='td_e' >
                                                <input type='text' name='txtcircumferance' value='' class='input_e' size='8' style='text-align:right'> mm
                                        </td>
                                        <td class='caption_e'>UPS</td>
                                        <td class='td_e' >
                                                <input type='text' name='txtups' value='' class='input_e' size='8' > mm
                                        </td>
                                        <td class='rb'></td>
                                </tr>
                                <tr>
                                        <td class='lb'></td>
                                        <td class='caption_e'>Repeat</td>
                                        <td class='td_e' >
                                                <input type='text' name='txtrepeat' value='' class='input_e' size='8' > mm
                                        </td>
                                        <td class='caption_e'>Cylinder Quantity</td>
                                        <td class='td_e' >
                                                <input type='text' name='txtqty' value='' class='input_e' size='8' style='text-align:right'> colors
                                        </td>
                                        <td class='rb'></td>
                                </tr>
                                <tr>
                                        <td class='lb'></td>
                                        <td class='caption_e'>Remarks</td>
                                        <td class='td_e' colspan='3'>
                                                <input type='text' name='txtremarks' value='' class='input_e'>
                                        </td>
                                        <td class='rb'></td>
                                </tr>
                                <tr>

                                        <td class='lb'></td>
                                        <td class='button_cell_e' colspan='4' align='center'>
                                                <input type='button' name='btnsve' value='Save' class='forms_button_e' onclick='submitform()'>
                                        </td>
                                        <td class='rb'></td>
                                </tr>
                                <tr>
                                        <td class='bottom_l_curb'></td>
                                        <td class='bottom_f_cell' colspan='4'></td>
                                        <td class='bottom_r_curb'></td>
                                </tr>
                              </table>
                        ";
                        $querycylinder="SELECT
                                                job_name,
                                                cylinder_width,
                                                printing_area,
                                                circumferance,
                                                ups,
                                                cylinder_repeat,
                                                cylinder_qty,
                                                remarks
                                        FROM
                                                mas_cylinder
                                        WHERE
                                                customer_id='".$cbocustomer."'";
                                                
                        $rscylinder=mysql_query($querycylinder)or die(mysql_error());
                        if(mysql_num_rows($rscylinder)>0)
                        {
                                echo    "<table width='98%'  cellspacing='0' cellpadding='0' align='center'>
                                                <tr>
                                                        <td class='title_cell_e'>Sl.No</td>
                                                        <td class='title_cell_e'>Job Name</td>
                                                        <td class='title_cell_e'>Width</td>
                                                        <td class='title_cell_e'>Printing Area</td>
                                                        <td class='title_cell_e'>Circumferance</td>
                                                        <td class='title_cell_e'>Ups</td>
                                                        <td class='title_cell_e'>Repeat</td>
                                                        <td class='title_cell_e'>Cylinder Qty.</td>
                                                        <td class='title_cell_e'>Remarks</td>
                                                </tr>

                                        ";
                                $i=0;
                                while($rowcylinder=mysql_fetch_array($rscylinder))
                                {
                                        extract($rowcylinder);
                                        if($i%2==0)
                                                $cls='even_td_e';
                                        else
                                                $cls='odd_td_e';
                                        echo "<tr >
                                                        <input type='hidden' value='".$job_name."' name='jobname[".$i."]'>
                                                        <input type='hidden' value='".$cylinder_width."' name='width[".$i."]'>
                                                        <input type='hidden' value='".$printing_area."' name='printarea[".$i."]'>
                                                        <input type='hidden' value='".$circumferance."' name='circumferance[".$i."]'>
                                                        <input type='hidden' value='".$ups."' name='ups[".$i."]'>
                                                        <input type='hidden' value='".$cylinder_repeat."' name='cylinderrepeat[".$i."]'>
                                                        <input type='hidden' value='".$cylinder_qty."' name='cylinderqty[".$i."]'>
                                                        <input type='hidden' value='".$remarks."' name='remarks[".$i."]'>
                                                        <td class='".$cls."' onclick='updatecylinder(".$i.")' style='cursor:hand;'>".($i+1)."</td>
                                                        <td class='".$cls."' onclick='updatecylinder(".$i.")' style='cursor:hand;'>".$job_name."</td>
                                                        <td class='".$cls."' onclick='updatecylinder(".$i.")' style='cursor:hand;'>".$cylinder_width."mm</td>
                                                        <td class='".$cls."' onclick='updatecylinder(".$i.")' style='cursor:hand;'>".$printing_area."mm</td>
                                                        <td class='".$cls."' onclick='updatecylinder(".$i.")' style='cursor:hand;'>".$circumferance."mm</td>
                                                        <td class='".$cls."' onclick='updatecylinder(".$i.")' style='cursor:hand;'>".$ups."mm</td>
                                                        <td class='".$cls."' onclick='updatecylinder(".$i.")' style='cursor:hand;'>".$cylinder_repeat."mm</td>
                                                        <td class='".$cls."' onclick='updatecylinder(".$i.")' style='cursor:hand;'>".$cylinder_qty."colors</td>
                                                        <td class='".$cls."' onclick='updatecylinder(".$i.")' style='cursor:hand;'>".$remarks."&nbsp;</td>
                                                </tr>" ;
                                                $i++;
                                }
                                echo "</table>";
                        }
                }

            ?>
            
            </form>
      </body>
</html>
<?PHP
      mysql_close();
?>
