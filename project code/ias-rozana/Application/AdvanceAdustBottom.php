<?PHP
      include "Library/dbconnect.php";
      include "Library/Library.php";
      include "Library/SessionValidate.php";
?>

<html>
      <head>
            <meta http-equiv='Content-Type' content='text/html; charset=windows-1252'>
            <title>Invoice Posting</title>
            <script language=javascript>

                  var xmlHttp = false;
                  try
                  {
                        xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
                  }
                  catch (e)
                  {
                        try
                        {
                              xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
                        }
                        catch (e2)
                        {
                              xmlHttp = false;
                        }
                  }

                  if (!xmlHttp && typeof XMLHttpRequest != 'undefined')
                  {
                        xmlHttp = new XMLHttpRequest();
                  }

                  function callServer(URLQuery)
                  {
                        var url = "Library/AjaxLibrary.php";

                        xmlHttp.open("POST", url, true);
                        //xmlHttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded; charset=UTF-8");

                        xmlHttp.setRequestHeader("Method", "POST " + url + " HTTP/1.1");
                        xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                        xmlHttp.onreadystatechange = updatePage;
                        xmlHttp.send(URLQuery);
                  }

                  function updatePage()
                  {
                        // alert(xmlHttp.readyState);
                        if (xmlHttp.readyState == 4)
                        {
                              var response = xmlHttp.responseText;
                              //alert(response);
                              window.BankAccountX.innerHTML="";
                              window.BankAccountX.innerHTML=response;
                        }
                  }
                  function sendBank(val)
                  {
                        var FunctionName="createCombo";
                        var ComboName="cboBankAccount";
                        var SelectA="Bank Account";
                        var TableName="trn_bank";
                        var ID="account_object_id";
                        var Name="account_no";
                        var Condition=escape("where bank_id='"+val+"' order by account_no");
                        var selectedValue="";
                        var OnChangeEvent="";

                        var URLQuery="FunctionName="+FunctionName+"&ComboName="+ComboName+"&SelectA="+SelectA+"&TableName="+TableName+"&ID="+ID+"&Name="+Name+"&Condition="+Condition+"&selectedValue="+selectedValue+"&OnChangeEvent="+OnChangeEvent+"";
                        //alert(URLQuery);
                        callServer(URLQuery);
                  }
            </script>
            
            <script language='javascript'>
                  function getAmount(IndexVal)
                  {
                        var NetBill=document.MyForm.elements["txtNetBill["+IndexVal+"]"].value;
                        var ReceivedAmount=document.MyForm.elements["txtReceivedAmount["+IndexVal+"]"].value;
                        var Amount=parseFloat(NetBill)-parseFloat(ReceivedAmount);

                        if(document.MyForm.elements["chkAccept["+IndexVal+"]"].checked)
                        {
                              document.MyForm.elements["txtAmount["+IndexVal+"]"].value=Amount;
                              calculateTotalAmount();
                        }
                        else
                        {
                              document.MyForm.elements["txtAmount["+IndexVal+"]"].value="";
                              calculateTotalAmount();
                        }
                  }
                  function calculateTotalAmount()
                  {
                        var Index=parseInt(document.MyForm.hidIndex.value);
                        var TotalAmount=0;

                        for (var i=0;i<Index;i++)
                        {
                              if(document.MyForm.elements["chkAccept["+i+"]"].checked)
                              {
                                    if(!isNaN(document.MyForm.elements["txtAmount["+i+"]"].value))
                                          TotalAmount=TotalAmount+parseFloat(document.MyForm.elements["txtAmount["+i+"]"].value);
                                    else
                                          document.MyForm.elements["txtAmount["+i+"]"].value='0';
                              }
                        }
                        document.MyForm.txtTotalAmount.value=TotalAmount;
                        document.MyForm.AdvanceCr.value=TotalAmount;
                        document.MyForm.AdvanceDr.value=TotalAmount;

                  }
                  function sendValue()
                  {
                        var Index=parseInt(document.MyForm.hidIndex.value);

                        var NetBill;
                        var ReceivedAmount;
                        var Amount;
                        var PossibleMaxAmount;


                        if((document.MyForm.elements["rdoReceiveType"][1].checked) && (parseInt(document.MyForm.cboBank.value)==-1 || parseInt(document.MyForm.cboBankAccount.value)==-1))
                        {
                              alert("Bank And Bank Account No Is Required.");
                              return;
                        }


                        var Flag=true;
                        for (var i=0;i<Index;i++)
                        {
                                if(document.MyForm.elements["chkAccept["+i+"]"].checked)
                                {
                                        NetBill=document.MyForm.elements["txtNetBill["+i+"]"].value;
                                        ReceivedAmount=document.MyForm.elements["txtReceivedAmount["+i+"]"].value;
                                        Amount=parseFloat(document.MyForm.elements["txtAmount["+i+"]"].value);
                                        PossibleMaxAmount=parseFloat(NetBill)-parseFloat(ReceivedAmount);

                                        if(Amount>PossibleMaxAmount || Amount<=0 || isNaN(Amount))
                                        {
                                                alert ("Please Enter Valid Amount.");
                                                document.MyForm.elements["txtAmount["+i+"]"].focus();
                                                return;
                                        }
                                        Flag=false;
                                }
                        }
                        if(Flag)
                        {
                                alert("Please Select At List One Invoice.");
                                return;
                        }

                        document.MyForm.action="AdvanceAdustSave.php";
                        document.MyForm.submit();
                  }
                  function checkReceiveType(val)
                  {
                        //alert(val);
                        if(val=='C')
                        {
                              document.MyForm.cboBank.disabled=true;
                              document.MyForm.cboBankAccount.disabled=true;
                              document.MyForm.txtChequeNo.disabled=true;
                              document.MyForm.cboChequeDay.disabled=true;
                              document.MyForm.cboChequeMonth.disabled=true;
                              document.MyForm.cboChequeYear.disabled=true;
                        }
                        else
                        {
                              document.MyForm.cboBank.disabled=false;
                              document.MyForm.cboBankAccount.disabled=false;
                              document.MyForm.txtChequeNo.disabled=false;
                              document.MyForm.cboChequeDay.disabled=false;
                              document.MyForm.cboChequeMonth.disabled=false;
                              document.MyForm.cboChequeYear.disabled=false;
                        }
                  }
            </script>
            <LINK href="Style/generic_form.css" type='text/css' rel='stylesheet'>
            <link rel='stylesheet' type='text/css' href='Style/eng_form.css' />
      </head>
      <body class='body_e'>
            <form name="MyForm" method='POST' action='AdvanceAdustSave.php'>
            <?PHP
                  $query="select
                              mas_supplier_invoice.invoiceobjet_id,
                              mas_supplier_invoice.invoice_number,
                              mas_supplier_invoice.invoice_date,
                              mas_supplier_invoice.net_bill,
                              IFNULL(TEMP.ReceivedAmount,0) AS ReceivedAmount,
                              mas_supplier_invoice.supplier_id
                        FROM
                              mas_supplier_invoice
                              LEFT JOIN
                              (
                                    select
                                          invoiceobject_id,
                                          SUM(pay_amount) AS ReceivedAmount
                                    from
                                          mas_invoice_payment
                                    group by
                                          invoiceobject_id
                              ) AS TEMP ON mas_supplier_invoice.invoiceobjet_id=TEMP.invoiceobject_id
                        WHERE
                              (mas_supplier_invoice.receive_status='0' OR mas_supplier_invoice.receive_status='1') AND
                              mas_supplier_invoice.supplier_id='$cboDebtor'";

                  $rs=mysql_query($query) or die("Error: ".mysql_error());

                  $RowCount=mysql_num_rows($rs);
                  if($RowCount>0)
                  {
                        echo "<input type='hidden' name='SupplierID' value='$cboDebtor'>";
                        echo "<table width='90%' id='table1' cellspacing='0' cellpadding='0' align='center'>
                                    <tr>
                                          <td class='top_left_curb'></td>
                                          <td colspan='6' class='header_cell_e' align='center'>Invoice List</td>
                                          <td class='top_right_curb'></td>
                                    </tr>
                                    <tr>
                                          <td class='lb' rowspan='".($RowCount+2)."'></td>
                                          <td class='title_cell_e'>Invoice Number</td>
                                          <td class='title_cell_e'>Date</td>
                                          <td class='title_cell_e'>Net Bill</td>
                                          <td class='title_cell_e'>Received Amount</td>
                                          <td class='title_cell_e'>Accept</td>
                                          <td class='title_cell_e'>Amount</td>
                                          <td class='rb' rowspan='".($RowCount+2)."'></td>
                                    </tr>";
                                    
                        $i=0;
                        while($row=mysql_fetch_array($rs))
                        {
                              extract($row);

                              if(($i%2)==0)
                                    $class='even_td_e';
                              else
                                    $class='odd_td_e';
                                    
                              echo "<tr>
                                          <td class='$class'>
                                                $invoice_number
                                                <input type='hidden' name='txtInvoiceObjectID[$i]' value='$invoiceobjet_id'>
                                          </td>
                                          <td class='$class'>$invoice_date</td>
                                          <td class='$class'><input type='text' class='input_e' name='txtNetBill[$i]' value='$net_bill' readonly></td>
                                          <td class='$class'><input type='text' class='input_e' name='txtReceivedAmount[$i]' value='$ReceivedAmount' readonly></td>
                                          <td class='$class'><input type='checkbox' name='chkAccept[$i]' value='ON' onclick=\"getAmount('$i')\"></td>
                                          <td class='$class'><input type='text' class='input_e' name='txtAmount[$i]' onchange='calculateTotalAmount()'></td>
                                    </tr>";
                              $i++;
                        }
                        echo "<tr>
                                    <td class='caption_e' colspan='5'>Total Amount</td>
                                    <td class='td_e'><input type='text' class='input_e' name='txtTotalAmount' readonly></td>
                              </tr>";
                        echo "<tr>
                                    <td class='bottom_l_curb'></td>
                                    <td class='bottom_f_cell' colspan='6'></td>
                                    <td class='bottom_r_curb'></td>
                              </tr>";
                        echo "</table>";
                        echo "<input type='hidden' name='hidIndex' value='$i'>";
                  }
                  else
                  {
                        drawNormalMassage("No Information Available.");
                        die();
                  }
            ?>
            <?PHP
                  $query="select (MAX(DR)+1) AS DR from mas_latestjournalnumber";

                  $rs=mysql_query($query) or die("Error: ".mysql_error());

                  $RowCount=mysql_num_rows($rs);
                  if($RowCount>0)
                  {
                        while($row=mysql_fetch_array($rs))
                        {
                              extract($row);
                        }
                  }
                  else
                  {
                        drawNormalMassage("Error: Voucher Number Ge2neration.");
                        die();
                  }

            ?>
            <?PHP
                  $query="select (MAX(JV)+1) AS JV from mas_latestjournalnumber";

                  $rs=mysql_query($query) or die("Error: ".mysql_error());

                  $RowCount=mysql_num_rows($rs);
                  if($RowCount>0)
                  {
                        while($row=mysql_fetch_array($rs))
                        {
                              extract($row);
                        }

                        echo "<table width='90%' id='table1' cellspacing='0' cellpadding='0' align='center'>
                                    <tr>
                                          <td class='top_left_curb'></td>
                                          <td colspan='4' class='header_cell_e' align='center'>Journal Voucher</td>
                                          <td class='top_right_curb'></td>
                                    </tr>
                                    <tr>
                                          <td class='lb' rowspan='2'></td>
                                          <td class='caption_e'>Voucher No</td>
                                          <td class='td_e'><input type='text' class='input_e' name='VoucherNo' value='$JV'></td>
                                          <td class='caption_e'>Voucher Date</td>
                                          <td class='td_e'>";
                                          echo "<select name='cboVoucherDay' class='select_e'>";
                                                      $D=date('d');
                                                      comboDay($D);
                                          echo "</select>";
                                          echo "<select name='cboVoucherMonth' class='select_e'>";
                                                      $M=date('m');
                                                      comboMonth($M);
                                          echo "</select>";
                                          echo "<select name='cboVoucherYear' class='select_e'>";
                                                      $Y=date('Y');
                                                      $PY=$Y-10;
                                                      $NY=$Y+10;
                                                      comboYear($PY,$NY,$Y);
                                          echo "</select>";
                                          echo "</td>
                                          <td class='rb' rowspan='2'></td>
                                    </tr>
                                    <tr>
                                          <td class='caption_e'>Customer</td>
                                          <td class='td_e'>
                                                <input type='text' class='input_e' name='CustomerName' value='".pick("mas_customer","company_name","customer_id=$cboDebtor")."'>
                                                <input type='hidden' class='input_e' name='CustomerID' value='$cboDebtor'>
                                                <input type='hidden' class='input_e' name='InvoiceObjectID' value='$invoiceobjet_id'>
                                          </td>
                                          <td class='caption_e'>Remarks</td>
                                          <td class='td_e'>
                                                <input type='text' class='input_e' size='50' name='Remarks' value=''>

                                          </td>
                                    </tr>
                                    <tr>
                                          <td class='bottom_l_curb'></td>
                                          <td class='bottom_f_cell' colspan='4'></td>
                                          <td class='bottom_r_curb'></td>
                                    </tr>
                              </table>";
                        echo "<br>";
                      /*  $RowSpan=6;
                        if($vat==0)
                        {
                                $total_bill=$net_bill-$net_bill*.1304;
                                $vat=$net_bill*.1304;
                        }
                        if($net_bill==0)
                              $RowSpan--;
                        if($discount_amount==0)
                              $RowSpan--;
                        if($total_bill==0)
                              $RowSpan--;
                        if($vat==0)
                              $RowSpan--;  */
                        echo "<table width='90%' id='table2' cellspacing='0' cellpadding='0' align='center'>
                                    <tr>
                                          <td class='top_left_curb'></td>
                                          <td colspan='3' class='header_cell_e' align='center'>Journal Voucher Detail</td>
                                          <td class='top_right_curb'></td>
                                    </tr>
                                    <tr>
                                          <td class='lb' ></td>
                                          <td class='title_cell_e'></td>
                                          <td class='title_cell_e' align='center'>Dr</td>
                                          <td class='title_cell_e' align='center'>Cr</td>
                                          <td class='rb' ></td>
                                    </tr>";
                        echo "<tr>
                                          <td class='lb' ></td>
                                          <td class='caption_e'>Advance</td>
                                          <td class='td_e'></td>
                                          <td class='td_e' align='center'><input type='text' class='input_e' name='AdvanceCr' value='' style=\"text-align : right;\" readonly></td>

                                          <td class='rb' ></td>
                                    </tr>";


                                        $discriptiontype=pick("mas_gl","description","gl_code='20501'");
                                        echo "<input type='hidden' name='discriptiontype' value='20501'>";

                              echo "<tr>
                                          <td class='lb' ></td>
                                          <td class='caption_e'>$discriptiontype</td>
                                          <td class='td_e' align='center'><input type='text' class='input_e' name='AdvanceDr' value='' style=\"text-align : right;\" readonly></td>
                                          <td class='td_e'></td>
                                          <td class='rb' ></td>

                                    </tr>";





                        echo "      <tr>
                                          <td class='lb' ></td>
                                          <td class='button_cell_e' colspan='3' align='center'><input type='submit' class='forms_button_e' name='Submit' value='Submit'></td>
                                          <td class='rb' ></td>
                                    </tr>
                                    <tr>
                                          <td class='bottom_l_curb'></td>
                                          <td class='bottom_f_cell' colspan='3' ></td>
                                          <td class='bottom_r_curb'></td>
                                    </tr>
                              </table>";
                  }
                  else
                  {
                        drawNormalMassage("Voucher Number Generation Failed.");
                  }
            ?>
            </form>
      </body>
</html>
