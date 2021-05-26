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
var mainitem=new Array(100);
var subitem=new Array(100);
var quantity=new Array(100);
var remarks=new Array(100);
var unitid=new Array(100);
var unit=new Array(100);
var Itemname=new Array(100);
var sumItemname=new Array(100);
var RequiredSize=new Array(100);
var AvailableSize=new Array(100);

var fullname=new Array(100);

function copyRecords(item,sub_item,edqunatity,edunitid,edremarks,itemname,unitdesc,Numrows)
{
       //alert(Numrows);
        for(var l=0;l<Numrows;l++)
        {

            //alert(cramount[l]);
            mainitem[l]= item[l];
            subitem[l]=sub_item[l];
            remarks[l]=edremarks[l];
            quantity[l]=edqunatity[l];
            unitid[l]=edunitid[l];
            fullname[l]=itemname[l];
            unit[l]=unitdesc[l];
            //alert(CreditAmount[l]);
        }


     index=Numrows;
     DrawTable(0);

}

function Addtogrid()
{
      mainitem[index]=frmVoucherEntry.cboitem.value;
      i=parseInt(frmVoucherEntry.cboitem.selectedIndex);
      Itemname[index]=frmVoucherEntry.cboitem.options[i].text;

      subitem[index]=frmVoucherEntry.cbosubitem.value;
      i=parseInt(frmVoucherEntry.cbosubitem.selectedIndex);
      sumItemname[index]=frmVoucherEntry.cbosubitem.options[i].text;

      fullname[index]=Itemname[index]+"-"+sumItemname[index];

      RequiredSize[index]=frmVoucherEntry.txtRSize.value;
      AvailableSize[index]=frmVoucherEntry.txtAvblSize.value;

      unitid[index]=frmVoucherEntry.cbounit.value;
      i=parseInt(frmVoucherEntry.cbounit.selectedIndex);
      unit[index]=frmVoucherEntry.cbounit.options[i].text;


      quantity[index]=frmVoucherEntry.txtRqQnty.value;
      remarks[index] = frmVoucherEntry.Remarks.value;
      
      index++;
      strtpoint=index-1;
      DrawTable(strtpoint);
}

