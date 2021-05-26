<?PHP
        include_once("Library/dbconnect.php");
        include_once("Library/Library.php");

?>
<html>

<head>
<meta http-equiv='Content-Language' content='en-us'>
<meta http-equiv='Content-Type' content='text/html; charset=windows-1252'>
<title>Supplier Entry Form</title>
<link rel='stylesheet' type='text/css' href='Style/eng_form.css'>
<link rel='stylesheet' type='text/css' href='Style/generic_form.css'>
<script language="JavaScript" src="Script/NumberFormat.js"></script>

<script language='javascript'>
      var xmlHttpSec = false;
try
{
        xmlHttpSec = new ActiveXObject("Msxml2.XMLHTTP");
}
catch (e)
{
        try
        {
                xmlHttpSec = new ActiveXObject("Microsoft.XMLHTTP");
        }
        catch (e2)
        {
                xmlHttpSec = false;
        }
}

if (!xmlHttpSec && typeof XMLHttpRequest != 'undefined')
{
        xmlHttpSec = new XMLHttpRequest();
}

function callServerSec(URLQuery)
{
        var url = "Library/AjaxLibrary.php";

        xmlHttpSec.open("POST", url, true);

        xmlHttpSec.setRequestHeader("Method", "POST " + url + " HTTP/1.1");
        xmlHttpSec.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xmlHttpSec.onreadystatechange = updatePageSec;
        xmlHttpSec.send(URLQuery);
}

function updatePageSec()
{
        if (xmlHttpSec.readyState == 4)
        {
                var response = xmlHttpSec.responseText;
                document.Form1.txtUnitPrice.value=response;
                //window.GridToAccount.innerHTML="";
                //window.GridToAccount.innerHTML=response;

        }
}

function callServerSec2(URLQuery)
{
        var url = "Library/AjaxLibrary.php";

        xmlHttpSec.open("POST", url, true);

        xmlHttpSec.setRequestHeader("Method", "POST " + url + " HTTP/1.1");
        xmlHttpSec.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xmlHttpSec.onreadystatechange = updatePageSec2;
        xmlHttpSec.send(URLQuery);
}

function updatePageSec2()
{
        if (xmlHttpSec.readyState == 4)
        {
                var response = xmlHttpSec.responseText;
                document.Form1.txtDescription.value=response;
                //window.GridToAccount.innerHTML="";
                //window.GridToAccount.innerHTML=response;

        }
}

function callServerSec3(URLQuery)
{
        var url = "Library/AjaxLibrary.php";

        xmlHttpSec.open("POST", url, true);

        xmlHttpSec.setRequestHeader("Method", "POST " + url + " HTTP/1.1");
        xmlHttpSec.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xmlHttpSec.onreadystatechange = updatePageSec3;
        xmlHttpSec.send(URLQuery);
}

function updatePageSec3()
{
        if (xmlHttpSec.readyState == 4)
        {
                var response = xmlHttpSec.responseText;
                document.Form1.txtQuantity.value=response;
                //window.GridToAccount.innerHTML="";
                //window.GridToAccount.innerHTML=response;

        }
}

function setunitrate(val)
{
        var val=document.Form1.txtJobNo.value;
        var FunctionName="pick";
        //var ComboName="cboToAccountNo";
        //var SelectA="Bank Account";
        var TableName="trn_order_description";
        //var ID="account_object_id";
        var Name="trn_order_description.order_rate";
        var Condition=escape("left join mas_order on mas_order.order_object_id=trn_order_description.order_object_id where mas_order.job_no='"+val+"' ");
        var selectedValue="";
        var OnChangeEvent="";

        var URLQuery="FunctionName="+FunctionName+"&TableName="+TableName+"&FieldName="+Name+"&Condition="+Condition+"";
        callServerSec(URLQuery);
        CalTotalPrice();
}
function setdescription()
{
        var val=document.Form1.txtJobNo.value;
        var FunctionName="pick";
        //var ComboName="cboToAccountNo";
        //var SelectA="Bank Account";
        var TableName="trn_order_description";
        //var ID="account_object_id";
        var Name="trn_order_description.order_description";
        var Condition=escape("left join mas_order on mas_order.order_object_id=trn_order_description.order_object_id where mas_order.job_no='"+val+"' ");
        var selectedValue="";
        var OnChangeEvent="";

        var URLQuery="FunctionName="+FunctionName+"&TableName="+TableName+"&FieldName="+Name+"&Condition="+Condition+"";
        callServerSec2(URLQuery);
}
function setquantity()
{
        var val=document.Form1.txtJobNo.value;
        var FunctionName="pick";
        //var ComboName="cboToAccountNo";
        //var SelectA="Bank Account";
        var TableName="trn_order_description";
        //var ID="account_object_id";
        var Name="trn_order_description.order_quntity";
        var Condition=escape("left join mas_order on mas_order.order_object_id=trn_order_description.order_object_id where mas_order.job_no='"+val+"' ");
        var selectedValue="";
        var OnChangeEvent="";

        var URLQuery="FunctionName="+FunctionName+"&TableName="+TableName+"&FieldName="+Name+"&Condition="+Condition+"";
        callServerSec3(URLQuery);
        CalTotalPrice();
}

