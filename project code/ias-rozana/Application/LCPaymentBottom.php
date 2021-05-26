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
<meta content="Author" name="Md.Sharif Ur Rahman">
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
        var DebitAmount=frmVoucherEntry.txtDebit.value;
        var DebitAmountLength=frmVoucherEntry.txtDebit.value.length;

        var remarks = frmVoucherEntry.txtRemarks.value;
        var ChartofAccountValue=cmbChartOfAccount.getText();

        var ResRow="";

        if(DebitAmount=="0")
        {
                alert('Value Required');
        }

        else if(DebitAmountLength==0)
        {
                alert('Value Required');
        }

        else
        {
                if(frmVoucherEntry.addBtn.value=='Update')
                {
                        var UpdateIndex=frmVoucherEntry.HidUpdateIndex.value;

                        frmVoucherEntry.elements["txtChartofAccount["+UpdateIndex+"]"].value=cmbChartOfAccount.getText();
                        frmVoucherEntry.elements["txtRemarks["+UpdateIndex+"]"].value=frmVoucherEntry.txtRemarks.value;
                        frmVoucherEntry.elements["txtDebitAmount["+UpdateIndex+"]"].value=frmVoucherEntry.txtDebit.value;
                        frmVoucherEntry.addBtn.value='Add';
                }
                else
                {
                        DataRow[index]='';
                        DataRow[index]+="<table border='1' align='center' width='90%' bordercolor='black' cellpadding='0' cellspacing='0'>";
                        DataRow[index]+="<tr>";
                        DataRow[index]+="<td width='30%' align='center' class='td_e'><input type='text' style='border:0;cursor:hand' name='txtChartofAccount["+index+"]'  value='"+ChartofAccountValue+"' readonly onclick='EditInformation("+index+");' class='input_e'></td>";
                        DataRow[index]+="<td width='30%' align='center' class='td_e'><input type='text' style='border:0;cursor:hand' name='txtRemarks["+index+"]'  value='"+remarks+"' readonly onclick='EditInformation("+index+");') class='input_e'></td>";
                        DataRow[index]+="<td width='25%' align='center' class='td_e'><input type='text' style='border:0;cursor:hand' name='txtDebitAmount["+index+"]'  value='"+DebitAmount+"' readonly onclick='EditInformation("+index+");' class='input_e' ></td>";
                        DataRow[index]+="<td width='15%' class='td_e'><input type='button' value='Delete' name='del["+index+"]' onClick='DeleteDataRow("+index+")' class='forms_button_e'></td>";
                        DataRow[index]+="</tr></table>";

                        window.d.innerHTML=window.d.innerHTML+DataRow[index];
                        index++;
                }

                frmVoucherEntry.TotalDabit.value=ReturnDebitTotal();
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

        frmVoucherEntry.TotalDabit.value=ReturnDebitTotal();
}

