<?PHP
session_start();

        include_once("Library/dbconnect.php");
        include_once("Library/Library.php");

$GetGlCode="select
                id,
                description
        from
                mas_gl
        order
                by description";

$RsGl=mysql_query($GetGlCode) or die(mysql_error());


?>

<html xmlns:ycode>

<style>
        yCode\:combobox {behavior: url(combobox.htc); }
</style>

<head>

<link rel='stylesheet' type='text/css' href='Style/eng_form.css'>
<link rel='stylesheet' type='text/css' href='Style/generic_form.css'>

<script language="JavaScript" src="Script/NumberFormat.js"></script>

<script language="JavaScript" src="Script/calendar1.js"></script>

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
                window.GridAccount.innerHTML="";
                window.GridAccount.innerHTML=response;
        }
}

function setAccount(val)
{
        var FunctionName="createCombo";
        var ComboName="cboAccountNo";
        var SelectA="Bank Account";
        var TableName="trn_bank";
        var ID="account_object_id";
        var Name="account_no";
        var Condition=escape("where bank_id='"+val+"' order by account_no");
        var selectedValue="";
        var OnChangeEvent="";

        var URLQuery="FunctionName="+FunctionName+"&ComboName="+ComboName+"&SelectA="+SelectA+"&TableName="+TableName+"&ID="+ID+"&Name="+Name+"&Condition="+Condition+"&selectedValue="+selectedValue+"&OnChangeEvent="+OnChangeEvent+"";
        callServer(URLQuery);
}

var index=1;
var DataRow= new Array();

function DrawTable()
{
        var CreditAmount=frmVoucherEntry.txtCredit.value;
        var CreditAmountLength=frmVoucherEntry.txtCredit.value.length;

        var remarks = frmVoucherEntry.txtRemarks.value;
        var ChartofAccountValue=cmbChartOfAccount.getText();
        var glcode=frmVoucherEntry.txtCOANO.value;

        var ResRow="";

        if(CreditAmount=="0")
        {
                alert('Value Required');
        }

        else if(CreditAmountLength==0)
        {
                alert('Value Required');
        }

        else
        {
                if(frmVoucherEntry.addBtn.value=='Update')
                {
                        var UpdateIndex=frmVoucherEntry.HidUpdateIndex.value;

                        frmVoucherEntry.elements["txtChartofAccount["+UpdateIndex+"]"].value=cmbChartOfAccount.getText();
                        frmVoucherEntry.elements("txtglcode["+UpdateIndex+"]").value=frmVoucherEntry.txtCOANO.value;
                        frmVoucherEntry.elements["txtRemarks["+UpdateIndex+"]"].value=frmVoucherEntry.txtRemarks.value;
                        frmVoucherEntry.elements["txtCreditAmount["+UpdateIndex+"]"].value=frmVoucherEntry.txtCredit.value;
                        frmVoucherEntry.addBtn.value='Add';
                }
                else
                {
                        DataRow[index]='';
                        DataRow[index]+="<table border='1' align='center' width='80%' bordercolor='black' cellpadding='0' cellspacing='0'>";
                        DataRow[index]+="<tr>";
                        DataRow[index]+="<td width='30%' align='center' class='td_e'><input type='text' style='border:0;cursor:hand' name='txtChartofAccount["+index+"]'  value='"+ChartofAccountValue+"' readonly onclick='EditInformation("+index+");' class='input_e'><input type='hidden' value='"+glcode+"' name='txtglcode["+index+"]'></td>";
                        DataRow[index]+="<td width='30%' align='center' class='td_e'><input type='text' style='border:0;cursor:hand' name='txtRemarks["+index+"]'  value='"+remarks+"' readonly onclick='EditInformation("+index+");') class='input_e'></td>";
                        DataRow[index]+="<td width='25%' align='center' class='td_e'><input type='text' style='border:0;cursor:hand;text-align:right' name='txtCreditAmount["+index+"]'  value='"+CreditAmount+"' readonly onclick='EditInformation("+index+");' class='input_e' size='10' ></td>";
                        DataRow[index]+="<td width='15%' class='td_e'><input type='button' value='Delete' name='del["+index+"]' onClick='DeleteDataRow("+index+")' class='forms_button_e'></td>";
                        DataRow[index]+="</tr></table>";

                        window.d.innerHTML=window.d.innerHTML+DataRow[index];
                        index++;
                }

                frmVoucherEntry.TotalCredit.value=ReturnCreditTotal();
        }
}


