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


var CreditAmount=new Array();
var remarks=new Array();
var ChartofAccountValue=new Array();
var glcode=new Array();

var CreditAmountLength=new Array();



function copyRecords(crglcode,crgldescripton,crdescription,cramount,Numrows)
{
       //alert(Numrows);
        for(var l=0;l<Numrows;l++)
        {

            //alert(cramount[l]);
            glcode[l]= crglcode[l];
            ChartofAccountValue[l]=crgldescripton[l];
            remarks[l]=crdescription[l];
            CreditAmount[l]=cramount[l];
            //alert(CreditAmount[l]);
        }


     index=Numrows;
     DrawTable(0);

}

function Addtogrid()
{

        CreditAmount[index]=frmVoucherEntry.txtCredit.value;
        //alert(CreditAmount[index]);
        CreditAmountLength[index]=frmVoucherEntry.txtCredit.value.length;

        remarks[index] = frmVoucherEntry.txtRemarks.value;
        ChartofAccountValue[index]=cmbChartOfAccount.getText();
        glcode[index]=frmVoucherEntry.txtCOANO.value;
        index++;
        strtpoint=index-1;
        DrawTable(strtpoint);


}


function DrawTable(start)
{

        var ResRow="";

        if(CreditAmount[index]=="0")
        {
                alert('Value Required');
        }

        else if(CreditAmountLength[index]==0)
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
                        for(i=start;i<index;i++)
                        {
                        DataRow[i]='';
                        DataRow[i]+="<table border='1' align='center' width='80%' bordercolor='black' cellpadding='0' cellspacing='0'>";
                        DataRow[i]+="<tr>";
                        DataRow[i]+="<td width='30%' align='center' class='td_e'><input type='text' style='border:0;cursor:hand' name='txtChartofAccount["+i+"]'  value='"+ChartofAccountValue[i]+"' readonly onclick='EditInformation("+i+");' class='input_e'><input type='hidden' value='"+glcode[i]+"' name='txtglcode["+i+"]'></td>";
                        DataRow[i]+="<td width='30%' align='center' class='td_e'><input type='text' style='border:0;cursor:hand' name='txtRemarks["+i+"]'  value='"+remarks[i]+"' readonly onclick='EditInformation("+i+");') class='input_e'></td>";
                        DataRow[i]+="<td width='25%' align='center' class='td_e'><input type='text' style='border:0;cursor:hand' name='txtCreditAmount["+i+"]'  value='"+CreditAmount[i]+"' readonly onclick='EditInformation("+i+");' class='input_e' ></td>";
                        DataRow[i]+="<td width='15%' class='td_e'><input type='button' value='Delete' name='del["+i+"]' onClick='DeleteDataRow("+i+")' class='forms_button_e'></td>";
                        DataRow[i]+="</tr></table>";

                        window.d.innerHTML=window.d.innerHTML+DataRow[i];
                        }
                }

                frmVoucherEntry.TotalCredit.value=ReturnCreditTotal();
        }
}


function DeleteDataRow(ind)
{
        window.d.innerHTML='';
        DataRow[ind]='';

        for(var i=0;i<index;i++)
        {
                if(DataRow[i]!='' || DataRow[i]!=null)
                window.d.innerHTML =  window.d.innerHTML + DataRow[i];
        }

        frmVoucherEntry.TotalCredit.value=ReturnCreditTotal();
        newval=index--;
        //alert(newval);
        frmVoucherEntry.TotalIndex.value=newval;
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
        for(var i=0;i<index;i++)
        {
                if(frmVoucherEntry.elements("txtCreditAmount["+i+"]")!=null)
                        CreditAmount=parseFloat((document.frmVoucherEntry.elements("txtCreditAmount["+i+"]").value))+CreditAmount;
        }
        frmVoucherEntry.TotalIndex.value=index;
        CreditAmount=parseFloat((document.frmVoucherEntry.TotalCredit.value));
        if(CreditAmount==0)
        {
                alert('Total Credit should not be 0');
                        return false;
        }
        else if(index==0)
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

        for(var i=0;i<index;i++)
        {
                if(document.frmVoucherEntry.elements["txtCreditAmount["+i+"]"]!=null)
                creditTotal += parseFloat(document.frmVoucherEntry.elements["txtCreditAmount["+i+"]"].value);
        }

        return creditTotal;
}