/*function setvalues(val)
{
      setdescription(val);
      //setquantity(val);
      //setunitrate(val);

}*/
</script>


<script language="JavaScript">

function SearchCustomerPopUp(val)
{
        var popit=window.open("EditSearchCustomerPopUp.php?InvoiceObjectID="+val+" ",'console','status,scrollbars,width=620,height=500');
}


function SearchCustomer()
{
        document.Form1.txtCustomerID.value="";
        document.Form1.action="EditInvoiceDetail.php";
        document.Form1.submit();
}
function setcombo()
{
        document.Form1.cboCustomerID.value=-1;
        document.Form1.action="EditInvoiceDetail.php";
        document.Form1.submit();
}


function CalTotalPrice()
{
        var TotalQuantity=parseFloat(document.Form1.txtQuantity.value);

        //alert(TotalQuantity);
        var UnitPrice=parseFloat(document.Form1.txtUnitPrice.value);
        //alert(UnitPrice);

        var TotalPrice=parseFloat(TotalQuantity*UnitPrice);

        //alert(TotalPrice);
        var tp = new NumberFormat(TotalPrice);
        tp.setPlaces(2);
        tp.setSeparators(false);
        var TotalPrice = tp.toFormatted();

        document.Form1.txtTotalPrice.value=result=TotalPrice;
}

function CalculateVat()
{
        if(document.Form1.chkVat.checked==true)
        {
        var vatValue;
        document.Form1.txtVatRate.readOnly=false;
        vatValue=(parseFloat(document.Form1.txtSum.value)*parseFloat(document.Form1.txtVatRate.value))/100;

        //--- to format the vat value------------
        var VatV = new NumberFormat(vatValue);
        VatV.setPlaces(2);
        VatV.setSeparators(false);
        var VatValue =parseFloat(VatV.toFormatted());
        //------------- end----------------------

        document.Form1.txtVatValue.value=VatValue;

        var NetP=parseFloat(document.Form1.txtNet.value)+VatValue;

        //alert(NetP);

        var NP = new NumberFormat(NetP);
        NP.setPlaces(2);
        NP.setSeparators(false);
        var Netprice =NP.toFormatted();


        document.Form1.txtNet.value=Netprice;


        }
        else
        {
        var vatValue;
        /*vatValue=(parseFloat(document.Form1.txtSum.value)*parseFloat(document.Form1.txtVatRate.value))/100;
        document.Form1.txtVatRate.readOnly=true; */
        document.Form1.txtVatValue.value=0;

       /* var NetP=parseFloat(document.Form1.txtNet.value)-vatValue; */

        var NP = new NumberFormat(document.Form1.txtSum.value);
        NP.setPlaces(2);
        NP.setSeparators(false);
        var Netprice =parseFloat(NP.toFormatted());

        document.Form1.txtNet.value=Netprice;
        }


}