function DeleteDataRow(ind)
{
        window.d.innerHTML='';
        DataRow[ind]='';

        for(var i=1;i<index;i++)
        {
                if(DataRow[i]!='' || DataRow[i]!=null)
                window.d.innerHTML =  window.d.innerHTML + DataRow[i];
        }

        frmVoucherEntry.TotalCredit.value=ReturnCreditTotal();
}

function DoConsisTancyBetDrCrAmount()
{
        var CreditAmount=0;
        if(frmVoucherEntry.journalno.value=="")
        {
                alert("Please provide voucher number.");
                frmVoucherEntry.journalno.focus();
                return false;
        }
        if(frmVoucherEntry.cmbCustomer.value=="-1")
        {
                alert("Please provide a Customer name.");
                frmVoucherEntry.cmbCustomer.focus();
                return false;
        }
        for(var i=1;i<index;i++)
        {
                if(frmVoucherEntry.elements("txtCreditAmount["+i+"]")!=null)
                        CreditAmount=parseFloat((document.frmVoucherEntry.elements("txtCreditAmount["+i+"]").value))+CreditAmount;
        }
        frmVoucherEntry.TotalIndex.value=index;

        if(CreditAmount==0)
        {
                alert('Total Credit should not be 0');
                        return false;
        }
        else if(index==1)
        {
                alert('At list one Credit amount should entered');
                return false;
        }
        else
        {
                frmVoucherEntry.submit();
        }
}

function EditInformation(index)
{
        cmbChartOfAccount.setText(frmVoucherEntry.elements("txtChartofAccount["+index+"]").value);
        frmVoucherEntry.txtCredit.value=frmVoucherEntry.elements("txtCreditAmount["+index+"]").value;
        frmVoucherEntry.txtCOANO.value=frmVoucherEntry.elements("txtglcode["+index+"]").value;
         frmVoucherEntry.txtRemarks.value=frmVoucherEntry.elements("txtRemarks["+index+"]").value;
        frmVoucherEntry.addBtn.value='Update';
        frmVoucherEntry.HidUpdateIndex.value=index;
}

function ReturnCreditTotal()
{
        var creditTotal=0;

        for(var i=1;i<index;i++)
        {
                if(document.frmVoucherEntry.elements["txtCreditAmount["+i+"]"]!=null)
                creditTotal += parseFloat(document.frmVoucherEntry.elements["txtCreditAmount["+i+"]"].value);
        }

        return creditTotal;
}

function AddandEvaluate()
{
        DrawTable();
}

/*
function getTotalAmount()
{
        var cr = ReturnCreditTotal();
}
*/

function DisableChequeInfo()
{
        document.frmVoucherEntry.cboBank.disabled=true;
        document.frmVoucherEntry.cboAccountNo.disabled=true;
        document.frmVoucherEntry.cqno.disabled=true;
        document.frmVoucherEntry.txtChequeDate.disabled=true;
}

function EnableChequeInfo()
{
        document.frmVoucherEntry.cboBank.disabled=false;
        document.frmVoucherEntry.cboAccountNo.disabled=false;
        document.frmVoucherEntry.cqno.disabled=false;
        document.frmVoucherEntry.txtChequeDate.disabled=false;
}

</script>

</head>

<body class='body_g'>

<?PHP

        if(!isset($txtVoucherDay))
                $txtVoucherDay=date("d");
        if(!isset($txtVoucherMonth))
                $txtVoucherMonth=date("m");
        if(!isset($txtVoucherYear))
                $txtVoucherYear=date("Y");

//--------------------- search max voucher no------------------------
                $party_sql="select
                               IFNULL(DR,0)+1 AS VNOrena
                            from
                                mas_latestjournalnumber
                          ";

                $rset =mysql_query($party_sql)  or die(mysql_error());
                while($row = mysql_fetch_array($rset))
                {
                        extract($row);
                }
?>


<form name='frmVoucherEntry' method='post' action='AddToMasTrnJournalRV.php'>

<input type="hidden" name="HidUpdateIndex" value="">
<input type="hidden" name="TotalIndex" value="">