function DrawTable(start)
{


                /*if(frmVoucherEntry.addBtn.value=='Update')
                {
                        var UpdateIndex=frmVoucherEntry.HidUpdateIndex.value;
                        alert(fullname[UpdateIndex]+unit[UpdateIndex]);
                        frmVoucherEntry.elements("txtmainitem["+UpdateIndex+"]").value=fullname[UpdateIndex];
                        frmVoucherEntry.elements("txtitem["+UpdateIndex+"]").value=frmVoucherEntry.cbosubitem.value;
                        //frmVoucherEntry.elements("txtitem["+UpdateIndex+"]").value=frmVoucherEntry.cbosubitem.value;
                        frmVoucherEntry.elements("txtRsizes["+UpdateIndex+"]").value=frmVoucherEntry.txtRSize.value;
                        frmVoucherEntry.elements("txtAvblSizes["+UpdateIndex+"]").value=frmVoucherEntry.txtAvblSize.value;
                        frmVoucherEntry.elements("txtquantities["+UpdateIndex+"]").value=frmVoucherEntry.txtRqQnty.value;
                        frmVoucherEntry.elements("txtunitname["+UpdateIndex+"]").value=unit[UpdateIndex];
                        frmVoucherEntry.elements("txtremark["+UpdateIndex+"]").value=frmVoucherEntry.Remarks.value;



                        frmVoucherEntry.addBtn.value='Add';

                }*/
                //else
                //{
                        for(i=start;i<index;i++)
                        {
                        DataRow[i]='';
                        DataRow[i]+="<table border='1' align='center' width='90%' bordercolor='black' cellpadding='0' cellspacing='0'>";
                        DataRow[i]+="<tr>";
                        DataRow[i]+="<td   width='30%' align='center' class='td_e' style='cursor:hand' ><input type='text' style='border:0;cursor:hand;' value='"+fullname[i]+"' name='txtmainitem["+i+"]' readonly><input type='hidden' value='"+subitem[i]+"' name='txtitem["+i+"]'><input type='hidden' value='"+mainitem[i]+"' name='txtmitem["+i+"]'></td>";
                        DataRow[i]+="<td   width='10%' align='center' class='td_e' style='cursor:hand;' ><input type='text' style='border:0;cursor:hand;' size='5' name='txtRsizes["+i+"]'  value='"+RequiredSize[i]+"' readonly></td>";
                        DataRow[i]+="<td   width='10%' align='center' class='td_e' style='cursor:hand;' ><input type='text' style='border:0;cursor:hand;' size='5' name='txtAvblSizes["+i+"]'  value='"+AvailableSize[i]+"' readonly></td>";
                        DataRow[i]+="<td   width='10%' align='center' class='td_e' style='cursor:hand;'><input type='text' style='border:0;cursor:hand;' size='5' name='txtquantities["+i+"]'  value='"+quantity[i]+"' readonly></td>";
                        DataRow[i]+="<td   width='5%' align='center' class='td_e' style='cursor:hand;' ><input type='text' name='txtunitname["+i+"]'  value='"+unit[i]+"' style='border:0;cursor:hand;' readonly size='5'><input type='hidden' name='txtunits["+i+"]'  value='"+unitid[i]+"' style='border:0;cursor:hand;' readonly></td>";
                        DataRow[i]+="<td   width='25%' align='center' class='td_e' style='cursor:hand;'><input type='text' style='border:0;cursor:hand;'  name='txtremark["+i+"]' value='"+remarks[i]+"' readonly ></td>";
                        DataRow[i]+="<td   width='10%' class='forms_button_e' style='cursor:hand;'><input type='button'  class='forms_button_e' value='Delete' name='del["+i+"]' onClick='DeleteDataRow("+i+")'></td>";
                        DataRow[i]+="</tr></table>";


                        d.innerHTML=d.innerHTML+DataRow[i];
                        }


                //}
                frmVoucherEntry.TotalIndex.value=index;


}

function DeleteDataRow(ind)
{

        d.innerHTML='';

        DataRow[ind]='';

        for(var i=0;i<index;i++)
        {
                if(DataRow[i]!='' || DataRow[i]!=null)
                d.innerHTML =  d.innerHTML + DataRow[i];
        }

       // e.innerHTML='';
        newval=index--;
       // alert(index);
        frmVoucherEntry.TotalIndex.value=newval;
        
        //getResult();
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
        /*var CreditAmount=0;
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
        { */
                frmVoucherEntry.submit();
        //}




}

function EditInformation(index)
{
    frmVoucherEntry.cboitem.value=frmVoucherEntry.elements("txtmitem["+index+"]").value;
    frmVoucherEntry.cbosubitem.value=frmVoucherEntry.elements("txtitem["+index+"]").value;
    frmVoucherEntry.txtRSize.value=frmVoucherEntry.elements("txtRsizes["+index+"]").value;
    frmVoucherEntry.txtAvblSize.value=frmVoucherEntry.elements("txtAvblSizes["+index+"]").value;
    frmVoucherEntry.txtRqQnty.value=frmVoucherEntry.elements("txtquantities["+index+"]").value;
    frmVoucherEntry.cbounit.value=frmVoucherEntry.elements("txtunits["+index+"]").value;
    frmVoucherEntry.Remarks.value=frmVoucherEntry.elements("txtremark["+index+"]").value;
    
    //DeleteDataRow(index);

    frmVoucherEntry.addBtn.value='Update';
    frmVoucherEntry.HidUpdateIndex.value=index;
   // alert(index);

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
        ResRow +=           "<td width='10%' align='right'>"+ReturnDebitTotal()+"</td>";
        ResRow +=           "<td width='10%' align='right'>"+ReturnCreditTotal()+"</td>";
        ResRow +=           "<td width='10%'>&nbsp;</td>";
        ResRow +=     "</tr>";
        ResRow += "</table>";

        e.innerHTML = ResRow;
}