function CalculateNetalue()
{
        if(document.Form1.txtDiscount.value=="")
                document.Form1.txtDiscount.value=0;

        if(document.Form1.chkVat.checked==true)
        {
        var vatValue;
        vatValue=parseFloat(document.Form1.txtVatValue.value);
        document.Form1.txtNet.value=(parseFloat(document.Form1.txtSum.value)+vatValue)-parseFloat(document.Form1.txtDiscount.value);
        }
        else
        {
        document.Form1.txtNet.value=parseFloat(document.Form1.txtSum.value)-parseFloat(document.Form1.txtDiscount.value);
        }

}

 var TrnInvoiceID=new Array(100);
 var BDate=new Array(100);
 var ChallanNo=new Array(100);
 var JobNo=new Array(100);
 var Description=new Array(100);
 var UnitID=new Array(100);
 var UnitName=new Array(100);
 var Quantity=new Array(100);
 var UnitPrice=new Array(100);
 var TotalPrice=new Array(100);

 var vatPercentage=0;
 var vatValue=0;
 var discountAmount=0;

 var sum=0;

 var i=0;
 var delnum=0;
 

function copyRecords(selTrnInvoiceobjectID,SelBDate,SelChallanNo,SelJobNo,SelDescription,SelUnitID,SelUnitName,SelQuantity,SelUnitPrice,SelTotalPrice,Numrows,vatPercentage,vatValue,discountAmount)
{
        //alert(vatValue);
        for(var l=0;l<Numrows;l++)
        {
                 //alert("salim");
                TrnInvoiceID[l]=selTrnInvoiceobjectID[l];
                BDate[l]=SelBDate[l];
                ChallanNo[l]=SelChallanNo[l];
                JobNo[l]=SelJobNo[l];
                Description[l]=SelDescription[l];
                UnitID[l]=SelUnitID[l];
                UnitName[l]=SelUnitName[l];
                Quantity[l]=SelQuantity[l];
                UnitPrice[l]=SelUnitPrice[l];
                TotalPrice[l]=SelTotalPrice[l];
        }
     vatPercentage=vatPercentage;
     vatValue=vatValue;
     discountAmount=discountAmount;
     
     i=Numrows;
     drawList();

}



function AddGrid()
{
        if(document.Form1.txtChallanNo.value=="")
        {
                alert("Please Enter Challan No")
                document.Form1.txtChallanNo.focus();
                return;
        }

        if(document.Form1.txtJobNo.value=="")
        {
                alert("Please Job No")
                document.Form1.txtJobNo.focus();
                return;
        }
        if(document.Form1.txtDescription.value=="")
        {
                alert("Please Enter Description")
                document.Form1.txtDescription.focus();
                return;
        }
        if(document.Form1.cboUnit.value==-1)
        {
                alert("Please Select Unit")
                document.Form1.cboUnit.focus();
                return;
        }
        if(document.Form1.txtQuantity.value=="")
        {
                alert("Please Enter Quantity")
                document.Form1.txtQuantity.focus();
                return;
        }
        if(document.Form1.txtUnitPrice.value=="")
        {
                alert("Please Enter Unit Price")
                document.Form1.txtUnitPrice.focus();
                return;
        }


        TrnInvoiceID[i]="-1";
        BDate[i]=document.Form1.cboDay.value+"-"+document.Form1.cboMonth.value+"-"+document.Form1.cboYear.value;
        ChallanNo[i]=document.Form1.txtChallanNo.value;
        JobNo[i]=document.Form1.txtJobNo.value;
        Description[i]=document.Form1.txtDescription.value;
        UnitID[i]=document.Form1.cboUnit.value;
        UnitName[i]=document.Form1.cboUnit.options[document.Form1.cboUnit.selectedIndex].text
        Quantity[i]=document.Form1.txtQuantity.value;
        UnitPrice[i]=document.Form1.txtUnitPrice.value;
        TotalPrice[i]=document.Form1.txtTotalPrice.value;

 i++;
 drawList();
}

function deleteRow(deleteIndex)
{
        var k=0;


        if(TrnInvoiceID[deleteIndex]!='-1')
        {
                DeletedTrnInvoice.innerHTML=DeletedTrnInvoice.innerHTML+"<input type='hidden' name='DelTrnInvoiceID["+delnum+"]' value='"+TrnInvoiceID[deleteIndex]+"'>";
                delnum++;
                document.Form1.txtDelNumber.value=delnum;

        }
        for (k=deleteIndex;k<i-1;k++)
        {

                TrnInvoiceID[k]=TrnInvoiceID[k+1];
                BDate[k]=BDate[k+1];
                ChallanNo[k]=ChallanNo[k+1];
                JobNo[k]=JobNo[k+1];
                Description[k]=Description[k+1];
                UnitID[k]=UnitID[k+1];
                UnitName[k]=UnitName[k+1];
                Quantity[k]=Quantity[k+1];
                UnitPrice[k]=UnitPrice[k+1];
                TotalPrice[k]=TotalPrice[k+1];
        }
        i--;
        drawList();
}


