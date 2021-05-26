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
                        var quentity=document.MyForm.elements["txtrquqty["+IndexVal+"]"].value;
                        //var Receivedqty=document.MyForm.elements["txtreceivedqty["+IndexVal+"]"].value;
                        //var Amount=parseFloat(NetBill)-parseFloat(ReceivedAmount);

                        if(document.MyForm.elements["Ck["+IndexVal+"]"].checked)
                        {
                              document.MyForm.elements["txtreceivedqty["+IndexVal+"]"].value=quentity;
                              //calculateTotalAmount();
                        }
                        else
                        {
                              document.MyForm.elements["txtreceivedqty["+IndexVal+"]"].value="";
                              //calculateTotalAmount();
                        }
                  }
            </script>
            <LINK href="Style/generic_form.css" type='text/css' rel='stylesheet'>
            <link rel='stylesheet' type='text/css' href='Style/eng_form.css' />
      </head>
      <body class='body_e'>
            <form name="MyForm" method='POST' action='AddTo_LcReceive.php' >



                              <?PHP
                                    echo "<input type='hidden' value='$cboLc' name='txtLcno'>";
                                    if(!isset($txtVoucherDay))
                                          $txtVoucherDay=date("d");
                                    if(!isset($txtVoucherMonth))
                                          $txtVoucherMonth=date("m");
                                    if(!isset($txtVoucherYear))
                                          $txtVoucherYear=date("Y");
                                          


                                    echo"<table width='100%' id='table1' cellspacing='0' cellpadding='0' align='center'>

                                    <tr>
                                          <td class='lb'></td>
                                          <td class='caption_e' >Receive No</td>
                                          <td class='td_e' colspan='2'><input type='text' name='txtReceiveNo' value='' class='input_e'></td>
                                          <td class='caption_e' >Challan No/ Packing No:</td>
                                          <td class='td_e' colspan='2'><input type='text' name='txtpackno' value='' class='input_e'></td>
                                          <td class='rb'></td>
                                    </tr>
                                    <tr>
                                          <td class='lb'></td>

                                          <td class='caption_e'>Issue Date:</td>
                                          <td class='td_e' colspan='5'>
                                                dd<input type='text' name='txtDay' value='$txtVoucherDay' size='2' maxlength='2' class='input_e'>
                                                mm<input type='text' name='txtMonth' value='$txtVoucherMonth' size='2' maxlength='2' class='input_e'>
                                                yyyy<input type='text' name='txtYear' value='$txtVoucherYear' size='4' maxlength='4' class='input_e'>
                                          </td>
                                          <td class='rb'></td>
                                    </tr>

                                    <tr>

                                          <td class='bottom_l_curb'></td>
                                          <td class='bottom_f_cell' colspan='6'></td>
                                          <td class='bottom_r_curb'></td>
                                    </tr>
                              </table>
                              ";
                              $query="SELECT
                                          lcobjectdetailid ,
                                          mas_item.itemcode,
                                          mas_item.parent_itemcode,
                                          unitid ,
                                          rate ,
                                          reqqty
                                    FROM
                                          trn_lc
                                          LEFT JOIN mas_item ON mas_item.itemcode = trn_lc.itemcode
                                    WHERE
                                          lcobjectid = '$cboLc'
                                    ";
                              //echo $query;
                              $rs=mysql_query($query)or die(mysql_error());
                              $numrows=mysql_num_rows($rs);
                              if($numrows>0)
                              {
                                    echo"
                                          <table width='100%' id='table1' cellspacing='0' cellpadding='0' align='center'>
                                                <tr>
                                                      <td class='title_cell_e'>Item Name</td>
                                                      <td class='title_cell_e'>Quantity</td>
                                                      <td class='title_cell_e'>Rate</td>
                                                      <td class='title_cell_e'>units</td>
                                                      <td class='title_cell_e'>&nbsp;</td>
                                                      <td class='title_cell_e'>Recieve Qty</td>

                                                </tr>
                                          ";
                                          $i=0;
                                    while($row=mysql_fetch_array($rs))
                                    {
                                          extract($row);
                                          $mainitem=pick("mas_item","itemdescription","itemcode='$parent_itemcode'");
                                          $subitem=pick("mas_item","itemdescription","itemcode='$itemcode'");
                                          $units=pick("mas_unit","unitdesc","unitid='$unitid'");
                                          echo" <tr>
                                                      <td class='td_e' align='center'>".$mainitem."-".$subitem."</td>
                                                      <td class='td_e' align='center'>$reqqty</td>
                                                      <td class='td_e' align='center'>$rate</td>
                                                      <td class='td_e' align='center'>$units</td>
                                                      <td class='td_e' align='center'>
                                                            <input type='checkbox' name='Ck[$i]' value='ON' onclick='putvalue($i)'>
                                                      </td>
                                                      <td class='td_e' align='center'>
                                                            <input type='text' name='txtreceivedqty[$i]' value='' class='input_e'>
                                                      </td>
                                                </tr>
                                                <input type='hidden' value='$itemcode' name='txtitemcode[$i]'>
                                                <input type='hidden' value='$trn_requisition_id' name='lcobjectdetailid[$i]'>
                                                <input type='hidden' value='$reqqty' name='txtrquqty[$i]'>
                                                <input type='hidden' value='$unitid' name='txtunit[$i]'>
                                                <input type='hidden' value='$rate' name='txtrate[$i]'>
                                                ";
                                          $i++;
                                                
                                    }
                                    echo"<input type='hidden' value='$i' name='TotalIndex'>
                                    <tr>
                                          <td colspan='6' align='center'>
                                                <input type='submit' value='Save' class='forms_button_e'>
                                          </td>
                                    </tr></table>";
                              }
                                          
                              ?>



            </form>
      </body>
</html>
<?PHP
      mysql_close();
?>