<table border='0' width='90%'  align='center' cellpadding='3' cellspacing='0'>
        <tr>
                <td align='center' colspan='10' width='100%' class='header_cell_e'>
                        Credit Voucher Entry Form
                </td>
        </tr>
        <tr>
                <td align='right' width='20%' class='td_e' colspan='2'>
                        Voucher Date:
                </td>
                <td align='left' width='40%' class='td_e' colspan='4'>
                <?PHP
                echo"
                        dd<input type='text' name='txtVoucherDay' value='$txtVoucherDay' size='2' maxlength='2' class='input_e'>
                        mm<input type='text' name='txtVoucherMonth' value='$txtVoucherMonth' size='2' maxlength='2' class='input_e'>
                        yyyy<input type='text' name='txtVoucherYear' value='$txtVoucherYear' size='4' maxlength='4' class='input_e'>
                ";
                ?>
                </td>
                <td align='right' width='20%' class='td_e' colspan='2'>
                        Voucher No:
                </td>
                <td align='left' width='20%' class='td_e' colspan='2'>
                        <?PHP
                                echo"<input type='text' name='journalno' value='$VNOrena' readonly class='input_e'>";
                        ?>
                        <input type='hidden' name='txtJournalType' Value='REC'>
                </td>
        </tr>
        <tr>
                <td align='right' widht='20%' class='td_e' colspan='2'>
                        Customer:
                </td>
                <td align='left' width='40%' class='td_e' colspan='4'>
                        <select name='cmbCustomer' class='select_e'>
                                <?PHP
                                        $Customer_sql="select
                                                                customer_id,
                                                                Company_Name
                                                        from
                                                                mas_customer
                                                        order by
                                                                Company_Name
                                                ";
                                        createQueryCombo("Customer",$Customer_sql,'-1',$cmbCustomer);

                                ?>
                        </select>
                </td>
                <td align='right' width='20%' class='td_e' colspan='2'>
                        Pay By:
                </td>
                <td align='left' width='20%' class='td_e' colspan='2'>
                        Cash<input type='radio' name='rdopayto' value='C' class='input_e' onClick="DisableChequeInfo()">
                        Cheque<input type='radio' name='rdopayto' value='Q' class='input_e' class='input_e' checked onClick="EnableChequeInfo()">
                </td>
        </tr>
        <tr>
                <td align='right' widht='20%' class='td_e' colspan='2'>
                        Bank:
                </td>
                <td  align='left' width='40%' class='td_e' colspan='4'>
                        <select name='cboBank' onchange='setAccount(this.value)' class='select_e'>
                        <?PHP
                                $SerachBank="select
                                                        bank_id,
                                                        bank_name
                                                from
                                                        mas_bank
                                                order by
                                                        bank_name
                                           ";
                                createQueryCombo("Bank",$SerachBank,"-1",$cboBank);
                        ?>
                        </select>
                </td>
                <td align='right' width='20%'  class='td_e' colspan='2'>
                        Account No:
                </td>
                <td align='left' width='20%' class='td_e' colspan='2'>
                        <span id='GridAccount'>
                                <select name='cboAccountNo' class='select_e'>
                                        <option value='-1'>Select A Bank Account</option>
                                </select>
                        </span>
                </td>
        </tr>
        <tr>
                <td align='right' width='20%' class='td_e' colspan='2'>
                        Cheque No:
                </td>
                <td align='left' width='40%' class='td_e' colspan='4'>
                        <input type='text' name='cqno' size='10' class='input_e'>
                </td>
                <td align='right' width='20%' class='td_e' colspan='2'>
                        Cheque Date:
                </td>
                <td align='left' width='20%' class='td_e' colspan='2'>
                        <input type='text' name='txtChequeDate' size='10' readonly class='input_e'>
                        &nbsp;<a href="javascript:ComplainDate1.popup();">
                                <img src="img/cal.gif" width="13" height="13" border="0" alt="Click Here to Pick up the date">
                                </a>
                </td>
        </tr>
        <tr>
                <td align='right' width='20%' class='td_e' colspan='2'>
                        Remarks:
                </td>
                <td align='left' width='80%' colspan='8' height='56' width='100%' class='td_e'>
                        <textarea rows='3' name='mremarks' cols='72'></textarea>
                </td>
        </tr>
</table>