// Replace special charecter
function replaceAll(strChk, strFind, strReplace)
{
  var strOut = strChk;
  while (strOut.indexOf(strFind) > -1)
  {
    strOut = strOut.replace(strFind, strReplace);
    //alert(strOut);
  }
  return strOut;
}



function drawList()
{
        sum=0;
        if(i<1)
        {
        show.innerHTML="";
        show.innerHTML=show.innerHTML+"Empty: No Item exist.";
        document.Form1.txtIndex.value=i;
        return;
        }
        var str='';
        str=str+"<table align='center' cellpadding='0' cellspacing='0' width='90%'>";
        str=str+"<tr>";
        str=str+"  <td  align='center' class='title_cell_e'><font size='2'><b>Delete</b></font></td>";
        str=str+"  <td  align='center' class='title_cell_e'><font size='2'><b>SN</b></font></td>";
        str=str+"  <td  align='center' class='title_cell_e'><font size='2'><b>Date</b></font></td>";
        str=str+"  <td  align='center' class='title_cell_e'><font size='2'><b>Challan No</b></font></td>";
        str=str+"  <td  align='center' class='title_cell_e'><font size='2'><b>JobNo</b></font></td>";
        str=str+"  <td  align='center' class='title_cell_e'><font size='2'><b>Description</b></font></td>";
        str=str+"  <td  align='center' class='title_cell_e'><font size='2'><b>Unit</b></font></td>";
        str=str+"  <td  align='center' class='title_cell_e'><font size='2'><b>Unit Price</b></font></td>";
        str=str+"  <td  align='center' class='title_cell_e'><font size='2'><b>Quantity</b></font></td>";
        str=str+"  <td  align='center' class='title_cell_e'><font size='2'><b>Total Price</b></font></td>";
        str=str+"</tr>";

        for(var j=0;j<i;j++)
        {
               //alert("salim");
                Description[j]=replaceAll(Description[j],"'","&#039;");
                str=str+"<tr>";
                str=str+"  <td  align='center' class='td_e'><input type='button' name='Delete["+j+"]' value='Delete' onClick='deleteRow("+j+")' style='width:70' class='forms_button_e'></td>";
                str=str+"  <td  align='center' class='td_e'><input class='input_e' type='text' name='SN["+j+"]' value='"+[j+1]+"' style='width:30' readOnly ></td>";
                str=str+"  <td  align='center' class='td_e'><input class='input_e' type='text' name='BDate["+j+"]' value='"+BDate[j]+"' style='width:100' readOnly></td>";
                str=str+"  <td  align='center' class='td_e'><input class='input_e' type='text' name='ChallanNo["+j+"]' value='"+ChallanNo[j]+"'  style='width:60' readOnly></td>";
                str=str+"  <td  align='center' class='td_e'><input class='input_e' type='text' name='JobNo["+j+"]' value='"+JobNo[j]+" ' style='width:60' readOnly></td>";
                str=str+"  <td  align='center' class='td_e'><input class='input_e' type='text' name='Description["+j+"]' value='"+Description[j]+"' style='width:160' readOnly></td>";
                str=str+"  <td  align='center' class='td_e'><input class='input_e' type='text' name='UnitName["+j+"]' value='"+UnitName[j]+"' style='width:100' readOnly></td>";
                str=str+"  <td  align='center' class='td_e'><input class='input_e' type='text' name='UnitPrice["+j+"]' value='"+UnitPrice[j]+"'  style='width:60;text-align: right' readOnly></td>";
                str=str+"  <td  align='center' class='td_e'><input class='input_e' type='text' name='Quantity["+j+"]' value='"+Quantity[j]+" ' style='width:60;text-align: right' readOnly></td>";
                str=str+"  <td  align='center' class='td_e'><input class='input_e' type='text' name='TotalPrice["+j+"]' value='"+TotalPrice[j]+"' style='width:60;text-align: right' readOnly></td>";
                str=str+"</tr>";

                str=str+" <input type='hidden' name='UnitID["+j+"]' value='"+UnitID[j]+"' style='width:100; height: 20'readOnly>";
                str=str+" <input type='hidden' name='TrnInvoiceID["+j+"]' value='"+TrnInvoiceID[j]+"' style='width:100; height: 20'readOnly>";
           }

                for(var j=0;j<i;j++)
                {

                       // alert(TotalPrice[j])
                        var Tempsum=parseFloat(TotalPrice[j]);
                        sum=parseFloat(sum)+Tempsum;
                        Tempsum=0;
                        //alert(sum)
                }
                var EVatValue=0;

                if(vatValue>0)
                {
                        //alert("salim");
                        var chkStstus="checked";

                        //---- calculate vat Value --------------
                        EVatValue=(parseFloat(sum)*parseFloat(vatPercentage))/100;

                        //--- to format the vat value------------
                        var EVatV = new NumberFormat(EVatValue);
                        EVatV.setPlaces(2);
                        EVatV.setSeparators(false);
                        EVatValue =parseFloat(EVatV.toFormatted());
                }
                else
                {
                        vatPercentage=15;
                        chkStstus="";
                }
                        
                //-----------calculate net value----------------
                var NetV=parseFloat(sum+EVatValue-discountAmount);
                //--- to format the vat value------------
                var ENetValue= new NumberFormat(NetV);
                ENetValue.setPlaces(2);
                ENetValue.setSeparators(false);
                var NetValue =parseFloat(ENetValue.toFormatted());


                str=str+"<tr>";
                str=str+"  <td  colspan='9' align='right' class='td_e'>Sub Total</td>";
                str=str+"  <td  align='left' class='td_e'><input class='input_e' type='text' name='txtSum' Style='text-align: right' value='"+sum+" ' style='width:60' readOnly></td>";
                str=str+"</tr>";
                str=str+"<tr>";
                str=str+"  <td  colspan='9' align='right' class='td_e'>Vat <input class='input_e' type='text' Style='text-align: right' name='txtVatRate' value='"+vatPercentage+"' style='width:30' readOnly onChange='CalculateVat()'>%<input class='input_e' type='checkbox' name='chkVat' onClick='CalculateVat()' "+chkStstus+" style='width:20'></td>";
                str=str+"  <td  align='left' class='td_e'><input class='input_e' type='text' name='txtVatValue' Style='text-align: right' value='"+EVatValue+"' style='width:60' readOnly ></td>";
                str=str+"</tr>";
                str=str+"<tr>";
                str=str+"  <td  colspan='9' align='right' class='td_e'>Discount</td>";
                str=str+"  <td  align='left' class='td_e'><input class='input_e' type='text' name='txtDiscount' Style='text-align: right' value='"+discountAmount+"' style='width:60' onChange='CalculateNetalue()'></td>";
                str=str+"</tr>";
                str=str+"<tr>";
                str=str+"  <td  colspan='9' align='right' class='td_e'>Net</td>";
                str=str+"  <td  align='left' class='td_e'><input class='input_e' type='text' name='txtNet' Style='text-align: right' value='"+NetValue+"' style='width:60' readOnly></td>";
                str=str+"</tr>";




                str=str+"</table>";
                str=str+"<input type='hidden' name='index' value=''+i+''>";
                show.innerHTML="";
                show.innerHTML=show.innerHTML+str;


                document.Form1.txtIndex.value=i;
}

