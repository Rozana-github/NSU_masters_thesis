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
            <link rel='stylesheet' type='text/css' href='Style/eng_form.css' />
      </head>
      <body class='body_e'>
            <form name="MyForm" method='POST' action='AddTo_MaterialIssue.php' target='MaterialIssueBottom'>
             <table width='100%' id='table1' cellspacing='0' cellpadding='0' align='center'>

                  <tr>


                              <?PHP
                                    echo "<input type='hidden' value='$cborequsitionno' name='requisitno'>";
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
                              ";
                              $query="SELECT
                                          mas_item.itemcode,
                                          mas_item.parent_itemcode,
                                          trn_material_req.trn_requisition_id,
                                          trn_material_req.req_quantity,
                                          trn_material_req.unitid,
                                          ifnull(sum(ifnull(trn_store_out.issue_quantity,0)),0) as issuedquantity ,
                                          ifnull(sb.storebalance,0) as storebalance
                                    FROM
                                          trn_material_req
                                          left join mas_item on mas_item.itemcode=trn_material_req.itemcode
                                          left join trn_store_out on trn_store_out.itemcode=trn_material_req.itemcode and trn_store_out.trn_requisition_id=trn_material_req.trn_requisition_id
                                          left join (
                                                      select
                                                            trn_store_in.itemcode,
                                                            sum(ifnull(quantity_disburse,0)) as storebalance
                                                      from
                                                            trn_store_in
                                                      where
                                                            trn_store_in.itemcode in (
                                                                                          select
                                                                                                trn_material_req.itemcode
                                                                                                from trn_material_req
                                                                                          where
                                                                                                trn_material_req.mas_requisition_id='$cborequsitionno'
                                                                                    )
                                                      group by
                                                            trn_store_in.itemcode
                                                      ) as sb on sb.itemcode=trn_material_req.itemcode
                                    WHERE
                                          trn_material_req.mas_requisition_id='$cborequsitionno'
                                    group by
                                          mas_item.itemcode
                                    order by
                                        trn_material_req.trn_requisition_id
                                    ";
                              $rs=mysql_query($query)or die(mysql_error());
                              $numrows=mysql_num_rows($rs);
                              if($numrows>0)
                              {
                                    echo"
                                          <table width='100%' id='table1' cellspacing='0' cellpadding='0' align='center'>
                                                <tr>
                                                      <td class='title_cell_e'>Sl.No</td>
                                                      <td class='title_cell_e'>particulars</td>
                                                      <td class='title_cell_e'>Requisit Qty</td>
                                                      <td class='title_cell_e'>Unit</td>
                                                      <td class='title_cell_e'>Issued Qty</td>
                                                      <td class='title_cell_e'>store Balance</td>
                                                      <td class='title_cell_e'>&nbsp;</td>
                                                      <td class='title_cell_e'>Issued Itme</td>
                                                      <td class='title_cell_e'>New Issue</td>
                                                </tr>
                                          ";
                                          $i=0;
                                    while($row=mysql_fetch_array($rs))
                                    {
                                          extract($row);
                                          if($i%2==0)
                                                $cls='even_td_e';
                                          else
                                               $cls='odd_td_e';

                                                $mainitem=pick("mas_item","itemdescription","itemcode=$parent_itemcode");
                                                $subitem=pick("mas_item","itemdescription","itemcode=$itemcode");
                                                $units=pick("mas_unit","unitdesc","unitid=$unitid");

                                                echo" <tr>
                                                      <td class='$cls' align='center'>".($i+1)."</td>
                                                      <td class='$cls' align='center'>".$mainitem."-".$subitem."</td>
                                                      <td class='$cls' align='center'>$req_quantity</td>
                                                      <td class='$cls' align='center'>$units</td>
                                                      <td class='$cls' align='center'>$issuedquantity</td>
                                                      <td class='$cls' align='center'>$storebalance</td>
                                                       <td class='$cls' align='center'>
                                                            <input type='checkbox' name='Ck[$i]' value='ON' onclick='putvalue($i)'>
                                                      </td>
                                                      <td class='$cls' align='center'>
                                                        <select name='issueitem[$i]' class='select_e'>";
                                                        createCombo("Item","mas_item","itemcode","itemdescription"," where parent_itemcode=$parent_itemcode","");
                                                echo"</select></td>
                                                      <td class='$cls' align='center'><input type='text' name='txtissueqty[$i]' value='' class='input_e' o></td>
                                                </tr>
                                                <input type='hidden' value='$itemcode' name='txtitemcode[$i]'>
                                                <input type='hidden' value='$trn_requisition_id' name='txttrnrequisitionid[$i]'>
                                                <input type='hidden' value='$unitid' name='txtunit[$i]'>
                                                <input type='hidden' value='$storebalance' name='txtopenbalance[$i]'>
                                                <input type='hidden' value='$req_quantity' name='txtreqqty[$i]'>
                                                <input type='hidden' value='$issuedquantity' name='txtissuedqty[$i]'>
                                                ";
                                                $i++;


                                                
                                    }
                                    echo"<input type='hidden' value='$i' name='TotalIndex'>
                                    <tr>
                                          <td colspan='9' align='center' class='button_cell_e'>
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
