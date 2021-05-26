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
                window.GridToAccount.innerHTML="";
                window.GridToAccount.innerHTML=response;
        }
}

function setAccountSec(val)
{
        var FunctionName="createCombo";
        var ComboName="cboToAccountNo";
        var SelectA="Bank Account";
        var TableName="trn_bank";
        var ID="account_object_id";
        var Name="account_no";
        var Condition=escape("where bank_id='"+val+"' order by account_no");
        var selectedValue="";
        var OnChangeEvent="";

        var URLQuery="FunctionName="+FunctionName+"&ComboName="+ComboName+"&SelectA="+SelectA+"&TableName="+TableName+"&ID="+ID+"&Name="+Name+"&Condition="+Condition+"&selectedValue="+selectedValue+"&OnChangeEvent="+OnChangeEvent+"";
        callServerSec(URLQuery);
}
</script>

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

function DisableToChequeInfo()
{
        document.frmVoucherEntry.cboToBank.disabled=true;
        document.frmVoucherEntry.cboToAccountNo.disabled=true;
}

function EnableToChequeInfo()
{
        document.frmVoucherEntry.cboToBank.disabled=false;
        document.frmVoucherEntry.cboToAccountNo.disabled=false;
}
function doValid()
{
      if(document.frmVoucherEntry.rdopayto[1].checked)
      {
            if(document.frmVoucherEntry.cboBank.value=='-1')
            {
                  document.frmVoucherEntry.cboBank.focus();
                  alert("Select a bank.");
                  return;
            }
            if(document.frmVoucherEntry.cboAccountNo.value=='-1')
            {
                  document.frmVoucherEntry.cboAccountNo.focus();
                  alert("Select a account no.");
                  return;
            }
      }
      if(document.frmVoucherEntry.rdoTopayto[1].checked)
      {
            if(document.frmVoucherEntry.cboToBank.value=='-1')
            {
                  document.frmVoucherEntry.cboToBank.focus();
                  alert("Select a bank.");
                  return;
            }
            if(document.frmVoucherEntry.cboToAccountNo.value=='-1')
            {
                  document.frmVoucherEntry.cboToAccountNo.focus();
                  alert("Select a account no.");
                  return;
            }
      }
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
                               IFNULL(TR,0)+1 AS VNOrena
                            from
                                mas_latestjournalnumber
                          ";

                $rset =mysql_query($party_sql)  or die(mysql_error());
                while($row = mysql_fetch_array($rset))
                {
                        extract($row);
                }
?>


<form name='frmVoucherEntry' method='post' action='SaveMasTrnJournalTV.php'>

<input type="hidden" name="HidUpdateIndex" value="">
<input type="hidden" name="TotalIndex" value="">

<table border='0'  width='100%' align='center' cellpadding='3' cellspacing='0'>
        <tr>
                <td align='center' colspan='10'  class='header_cell_e'>
                        Transfer Voucher Entry Form
                </td>
        </tr>
        <tr>
                <td align='right'  class='td_e' colspan='2'>
                        Voucher Date:
                </td>
                <td align='left'  class='td_e' colspan='4'>
                <?PHP
                echo"
                        dd<input type='text' name='txtVoucherDay' value='$txtVoucherDay' size='2' maxlength='2' class='input_e'>
                        mm<input type='text' name='txtVoucherMonth' value='$txtVoucherMonth' size='2' maxlength='2' class='input_e'>
                        yyyy<input type='text' name='txtVoucherYear' value='$txtVoucherYear' size='4' maxlength='4'  class='input_e'>
                ";
                ?>
                </td>
                <td align='right'  class='td_e' colspan='2'>
                        Voucher No:
                </td>
                <td align='left'  class='td_e' colspan='2'>
                        <?PHP
                                echo"<input type='text' name='journalno' value='$VNOrena' readonly class='input_e'>";
                        ?>
                        <input type='hidden' name='txtJournalType' Value='TR'>
                </td>
        </tr>
</table>
<br>
<table border='0'  width='100%' align='center' cellpadding='3' cellspacing='0'>
      <tr>
                <td align='center' colspan='10'  class='header_cell_e'>
                        From
                </td>
        </tr>
        <tr>
                <td align='center'  class='td_e' colspan='10'>
                        Pay By:
                        Cash<input type='radio' name='rdopayto' value='C' class='input_e' onClick="DisableChequeInfo()">
                        Cheque<input type='radio' name='rdopayto' value='Q' class='input_e' class='input_e' checked onClick="EnableChequeInfo()">
                </td>
        </tr>

        <tr>
                <td align='right'  class='td_e' colspan='2'>
                        Bank:
                </td>
                <td  align='left'  class='td_e' colspan='4'>
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
                <td align='right'   class='td_e' colspan='2'>
                        Account No:
                </td>
                <td align='left'  class='td_e' colspan='2'>
                        <span id='GridAccount'>
                                <select name='cboAccountNo' class='select_e'>
                                        <option value='-1'>Select A Bank Account</option>
                                </select>
                        </span>
                </td>
        </tr>
        <tr>
                <td align='right'  class='td_e' colspan='2'>
                        Cheque No:
                </td>
                <td align='left'  class='td_e' colspan='4'>
                        <input type='text' name='cqno' size='10' class='input_e'>
                </td>
                <td align='right'  class='td_e' colspan='2'>
                        Cheque Date:
                </td>
                <td align='left'  class='td_e' colspan='2'>
                        <input type='text' name='txtChequeDate' size='10' readonly class='input_e'>
                        <a href="javascript:ComplainDate1.popup();">
                                <img src="img/cal.gif" width="13" height="13" border="0" alt="Click Here to Pick up the date">
                        </a>
                </td>
        </tr>
        <tr>
                <td align='right'  class='td_e' colspan='2'>
                        Particulars:
                </td>
                <td align='left'  colspan='4' height='56'  class='td_e'>
                        <textarea rows='3' name='mremarks' cols='50'></textarea>
                </td>
                <td align='right'  class='td_e' colspan='2'>
                        Amount:
                </td>
                <td align='left'  class='td_e' colspan='2'>
                        <input type='text' name='txtAmount' size='10' class='input_e'>
                </td>
        </tr>
</table>
<br>
<table border='0'  width='100%' align='center' cellpadding='3' cellspacing='0'>
      <tr>
                <td align='center' colspan='4'  class='header_cell_e'>
                        To
                </td>
        </tr>
        <tr>
                <td align='center'  class='td_e' colspan='4'>
                        Rec By:
                        Cash<input type='radio' name='rdoTopayto' value='C' class='input_e' onClick="DisableToChequeInfo()">
                        Bank<input type='radio' name='rdoTopayto' value='Q' class='input_e' class='input_e' checked onClick="EnableToChequeInfo()">
                </td>
        </tr>
        <tr>
                <td align='right'  class='td_e' >
                        Bank:
                </td>
                <td  align='left'  class='td_e' >
                        <select name='cboToBank' onchange='setAccountSec(this.value)' class='select_e'>
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
                <td align='right'   class='td_e' >
                        Account No:
                </td>
                <td align='left'  class='td_e' width='22%'>
                        <span id='GridToAccount'>
                                <select name='cboToAccountNo' class='select_e'>
                                        <option value='-1'>Select A Bank Account</option>
                                </select>
                        </span>
                </td>
        </tr>
</table>

<p align='center'>
        <input type='button' value='Save' name='saveBtn' onClick='doValid()' class='forms_button_e'>
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