function CheckValue()
{
        document.Form1.submit();

}


</script>


</head>

<body class='body_g'>
<form name='Form1' method='post' action='AddToUpdateInvoiceEntry.php'>


<?PHP
        //----------------- search existing invoice information----------
        $searchInvoiceInfo="select
                                        mas_invoice.*,
                                        trn_invoice.*,
                                        mas_customer.*
                                from
                                        mas_invoice inner join trn_invoice
                                        on mas_invoice.invoiceobjet_id=trn_invoice.invoiceobject_id
                                        inner join mas_customer
                                        on mas_invoice.customer_id=mas_customer.customer_id
                                where
                                        mas_invoice.invoiceobjet_id='".$txtInvoiceObjectID."'
                        ";
        $resultinvoiceInfo=mysql_query($searchInvoiceInfo) or die(mysql_error());
        //echo $searchInvoiceInfo;
        while($rowInvoiceInfo=mysql_fetch_array($resultinvoiceInfo))
        {
                extract($rowInvoiceInfo);
        }
        echo"<input type='hidden' name='txtInvoiceObjectID' value='$txtInvoiceObjectID'>";

?>

<?PHP
        if(isset($SelectedtxtCustomerID)|| (isset($cboCustomerID) && $cboCustomerID>0))
        {
                if(isset($cboCustomerID) && $cboCustomerID>0)
                        $SelectedtxtCustomerID=$cboCustomerID;
                if($txtCustomerID!='')
                        $SelectedtxtSupplierID=$txtCustomerID;

                //---------- search customer address-----------------
                $searchCustomerAddress="select
                                                *
                                        from
                                                mas_customer
                                        where
                                                customerobject_id='".$SelectedtxtCustomerID."'

                                        ";
                //echo $searchCustomerAddress."<br>";
                $ResultCustomerAddress=mysql_query($searchCustomerAddress)  or die(mysql_error());
                while($rowCustomerAddress=mysql_fetch_array($ResultCustomerAddress))
                {
                        extract($rowCustomerAddress);
                }

                $txtCustomerID=$customer_id;
                $cboCustomerID=$customerobject_id;

                //echo $cboCustomerID;

                //unset($SelectedtxtCustomerID);
        }
        else if(isset($txtCustomerID) && $txtCustomerID!="")
        {
                //---------- search customer address-----------------
                $searchCustomerAddress="select
                                                *
                                        from
                                                mas_customer
                                        where
                                                customer_id='".$txtCustomerID."'

                                        ";
                $ResultCustomerAddress=mysql_query($searchCustomerAddress)  or die(mysql_error());
                while($rowCustomerAddress=mysql_fetch_array($ResultCustomerAddress))
                {
                        extract($rowCustomerAddress);
                }

                $txtCustomerID=$customer_id;
                $cboCustomerID=$customerobject_id;
        }
        else
        {
                $txtCustomerID=$customer_id;
                $cboCustomerID=$customerobject_id;
        }
