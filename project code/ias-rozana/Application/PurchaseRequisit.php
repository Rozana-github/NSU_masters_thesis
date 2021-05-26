<?PHP
session_start();

        include_once("Library/dbconnect.php");
        include_once("Library/Library.php");



?>

<html xmlns:ycode>

        <STYLE>
                yCode\:combobox {behavior: url(combobox.htc); }
        </STYLE>

<head>
<link rel='stylesheet' type='text/css' href='Style/eng_form.css'>
<link rel='stylesheet' type='text/css' href='Style/generic_form.css'>

<script language="JavaScript" src="Script/NumberFormat.js"></script>

<script language="JavaScript" src="Script/calendar1.js"></script>

<!-- <script language="javascript1.2"  type=text/javascript  src="libraries/gen_validatorv2.js">
        </script>
-->
<title>Voucher Entry Form</title>

<script language='JavaScript'>

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

        xmlHttp.setRequestHeader("Method", "POST " + url + " HTTP/1.1");
        xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xmlHttp.onreadystatechange = updatePage;
        xmlHttp.send(URLQuery);
}

function updatePage()
{
        if (xmlHttp.readyState == 4)
        {
                var response = xmlHttp.responseText;
                window.Gridsubitme.innerHTML="";
                window.Gridsubitme.innerHTML=response;
        }
}

function setubitem(val)
{
        var FunctionName="createCombo";
        var ComboName="cbosubitem";
        var SelectA="Subitem";
        var TableName="mas_item";
        var ID="itemcode";
        var Name="itemdescription";
        var Condition=escape("where parent_itemcode='"+val+"' order by itemdescription");
        var selectedValue="";
        var OnChangeEvent="";

        var URLQuery="FunctionName="+FunctionName+"&ComboName="+ComboName+"&SelectA="+SelectA+"&TableName="+TableName+"&ID="+ID+"&Name="+Name+"&Condition="+Condition+"&selectedValue="+selectedValue+"&OnChangeEvent="+OnChangeEvent+"";
        callServer(URLQuery);
}


var index=0;
var DataRow= new Array();

