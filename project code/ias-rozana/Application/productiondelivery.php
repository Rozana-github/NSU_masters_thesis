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

                              document.MyForm.elements["txtdeliverdqty["+IndexVal+"]"].disabled=false;
                              document.MyForm.elements["txtdeliverdqty["+IndexVal+"]"].value=document.MyForm.elements["txtproducedqty["+IndexVal+"]"].value;

                              //calculateTotalAmount();
                        }
                        else
                        {
                              document.MyForm.elements["txtdeliverdqty["+IndexVal+"]"].value="";
                              document.MyForm.elements["txtdeliverdqty["+IndexVal+"]"].disabled=true;

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
            <form name="MyForm" method='POST' action='productiondelivery_Save.php'>
            <?PHP
                 echo "<table width='90%' id='table1' cellspacing='0' cellpadding='0' align='center'>

                                    <tr>
                                          <td class='top_left_curb'></td>
                                          <td colspan='2' class='header_cell_e' align='center'>Order List for Delivery</td>
                                          <td class='top_right_curb'></td>
                                    </tr>

                                    <tr>
                                          <td class='lb' ></td>

                                          <td class='caption_e'>Delivered Date</td>
                                          <td class='td_e'>";
                                          echo "<select name='cbodeliveryDay' class='select_e'>";
                                                      $D=date('d');
                                                      comboDay($D);
                                          echo "</select>";
                                          echo "<select name='cbodeliveryMonth' class='select_e'>";
                                                      $M=date('m');
                                                      comboMonth($M);
                                          echo "</select>";
                                          echo "<select name='cbodeliveryYear' class='select_e'>";
                                                      $Y=date('Y');
                                                      $PY=$Y-10;
                                                      $NY=$Y+10;
                                                      comboYear($PY,$NY,$Y);
                                          echo "</select>";
                                          echo "</td>
                                          <td class='rb' ></td>
                                    </tr>
                                    </table>";
                  $query="SELECT
                                mas_order_planed.plan_object_id ,
                                mas_order_planed.order_object_id ,
                                date_format(mas_order_planed.planed_date,'%d-%m-%Y') as planed_date,
                                mas_order.job_no,
                                mas_customer.company_name,
                                trn_order_description.order_quntity,
                                (productionqty-ifnull(temp.delivered_qty,0)) as productionqty
                        FROM
                                mas_order_planed
                                INNER JOIN mas_order_production ON mas_order_production.plan_object_id = mas_order_planed.plan_object_id
                                INNER JOIN mas_order ON mas_order.order_object_id = mas_order_planed.order_object_id
                                LEFT JOIN mas_customer ON mas_customer.customer_id = mas_order.customer_id
                                LEFT JOIN trn_order_description ON trn_order_description.order_object_id = mas_order.order_object_id
                                left join (select plan_object_id,delivered_qty from mas_order_delivery order by plan_object_id) as temp on temp.plan_object_id=mas_order_production.plan_object_id
                        WHERE
                                mas_order_production.status in (0,1) ";

                  $rs=mysql_query($query) or die("Error: ".mysql_error());

                  $RowCount=mysql_num_rows($rs);
                  if($RowCount>0)
                  {

                        echo "<table width='90%' id='table1' cellspacing='0' cellpadding='0' align='center'>

                                    <tr>
                                          <td class='lb' ></td>
                                          <td class='title_cell_e'>Sl.No</td>
                                          <td class='title_cell_e'>Nob No</td>
                                          <td class='title_cell_e'>Company Name</td>
                                          <td class='title_cell_e'>Order Qty</td>
                                          <td class='title_cell_e'>Production Date </td>

                                          <td class='title_cell_e'>Production Qty</td>
                                          <td class='title_cell_e'>&nbsp;</td>
                                          <td class='title_cell_e'>Delivered Qty.</td>
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
                                          <td class='$class'>".($i+1)."</td>
                                          <td class='$class'>
                                                $job_no
                                                <input type='hidden' name='txtorderobjectid[$i]' value='$order_object_id'>
                                                <input type='hidden' name='txtplanobjectid[$i]' value='$plan_object_id'>
                                          </td>
                                          <td class='$class'>$company_name</td>
                                          <td class='$class'>$order_quntity</td>
                                          <td class='$class'>$planed_date</td>
                                          <td class='$class'><input type='text' class='input_e' name='txtproducedqty[$i]' value='$productionqty' size='15' style='text-align:right'></td>
                                          <td class='$class'><input type='checkbox' name='chkAccept[$i]' value='ON' onclick=\"getAmount('$i')\"></td>
                                          <td class='$class'><input type='text' class='input_e' name='txtdeliverdqty[$i]' disabled size='15' style='text-align:right'></td>
                                          <td class='rb' ></td>
                                    </tr>";
                              $i++;
                        }
                        /*echo "<tr>
                                    <td class='lb' ></td>
                                    <td class='caption_e' colspan='5'>Total Amount</td>
                                    <td class='td_e'><input type='text' class='input_e' name='txttotalproduced' readonly></td>
                                     <td class='td_e' >&nbsp;</td>
                                    <td class='td_e'><input type='text' class='input_e' name='txttotaldelivered' readonly></td>
                                    <td class='rb' ></td>
                              </tr>"; */
                        echo "<tr>
                                           <td class='lb' ></td>
                                          <td class='button_cell_e' colspan='8' align='center'><input type='submit' class='forms_button_e' name='Submit' value='Submit'></td>
                                         <td class='rb' ></td>
                                    </tr>
                                    <tr>
                                    <td class='bottom_l_curb'></td>
                                    <td class='bottom_f_cell' colspan='8'></td>
                                    <td class='bottom_r_curb'></td>
                              </tr>";
                        echo "
                                </table>";
                        echo "<input type='hidden' name='hidIndex' value='$i'>";
                  }
                  else
                  {
                        drawNormalMassage("No Information Available.");
                        die();
                  }






                        echo "  <table width='90%' id='table2' cellspacing='0' cellpadding='0' align='center'>

                              </table>";


            ?>
            </form>
      </body>
</html>