?>


<?PHP
echo"

<table border='0' width='100%' id='table1' cellspacing='0' class='td_e'>
        <tr>
                <td width='100%' align='center' colspan='4' class='header_cell_e'>Update Invoice</td>

        </tr>
        <tr>
                <td width='100%' align='center' colspan='4' class='title_cell_e'>Select/Enter Customer</td>
        </tr>
        <tr>
                <td width='25%' align='center' class='td_e'>
                        <input type='text' name='txtCustomerID' value='$txtCustomerID' class='input_e' onblur='setcombo()'>
                </td>
                <td width='25%' align='center' class='td_e'>
                        <select name='cboCustomerID' class='select_e' onChange=\"SearchCustomer()\">";

                                //--------search Customer------------
                                $searchCustomer="select
                                                        customerobject_id,
                                                        concat(Company_Name,'[ ',customer_id,' ]') as CustomerName
                                                from
                                                        mas_customer
                                                order by
                                                        CustomerName
                                                ";
                               createQueryCombo("Customer",$searchCustomer,"-1",$cboCustomerID);
                   echo"</select>
                </td>
                <td width='25%' align='center' class='td_e'>
                        <input type='button' value='Search Customer' name='btnSearch' onClick=\"SearchCustomerPopUp('$txtInvoiceObjectID')\" class='forms_button_e' style='width:150px'>
                </td>
                <td width='25%' align='center' class='td_e'>
                        <input type='button' value='Enter' name='btnEnter' class='forms_button_e' style='width:70px' onClick=\"SearchCustomer()\">
                </td>
        </tr>
</table>
<br>
<table border='0' width='100%' id='table2' cellspacing='0' class='td_e'>
        <tr>
                <td align='right' width='10%' valign='top' class='caption_e'>Address:</td>
                <td align='left' width='90%' class='td_e'>
                        <textarea rows='6' name='txtAddress' cols='36' class='input_e'>$office_address </textarea>
                </td>
        </tr>
</table>
";

?>
<br>
<?PHP
        //------------explode invoice date----------
        $InvoiceD=explode("-",$invoice_date);

        //------------explode order data------------
        $orderD=explode("-",$order_date);
        