<table border='1' align='center' width='90%' bordercolor='black' cellpadding='0' cellspacing='0' >
        <tr>
                <td>
                        <table border='0' align='center'  cellpadding='4' cellspacing='0' width='100%'>
                                <tr>
                                        <td class='title_cell_e'>
                                                Head of Account
                                        </td>
                                        <td class='title_cell_e'>
                                                Particulars
                                        </td>
                                        <td class='title_cell_e'>
                                                Amount
                                        </td>
                                        <td class='title_cell_e'>
                                                &nbsp;
                                        </td>
                                </tr>
                                <tr>
                                        <td class='td_e'>
                                                <table cellpadding=0 cellspacing=0>
                                                        <tr>
                                                                <td class='td_e'>

                                                                        <input type='text' name='txtCOANO' size='10' onchange='setCombo(this.value)' class='input_e'>
                                                                </td>
                                                                <td class='td_e'>
                                                                        <yCode:COMBOBOX ID="cmbChartOfAccount" name="cmbChartOfAccount" cb_onselectionchanged='getValue()'>
                                                                         <?PHP

                                                                                   $glChildQuery = "select t1.*
                                                                                                    from mas_gl as t1
                                                                                                    left join mas_gl t2
                                                                                                    on
                                                                                                    t1.id = t2.pid
                                                                                                    where t2.id is NULL
                                                                                                    order  by description
                                                                                                    ";

                            //$rset = $Dc->DoQuery($glChildQuery);
                                                                                $resultChildQuery=mysql_query($glChildQuery) or die(mysql_error());
                                                                                echo "<option value='-1'>Select A COA</option>";
                                                                                    while($row = mysql_fetch_array($resultChildQuery))
                                                                                      {
                                                                                        extract($row);

                                                                                                echo "<option value='$gl_code'>$description</option>";

                                                                                      }

                                                                           ?>
                                                                 </yCode:COMBOBOX>
                                                                 </td>

                                                         <tr>
                                                 </table>

                        <SCRIPT>
                              function setCombo(val)
                              {
                                    var flag=false;

                                    for(var i=1;i<cmbChartOfAccount.getOptionCount();i++)
                                    {
                                          if(cmbChartOfAccount.getOptionValue(i)==parseInt(val))
                                          {
                                                cmbChartOfAccount.setSelectedIndex(i);
                                                flag=true;
                                          }
                                    }
                                    if(!flag)
                                    {
                                          cmbChartOfAccount.setSelectedIndex(0);
                                          document.frmVoucherEntry.txtCOANO.value="";
                                          document.frmVoucherEntry.txtCOANO.focus();
                                    }
                              }
                              function getValue()
                              {
                                    var iNewSelection = event.selectedIndex;
                                    if (iNewSelection > - 1 )
                                    {
                                          document.frmVoucherEntry.txtCOANO.value=cmbChartOfAccount.getOptionValue(iNewSelection);
                                    }
                              }
                              function initMyDoc()
                              {
                                    cmbChartOfAccount.options_only=true;
                                    //cmbChartOfAccount.lookup_options=false;
                                    cmbChartOfAccount.tables=1;
                              }
                         </SCRIPT>
                                        </td>
                                        <td valign='top' class='td_e'>
                                                <input type='text' name='txtRemarks' size='20' class='input_e'>
                                        </td>
                                        <td valign='top' class='td_e'>
                                               <input type='text' name='txtCredit' size='10' class='input_e' style='text-align:right'>
                                        </td>
                                        <td valign='top' class='td_e'>
                                                <input type='button' value='ADD' name='addBtn' onClick='AddandEvaluate()' class='forms_button_e'>
                                        </td>
                                </tr>
                        </table>
                </td>
        </tr>
</table>

<input type="hidden" name="txtHiddenIndex" value="">

<br>

<table border='1' align='center' width='80%' bordercolor='black' cellpadding='0' cellspacing='0'>
        <tr>
                <td width='30%' class='title_cell_e'>
                        Chart of Account
                </td>
                <td width='30%' class='title_cell_e'>
                        Particulars
                </td>
                <td width='25%' class='title_cell_e'>
                        Credit
                </td>
                <td width='15%' class='title_cell_e'>
                        &nbsp;
                </td>
        </tr>
</table>

<span id='d'>

</span>

<table border='1' align='center' width='80%' bordercolor='black' cellpadding='0' cellspacing='0'>
        <tr>
                <td width='60%' class='td_e' colspan='2' align='right'>
                        Total:
                </td>
                <td width='25%' class='td_e' align='center'>
                        <input type='text' name='TotalCredit' value='0' readonly class='input_e' style='text-align:right'>
                </td>
                <td width='15%' class='td_e'>&nbsp;</td>
        </tr>
</table>

<p align='center'>
        <input type='button' value='Save' name='saveBtn' onClick='DoConsisTancyBetDrCrAmount()' class='forms_button_e'>
</p>

</form>

<script language="JavaScript">

        // create calendar object(s) just after form tag closed
        // specify form element as the only parameter (document.forms['formname'].elements['inputname']);
        // note: you can have as many calendar objects as you need for your application

        var ComplainDate1 = new calendar1(document.forms['frmVoucherEntry'].elements['txtChequeDate']);
        ComplainDate1 .year_scroll = true;
        ComplainDate1 .time_comp = false;
</script>

</body>

</html>
