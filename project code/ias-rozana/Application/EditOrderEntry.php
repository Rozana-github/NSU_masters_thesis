<?PHP
        include "Library/dbconnect.php";
        include "Library/Library.php";
        //include "Library.php";

?>
<html>

<head>
<meta http-equiv='Content-Language' content='en-us'>
<meta http-equiv='Content-Type' content='text/html; charset=windows-1252'>
<title>Supplier Entry Form</title>
<link rel='stylesheet' type='text/css' href='Style/eng_form.css'>
<link rel='stylesheet' type='text/css' href='Style/generic_form.css'>
<script language="JavaScript" src="Script/NumberFormat.js"></script>
<script language="JavaScript" src="Script/calendar1.js"></script>


<script language="JavaScript">
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
      //---------------------------- end ----------------------*/

      //------------------- search Item List------------------ Create By Sharif------------------------/
      function SelectItem(val)
      {
            var GLID=val.value;
            //var txtTest=document.Form1.cbocat.value;
            var url = "AjaxCode/SearchItemName.php";
            var str="GLID="+GLID+"";
            xmlHttp.open("POST", url, true);
            //xmlHttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded; charset=UTF-8");
            xmlHttp.setRequestHeader("Method", "POST " + url + " HTTP/1.1");
            xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xmlHttp.onreadystatechange = ShowItem;
            xmlHttp.send(str);
      }
      //--------------------------- Item----------------------------*/
      function ShowItem()
      {
            if (xmlHttp.readyState == 4)
            {
                  var response = xmlHttp.responseText;
                  // alert(response);
                  window.GridTest.innerHTML="";
                  window.GridTest.innerHTML=response;
            }
      }
      //----------------------------- end ----------------------------*/


function SearchCustomerPopUp()
{
        var popit=window.open('SearchCustomerPopUp.php','console','status,scrollbars,width=620,height=500');
}