function DrawTable()
{
      var mainitem=frmVoucherEntry.cboitem.value;
      i=parseInt(frmVoucherEntry.cboitem.selectedIndex);
      var Itemname=frmVoucherEntry.cboitem.options[i].text;
       
      var subitem=frmVoucherEntry.cbosubitem.value;
      i=parseInt(frmVoucherEntry.cbosubitem.selectedIndex);
      var sumItemname=frmVoucherEntry.cbosubitem.options[i].text;

      var fullname=Itemname+"-"+sumItemname;
        
      var Spacification=frmVoucherEntry.txtspacification.value;
      var Quantity=frmVoucherEntry.txtRQuantity.value;

      var unitid=frmVoucherEntry.cbounit.value;
      i=parseInt(frmVoucherEntry.cbounit.selectedIndex);
      var unit=frmVoucherEntry.cbounit.options[i].text;

      var requireddate=frmVoucherEntry.txtrReqDate.value;
      var remarks = frmVoucherEntry.txtRemarks.value;


                if(frmVoucherEntry.addBtn.value=='Update')
                {

                        var UpdateIndex=frmVoucherEntry.HidUpdateIndex.value;
                        
                        frmVoucherEntry.elements("txtitemdescription["+UpdateIndex+"]").value=fullname;
                        frmVoucherEntry.elements("txtmainitem["+UpdateIndex+"]").value=frmVoucherEntry.cboitem.value;
                        frmVoucherEntry.elements("txtitem["+UpdateIndex+"]").value=frmVoucherEntry.cbosubitem.value;
                        frmVoucherEntry.elements("txtspacifications["+UpdateIndex+"]").value=frmVoucherEntry.txtspacification.value;
                        frmVoucherEntry.elements("txtquantities["+UpdateIndex+"]").value=frmVoucherEntry.txtRQuantity.value;
                        frmVoucherEntry.elements("txtunits["+UpdateIndex+"]").value=frmVoucherEntry.cbounit.value;
                        frmVoucherEntry.elements("txtunitname["+UpdateIndex+"]").value=unit;
                        frmVoucherEntry.elements("txtrequireddates["+UpdateIndex+"]").value=frmVoucherEntry.txtrReqDate.value;
                        frmVoucherEntry.elements("txtremark["+UpdateIndex+"]").value=frmVoucherEntry.txtRemarks.value;

                        frmVoucherEntry.addBtn.value='Add';

                }
                else
                {
                        DataRow[index]='';
                        DataRow[index]+="<table border='1' align='center' width='100%' bordercolor='black' cellpadding='0' cellspacing='0'>";
                        DataRow[index]+="<tr>";
                        DataRow[index]+="<td   width='20%' align='center' class='td_e' style='cursor:hand;' onclick='EditInformation("+index+")'><input type='text' name='txtitemdescription["+index+"]' value='"+fullname+"' style='border:0;cursor:hand;' readonly><input type='hidden' value='"+mainitem+"' name='txtmainitem["+index+"]'><input type='hidden' value='"+subitem+"' name='txtitem["+index+"]'></td>";
                        DataRow[index]+="<td   width='10%' align='center' class='td_e' style='cursor:hand;' onclick='EditInformation("+index+")'><input type='text' name='txtspacifications["+index+"]'  value='"+Spacification+"' size='5' style='border:0;cursor:hand;' readonly></td>";
                        DataRow[index]+="<td   width='10%' align='center' class='td_e' style='cursor:hand;' onclick='EditInformation("+index+")'><input type='text' name='txtquantities["+index+"]'  value='"+Quantity+"' size='5' style='border:0;cursor:hand;' readonly></td>";
                        DataRow[index]+="<td   width='10%' align='center' class='td_e' style='cursor:hand;' onclick='EditInformation("+index+")'><input type='text' name='txtunitname["+index+"]'  value='"+unit+"' style='border:0;cursor:hand;' readonly size='5'><input type='hidden' name='txtunits["+index+"]'  value='"+unitid+"' style='border:0;cursor:hand;' readonly></td>";
                        DataRow[index]+="<td   width='20%' align='center' class='td_e' style='cursor:hand;' onclick='EditInformation("+index+")'><input type='text' name='txtrequireddates["+index+"]' value='"+requireddate+"' size='10' style='border:0;cursor:hand;' readonly></td>";
                        DataRow[index]+="<td   width='20%' align='center' class='td_e' style='cursor:hand;' onclick='EditInformation("+index+")'><input type='text' name='txtremark["+index+"]' value='"+remarks+"' size='15' style='border:0;cursor:hand;' readonly></td>";
                        DataRow[index]+="<td   width='10%' class='forms_button_e' style='cursor:hand;'><input type='button'  class='forms_button_e' value='Delete' name='del["+index+"]' onClick='DeleteDataRow("+index+")'></td>";
                        DataRow[index]+="</tr></table>";


                        d.innerHTML=d.innerHTML+DataRow[index];

                        index++;

                }
                 frmVoucherEntry.TotalIndex.value=index;


}

function DeleteDataRow(ind)
{

        d.innerHTML='';

        DataRow[ind]='';

        for(var i=1;i<index;i++)
        {
                if(DataRow[i]!='' || DataRow[i]!=null)
                d.innerHTML =  d.innerHTML + DataRow[i];
        }

        e.innerHTML='';
        getResult();
}



function EnableDebit()
{

        var DebitAmount=frmVoucherEntry.txtDebit.value;
        var CreditAmount=frmVoucherEntry.txtCredit.value;

        if(DebitAmount!=0)
        {
                frmVoucherEntry.txtCredit.value=0;
                frmVoucherEntry.txtDebit.value=DebitAmount;
        }
}

function EnableCredit()
{
        var DebitAmount=frmVoucherEntry.txtDebit.value;
        var CreditAmount=frmVoucherEntry.txtCredit.value;
        // alert(CreditAmount);
        if(CreditAmount!=0)
        {
                frmVoucherEntry.txtCredit.value=CreditAmount;
                frmVoucherEntry.txtDebit.value=0;
        }
}

function DoConsisTancyBetDrCrAmount()
{

                frmVoucherEntry.submit();





}

function EditInformation(index)
{

    frmVoucherEntry.cboitem.value=frmVoucherEntry.elements("txtmainitem["+index+"]").value;
    frmVoucherEntry.cbosubitem.value=frmVoucherEntry.elements("txtitem["+index+"]").value;
    frmVoucherEntry.txtspacification.value=frmVoucherEntry.elements("txtspacifications["+index+"]").value;
    frmVoucherEntry.txtRQuantity.value=frmVoucherEntry.elements("txtquantities["+index+"]").value;
    frmVoucherEntry.cbounit.value=frmVoucherEntry.elements("txtunits["+index+"]").value;
    frmVoucherEntry.txtrReqDate.value=frmVoucherEntry.elements("txtrequireddates["+index+"]").value;
    frmVoucherEntry.txtRemarks.value=frmVoucherEntry.elements("txtremark["+index+"]").value;
    
    
    

    frmVoucherEntry.addBtn.value='Update';
    frmVoucherEntry.HidUpdateIndex.value=index;

}