function AddandEvaluate()
{
        Addtogrid()
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


<form name='frmVoucherEntry' method='post' action='AddToMaseditTrnJournalRV.php'>

<input type="hidden" name="HidUpdateIndex" value="">
<input type="hidden" name="TotalIndex" value="">
<?PHP
echo "<input type='hidden' name='txtjurnalid' value='$sjournalid'>";
?>

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
                        dd<input type='text' name='txtVoucherDay' value='".$vdate[0]."' size='2' maxlength='2' class='input_e'>
                        mm<input type='text' name='txtVoucherMonth' value='".$vdate[1]."' size='2' maxlength='2' class='input_e'>
                        yyyy<input type='text' name='txtVoucherYear' value='".$vdate[2]."' size='4' maxlength='4' class='input_e'>
                ";
                ?>
                </td>
                <td align='right' width='20%' class='td_e' colspan='2'>
                        Voucher No:
                </td>
                <td align='left' width='20%' class='td_e' colspan='2'>
                        <?PHP
                                echo"<input type='text' name='journalno' value='$journalno' readonly class='input_e'>";
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
                                        createQueryCombo("Customer",$Customer_sql,'-1',$customerid);

                                ?>
                        </select>
                </td>
                <td align='right' width='20%' class='td_e' colspan='2'>
                        Pay By:
                </td>
                <td align='left' width='20%' class='td_e' colspan='2'>
                         <?PHP
                              echo "Cash<input type='radio' name='rdopayto' value='C' class='input_e' " ;
                              if($paytype=='Q')
                                    echo " checked ";
                              echo "onClick='DisableChequeInfo()'>";

                              echo " Cheque<input type='radio' name='rdopayto' value='Q' class='input_e' class='input_e' ";
                              if($paytype=='C')
                                    echo " checked ";
                              echo "onClick='DisableChequeInfo()'>";
                        ?>
                </td>
        </tr>
        <tr>
                <td align='right' widht='20%' class='td_e' colspan='2'>
                        Bank:
                </td>
                <td  align='left' width='40%' class='td_e' colspan='4'>
                        <select name='cboBank' onblur='setAccount(this.value)' class='select_e'>
                        <?PHP
                                $SerachBank="select
                                                        bank_id,
                                                        bank_name
                                                from
                                                        mas_bank
                                                order by
                                                        bank_name
                                           ";
                                createQueryCombo("Bank",$SerachBank,'-1',$bank);
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
                        <input type='text' name='cqno'<?PHP echo "value='$chequeno' "?> size='10' class='input_e'>
                </td>
                <td align='right' width='20%' class='td_e' colspan='2'>
                        Cheque Date:
                </td>
                <td align='left' width='20%' class='td_e' colspan='2'>
                        <input type='text' name='txtChequeDate' <?PHP echo "value='$chequedate1' "?>  size='10' readonly class='input_e'>
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
                                                Chart of Account
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
                                               <input type='text' name='txtCredit' size='8' class='input_e'>
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
                        <input type='text' name='TotalCredit' value='0' readonly class='input_e'>
                </td>
                <td width='15%' class='td_e'>&nbsp;</td>
        </tr>
</table>

<p align='center'>
        <input type='button' value='Save' name='saveBtn' onClick='DoConsisTancyBetDrCrAmount()' class='forms_button_e'>
</p>



<script language="JavaScript">

        // create calendar object(s) just after form tag closed
        // specify form element as the only parameter (document.forms['formname'].elements['inputname']);
        // note: you can have as many calendar objects as you need for your application

        var ComplainDate1 = new calendar1(document.forms['frmVoucherEntry'].elements['txtChequeDate']);
        ComplainDate1 .year_scroll = true;
        ComplainDate1 .time_comp = false;
</script>

<input type='hidden' name='txtIndex' value='0'>

<script language='JavaScript'>
        var crglcode=new Array(100);
        var crgldescripton=new Array(100);
        var crdescription=new Array(100);
        var cramount=new Array(100);
        var Numrows=0;

<?PHP
        // select Nominee information
        $query="SELECT
                        mas_journal.journalno,
                        mas_journal.journaltype,
                        mas_journal.journaldate,
                        trn_journal.remarks,
                        mas_journal.payto,
                        trn_journal.amount,
                        trn_journal.ttype,
                        mas_gl.id,
                        mas_gl.description,
                        mas_gl.gl_code

                FROM
                        mas_journal
                        INNER JOIN trn_journal ON mas_journal.journalid = trn_journal.journalid
                        INNER JOIN mas_gl ON trn_journal.glcode = mas_gl.gl_code

                WHERE
                        mas_journal.journalid='$sjournalid'
                        and trn_journal.ttype='Cr'
                GROUP BY
                        mas_journal.journalno, mas_journal.journaltype, mas_journal.journaldate, mas_journal.payto, trn_journal.amount, trn_journal.ttype, mas_gl.gl_code, mas_gl.description
                ORDER BY
                        trn_journal.ttype Desc
                ";

         //echo $query;

        $result=mysql_query($query) or die(mysql_error());
        $j=0;
        while($row=mysql_fetch_array($result))
        {
                extract($row);

            echo   "crglcode[$j]=\"$gl_code\";";
            echo   "crgldescripton[$j]=\"$description\";";
            echo   "crdescription[$j]=\"$remarks\";";
            echo   "cramount[$j]=\"$amount\";";


        $j++;
        }
         echo "Numrows=$j;\n";
         echo "copyRecords(crglcode,crgldescripton,crdescription,cramount,Numrows);";


?>


</script>

<span ID='DeletedTrnInvoice'>
</span>
<input type='hidden' name='txtDelNumber'>

</form>

</body>

</html>