function SearchCustomer()
{
        document.Form1.txtCustomerID.value="";
        document.Form1.action="OrderEntry.php";
        document.Form1.submit();
}
function setcombo()
{
        document.Form1.cboCustomerID.value=-1;
        document.Form1.action="OrderEntry.php";
        document.Form1.submit();
}






 var ItemID=new Array(100);
 var SubItemID=new Array(100);
 var ItemName=new Array(100);
 var orderdescription=new Array(100);
 var orderqty=new Array(100);
 var orderrate=new Array(100);
 var unitname=new Array(100);
 var UnitID=new Array(100);
 var orderamt=new Array(100);
 var k=0


 var i=0;
 
 function copyRecords(trn_order_desc,trn_order_quantity,trn_order_rate,trn_order_amount,trn_order_unit,trn_order_unit_name,trn_order_item,trn_order_subitem,trn_order_item_name,trn_order_subitem_name,totaltrn_order_desc_row,totaltrn_struct_row)
{
        //alert(vatValue);
        for(var n=0;n<totaltrn_order_desc_row;n++)
        {
                 //alert("salim");
                orderdescription[n]=trn_order_desc[n];
                orderqty[n]=trn_order_quantity[n];
                orderrate[n]=trn_order_rate[n];
                UnitID[n]=trn_order_unit[n];
                orderamt[n]=trn_order_amount[n];
                unitname[n]=trn_order_unit_name[n];
        }
        for(var n=0;n<totaltrn_struct_row;n++)
        {
                 //alert("salim");
                ItemID[n]=trn_order_item[n];
                SubItemID[n]=trn_order_subitem[n];

                ItemName[n]=trn_order_item_name[n]+"-"+trn_order_subitem_name[n];;

        }


     k=totaltrn_order_desc_row;
     i=totaltrn_struct_row;
     draworderdesc()
     drawList();

}
 
 function addtodesc()
 {
     orderdescription[k]=document.Form1.txtdescription.value;
     orderqty[k]=document.Form1.txtquty.value;
     orderrate[k]=document.Form1.txtRate.value;
     UnitID[k]=document.Form1.CmbUnitComb.value;
     unitname[k]=document.Form1.CmbUnitComb.options[document.Form1.CmbUnitComb.selectedIndex].text;
     orderamt[k]=document.Form1.txtorderamt.value;
     k++;
     draworderdesc();
 }
 
 function draworderdesc()
 {
    if(k<1)
        {
        desc.innerHTML="";
        desc.innerHTML=desc.innerHTML+"";
        document.Form1.txtdescIndex.value=k;
        return;
        }
        var str='';
        str=str+"<table align='center'  cellpadding='0' cellspacing='0' width='100%'>";
        str=str+"<tr><td colspan='6' class='header_cell_e' align='center'>Oredr Description</td></tr>";
        str=str+"<tr>";
        str=str+"  <td  align='center' class='title_cell_e'><font size='2'><b>Delete</b></font></td>";
        str=str+"  <td  align='center' class='title_cell_e'><font size='2'><b> Description</b></font></td>";
        str=str+"  <td  align='center' class='title_cell_e'><font size='2'><b>Quantity</b></font></td>";
        str=str+"  <td  align='center' class='title_cell_e'><font size='2'><b>rate</b></font></td>";
        str=str+"  <td  align='center' class='title_cell_e'><font size='2'><b>Unit</b></font></td>";
        str=str+"  <td  align='center' class='title_cell_e'><font size='2'><b>Amount</b></font></td>";

        str=str+"</tr>";

        for(var j=0;j<k;j++)
           {
               //Description[j]=replaceAll(Description[j],"'","&#039;");
               str=str+"<tr>";
               str=str+"  <td  align='center' class='td_e'><input type='button' name='Delete["+j+"]' value='Delete' onClick='deleteRoworder("+j+")' style='width:70' class='forms_button_e'></td>";
               str=str+"  <td  align='center' class='td_e'><input class='input_e' type='text' name='txtorderdescription["+j+"]' value='"+orderdescription[j]+"'  readOnly ></td>";
               str=str+"  <td  align='center' class='td_e'><input class='input_e' type='text' name='txtorderqunatity["+j+"]' value='"+orderqty[j]+"'  size='10' style='text-align:right' readOnly></td>";
               str=str+" <td  align='center' class='td_e'><input class='input_e' type='text' name='txtorderrate["+j+"]' value='"+orderrate[j]+"' size='10' style=' text-align:right; height: 20'readOnly>";
               str=str+" <td  align='center' class='td_e'><input type='hidden' name='txtunitid["+j+"]' value='"+UnitID[j]+"'><input class='input_e' type='text' name='txtorderunit["+j+"]' value='"+unitname[j]+"' style='width:115; height: 20'readOnly>";
               str=str+" <td  align='center' class='td_e'><input class='input_e' type='text' name='txtorderamount["+j+"]' value='"+orderamt[j]+"' size='10' style='text-align:right; height: 20'readOnly>";

               str=str+"</tr>";


           }


        str=str+"</table>";
        str=str+"<input type='hidden' name='index' value=''+i+''>";
        desc.innerHTML="";
        desc.innerHTML=desc.innerHTML+str;


        document.Form1.txtdescIndex.value=k;
 }


function AddGrid()
{

 ItemID[i]=document.Form1.cboGL.value;
 SubItemID[i]=document.Form1.cboItem.value;
 ItemName[i]=document.Form1.cboGL.options[document.Form1.cboGL.selectedIndex].text+"-"+document.Form1.cboItem.options[document.Form1.cboItem.selectedIndex].text;
 //alert("add"+ItemName[i]);
 i++;
 drawList();
}

function deleteRoworder(deleteIndex)
{
        var l=0;

        for (l=deleteIndex;l<k-1;l++)
        {

                orderdescription[l]=orderdescription[l+1];
                orderqty[l]=orderqty[l+1];
                orderrate[l]=orderrate[l+1];
                unitname[l]=unitname[l+1];
                UnitID[l]=UnitID[l+1];
                orderamt[l]=orderamt[l+1];
                
                
                
        }
        k--;
        draworderdesc();
}

