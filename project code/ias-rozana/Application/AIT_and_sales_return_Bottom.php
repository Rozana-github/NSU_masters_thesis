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
                        //var NetBill=document.MyForm.elements["txtNetBill["+IndexVal+"]"].value;
                        //var ReceivedAmount=document.MyForm.elements["txtReceivedAmount["+IndexVal+"]"].value;
                        //var Amount=parseFloat(NetBill)-parseFloat(ReceivedAmount);

                        if(document.MyForm.elements["chkAccept["+IndexVal+"]"].checked)
                        {

                              document.MyForm.elements["txtAITAmount["+IndexVal+"]"].disabled=false;
                              document.MyForm.elements["txtSalesAmount["+IndexVal+"]"].disabled=false;
                              //calculateTotalAmount();
                        }
                        else
                        {
                              document.MyForm.elements["txtAITAmount["+IndexVal+"]"].value="";
                              document.MyForm.elements["txtSalesAmount["+IndexVal+"]"].value="";
                              //calculateTotalAmount();
                        }
                  }
                  function calculateTotalAITAmount()
                  {
                        var Index=parseInt(document.MyForm.hidIndex.value);
                        var TotalAITAmount=0;
                        var TotalSalesAmount=0;

                        for (var i=0;i<Index;i++)
                        {
                              if(document.MyForm.elements["chkAccept["+i+"]"].checked)
                              {
                                    if(document.MyForm.elements["txtAITAmount["+i+"]"].value!='' )
                                        TotalAITAmount=TotalAITAmount+parseFloat(document.MyForm.elements["txtAITAmount["+i+"]"].value)
                                    else
                                    {
                                          document.MyForm.elements["txtAITAmount["+i+"]"].value='0';
                                           document.MyForm.elements["txtSalesAmount["+i+"]"].value='0';
                                           TotalAITAmount=TotalAITAmount+parseFloat(document.MyForm.elements["txtAITAmount["+i+"]"].value)
                                           //TotalSalesAmount=TotalSalesAmount+parseFloat(document.MyForm.elements["txtSalesAmount["+i+"]"].value);


                                   }
                                   //TotalAITAmount=TotalAITAmount+parseFloat(document.MyForm.elements["txtAITAmount["+i+"]"].value);
                              }
                        }
                        document.MyForm.txtTotalAITAmount.value=TotalAITAmount;

                        //document.MyForm.AdvanceCr.value=TotalAITAmount+TotalSalesAmount;
                        //document.MyForm.AdvanceDr.value=TotalAITAmount+TotalSalesAmount;

                        
                  }
                  function calculateTotalSalesAmount()
                  {
                        var Index=parseInt(document.MyForm.hidIndex.value);
                        var TotalAITAmount=0;
                        var TotalSalesAmount=0;

                        for (var i=0;i<Index;i++)
                        {
                              if(document.MyForm.elements["chkAccept["+i+"]"].checked)
                              {

                                    if(document.MyForm.elements["txtSalesAmount["+i+"]"].value!='')
                                          TotalSalesAmount=TotalSalesAmount+parseFloat(document.MyForm.elements["txtSalesAmount["+i+"]"].value);
                                    else
                                    {

                                          document.MyForm.elements["txtSalesAmount["+i+"]"].value='';
                                        //document.MyForm.elements["txtAITAmount["+i+"]"].value='';

                                   }
                                   //TotalSalesAmount=TotalSalesAmount+parseFloat(document.MyForm.elements["txtSalesAmount["+i+"]"].value);
                              }
                        }

                        document.MyForm.txtTotalSalesAmount.value=TotalSalesAmount;
                        //document.MyForm.AdvanceCr.value=TotalAITAmount+TotalSalesAmount;
                        //document.MyForm.AdvanceDr.value=TotalAITAmount+TotalSalesAmount;


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
            <form name="MyForm" method='POST' action='AIT_and_sales_Save.php'>
            <?PHP
                  $query="select
                              mas_invoice.invoiceobjet_id,
                              mas_invoice.invoice_number,
                              mas_invoice.invoice_date,
                              mas_invoice.net_bill,
                              ifnull(TEMP.receivedamt,0)+IFNULL(TEMP.aitAmount,0)+IFNULL(TEMP.salesamount,0)  AS aitAmount,

                              mas_invoice.customer_id
                        FROM
                              mas_invoice
                              LEFT JOIN
                              (
                                    select
                                          invoiceobjet_id,
                                          sum(collection_amount) as receivedamt,
                                          SUM(ait_amount) AS aitAmount,
                                          sum(sales_return_amount) as salesamount
                                    from
                                          mas_invoice_collection
                                    group by
                                          invoiceobjet_id
                              ) AS TEMP ON mas_invoice.invoiceobjet_id=TEMP.invoiceobjet_id
                        WHERE
                              (mas_invoice.receive_status='0' OR mas_invoice.receive_status='1') AND
                              mas_invoice.customer_id='$cboDebtor'";

                  $rs=mysql_query($query) or die("Error: ".mysql_error());

                  $RowCount=mysql_num_rows($rs);
                  if($RowCount>0)
                  {
                        echo "<input type='hidden' name='CustomerID' value='$cboDebtor'>";
                        echo "<table width='90%' id='table1' cellspacing='0' cellpadding='0' align='center'>
                                    <tr>
                                          <td class='top_left_curb'></td>
                                          <td colspan='7' class='header_cell_e' align='center'>Invoice List</td>
                                          <td class='top_right_curb'></td>
                                    </tr>
                                    <tr>
                                          <td class='lb' ></td>
                                          <td class='title_cell_e'>Invoice Number</td>
                                          <td class='title_cell_e'>Date</td>
                                          <td class='title_cell_e'>Net Bill</td>
                                          <td class='title_cell_e'>Rec.amount with ait </td>

                                          <td class='title_cell_e'>Accept</td>
                                          <td class='title_cell_e'>AIT Amount</td>
                                          <td class='title_cell_e'>Sales Return</td>
                                          <td class='rb' ></td>
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
                                          <td class='lb' ></td>
                                          <td class='$class'>
                                                $invoice_number
                                                <input type='hidden' name='txtInvoiceObjectID[$i]' value='$invoiceobjet_id'>
                                          </td>
                                          <td class='$class'>$invoice_date</td>
                                          <td class='$class'><input type='text' class='input_e' name='txtNetBill[$i]' value='$net_bill' readonly size='15' style='text-align:right'></td>
                                          <td class='$class'><input type='text' class='input_e' name='txtrecAITAmount[$i]' value='$aitAmount' readonly size='15' style='text-align:right'></td>

                                          <td class='$class'><input type='checkbox' name='chkAccept[$i]' value='ON' onclick=\"getAmount('$i')\"></td>
                                          <td class='$class'><input type='text' class='input_e' name='txtAITAmount[$i]' disabled onchange='calculateTotalAITAmount()' size='15' style='text-align:right'></td>
                                          <td class='$class'><input type='text' class='input_e' name='txtSalesAmount[$i]' disabled onchange='calculateTotalSalesAmount()' size='15' style='text-align:right'></td>
                                          <td class='rb' ></td>
                                    </tr>";
                              $i++;
                        }
                        echo "<tr>
                                    <td class='lb' ></td>
                                    <td class='caption_e' colspan='5'>Total Amount</td>
                                    <td class='td_e'><input type='text' class='input_e' name='txtTotalAITAmount' readonly></td>
                                    <td class='td_e'><input type='text' class='input_e' name='txtTotalSalesAmount' readonly></td>
                                    <td class='rb' ></td>
                              </tr>";
                        echo "<tr>
                                    <td class='bottom_l_curb'></td>
                                    <td class='bottom_f_cell' colspan='7'></td>
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

                        /*echo "<table width='90%' id='table2' cellspacing='0' cellpadding='0' align='center'>
                                    <tr>
                                          <td class='top_left_curb'></td>
                                          <td colspan='3' class='header_cell_e' align='center'>Journal Voucher Detail</td>
                                          <td class='top_right_curb'></td>
                                    </tr>
                                    <tr>
                                          <td class='lb' rowspan='$RowSpan'></td>
                                          <td class='title_cell_e'></td>
                                          <td class='title_cell_e' align='center'>Dr</td>
                                          <td class='title_cell_e' align='center'>Cr</td>
                                          <td class='rb' rowspan='$RowSpan'></td>
                                    </tr>";
                        /*echo "<tr>
                                          <td class='lb' ></td>
                                          <td class='caption_e'>Advance</td>
                                          <td class='td_e' align='center'><input type='text' class='input_e' name='AdvanceDr' value='' style=\"text-align : right;\" readonly></td>
                                          <td class='td_e'></td>
                                          <td class='rb' ></td>
                                    </tr>";

                              /*$querydebtorstype="select
                                                        customer_id,
                                                        type
                                                from
                                                        mas_customer
                                                where
                                                        customer_id='$cboDebtor'
                                                ";
                               //echo $querydebtorstype;
                               $rsdebtorstype=mysql_query($querydebtorstype)or die(mysql_error());
                               while($row=mysql_fetch_array($rsdebtorstype))
                               {
                                        extract($row);
                               }
                               if($type==1)
                               {
                                        $discriptiontype=pick("mas_gl","description","gl_code='10501'");
                                        echo "<input type='hidden' name='discriptiontype' value='10501'>";
                               }
                               else if($type==2)
                               {
                                        $discriptiontype=pick("mas_gl","description","gl_code='10615'");
                                        echo "<input type='hidden' name='discriptiontype' value='10615'>";
                               }
                              echo "<tr>
                                          <td class='lb' ></td>
                                          <td class='caption_e'>$discriptiontype</td>
                                          <td class='td_e'></td>
                                          <td class='td_e' align='center'><input type='text' class='input_e' name='AdvanceCr' value='' style=\"text-align : right;\" readonly></td>
                                          <td class='rb' ></td>

                                    </tr>"; */







                        echo "  <table width='90%' id='table2' cellspacing='0' cellpadding='0' align='center'>
                            <tr>

                                          <td class='button_cell_e' colspan='3' align='center'><input type='submit' class='forms_button_e' name='Submit' value='Submit'></td>

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