/*
function DoUpdate()
{

}
*/

function ReturnDebitTotal()
{
        var debitTotal = 0;

        for(var i=1;i<index;i++)
        {
                if(document.frmVoucherEntry.elements("txtDebitAmount["+i+"]")!=null)
                debitTotal += parseFloat(document.frmVoucherEntry.elements("txtDebitAmount["+i+"]").value);
        }

        return debitTotal;
}

function ReturnCreditTotal()
{
        var creditTotal = 0;

        for(var i=1;i<index;i++)
        {
                if(document.frmVoucherEntry.elements("txtCreditAmount["+i+"]")!=null)
                creditTotal += parseFloat(document.frmVoucherEntry.elements("txtCreditAmount["+i+"]").value);
        }

        return creditTotal;
}

function getResult()
{
        var ResRow='';

        ResRow += "<table border='1' align='center' width='90%' bordercolor='black' cellpadding='0' cellspacing='0'>";
        ResRow +=     "<tr>";
        ResRow +=           "<td width='69%' colspan='4'><b>Total</b></td>";
        ResRow +=           "<td width='10%'  align='right'>"+ReturnDebitTotal()+"</td>";
        ResRow +=           "<td width='10%' align='right'>"+ReturnCreditTotal()+"</td>";
        ResRow +=           "<td width='10%'>&nbsp;</td>";
        ResRow +=     "</tr>";
        ResRow += "</table>";

        e.innerHTML = ResRow;
}

function AddandEvaluate()
{
        DrawTable();
        //getResult();
}

function getTotalAmount()
{
        var dr = ReturnDebitTotal();
        var cr = ReturnCreditTotal();
}



function DisabledCustomer()
{
        if(document.frmVoucherEntry.cmbSupplier.value==-1)
        {
                document.frmVoucherEntry.cmbCustomer.disabled=false;
        }
        else if(document.frmVoucherEntry.cmbSupplier.value!=-1)
        {
                document.frmVoucherEntry.cmbCustomer.disabled=true;
        }
}
function DisabledSupplier()
{
        if(document.frmVoucherEntry.cmbCustomer.value==-1)
        {
                document.frmVoucherEntry.cmbSupplier.disabled=false;
        }
        else if(document.frmVoucherEntry.cmbCustomer.value!=-1)
        {
                document.frmVoucherEntry.cmbSupplier.disabled=true;
        }
}

</script>

</head>

<body >

<?PHP

        if(!isset($txtVoucherDay))
                $txtVoucherDay=date("d");
        if(!isset($txtVoucherMonth))
                $txtVoucherMonth=date("m");
        if(!isset($txtVoucherYear))
                $txtVoucherYear=date("Y");

//--------------------- search max voucher no------------------------
                $party_sql="select
                               IFNULL(JV,0)+1 AS VNOrena
                            from
                                mas_latestjournalnumber
                          ";

                $rset =mysql_query($party_sql)  or die(mysql_error());
                while($row = mysql_fetch_array($rset))
                {
                        extract($row);
                }

?>

<form name='frmVoucherEntry' method='post' action='AddTo_PurchaseRequisit_Entry.php'>
<input type="hidden" name="HidUpdateIndex" value="">
<input type="hidden" name="TotalIndex" value="">

  <table border='0' width='100%'  align='center' cellpadding='3' cellspacing='0'>
        <tr>
                <td colspan='10' class='header_cell_e' width='100%' align='center'>
                        Requisit for Purchase
                </td>
        </tr>
        <tr>
                <td colspan='2' width='20%' class='td_e'>Requisition Date</td>
                <td colspan='3' width='30%' class='td_e'>
                <?PHP
                echo"
                        dd<input type='text' name='txtVoucherDay' value='$txtVoucherDay' size='2' maxlength='2' class='input_e'>
                        mm<input type='text' name='txtVoucherMonth' value='$txtVoucherMonth' size='2' maxlength='2' class='input_e'>
                        yyyy<input type='text' name='txtVoucherYear' value='$txtVoucherYear' size='4' maxlength='4' class='input_e'>
                ";
                ?>
                </td>
                <td width='20%' colspan='2' class='td_e'>Requisition No</td>
                <td width='30%' colspan='3' class='td_e'>
                        <?PHP
                                echo"<input type='text' name='txtrequisitionNo' value=''  class='input_e'>";
                        ?>
                        <input type='hidden' name='vtype' Value='JV'>
                </td>
        </tr>

