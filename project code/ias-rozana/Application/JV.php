<?PHP
session_start();

        include_once("Library/dbconnect.php");
        include_once("Library/Library.php");
        //include_once 'DrawFlexCombo.php';
/*
include_once 'libraries/Library.php';
include_once 'libraries/DataConnector.php';
include_once 'DrawFlexCombo.php';
include_once 'Library.php';
*/
/*
$Dc=new DataConnector();
$Lib=new Library();
*/

$GetGlCode="select id,
                   description
                   from mas_gl
                   order by description";


$resultGetGlCode=mysql_query($GetGlCode) or die(mysql_error());

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

var index=1;
var DataRow= new Array();

function DrawTable()
{
        var DebitAmount=frmVoucherEntry.txtDebit.value;
        var CreditAmount=frmVoucherEntry.txtCredit.value;

        var DebitAmountLength=frmVoucherEntry.txtDebit.value.length;
        var CreditAmountLength=frmVoucherEntry.txtCredit.value.length;
        var glcode=frmVoucherEntry.txtCOANO.value;
        //alert("the glcode :"+glcode);
        
        var costcenter=frmVoucherEntry.cmbCostCenter.value;

        i=parseInt(frmVoucherEntry.cmbCostCenter.selectedIndex);


        var costcenter_name=frmVoucherEntry.cmbCostCenter.options[i].text;


        var remarks = frmVoucherEntry.txtRemarks.value;

        var ChartofAccountValue=cmbChartOfAccount.getText();

        if(DebitAmount=='0' && CreditAmount=='0')
        {
                alert('Value Required');
        }
        else if(DebitAmountLength==0 ||CreditAmountLength==0 )
        {
                alert('Value Required');
        }
        else
        {
                if(frmVoucherEntry.addBtn.value=='Update')
                {
                        var UpdateIndex=frmVoucherEntry.HidUpdateIndex.value;
                        j=parseInt(frmVoucherEntry.cmbCostCenter.selectedIndex);


                        frmVoucherEntry.elements["txtcostcenter["+UpdateIndex+"]"].value=frmVoucherEntry.cmbCostCenter.options[j].text;;
                        frmVoucherEntry.elements["cmbCostCenter1["+UpdateIndex+"]"].value= frmVoucherEntry.cmbCostCenter.value;
                        frmVoucherEntry.elements("txtChartofAccount["+UpdateIndex+"]").value=cmbChartOfAccount.getText();
                        frmVoucherEntry.elements("txtglcode["+UpdateIndex+"]").value=frmVoucherEntry.txtCOANO.value;
                        frmVoucherEntry.elements("txtRemarks["+UpdateIndex+"]").value=frmVoucherEntry.txtRemarks.value;
                        frmVoucherEntry.elements("txtDebitAmount["+UpdateIndex+"]").value=frmVoucherEntry.txtDebit.value;
                        frmVoucherEntry.elements("txtCreditAmount["+UpdateIndex+"]").value=frmVoucherEntry.txtCredit.value;

                        frmVoucherEntry.addBtn.value='Add';

                }
                else
                {
                        DataRow[index]='';
                        DataRow[index]+="<table border='1' align='center' width='90%' bordercolor='black' cellpadding='0' cellspacing='0'>";
                        DataRow[index]+="<tr>";
                        DataRow[index]+="<td  width='20%' align='center' class='td_e'><input type='text' style='border:0;cursor:hand' Size='15' name='txtcostcenter["+index+"]'  value='"+costcenter_name+"' readonly onclick='EditInformation("+index+");' class='input_e'><input type='hidden' value='"+costcenter+"' name='cmbCostCenter1["+index+"]'></td>";
                        DataRow[index]+="<td  width='30%'  class='td_e'><input type='text' style='border:0;cursor:hand;' name='txtChartofAccount["+index+"]'  value='"+ChartofAccountValue+"' readonly onclick='EditInformation("+index+");'><input type='hidden' value='"+glcode+"' name='txtglcode["+index+"]'></td>";
                        DataRow[index]+="<td  width='20%' class='td_e'><input type='text' style='border:0;cursor:hand;' size='20' name='txtRemarks["+index+"]'  value='"+remarks+"' readonly onclick='EditInformation("+index+");')></td>";
                        DataRow[index]+="<td  width='10%' class='td_e'><input type='text' style='border:0;cursor:hand;text-align: right' size='5' name='txtDebitAmount["+index+"]'  value='"+DebitAmount+"' readonly onclick='EditInformation("+index+");'></td>";
                        DataRow[index]+="<td  width='10%' class='td_e'><input type='text' style='border:0;cursor:hand;text-align: right' size='5' name='txtCreditAmount["+index+"]' value='"+CreditAmount+"' readonly onclick='EditInformation("+index+");'></td>";
                        DataRow[index]+="<td  width='10%' class='forms_button_e'><input type='button' style='border:0;cursor:hand;' class='forms_button_e' value='Delete' name='del["+index+"]' onClick='DeleteDataRow("+index+")'></td>";
                        DataRow[index]+="</tr></table>";


                        d.innerHTML=d.innerHTML+DataRow[index];
                        index++;
                }

        }
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
        var CreditAmount=0;
        var DebitAmount=0;

        if(frmVoucherEntry.journalno.value=="")
        {
                alert("Please provide voucher number.");
                frmVoucherEntry.journalno.focus();
                return false;
        }
        if(frmVoucherEntry.cmbSupplier.disabled==true)
        {
                if(frmVoucherEntry.cmbCustomer.value=="-1")
                {
                        alert("Please provide a Customer name.");
                        frmVoucherEntry.cmbCustomer.focus();
                        return false;
                }
        }
        if(frmVoucherEntry.cmbCustomer.disabled==true)
        {
                if(frmVoucherEntry.cmbSupplier.value=="-1")
                {
                        alert("Please provide a Supplier name.");
                        frmVoucherEntry.cmbSupplier.focus();
                        return false;
                }
        }

        for(var i=1;i<index;i++)
        {
                if(frmVoucherEntry.elements("txtDebitAmount["+i+"]")!=null)
                        DebitAmount=parseFloat((document.frmVoucherEntry.elements("txtDebitAmount["+i+"]").value))+DebitAmount;
        }

        for(var i=1;i<index;i++)
        {
                if(document.frmVoucherEntry.elements("txtCreditAmount["+i+"]")!=null)
                CreditAmount=parseFloat((document.frmVoucherEntry.elements("txtCreditAmount["+i+"]").value))+CreditAmount;
        }
        frmVoucherEntry.TotalIndex.value=index;

        if(DebitAmount!=CreditAmount)
        {
                alert('Total Debit and Total Credit are not equal');
                return false;
        }
        else if(index==1)
        {
                alert('Total Debit and Total Credit are not equal');
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
    frmVoucherEntry.cmbCostCenter.value=frmVoucherEntry.elements("cmbCostCenter1["+index+"]").value;
    frmVoucherEntry.txtDebit.value=frmVoucherEntry.elements("txtDebitAmount["+index+"]").value;
    frmVoucherEntry.txtCredit.value=frmVoucherEntry.elements("txtCreditAmount["+index+"]").value;
     frmVoucherEntry.txtRemarks.value=frmVoucherEntry.elements("txtRemarks["+index+"]").value;
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
        getResult();
}

function getTotalAmount()
{
        var dr = ReturnDebitTotal();
        var cr = ReturnCreditTotal();
}

/*
function setValue()
{

        val = document.frmVoucherEntry.cmbParty.options[document.frmVoucherEntry.cmbParty.selectedIndex].value;

        val = val.split("-");

        if(val[1]!=1)
                document.frmVoucherEntry.payto.value=val[1];
        else
                document.frmVoucherEntry.payto.value="";
}
*/

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

<body ONLOAD="initMyDoc()">

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

<form name='frmVoucherEntry' method='post' action='SaveMasTrnJournal.php'>
<input type="hidden" name="HidUpdateIndex" value="">
<input type="hidden" name="TotalIndex" value="">

  <table border='0' width='100%'  align='center' cellpadding='3' cellspacing='0'>
        <tr>
                <td colspan='10' class='header_cell_e' width='100%' align='center'>
                        Journal Voucher Entry Form
                </td>
        </tr>
        <tr>
                <td colspan='2' width='20%' class='td_e'>Voucher Date</td>
                <td colspan='3' width='30%' class='td_e'>
                <?PHP
                echo"
                        dd<input type='text' name='txtVoucherDay' value='$txtVoucherDay' size='2' maxlength='2' class='input_e'>
                        mm<input type='text' name='txtVoucherMonth' value='$txtVoucherMonth' size='2' maxlength='2' class='input_e'>
                        yyyy<input type='text' name='txtVoucherYear' value='$txtVoucherYear' size='4' maxlength='4' class='input_e'>
                ";
                ?>
                </td>
                <td width='20%' colspan='2' class='td_e'>Voucher No</td>
                <td width='30%' colspan='3' class='td_e'>
                        <?PHP
                                echo"<input type='text' name='journalno' value='$VNOrena' readonly class='input_e'>";
                        ?>
                        <input type='hidden' name='vtype' Value='JV'>
                </td>
        </tr>
        <tr>
                <td widht='20%' colspan='2' class='td_e'>Creditor</td>
                <td width='30%' colspan='3' class='td_e'>
                        <select name='cmbSupplier' class='select_e' onChange="DisabledCustomer()">
                                <?PHP
                                        $party_sql="select
                                                                supplier_id,
                                                                Company_Name
                                                        from
                                                                mas_supplier
                                                        order by
                                                                Company_Name
                                                ";
                                        createQueryCombo("Supplier",$party_sql,'-1',$cmbParty);
                                ?>
                       </select>
                </td>
                <td width='20%' colspan='2' class='td_e'>Debtor</td>
                <td width='30%' colspan='3' class='td_e'>
                        <select name='cmbCustomer' class='select_e' onChange="DisabledSupplier()">
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
        </tr>
        <tr>
                <td width='20%' colspan='2' class='td_e'>Description:</td>
                <td width='80%' colspan='8' align='left' height='56' width='100%' class='td_e'>
                        <textarea rows='3' name='mremarks' cols='48'></textarea>
                </td>
        </tr>
</table>

<table border='1' align='center' width='90%' bordercolor='black' cellpadding='0' cellspacing='0' >
 <tr><td>
  <table border='0' align='center'  cellpadding='4' cellspacing='0' width='100%'>
        <tr>
                 <td class='title_cell_e'>Cost Center</td>
                <td class='title_cell_e'>Chart of Account</td>
                <td class='title_cell_e'>Particulars</td>
                <td class='title_cell_e'>Debit</td>
                <td class='title_cell_e'class='td_e'>Credit</td>
                <td class='title_cell_e'>&nbsp;</td>
        </tr>
        <tr>
            <td class='td_e'>

                  <select name='cmbCostCenter' class='select_e'>
                  <?PHP
                        $cost_center_sql="select
                                                cost_code,
                                                description
                                          from
                                                mas_cost_center
                                          where
                                                id not in (select distinct pid from mas_cost_center)
                                          order by
                                                description
                                          ";
                        createQueryCombo("Cost Center",$cost_center_sql,'-1',$cmbCostCenter);
                  ?>
                  </select>
            </td>
                <td class='td_e'>
                        <table cellpadding=0 cellspacing=0>
                        <tr>
                        <td class='td_e'>
                        
                                <input type='text' name='txtCOANO' size='5' onchange='setCombo(this.value)' class='input_e'>
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

                <td valign='top' class='td_e'><input type='text' name='txtRemarks' size='20'  class='input_e'></td>
                <td valign='top' class='td_e'><input type='text' name='txtDebit' size='5' Style='text-align: right' onchange='EnableDebit()' class='input_e'></td>
                <td valign='top' class='td_e'><input type='text' name='txtCredit' size='5' Style='text-align: right' onchange='EnableCredit()' class='input_e'></td>
                <td valign='top' class='td_e'><input type='button' value='ADD' name='addBtn' onClick='AddandEvaluate()' class='forms_button_e'></td>
        </tr>
   </table>
 </td></tr>
</table>

<input type="hidden" name="txtHiddenIndex" value="">

<br>
<table border='0' align='center' width='90%' bordercolor='black' cellpadding='0' cellspacing='0'>
 <tr>
                <td  width='20%' class='title_cell_e'>Cost Center</td>
                <td  width='30%' class='title_cell_e'>Chart of Account</td>
                <td  width='20%' class='title_cell_e'>Particulars</td>
                <td  width='10%' class='title_cell_e'>Debit</td>
                <td  width='10%' class='title_cell_e'>Credit</td>
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

</form>

</body>

</html>