echo"
<table border='0' width='100%' id='table3' cellspacing='0' class='td_e'>
        <tr>
                <td width='25%' align='right' class='caption_e'>Invoice No:</td>
                <td width='25%' align='left' class='td_e'>
                        <input type='text' name='txtInvoiceNumber' value='$invoice_number' class='input_e'>
                </td>
                <td width='25%' align='right' class='caption_e'>Invoice Date:</td>
                <td width='25%' align='left' class='td_e'>
                        <select name='cboInvoiceDay' class='select_e'>";
                                comboDay($InvoiceD[2]);
                        echo"</select>
                        <select name='cboInvoiceMonth' class='select_e'>";
                                comboMonth($InvoiceD[1]);
                        echo"</select>
                        <select name='cboInvoiceYear' class='select_e'>";
                                $Y=date('Y');
                                $PY=$Y-10;
                                $NY=$Y+10;
                                comboYear($PY,$NY,$InvoiceD[0]);
                        echo"</select>
                </td>
        </tr>
        <tr>
                <td width='25%' align='right' class='caption_e'>Order No:</td>
                <td width='25%' align='left' class='td_e'>
                        <input type='text' name='txtOrderNo' value='$order_number' class='input_e'>
                </td>
                <td width='25%' align='right' class='caption_e'>Order Date:</td>
                <td width='25%' align='left' class='td_e'>
                        <select name='cboOrderDay' class='select_e'>";
                                comboDay($orderD[2]);
                        echo"</select>
                        <select name='cboOrderMonth' class='select_e'>";
                                comboMonth($orderD[1]);
                        echo"</select>
                        <select name='cboOrderYear' class='select_e'>";
                                $Y=date('Y');
                                $PY=$Y-10;
                                $NY=$Y+10;
                                comboYear($PY,$NY,$orderD[0]);
                        echo"</select>
                </td>
        </tr>
        <tr>
                <td width='25%' align='right' class='caption_e'>Payment Type:</td>
                <td width='75%' align='left' colspan='3' class='td_e'>
                        <input type='text' name='txtPaymentType' value='$payment_terms' class='input_e'>
                </td>
        </tr>
</table>
<br>
<table border='0' width='100%' cellspacing='0' id='table4' class='td_e'>
        <tr>
                <td  align='center' class='title_cell_e'>Date</td>
                <td  align='center' class='title_cell_e'>Challan No</td>
                <td  align='center' class='title_cell_e'>Job No</td>
                <td  align='center' class='title_cell_e'>Description</td>
                <td  align='center' class='title_cell_e'>Unit</td>
                <td  align='center' class='title_cell_e'>Quantity</td>
                <td  align='center' class='title_cell_e'>Unit Price</td>
                <td  align='center' class='title_cell_e'>Total Price</td>
                <td  align='center' class='title_cell_e'>&nbsp;</td>
        </tr>
        <tr>
                <td align='center' class='td_e'>
                        <select name='cboDay' class='select_e'>";
                                $D=date('d');
                                comboDay($D);
                        echo"</select>
                        <select name='cboMonth' class='select_e'>";
                                $M=date('m');
                                comboMonth($M);
                        echo"</select>
                        <select name='cboYear' class='select_e'>";
                                $Y=date('Y');
                                $PY=$Y-10;
                                $NY=$Y+10;
                                comboYear($PY,$NY,$Y);
                        echo"</select>

                </td>
                <td  class='td_e'>
                        <input type='text' name='txtChallanNo' size='9' class='input_e'>
                </td>
                <td  align='center' class='td_e' >
                        <input type='text' name='txtJobNo' size='9' class='input_e'>
                </td>
                <td  align='center' class='td_e'>
                        <input type='text' name='txtDescription' size='20' class='input_e' onfocus='setdescription()'>
                </td>
                <td  align='center' class='td_e'>
                        <select name='cboUnit' class='select_e'>";
                                //-------- search Unit----------
                                $searchUnit="select
                                                        unitid,
                                                        unitdesc
                                                from
                                                        mas_unit
                                                order by
                                                        unitdesc
                                        ";
                               createQueryCombo("Unit",$searchUnit,"-1",$cboUnit);
                        echo"</select>
                </td>
                <td  align='center' class='td_e'>
                        <input type='text' name='txtQuantity' value='0' Style='text-align: right' size='9' class='input_e' onfocus='setquantity()'>
                </td>
                <td  align='center' class='td_e'>
                        <input type='text' name='txtUnitPrice' value='0' Style='text-align: right' size='9' class='input_e' onfocus='setunitrate()'>
                </td>
                <td  align='center' class='td_e'>
                        <input type='text' name='txtTotalPrice' Style='text-align: right' value='0' size='9' class='input_e' readOnly onfocus='CalTotalPrice()'>
                </td>
                <td  align='center' class='td_e'>
                        <input type='button' value='Add' name='btnAdd' class='forms_button_e' onClick=\"AddGrid()\">
                </td>
        </tr>
