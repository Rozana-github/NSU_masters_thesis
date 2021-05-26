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
                  function sendData()
                  {
                        document.MyForm.submit();
                  }
                  function doPrint()
                  {
                        window.parent.MaterialIssueBottom.focus();
                        window.parent.MaterialIssueBottom.print();
                  }
                      function putvalue(IndexVal)
                  {
                        //alert(document.MyForm.elements["txtissueqty["+IndexVal+"]"].value);
                        var reqqty=parseInt(document.MyForm.elements["txtreqqty["+IndexVal+"]"].value);
                        var issueqty=parseInt(document.MyForm.elements["txtissuedqty["+IndexVal+"]"].value);
                        var quentity=reqqty-issueqty;
                        //alert(reqqty+"**"+issueqty+"**"+quentity);
                        var storebalance=document.MyForm.elements["txtopenbalance["+IndexVal+"]"].value;
                        //var Amount=parseFloat(NetBill)-parseFloat(ReceivedAmount);

                        if(document.MyForm.elements["Ck["+IndexVal+"]"].checked)
                        {
                              if(storebalance!=0)
                              {
                                    document.MyForm.elements["txtissueqty["+IndexVal+"]"].value=quentity;
                              }
                              else
                              {
                                    document.MyForm.elements["txtissueqty["+IndexVal+"]"].value=0;
                              }
                              //calculateTotalAmount();
                        }
                        else
                        {
                              document.MyForm.elements["txtissueqty["+IndexVal+"]"].value="";
                              //calculateTotalAmount();
                        }
                  }
            </script>
            <LINK href="Style/generic_form.css" type='text/css' rel='stylesheet'>
         <link rel='stylesheet' type='text/css' href='Style/eng_report.css' />
        <link rel='stylesheet' type='text/css' href='Style/interface_styles.css' />
      </head>
      <body class='body_e'>
            <form name="MyForm" method='POST' action='AddTo_MaterialIssue.php' target='MaterialIssueBottom'>
             <table width='100%' id='table1' cellspacing='0' cellpadding='0' align='center'>

                  <tr>


                              <?PHP
                                    /*echo "<input type='hidden' value='$cborequsitionno' name='requisitno'>";
                                    if(!isset($txtVoucherDay))
                                          $txtVoucherDay=date("d");
                                    if(!isset($txtVoucherMonth))
                                          $txtVoucherMonth=date("m");
                                    if(!isset($txtVoucherYear))
                                          $txtVoucherYear=date("Y");
                                          


                                    echo" <td class='lb'></td>

                                          <td class='caption_e'>Issue Date:</td>
                                          <td class='td_e' colspan='2'>
                                                dd<input type='text' name='txtDay' value='$txtVoucherDay' size='2' maxlength='2' class='input_e'>
                                                mm<input type='text' name='txtMonth' value='$txtVoucherMonth' size='2' maxlength='2' class='input_e'>
                                                yyyy<input type='text' name='txtYear' value='$txtVoucherYear' size='4' maxlength='4' class='input_e'>
                                          </td>
                                          <td class='caption_e' >Issued By</td>
                                          <td class='td_e' colspan='2'><input type='text' name='txtemployee' value='' class='input_e'></td>
                                          <td class='rb'></td>
                                    </tr>
                                    <tr>
                                          <td class='bottom_l_curb'></td>
                                          <td class='bottom_f_cell' colspan='6'></td>
                                          <td class='bottom_r_curb'></td>
                                    </tr>
                              </table>
                              ";   */
                              $query="SELECT
                                                requisition_number,
                                                date_format(requisition_date,'%d-%m-%Y') as requisition_date,
                                                requisition_by,
                                                requisition_job,
                                                requisition_item,
                                                date_format(required_date,'%d-%m-%Y') as required_date,
                                                job_quantity,
                                                requision_status
                                        FROM
                                                mas_material_req
                                        WHERE
                                                mas_requisition_id='$cborequsitionno'

                                    ";
                                //echo  $query;
                              $rs=mysql_query($query)or die(mysql_error());
                              $numrows=mysql_num_rows($rs);
                              if($numrows>0)
                              {
                                    drawCompanyInformation("Material Requsition Slip","");

                                          $i=0;
                                    while($row=mysql_fetch_array($rs))
                                    {
                                          extract($row);
                                          $mainitem=pick("mas_item","itemdescription","itemcode=$requisition_item");
                                          
                                    }
                                    echo "<table width='90%' id='table1' cellspacing='3' cellpadding='0' align='center'>
                                                <tr>
                                                        <td>Job No:</td><td>$requisition_job</td>
                                                        <td>Requsition No:</td><td>$requisition_number</td>
                                                </tr>
                                                <tr>
                                                        <td>Item Name:</td><td>$mainitem</td>
                                                        <td>Requsition No:</td><td>$requisition_date</td>
                                                </tr>
                                                <tr>
                                                        <td>Required Date:</td><td>$required_date</td>
                                                        <td>Job Quantity:</td><td>$job_quantity   kg</td>
                                                </tr>
                                        </table>";
                                         $trnquery="SELECT
                                                        mas_item.itemcode,
                                                        mas_item.parent_itemcode,
                                                        trn_material_req.trn_requisition_id,
                                                        trn_material_req.req_quantity,
                                                        trn_material_req.unitid,
                                                        trn_material_req.remarks
                                                FROM
                                                        trn_material_req
                                                        left join mas_item on mas_item.itemcode=trn_material_req.itemcode
                                               WHERE
                                                        trn_material_req.mas_requisition_id='$cborequsitionno'

                                                ";
                                        $rstrn=mysql_query($trnquery)or die(mysql_error());
                                        echo"
                                                <br>
                                                <br><table width='90%' id='table1' cellspacing='0' cellpadding='0' align='center'>
                                                <tr>
                                                      <td class='title_cell_e_l'>Sl.No</td>
                                                      <td class='title_cell_e'>particulars</td>
                                                      <td class='title_cell_e'>Rqrd. Size mm</td>
                                                      <td class='title_cell_e'>Avbl. Size mm</td>
                                                      <td class='title_cell_e'>Requd. Qnty. kg</td>

                                                      <td class='title_cell_e'>Remarks</td>


                                                </tr>
                                                ";
                                        while($rowtrn=mysql_fetch_array($rstrn))
                                        {
                                                extract($rowtrn);
                                                if(($i%2)==0)
                                                {
                                                        $cls="even_td_e";
                                                        $lcls="even_left_td_e";
                                                }
                                                else
                                                {
                                                        $cls="odd_td_e";
                                                        $lcls="odd_left_td_e";
                                                }

                                                $mainitem=pick("mas_item","itemdescription","itemcode=$parent_itemcode");
                                                $subitem=pick("mas_item","itemdescription","itemcode=$itemcode");
                                                $units=pick("mas_unit","unitdesc","unitid=$unitid");

                                                echo" <tr>
                                                      <td class='$lcls' align='center'>".($i+1)."</td>
                                                      <td class='$cls' align='left'>".$mainitem."-".$subitem."</td>
                                                      <td class='$cls' align='right'>&nbsp;</td>
                                                      <td class='$cls' align='right'>&nbsp;</td>
                                                      <td class='$cls' align='right'>$req_quantity $units</td>

                                                      <td class='$cls' align='center'>$remarks&nbsp;</td>


                                                </tr>

                                                ";
                                                $i++;
                                        }


                                     echo "</table>";
                                     echo "<br><br><table width='90%' id='table1' cellspacing='3' cellpadding='0' align='center'>
                                                <tr>
                                                        <td>Originator:</td>
                                                        <td>
                                                        <table>
                                                                <tr>
                                                                <td>Signature:</td><td>----------------</td>
                                                                </tr>
                                                                <tr>
                                                                <td>Name:</td><td>----------------</td>
                                                                </tr>
                                                        </table>
                                                        </td>
                                                        <td>Store Personnel:</td>
                                                        <td>
                                                        <table>
                                                                <tr>
                                                                <td>Signature:</td><td>----------------</td>
                                                                </tr>
                                                                <tr>
                                                                <td>Name:</td><td>----------------</td>
                                                                </tr>
                                                        </table>
                                                        </td>

                                                </tr>
                                                <tr>
                                                        <td>&nbsp;</td><td>&nbsp;</td>
                                                        <td>&nbsp;</td><td>&nbsp;</td>
                                                </tr>
                                                <tr>
                                                        <td>Authorised:</td><td>---------------------------</td>
                                                        <td>Authorised:</td><td>---------------------------</td>
                                                </tr>
                                        </table>";
                                    }
                                    /*echo"<input type='hidden' value='$i' name='TotalIndex'>
                                    <tr>
                                          <td colspan='6' align='center'>
                                                <input type='submit' value='Save' class='forms_button_e'>
                                          </td>
                                    </tr>*/


                                          
                              ?>



            </form>
      </body>
</html>
<?PHP
      mysql_close();
?>