</table>

<table border='1' align='center' width='100%' bordercolor='black' cellpadding='0' cellspacing='0' >
 <tr><td>
  <table border='0' align='center'  cellpadding='4' cellspacing='0' width='100%'>
        <tr>
                <td class='title_cell_e'>Main Item</td>
                <td class='title_cell_e'>Sub-Item</td>
                <td class='title_cell_e'>Specification</td>
                <td class='title_cell_e'>Quantity Required for Purchase</td>
                <td class='title_cell_e'>Unit</td>

                <td class='title_cell_e'class='td_e'>When Required</td>
                <td class='title_cell_e'>Remarks</td>
                <td class='title_cell_e'>&nbsp;</td>
        </tr>
        <tr>
            <td class='td_e'>

                  <select name='cboitem' class='select_e' onchange='setubitem(this.value)'>
                  <?PHP
                        $item_sql="SELECT
                                          itemcode as id ,
                                          itemdescription as description
                                    FROM
                                          mas_item
                                    WHERE
                                          level = '0'
                                    order by
                                          description
                                    ";
                        createQueryCombo("Item",$item_sql,'-1',$cboitem);
                  ?>
                  </select>
            </td>
            <td class='td_e'>
             <span id='Gridsubitme'>
                  <select name='cbosubitem' class='select_e'>
                        <option value='-1'>Select Subitem</option>
                  </select>
              </span>
            </td>


                <td valign='top' class='td_e' align='center'><input type='text' name='txtspacification' size='5'  class='input_e'></td>
                <td valign='top' class='td_e' align='center'><input type='text' name='txtRQuantity' size='10'  class='input_e'></td>
                <td class='td_e' align='center'>

                  <select name='cbounit' class='select_e'>
                        <?PHP
                               createCombo("Unit","mas_unit","unitid","unitdesc","","")
                        ?>
                  </select>

            </td>

                  <td valign='top' class='td_e' align='center'>
                        <input type='text' name='txtrReqDate' size='7'  class='input_e'>
                              <a href="javascript:ComplainDate1.popup();">
                                <img src="img/cal.gif" width="13" height="13" border="0" alt="Click Here to Pick up the date">
                              </a>
                  </td>
                  <td valign='top' class='td_e'><input type='text' name='txtRemarks' size='10'  class='input_e'></td>
                  <td valign='top' class='td_e'><input type='button' value='ADD' name='addBtn' onClick='AddandEvaluate()' class='forms_button_e'></td>
        </tr>
   </table>
 </td></tr>
</table>

<input type="hidden" name="txtHiddenIndex" value="">

<br>
<table border='0' align='center' width='100%' bordercolor='black' cellpadding='0' cellspacing='0'>
 <tr>
                <td  width='20%' class='title_cell_e'>Name of the Item</td>
                <td  width='10%' class='title_cell_e'>Spacification</td>
                <td  width='10%' class='title_cell_e'>Quantity Required for Purchase</td>
                <td  width='10%' class='title_cell_e'>Unit</td>
                <td  width='20%' class='title_cell_e'>When Required</td>
                <td  width='20%' class='title_cell_e'>Remarks/ If Alternative</td>
                <td  width='10%' class='title_cell_e'>&nbsp;</td>
  </tr>
</table>

<span id='d'>
</span>

<span id='e'>
</span>



<p align='center'>
 <input type='button' value='Save' name='saveBtn' onClick='DoConsisTancyBetDrCrAmount()' class='forms_button_e'>
</p>

<script language="JavaScript">

        // create calendar object(s) just after form tag closed
        // specify form element as the only parameter (document.forms['formname'].elements['inputname']);
        // note: you can have as many calendar objects as you need for your application

        var ComplainDate1 = new calendar1(document.forms['frmVoucherEntry'].elements['txtrReqDate']);
        ComplainDate1 .year_scroll = true;
        ComplainDate1 .time_comp = false;
</script>

</form>

</body>

</html>