</table>
<br>
<table border='0' cellpadding='0' cellspacing='0' width='100%'  bordercolor='#111111'>
        <tr>
                <td  align='center' class='button_cell_e'>
                        <input type='button' value='Submit' name='btnSubmit' onClick=\"CheckValue()\" class='forms_button_e' style='width:120px' >

                </td>
        </tr>
</table>";

?>
<br>

<table border='0' cellpadding='0' cellspacing='0'  bordercolor='#111111'>
        <tr>
                <td  align='left' class='td_e'>
                        <span ID='show'>
                                Empty: No List exist.
                        </span>
                </td>
        </tr>
</table>

<input type='hidden' name='txtIndex' value='0'>

<script language='JavaScript'>
       //alert("salim");
        var selTrnInvoiceobjectID=new Array(100);
        var SelBDate=new Array(100);
        var SelChallanNo=new Array(100);
        var SelJobNo=new Array(100);
        var SelDescription=new Array(100);
        var SelUnitID=new Array(100);
        var SelUnitName=new Array(100);
        var SelQuantity=new Array(100);
        var SelUnitPrice=new Array(100);
        var SelTotalPrice=new Array(100);

        var vatPercentage;
        var vatValue;
        var discountAmount;
        var Numrows=0;

<?PHP
        // select Nominee information
        $MasTrnInvoiceInfo="select
                                mas_invoice.vat_parcent,
                                ifnull(mas_invoice.vat,0) as vat,
                                mas_invoice.discount_amount,
                                trn_invoice.*,
                                mas_unit.unitdesc
                        from
                                mas_invoice inner join trn_invoice
                                on mas_invoice.invoiceobjet_id=trn_invoice.invoiceobject_id
                                inner join mas_unit
                                on trn_invoice.unit_type=mas_unit.unitid
                      where
                                mas_invoice.invoiceobjet_id='".$txtInvoiceObjectID."'
                     ";
         //echo $MasTrnInvoiceInfo;

        $resultMasTrnInvoiceInfo=mysql_query($MasTrnInvoiceInfo) or die(mysql_error());
        $j=0;
        while($rowMasTrnInvoiceInfo=mysql_fetch_array($resultMasTrnInvoiceInfo))
        {
                extract($rowMasTrnInvoiceInfo);

               //$challand=explode("-",$challan_date);
            //echo $RelationName."<br>";
            //echo $GurdianRelationName."<br>";

            echo   "selTrnInvoiceobjectID[$j]=\"$trninvoiceobject_id\";";
            echo   "SelBDate[$j]=\"$challan_date\";";
            echo   "SelChallanNo[$j]=\"$challan_no\";";
            echo   "SelJobNo[$j]=\"$job_no\";";
            echo   "SelDescription[$j]=\"$product_name\";";
            echo   "SelUnitID[$j]=\"$unit_type\";";
            echo   "SelUnitName[$j]=\"$unitdesc\";";
            echo   "SelQuantity[$j]=\"$total_quantity\";";
            echo   "SelUnitPrice[$j]=\"$unit_price\";";
            echo   "SelTotalPrice[$j]=\"$total_price\";";

        $j++;
        }
        echo"vatPercentage=\"$vat_parcent\";";
        echo"vatValue=\"$vat\";";
        echo"discountAmount=\"$discount_amount\";";
        
        
         echo "Numrows=$j;";
         echo "copyRecords(selTrnInvoiceobjectID,SelBDate,SelChallanNo,SelJobNo,SelDescription,SelUnitID,SelUnitName,SelQuantity,SelUnitPrice,SelTotalPrice,Numrows,vatPercentage,vatValue,discountAmount);";


?>


</script>

<span ID='DeletedTrnInvoice'>
</span>
<input type='hidden' name='txtDelNumber'>

</form>
</body>

</html>

