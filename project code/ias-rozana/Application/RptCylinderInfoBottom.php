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
            <link rel='stylesheet' type='text/css' href='Style/eng_report.css' />
            <LINK href="Style/generic_report.css" type='text/css' rel='stylesheet'>
            <link rel='stylesheet' type='text/css' href='Style/interface_styles.css' />
      </head>
      <body class='body_e'>
      <?PHP

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
                                drawCompanyInformation("Cylinder Information ","Customer Name: ".pick("mas_customer","company_name","customer_id='".$cbocustomer."'"));
                                echo    "<table width='98%'  cellspacing='0' cellpadding='0' align='center'>
                                                <tr>
                                                        <td class='title_cell_e_l'>Sl.No</td>
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
                                        {
                                                $cls='even_td_e';
                                                $clsl='even_left_td_e';
                                        }
                                        else
                                        {
                                                $cls='odd_td_e';
                                                $clsl='odd_left_td_e';
                                        }
                                        echo "<tr >

                                                        <td class='".$clsl."' onclick='updatecylinder(".$i.")' style='cursor:hand;'>".($i+1)."</td>
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
                        else
                        {
                                drawNormalMassage("No Information Available.");
                        }


            ?>
            

      </body>
</html>
<?PHP
      mysql_close();
?>