function AddandEvaluate()
{



        //alert(frmVoucherEntry.TotalIndex.value);
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
<form name='frmVoucherEntry' method='post' action='AddTo_EditMaterialRequisit.php'>
<?PHP
       $masmaterial="select
                                requisition_number,
                                requisition_date,
                                requisition_by,
                                requisition_job,
                                requisition_item,
                                required_date,
                                job_quantity

                      from
                                mas_material_req
                      where
                                mas_requisition_id='$object_id'
                ";
        $rsmasmaterial=mysql_query($masmaterial)or die(mysql_error());
        while($rowmaterial=mysql_fetch_array($rsmasmaterial))
        {
                extract($rowmaterial);
                $requisitiondate=explode("-",$requisition_date);
                $requireddate=explode("-",$required_date);
        }
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

       echo "<input type='hidden' value='$object_id' name='txtmasrequisition'>";

?>


<input type="hidden" name="HidUpdateIndex" value="">
<input type="hidden" name="TotalIndex" value="">

  <table border='0' width='100%'  align='center' cellpadding='3' cellspacing='0'>
        <tr>
                <td colspan='10' class='header_cell_e' width='100%' align='center'>
                        Material Requisit
                </td>
        </tr>
        <tr>

                <td colspan='2' width='20%' class='td_e'>Job #:</td>
                <td colspan='3' width='30%' class='td_e'>
                        <?PHP
                                echo "<input type='text' name='txtjobno' value='$requisition_job' class='input_e'>";
                        ?>
                </td>
                <td width='20%' colspan='2' class='td_e'>Requisition No</td>
                <td width='30%' colspan='3' class='td_e'>

                        <?PHP
                                echo "<input type='text' name='Requisitno' value='$requisition_number'  class='input_e'>";
                        ?>


                </td>
        </tr>
         <tr>

                <td width='20%' colspan='2' class='td_e'>Item:</td>
                <td width='30%' colspan='3' class='td_e'>

                </td>
                <td colspan='2' width='20%' class='td_e'>Date</td>
                <td colspan='3' width='30%' class='td_e'>
                <?PHP
                echo"
                        dd<input type='text' name='txtDay' value='$requisitiondate[2]' size='2' maxlength='2' class='input_e'>
                        mm<input type='text' name='txtMonth' value='$requisitiondate[1]' size='2' maxlength='2' class='input_e'>
                        yyyy<input type='text' name='txtYear' value='$requisitiondate[0]' size='4' maxlength='4' class='input_e'>
                ";
                ?>
                </td>

        </tr>
        <tr>

                <td width='20%' colspan='2' class='td_e'>Date Required</td>
                <td width='30%' colspan='3' class='td_e'>
                  <?PHP
                echo"
                        dd<input type='text' name='txtRDay' value='$requireddate[2]' size='2' maxlength='2' class='input_e'>
                        mm<input type='text' name='txtRMonth' value='$requireddate[1]' size='2' maxlength='2' class='input_e'>
                        yyyy<input type='text' name='txtRYear' value='$requireddate[0]' size='4' maxlength='4' class='input_e'>
                ";
                ?>
                </td>
                <td colspan='2' width='20%' class='td_e'>Job Quantity</td>
                <td colspan='3' width='30%' class='td_e'>

                        <?PHP echo "<input type='text' name='Jobquantity' value='$job_quantity'  class='input_e'>";?>
                </td>

        </tr>

</table>

<table border='1' align='center' width='100%' bordercolor='black' cellpadding='0' cellspacing='0' >
 <tr><td>
  <table border='0' align='center'  cellpadding='4' cellspacing='0' width='100%'>
        <tr>
                <td class='title_cell_e'>Particulars</td>
                <td class='title_cell_e'>Rqrd.Size mm</td>
                <td class='title_cell_e'>Avbl.Size mm</td>
                <td class='title_cell_e'>Rqrd.Qnty</td>
                <td class='title_cell_e'>Unit</td>
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
                        <span id='Gridsubitme'>
                        <select name='cbosubitem' class='select_e'>
                        <option value='-1'>Select Subitem</option>
                        </select>
                        </span>
                  </td>
                  <td valign='top' class='td_e'><input type='text' name='txtRSize' size='6'  class='input_e'></td>
                  <td valign='top' class='td_e'><input type='text' name='txtAvblSize' size='6'  class='input_e'></td>
                  <td valign='top' class='td_e'><input type='text' name='txtRqQnty' size='8'  class='input_e'></td>
                  <td class='td_e' align='center'>
                        <select name='cbounit' class='select_e'>
                        <?PHP
                               createCombo("Unit","mas_unit","unitid","unitdesc","","")
                        ?>
                        </select>
                  </td>
                  <td valign='top' class='td_e'><input type='text' name='Remarks' size='15'  class='input_e'></td>
                  <td valign='top' class='td_e'><input type='button' value='ADD' name='addBtn' onClick='Addtogrid()' class='forms_button_e'></td>
        </tr>
   </table>
 </td></tr>
</table>

<input type="hidden" name="txtHiddenIndex" value="">

<br>
<table border='0' align='center' width='90%' bordercolor='black' cellpadding='0' cellspacing='0'>
 <tr>
      <td width='30%' class='title_cell_e'>Particulars</td>
      <td width='10%' class='title_cell_e'>Rqrd.Size mm</td>
      <td width='10%' class='title_cell_e'>Avbl.Size mm</td>
      <td width='10%' class='title_cell_e'>Rqrd.Qnty</td>
      <td width='5%' class='title_cell_e'>Unit</td>
      <td width='25%' class='title_cell_e'>Remarks</td>
      <td width='10%' class='title_cell_e'>&nbsp;</td>
  </tr>
</table>

<span id='d'>
</span>

<span id='e'>
</span>

<script language='JavaScript'>
        var item=new Array(100);
        var sub_item=new Array(100);
        var edqunatity=new Array(100);
        var edremarks=new Array(100);
        var edunitid=new Array(100);
        var edunitname=new Array(100);
        var editemname=new Array(100);
        var itemname=new Array(100);
        var unitdesc=new Array(100);
        var Numrows=0;

<?PHP
        // select Nominee information
        $query="SELECT
                        trn_material_req.itemcode ,
                        mas_item.parent_itemcode,

                        trn_material_req.req_quantity,
                        trn_material_req.remarks,
                        trn_material_req.unitid

                        
                FROM
                        trn_material_req
                        LEFT JOIN mas_item ON mas_item.itemcode = trn_material_req.itemcode
                        LEFT JOIN mas_unit ON mas_unit.unitid = trn_material_req.unitid
                WHERE
                        trn_material_req.`mas_requisition_id`='$object_id'
                order by
                        trn_material_req.trn_requisition_id

                ";

         //echo $query;

        $result=mysql_query($query) or die(mysql_error());
        $j=0;
        while($row=mysql_fetch_array($result))
        {
                extract($row);
                $itemdesc=pick("mas_item","itemdescription","itemcode='$parent_itemcode'");
                $subitemdesc=pick("mas_item","itemdescription","itemcode='$itemcode'");
                $desc= $itemdesc."-".$subitemdesc;
                $unitname=pick("mas_unit","unitdesc","unitid='$unitid'");

            echo   "item[$j]=\"$parent_itemcode\";";
            echo   "sub_item[$j]=\"$itemcode\";";
            echo   "edqunatity[$j]=\"$req_quantity\";";
            echo   "edremarks[$j]=\"$remarks\";";
            echo   "edunitid[$j]=\"$unitid\";";
            echo   "itemname[$j]=\"$desc\";";
            echo   "unitdesc[$j]=\"$unitname\";";


        $j++;
        }
         echo "Numrows=$j;\n";
         echo "copyRecords(item,sub_item,edqunatity,edunitid,edremarks,itemname,unitdesc,Numrows);";


?>


</script>

<p align='center'>
 <input type='button' value='Save' name='saveBtn' onClick='DoConsisTancyBetDrCrAmount()' class='forms_button_e'>
</p>

</form>

</body>

</html>