function deleteRow(deleteIndex)
{
        var l=0;

        for (l=deleteIndex;l<i-1;l++)
        {

                ItemID[l]=ItemID[l+1];
                SubItemID[l]=SubItemID[l+1];
                ItemName[l]=ItemName[l+1];
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

//alert(i);
//alert("draw"+ItemName[i]);
        if(i<1)
        {
        show.innerHTML="";
        show.innerHTML=show.innerHTML+"";
        document.Form1.txtIndex.value=i;
        return;
        }
        var str='';
        str=str+"<table align='center'  cellpadding='0' cellspacing='0' width='100%'>";
        str=str+"<tr><td colspan='3' class='header_cell_e' align='center'>Stucture</td></tr>";
        str=str+"<tr>";
        str=str+"  <td  align='center' class='title_cell_e'><font size='2'><b>Delete</b></font></td>";
        str=str+"  <td  align='center' class='title_cell_e'><font size='2'><b>SN</b></font></td>";
        str=str+"  <td  align='center' class='title_cell_e'><font size='2'><b>Item</b></font></td>";

        str=str+"</tr>";

        for(var j=0;j<i;j++)
           {
               //Description[j]=replaceAll(Description[j],"'","&#039;");
               str=str+"<tr>";
               str=str+"  <td  align='center' class='td_e'><input type='button' name='Delete["+j+"]' value='Delete' onClick='deleteRow("+j+")' style='width:70' class='forms_button_e'></td>";
               str=str+"  <td  align='center' class='td_e'><input class='input_e' type='text' name='SN["+j+"]' value='"+[j+1]+"' style='width:30' readOnly ></td>";
               str=str+"  <td  align='center' class='td_e'><input class='input_e' type='text' name='ItemName["+j+"]' value='"+ItemName[j]+"'  readOnly></td>";
               str=str+" <input type='hidden' name='ItemID["+j+"]' value='"+ItemID[j]+"' style='width:115; height: 20'readOnly>";
               str=str+" <input type='hidden' name='SubItemID["+j+"]' value='"+SubItemID[j]+"' style='width:115; height: 20'readOnly>";
               str=str+"</tr>";


           }


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
function calamount()
{
      var quantity=parseFloat(document.Form1.txtquty.value);

      var rate=parseFloat(document.Form1.txtRate.value);
      document.Form1.txtorderamt.value=quantity*rate;
}
function caldue()
{
      var amount=parseFloat(document.Form1.txtamount.value);
      var paidamount=parseFloat(document.Form1.txtpaidamount.value);
      document.Form1.txtdueamount.value=amount-paidamount;
}


</script>


</head>

<body class='body_g'>
<form name='Form1' method='post' action='AddToEditOrderEntry.php'>

<?PHP
      echo"<input type='hidden' name='objectid' value='$object_id'>";
        $findexist="SELECT
                                    trn_order_description.order_desc_object_id,
                                    mas_order.order_object_id,
                                    mas_order.job_no,
                                    trn_order_description.order_description,
                                    mas_customer.customer_id,
                                    Company_Name,
                                    office_address,
                                    date_format(mas_order.order_date,'%d-%m-%Y') as order_date,
                                    trn_order_description.order_quntity,
                                    trn_order_description.order_unit ,
                                    trn_order_description.order_rate,
                                    trn_order_description.order_amount,
                                    mas_order.order_unit as mas_order_unit,
                                    total_amount,
                                    vat_status,
                                    date_format(first_proof_date,'%d-%m-%Y') as first_proof_date,
                                    date_format(final_proof_date,'%d-%m-%Y') final_proof_date,
                                    date_format(printing_order_date,'%d-%m-%Y') printing_order_date,
                                    date_format(delivery_date,'%d-%m-%Y') delivery_date,
                                    size,
                                    order_status,
                                    product_status,
                                    paid_on_order_amount,
                                    due_on_delivery_amount,
                                    remarks
                              FROM
                                    mas_order
                                    LEFT JOIN mas_customer ON mas_customer.customer_id = mas_order.customer_id
                                    left join trn_order_description on trn_order_description.order_object_id=mas_order.order_object_id
                              where
                                    mas_order.order_object_id='$object_id'
                              order by
                                     trn_order_description.order_desc_object_id
                  ";
            $rsexist=mysql_query($findexist)or die(mysql_error());
            $i=0;
            while($rowexist=mysql_fetch_array($rsexist))
            {
                  extract($rowexist);
                  $desc[$i]=$order_description;
                  $unit[$i]=$order_unit;
                  $unitrate[$i]=$order_rate;
                  $orderamount[$i]=$order_amount;
                  $orderqty[$i]=$order_quntity;
                  $i++;
            }
            $orderdate=explode("-",$order_date);

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
                <td width='100%' align='center' colspan='4' class='header_cell_e'>Order Entry</td>

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
                        <input type='button' value='Search Customer' name='btnSearch' onClick=\"SearchCustomerPopUp()\" class='forms_button_e' style='width:150px'>
                </td>
                <td width='25%' align='center' class='td_e'> ";
                        //<input type='button' value='Enter' name='btnEnter' class='forms_button_e' style='width:70px' onClick=\"SearchCustomer()\">
                echo "</td>
        </tr>
</table>

";

?>
<br>
<table border='0' width='100%' id='table3' cellspacing='0' class='td_e'>
        <tr>

                  <td  class='caption_e'>Job No.</td>
                  <td>
                        <?PHP
                              echo "<input type='text' name='txtjobno'  class='input_e' value='$job_no' readonly>";
                        ?>
                  </td>
                  <td class='caption_e'>order Date:</td>
                  <td colspan='1' class='td_e'>
                        <select name='cboOrderDay' class='select_e'>
                        <?PHP
                                $D=date('d');
                                comboDay($orderdate[0]);
                        ?>
                        </select>
                        <select name='cboOrderMonth' class='select_e'>
                        <?PHP
                                $M=date('m');
                                comboMonth($orderdate[1]);
                        ?>
                        </select>
                        <select name='cboOrderYear' class='select_e'>
                        <?PHP
                                $Y=date('Y');
                                $PY=$Y-10;
                                $NY=$Y+10;
                                comboYear($PY,$NY,$orderdate[2]);
                        ?>
                        </select>
                  </td>
            </tr>
            <tr>
                  <td class='caption_e'> Unit</td>
                  <td colspan='3'>
                        <?PHP
                              echo "<select name='CmbUnitCombmain' class='select_e'>";
                              createCombo("Unit","mas_unit ","unitid","unitdesc","","$mas_order_unit");
                              echo "</select>";
                        ?>
                  </td>
            <tr>

            <tr>
                  <td  class='button_cell_e' colspan='4'><b>Estimated Date of</b></td>
            </tr>
            <tr>
                  <td class='caption_e' >1st Proof</td>
                  <?PHP
                  echo "
                  <td class='td_e'><input type='text' name='txtfstproofdate' value='$first_proof_date' size='10' class='input_e'>
                  &nbsp;<a href='javascript:ComplainDate1.popup();'>
                                <img src='img/cal.gif' width='13' height='13' border='0' alt='Click Here to Pick up the date'>
                                </a>
                  </td>
                  <td class='caption_e'>Final Proof</td>
                  <td class='td_e'><input type='text' name='txtfinalproofdate' size=10' value='$final_proof_date' class='input_e'>
                  &nbsp;<a href='javascript:ComplainDate2.popup();'>
                                <img src='img/cal.gif' width='13' height='13' border='0' alt='Click Here to Pick up the date'>
                                </a>
                  </td>
                  ";
                  ?>
            </tr>
            <tr>
                  <td class='caption_e'>printing order</td>
                  <?PHP
                  echo"
                  <td class='td_e'><input type='text' name='txtprintorderdate' value='$printing_order_date' size='10' class='input_e'>
                  &nbsp;<a href='javascript:ComplainDate3.popup();'>
                                <img src='img/cal.gif' width='13' height='13' border='0' alt='Click Here to Pick up the date'>
                                </a>
                  </td>
                  <td class='caption_e'>delivery</td>
                  <td class='td_e'><input type='text' name='txtdeliverydate' size='10' value='$delivery_date' class='input_e'>
                        &nbsp;<a href='javascript:ComplainDate4.popup();'>
                                <img src='img/cal.gif' width='13' height='13' border='0' alt='Click Here to Pick up the date'>
                                </a>
                  </td>";
                  ?>
            </tr>
            <tr>
                  <td  class='button_cell_e' colspan='4'><b>Payment Information</b></td>
            </tr>
            <tr>
                  <td class='caption_e' >Paid amount</td>
                  <td class='td_e'>
                  <?PHP
                        echo"<input type='text'  style='text-align:right' value='0' name='txtpaidamount' size='10' value='$paid_on_order_amount' class='input_e' onchange='caldue()'></td>";
                  ?>
                  <td class='caption_e'>Due on Delivery</td>
                  <?PHP
                        echo"<td class='td_e'><input type='text'  style='text-align:right' name='txtdueamount' size='10' value='$due_on_delivery_amount' class='input_e' readonly></td>";
                  ?>
            </tr>
            <tr>
                  <td class='caption_e' >Remarks</td>
                  <td class='td_e' >
                  <?PHP
                        echo"<input type='text' name='txtremarks' size='30' value='$remarks' class='input_e'></td>";
                  ?>
                  <td class='caption_e' >VAT Status</td>
                  <td class='td_e' >
                  <?PHP
                        if($vat_status==1)
                        {
                              echo"<input type='radio' value='1' checked name='vatstatus'> Yes
                                    <input type='radio' value='0' name='vatstatus'> No
                                    ";
                        }
                        else
                        {
                               echo"<input type='radio' value='1'  name='vatstatus'> Yes
                                    <input type='radio' value='0' checked name='vatstatus'> No
                                    ";
                        }
                  ?>
                  </td >

            </tr>

</table>
<br>
<table border='0' width='100%' cellspacing='0' id='table4' class='td_e'>
        <tr>

                <td  class='button_cell_e' colspan='6'><b>Order Description </b></td>

      </tr>
      <tr>
                  <td   class='title_cell_e'>Description:</td>
                  <td   class='title_cell_e'>Quantity</td>
                  <td   class='title_cell_e' >Rate</td>
                  <td   class='title_cell_e' >Unit</td>
                  <td   class='title_cell_e' >Amount</td>
                  <td   class='title_cell_e' >&nbsp;</td>

       </tr>
       <tr>
                  <td align='center'>
                        <input type='text' align='center' name='txtdescription' class='input_e'>
                  </td>
                  <td align='center'>
                        <input type='text' style='text-align:right' name='txtquty' class='input_e' value='0' size='10' onchange='calamount()'>
                  </td>
                  <td align='center'>
                        <input type='text'  style='text-align:right' name='txtRate' class='input_e' value='0' size='10' onchange='calamount()'>
                  </td>
                  <td align='center'>
                        <?PHP
                              echo "<select name='CmbUnitComb' class='select_e'>";
                              createCombo("Unit","mas_unit ","unitid","unitdesc","","");
                              echo "</select>";
                        ?>
                  </td>
                  <td align='center'>
                        <input type='text'  style='text-align:right' name='txtorderamt' class='input_e' value='0' size='10'>
                  </td>
                  <td  align='center' class='td_e'>
                        <input type='button' value='Add' name='btnAddorder' class='forms_button_e' onClick="addtodesc()">
                </td>
     </tr>
</table>
<br>
<table border='0' width='100%' cellspacing='0' id='table4' class='td_e'>

     <tr>

                <td  class='button_cell_e' colspan='4'><b>Order Structure</b></td>

      </tr>
     <tr>
                <td  align='center' class='title_cell_e'>Item</td>
                <td  align='center' class='title_cell_e'>Sub-Itme</td>
                <td  align='center' class='title_cell_e' colspan='2'>&nbsp;</td>
      </tr>
        <tr>
                  <?PHP
                   echo "<td align='center' class='td_e'>
                        <select name='cboGL' onChange=\"SelectItem(this)\" class='select_e'>";
                              $searchMasItem="select
                                                      itemcode ,
                                                      itemdescription
                                                from
                                                      mas_item
                                                where
                                                      parent_itemcode='0'
                                                order by itemdescription
                                                ";

                              createQueryCombo("Item",$searchMasItem,"-1","");
                        echo"
                        </select></td> ";


                  //echo $searchMasItem;
                  echo "<td align='center' class='td_e'>
                        <span id='GridTest'>
                              <select name='cboItem' class='select_e'>
                                    <option value='-1'>Select a Sub-Item</option>
                              </select>
                        </span>

                  </td>";
                  ?>
                  

                <td  align='center' class='td_e'>
                        <input type='button' value='Add' name='btnAdd' class='forms_button_e' onClick="AddGrid()">
                </td>
        </tr>
</table>
<br>
<table border='0'  width='100%' cellpadding='0' cellspacing='0'  bordercolor='#111111'>
        <tr>
                <td  align='center' class='td_e'>
                        <input type='button' value='Submit' name='btnSubmit' onClick="CheckValue()" class='forms_button_e' style='width:120px' >

                </td>
        </tr>
</table>
<br>
<table border='0' width='90%'cellpadding='0' align='center' cellspacing='0'  bordercolor='#111111'>
        <tr>
                <td  align='center' >
                        <span ID='desc'>

                        </span>
                </td>
        </tr>
</table>
<table border='0' width='90%'cellpadding='0' align='center' cellspacing='0'  bordercolor='#111111'>
        <tr>
                <td  align='center' >
                        <span ID='show'>

                        </span>
                </td>
        </tr>
</table>

<input type='hidden' name='txtIndex' value='0'>
<input type='hidden' name='txtdescIndex' value='0'>


</form>

<script language='JavaScript'>
       //alert("salim");
        var trn_order_desc=new Array(100);
        var trn_order_quantity=new Array(100);
        var trn_order_rate=new Array(100);
        var trn_order_amount=new Array(100);
        var trn_order_unit=new Array(100);
        var trn_order_unit_name=new Array(100);
        var trn_order_item=new Array(100);
        var trn_order_subitem=new Array(100);
        var trn_order_item_name=new Array(100);
        var trn_order_subitem_name=new Array(100);
        var totaltrn_order_desc_row=0;
        var totaltrn_struct_row=0;

<?PHP
        // select Nominee information
        $querytrn_order_desc="
                              SELECT
                                    order_desc_object_id,
                                    order_object_id,
                                    order_description,
                                    order_quntity,
                                    order_rate,
                                    order_unit,
                                    order_amount
                              FROM
                                    trn_order_description
                              WHERE
                                    order_object_id='$object_id'
                        ";
         //echo $MasTrnInvoiceInfo;

        $resulttrn_order_desc=mysql_query($querytrn_order_desc) or die(mysql_error());
        $j=0;
        while($rowtrn_order_desc=mysql_fetch_array($resulttrn_order_desc))
        {
            extract($rowtrn_order_desc);
            $unit=pick("mas_unit","unitdesc","unitid=$order_unit");
            echo   "trn_order_desc[$j]=\"$order_description\";";
            echo   "trn_order_quantity[$j]=\"$order_quntity\";";
            echo   "trn_order_rate[$j]=\"$order_rate\";";
            echo   "trn_order_amount[$j]=\"$order_amount\";";
            echo   "trn_order_unit[$j]=\"$order_unit\";";
            echo   "trn_order_unit_name[$j]=\"$unit\";";


               $j++;
        }
         echo "totaltrn_order_desc_row=$j;";
         
         $querytrn_structure="SELECT
                                    trn_order_object_id,
                                    order_object_id,
                                    mas_item,
                                    sub_item
                              FROM
                                    trn_order
                              WHERE
                                    order_object_id='$object_id'
                              ";
         $rstrn_structure=mysql_query($querytrn_structure)or die(mysql_error());
         $j=0;
         while($rowtrn_structure=mysql_fetch_array($rstrn_structure))
         {
            extract($rowtrn_structure);
            $itemname=pick("mas_item","itemdescription","itemcode='$mas_item'");
            $subitmename=pick("mas_item","itemdescription","itemcode='$sub_item'");
            echo   "trn_order_item[$j]=\"$mas_item\";";
            echo   "trn_order_subitem[$j]=\"$sub_item\";";
            echo   "trn_order_item_name[$j]=\"$itemname\";";
            echo   "trn_order_subitem_name[$j]=\"$subitmename\";";
            
            $j++;
         }
            echo "totaltrn_struct_row=$j;";
         
         echo "copyRecords(trn_order_desc,trn_order_quantity,trn_order_rate,trn_order_amount,trn_order_unit,trn_order_unit_name,trn_order_item,trn_order_subitem,trn_order_item_name,trn_order_subitem_name,totaltrn_order_desc_row,totaltrn_struct_row);";


?>


</script>



<script language="JavaScript">

        // create calendar object(s) just after form tag closed
        // specify form element as the only parameter (document.forms['formname'].elements['inputname']);
        // note: you can have as many calendar objects as you need for your application

        var ComplainDate1 = new calendar1(document.forms['Form1'].elements['txtfstproofdate']);
        var ComplainDate2 = new calendar1(document.forms['Form1'].elements['txtfinalproofdate']);
        var ComplainDate3 = new calendar1(document.forms['Form1'].elements['txtprintorderdate']);
        var ComplainDate4 = new calendar1(document.forms['Form1'].elements['txtdeliverydate']);
        ComplainDate1 .year_scroll = true;
        ComplainDate1 .time_comp = false;
</script>

</body>

</html>

