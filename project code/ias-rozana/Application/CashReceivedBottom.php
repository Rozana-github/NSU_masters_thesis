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

                        document.MyForm.action="CashReceivedSave.php";
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
            <form name="MyForm" method='POST' action='CashReceivedSave.php'>
            <?PHP
                  $query="select
                              mas_invoice.invoiceobjet_id,
                              mas_invoice.invoice_number,
                              mas_invoice.invoice_date,
                              mas_invoice.net_bill,
                              IFNULL(TEMP.ReceivedAmount,0) AS ReceivedAmount,
                              mas_invoice.customer_id
                        FROM
                              mas_invoice
                              LEFT JOIN
                              (
                                    select
                                          invoiceobjet_id,
                                          SUM(collection_amount+ait_amount+sales_return_amount) AS ReceivedAmount
                                    from
                                          mas_invoice_collection
                                    group by
                                          invoiceobjet_id
                              ) AS TEMP ON mas_invoice.invoiceobjet_id=TEMP.invoiceobjet_id
                        WHERE
                              (mas_invoice.receive_status='0' OR mas_invoice.receive_status='1') AND
                              customer_id='$cboDebtor'";

                  $rs=mysql_query($query) or die("Error: ".mysql_error());

                  $RowCount=mysql_num_rows($rs);
                  if($RowCount>0)
                  {
                        echo "<input type='hidden' name='CustomerID' value='$cboDebtor'>";
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
                                          <td class='$class'><input type='text' style='text-align:right' class='input_e' name='txtNetBill[$i]' value='$net_bill' readonly></td>
                                          <td class='$class'><input type='text' style='text-align:right' class='input_e' name='txtReceivedAmount[$i]' value='$ReceivedAmount' readonly></td>
                                          <td class='$class'><input type='checkbox' name='chkAccept[$i]' value='ON' onclick=\"getAmount('$i')\"></td>
                                          <td class='$class'><input type='text' style='text-align:right' class='input_e' name='txtAmount[$i]' onchange='calculateTotalAmount()'></td>
                                    </tr>";
                              $i++;
                        }
                        echo "<tr>
                                    <td class='caption_e' colspan='5'>Total Amount</td>
                                    <td class='td_e'><input type='text' class='input_e' style='text-align:right' name='txtTotalAmount'></td>
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
            <table width='90%' id='table1' cellspacing='0' cellpadding='0' align='center'>
                  <tr>
                        <td class='top_left_curb'></td>
                        <td colspan='4' class='header_cell_e' align='center'>Voucher Detail</td>
                        <td class='top_right_curb'></td>
                  </tr>
                  <tr>
                        <td class='lb' rowspan='6'></td>
                        <td class='caption_e'>Receive Type</td>
                        <td class='td_e'>
                              Cash<input type='radio' name='rdoReceiveType' value='C' onclick='checkReceiveType(this.value)'>
                              Cheque<input type='radio' name='rdoReceiveType' value='Q' onclick='checkReceiveType(this.value)' checked>
                        </td>
                        <td class='caption_e'>Money Receipt No</td>
                        <td class='td_e'><input type='text' class='input_e' name='txtMoneyReceiptNo'></td>
                        <td class='rb' rowspan='6'></td>
                  </tr>
                  <tr>
                        <td class='caption_e'>Voucher No</td>
                        <td class='td_e'><input type='text' class='input_e' name='txtVoucherNo' value='<?PHP echo "$DR"; ?>' readonly></td>
                        <td class='caption_e'>Voucher Date</td>
                        <td class='td_e'>
                              <select name='cboVoucherDay' class='select_e'>
                                    <?PHP
                                          $D=date('d');
                                          comboDay($D);
                                    ?>
                              </select>
                              <select name='cboVoucherMonth' class='select_e'>
                                    <?PHP
                                          $M=date('m');
                                          comboMonth($M);
                                    ?>
                              </select>
                              <select name='cboVoucherYear' class='select_e'>
                                    <?PHP
                                          $Y=date('Y');
                                          $PY=$Y-10;
                                          $NY=$Y+10;
                                          comboYear($PY,$NY,$Y);
                                    ?>
                              </select>
                        </td>
                  </tr>
                  <tr>
                        <td class='caption_e'>Bank</td>
                        <td class='td_e'>
                              <select name='cboBank' class='select_e' onchange='sendBank(this.value)'>
                              <?PHP
                                    createCombo("Bank","mas_bank","bank_id","bank_name","order by bank_name","");
                              ?>
                              </select>
                        </td>
                        <td class='caption_e'>Bank Account</td>
                        <td class='td_e'>
                              <span id="BankAccountX">
                                    <select name='cboBankAccount' class='select_e'>
                                           <option value='-1'>Select a Bank Account</option>
                                    </select>
                              </span>
                        </td>
                  </tr>
                  <tr>
                        <td class='caption_e'>Cheque No</td>
                        <td class='td_e'><input type='text' class='input_e' name='txtChequeNo'></td>
                        <td class='caption_e'>Cheque Date</td>
                        <td class='td_e'>
                           <select name='cboChequeDay' class='select_e'>
                                    <?PHP
                                          $D=date('d');
                                          comboDay($D);
                                    ?>
                              </select>
                              <select name='cboChequeMonth' class='select_e'>
                                    <?PHP
                                          $M=date('m');
                                          comboMonth($M);
                                    ?>
                              </select>
                              <select name='cboChequeYear' class='select_e'>
                                    <?PHP
                                          $Y=date('Y');
                                          $PY=$Y-10;
                                          $NY=$Y+10;
                                          comboYear($PY,$NY,$Y);
                                    ?>
                              </select>
                        </td>
                  </tr>
                  <tr>
                        <td class='caption_e'>Remarks</td>
                        <td class='td_e' colspan='3'><textarea name='txaRemarks' class='input_e' cols='80'></textarea></td>
                  </tr>
                  <tr>
                        <td class='button_cell_e' colspan='4' align='center'><input type='button' class='forms_button_e' name='Submit' value='Submit' onclick='sendValue()'></td>
                  </tr>
                  <tr>
                        <td class='bottom_l_curb'></td>
                        <td class='bottom_f_cell' colspan='4'></td>
                        <td class='bottom_r_curb'></td>
                  </tr>
            </table>
            </form>
      </body>
</html>