function DoConsisTancyBetDrCrAmount()
{
        var DebitAmount=0;
        if(frmVoucherEntry.journalno.value=="")
        {
                alert("Please provide voucher number.");
                frmVoucherEntry.journalno.focus();
                return false;
        }
        if(frmVoucherEntry.cmbParty.value=="-1")
        {
                alert("Please provide a party name.");
                frmVoucherEntry.cmbParty.focus();
                return false;
        }
        for(var i=1;i<index;i++)
        {
                if(frmVoucherEntry.elements("txtDebitAmount["+i+"]")!=null)
                        DebitAmount=parseFloat((document.frmVoucherEntry.elements("txtDebitAmount["+i+"]").value))+DebitAmount;
        }
        frmVoucherEntry.TotalIndex.value=index;

        if(DebitAmount==0)
        {
                alert('Total Debit should not be 0');
                        return false;
        }
        else if(index==1)
        {
                alert('At list one dabit amount should entered');
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
        frmVoucherEntry.txtDebit.value=frmVoucherEntry.elements("txtDebitAmount["+index+"]").value;
        frmVoucherEntry.addBtn.value='Update';
        frmVoucherEntry.HidUpdateIndex.value=index;
}

function ReturnDebitTotal()
{
        var debitTotal = 0;

        for(var i=1;i<index;i++)
        {
                if(document.frmVoucherEntry.elements["txtDebitAmount["+i+"]"]!=null)
                debitTotal += parseFloat(document.frmVoucherEntry.elements["txtDebitAmount["+i+"]"].value);
        }

        return debitTotal;
}

function AddandEvaluate()
{
        DrawTable();
}

function getTotalAmount()
{
        var dr = ReturnDebitTotal();
}

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

<script language='JavaScript'>
function getVoucherNo()
{
        var DayLen=document.frmVoucherEntry.txtVoucherDay.value.length;
        var MonthLen=document.frmVoucherEntry.txtVoucherMonth.value.length;
        var YearLen=document.frmVoucherEntry.txtVoucherYear.value.length;

        if(DayLen>2 || DayLen<1)
                return;
        if(MonthLen>2 || MonthLen<1)
                return;
        if(YearLen!=4)
                return;

        document.frmVoucherEntry.action="PV.php";
        document.frmVoucherEntry.submit();
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
                               IFNULL(CR,0)+1 AS VNOrena
                            from
                                mas_latestjournalnumber
                          ";

                $rset =mysql_query($party_sql)  or die(mysql_error());
                while($row = mysql_fetch_array($rset))
                {
                        extract($row);
                }
?>


<form name='frmVoucherEntry' method='post' action='AddTo_SaveMasJournalPyment.php'>

<input type="hidden" name="HidUpdateIndex" value="">
<input type="hidden" name="TotalIndex" value="">
<?PHP /*------------------------- Stracture and new logic Developed By: Sharif-Ur-Rahman ----------------------------*/?>
<table border='0' width='100%'  align='center' cellpadding='0' cellspacing='0'>
      <tr>
            <td class='top_left_curb'></td>
            <td align='center' colspan='6' class='header_cell_e'>
                        LC Payment Form
            </td>
            <td class='top_right_curb'></td>
      </tr>
      <tr>
            <td class='lb' rowspan='4'></td>
            <td class='caption_e'>
                  Voucher Date:
            </td>
            <td class='td_e'>
                <?PHP
                echo"
                        dd<input type='text' name='txtVoucherDay' value='$txtVoucherDay' size='2' maxlength='2' class='input_e'>
                        mm<input type='text' name='txtVoucherMonth' value='$txtVoucherMonth' size='2' maxlength='2' class='input_e'>
                        yyyy<input type='text' name='txtVoucherYear' value='$txtVoucherYear' size='4' maxlength='4'  class='input_e'>
                ";
                ?>
            </td>
            <td class='caption_e'>
                  Pay By:
            </td>
            <td class='td_e'>
                  Cash<input type='radio' name='rdopayto' value='C' class='input_e' onClick="DisableChequeInfo()">
                  Cheque<input type='radio' name='rdopayto' value='Q' class='input_e' class='input_e' checked onClick="EnableChequeInfo()">
            </td>
            <td class='caption_e'>
                  Voucher No:
            </td>
            <td class='td_e'>
                  <?PHP
                        echo"<input type='text' name='journalno' size='15' value='$VNOrena' readonly class='input_e'>";
                  ?>
                  <input type='hidden' name='txtJournalType' Value='Pay'>
            </td>
            <td class='rb' rowspan='4'></td>
      </tr>
      <tr>
            <td class='caption_e'>
                  Parties:
            </td>
            <td class='td_e'>
                  <select name='cmbParty' class='select_e'>
                        <?PHP
                                        $party_sql="select
                                                                supplier_id,
                                                                Company_Name
                                                        from
                                                                mas_supplier
                                                        order by
                                                                Company_Name
                                                ";
                                        createQueryCombo("Party",$party_sql,'-1',$partyid);

                                ?>
                        </select>
            </td>
            <td class='caption_e'>
                  LC No:
            </td>
            <td class='td_e'>
            <?PHP
                  echo "<input type='text' name='txtLcNo' size='21' value='$Rrpt_lcno' class='input_e' readonly>";
                  echo "<input type='hidden' name='txtLCObject_ID' value='$lcobjectid'>";
            ?>
            </td>
            <td class='caption_e' colspan='2'>
                 &nbsp;
            </td>
        </tr>
        <tr>
            <td class='caption_e'>
                  Bank:
            </td>
            <td class='td_e'>
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
            <td class='caption_e'>
                  Account No:
            </td>
            <td class='td_e'>
                  <span id='GridAccount'>
                        <select name='cboAccountNo' class='select_e'>
                              <option value='-1'>Select A Bank Account</option>
                        </select>
                  </span>
            </td>
            <td class='caption_e'>
                  Cheque No:
            </td>
            <td class='td_e'>
                  <input type='text' name='cqno' size='15' class='input_e'>
                  <input type='hidden' name='txtChequeDate' size='10' readonly class='input_e'>
            </td>
      </tr>
      <tr>
            <td class='caption_e'>
                  Remarks:
            </td>
            <td colspan='5' class='td_e'>
                  <textarea rows='2' name='mremarks' cols='110' class='input_e'></textarea>
            </td>
      </tr>
      <tr>
            <td class='bottom_l_curb'></td>
            <td class='bottom_f_cell' colspan='6'></td>
            <td class='bottom_r_curb'></td>
      </tr>
</table>

<table border='1' align='center' width='90%' bordercolor='black' cellpadding='0' cellspacing='0' >
        <tr>
                <td>
                        <table border='0' align='center'  cellpadding='4' cellspacing='0' width='100%'>
                                <tr>
                                        <td class='title_cell_e'>
                                                Chart of Account
                                        </td>
                                        <td class='title_cell_e'>
                                                Remarks
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
                                                <yCode:COMBOBOX ID="cmbChartOfAccount"  name="cmbChartOfAccount">
                                                <?PHP

                                                        $glChildQuery="select
                                                                                t1.*
                                                                        from
                                                                                mas_gl as t1
                                                                                left join mas_gl as t2
                                                                                on t1.id = t2.pid
                                                                        where
                                                                                t2.id is NULL
                                                                        order by
                                                                                description
                                                                        ";

                                                        $rset=mysql_query($glChildQuery) or die(mysql_error());
                                                        while($row = mysql_fetch_array($rset))
                                                        {
                                                                extract($row);

                                                                echo "<option value='$id'>$description</option>";
                                                        }
                                                ?>
                                                </yCode:COMBOBOX>
                                        </td>
                                        <td valign='top' class='td_e'>
                                                <input type='text' name='txtRemarks' size='20' class='input_e'>
                                        </td>
                                        <td valign='top' class='td_e'>
                                               <input type='text' name='txtDebit' size='8' class='input_e'>
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
                        Remarks
                </td>
                <td width='25%' class='title_cell_e'>
                        Debit
                </td>
                <td width='15%' class='title_cell_e'>&nbsp;</td>
        </tr>
</table>

<span id='d'>

</span>

<table border='1' align='center' width='80%' bordercolor='black' cellpadding='0' cellspacing='0'>
        <tr>
                <td width='60%' class='td_e' colspan='2' align='right'>
                        Total:
                </td>
                <td width='25%' class='td_e' align='right'>
                        <input type='text' name='TotalDabit' value='0' readonly class='input_e'>
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
