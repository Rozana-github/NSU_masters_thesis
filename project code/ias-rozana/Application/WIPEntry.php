<?PHPPHPPHPPHP
       session_start();

        include_once("Library/dbconnect.php");
        include "Library.php";
?>
<html>

<head>
<meta http-equiv="Content-Language" content="en-us">
<meta content="Author" name="Md.Sharif Ur Rahman">
<title>LC</title>

<script language="JavaScript" src="Script/calendar1.js"></script>
<!--<script language="JavaScript" src="calendar1.js"></script>-->
<script language="javascript">
      //---------------------------- xml test---------------------*/
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

      //------------------------------------------- end---------------------------------------------------/
      // ------------------------------ Searc Bank Account --- Create By Sharif --------------------------/
      function setAccount(val,cboLC)
      {
                  //alert(val.value);
                  //alert(cboLC);
                  //var ACNO=cboLC.value;
                  var BANKID=val.value;
                  var FunctionName="createCombo";
                  var ComboName="cboBanKAccount";
                  var SelectA="Account";
                  var TableName="trn_bank";
                  var ID="account_object_id";
                  var Name="account_no";
                  var Condition=escape("where bank_id='"+BANKID+"'");
                  var selectedValue="'"+cboLC+"'";
                  //alert(selectedValue);
                  var URLQuery="FunctionName="+FunctionName+"&ComboName="+ComboName+"&SelectA="+SelectA+"&TableName="+TableName+"&ID="+ID+"&Name="+Name+"&Condition="+Condition+"&selectedValue="+selectedValue+"&OnChangeEvent=''";
                  callServer(URLQuery);
      }
      function callServer(URLQuery)
      {
            var url = "Library/AjaxLibrary.php";

            xmlHttp.open("POST", url, true);

            xmlHttp.setRequestHeader("Method", "POST " + url + " HTTP/1.1");
            xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            xmlHttp.onreadystatechange = ShowBankAccount;
            xmlHttp.send(URLQuery);
      }
      function ShowBankAccount()
      {
            if (xmlHttp.readyState == 4)
            {
                  var response1 = xmlHttp.responseText;
                  window.GridAAC.innerHTML="";
                  window.GridAAC.innerHTML=response1;
            }
      }
      
      
      //------------------------------------------- end---------------------------------------------------/


      function SelectLC()
      {
            document.Form1.action="StoreLCEntry.php";
            document.Form1.submit();
      }
      function ShowDetail()
      {
           document.Form1.action="WIPEntry.php";
           document.Form1.submit();
      }
      function deleterow(wipobjectid)
      {
            document.Form1.action="WIPEntry.php?deletrow=1&objectid="+wipobjectid+"";
            document.Form1.submit();
      }
      
      function setvalue(i)
      {
          document.Form1.txtpDate.value=document.Form1.elements["hipdate["+i+"]"].value;
          document.Form1.cbocompany.value=document.Form1.elements["hicompany["+i+"]"].value;
          document.Form1.txtjobno.value=document.Form1.elements["hijobno["+i+"]"].value;
          document.Form1.txtjobname.value=document.Form1.elements["hijobname["+i+"]"].value;
          document.Form1.txtjobquantity.value=document.Form1.elements["hiquantity["+i+"]"].value;
          document.Form1.cboetype.value=document.Form1.elements["hietype["+i+"]"].value;
          document.Form1.txtbpqty.value=document.Form1.elements["hibpqty["+i+"]"].value;
          document.Form1.txtbprate.value=document.Form1.elements["hibprate["+i+"]"].value;
          document.Form1.txtinkqty.value=document.Form1.elements["hiinkqty["+i+"]"].value;
          document.Form1.txtinkrate.value=document.Form1.elements["hiinkrate["+i+"]"].value;
          document.Form1.txtpetqty.value=document.Form1.elements["hipetqty["+i+"]"].value;
          document.Form1.txtpetrate.value=document.Form1.elements["hipetrate["+i+"]"].value;
          document.Form1.txtadveqty.value=document.Form1.elements["hiadiveqty["+i+"]"].value;
          document.Form1.txtadverate.value=document.Form1.elements["hiadiverate["+i+"]"].value;
          document.Form1.txtsolvtqty.value=document.Form1.elements["hisolvtqty["+i+"]"].value;
          document.Form1.txtsolvtrate.value=document.Form1.elements["hisolvtrate["+i+"]"].value;
          document.Form1.txtMcppqty.value=document.Form1.elements["himcppqty["+i+"]"].value;
          document.Form1.txtMcpprate.value=document.Form1.elements["himcpprate["+i+"]"].value;
          document.Form1.txtmpetqty.value=document.Form1.elements["himpetqty["+i+"]"].value;
          document.Form1.txtmpetrate.value=document.Form1.elements["himpetrate["+i+"]"].value;
          document.Form1.txtfoilqty.value=document.Form1.elements["hifoilqty["+i+"]"].value;
          document.Form1.txtfoilrate.value=document.Form1.elements["hifoilrate["+i+"]"].value;
          document.Form1.txtlfqty.value=document.Form1.elements["hilfqty["+i+"]"].value;
          document.Form1.txtlfrate.value=document.Form1.elements["hilfrate["+i+"]"].value;
          document.Form1.txtmfqty.value=document.Form1.elements["himfqty["+i+"]"].value;
          document.Form1.txtmfrate.value=document.Form1.elements["himfrate["+i+"]"].value;
          document.Form1.txttmcost.value=document.Form1.elements["hitmcost["+i+"]"].value;
          document.Form1.txtoh.value=document.Form1.elements["hioh["+i+"]"].value;
          document.Form1.txtohrate.value=document.Form1.elements["hioh_rate["+i+"]"].value;
          document.Form1.txttcost.value=document.Form1.elements["hitcost["+i+"]"].value;
          document.Form1.btnsubmit.value='Update';

          
      }
      
      function calculateTMCost()
      {
          TMCost=0;
          TMCost=TMCost+parseFloat(document.Form1.txtbpqty.value)*parseFloat(document.Form1.txtbprate.value);
          TMCost=TMCost+parseFloat(document.Form1.txtinkqty.value)*parseFloat(document.Form1.txtinkrate.value);
          TMCost=TMCost+parseFloat(document.Form1.txtpetqty.value)*parseFloat(document.Form1.txtpetrate.value);
          TMCost=TMCost+parseFloat(document.Form1.txtadveqty.value)*parseFloat(document.Form1.txtadverate.value);
          TMCost=TMCost+parseFloat(document.Form1.txtsolvtqty.value)*parseFloat(document.Form1.txtsolvtrate.value);
          TMCost=TMCost+parseFloat(document.Form1.txtMcppqty.value)*parseFloat(document.Form1.txtMcpprate.value);
          TMCost=TMCost+parseFloat(document.Form1.txtmpetqty.value)*parseFloat(document.Form1.txtmpetrate.value);
          TMCost=TMCost+parseFloat(document.Form1.txtfoilqty.value)*parseFloat(document.Form1.txtfoilrate.value);
          TMCost=TMCost+parseFloat(document.Form1.txtlfqty.value)*parseFloat(document.Form1.txtlfrate.value);
          TMCost=TMCost+parseFloat(document.Form1.txtmfqty.value)*parseFloat(document.Form1.txtmfrate.value);
          document.Form1.txttmcost.value=TMCost;
      }
      function calculateoh()
      {
            document.Form1.txtoh.value=(parseFloat(document.Form1.txttmcost.value)*parseFloat(document.Form1.txtohrate.value))/100;
            document.Form1.txttcost.value=parseFloat(document.Form1.txtoh.value)+parseFloat(document.Form1.txttmcost.value);
      }
      function calculatetotalcost()
      {

      }
      

      var DeleteCheck=new Array(100);
      var TrnOnjectID=new Array(100);
      var ItemID=new Array(100);
      var ItemName=new Array(100);

      var ItemUnit=new Array(100);
      var ItemUnitValue=new Array(100);

      var Rate=new Array(100);
      var RequiredQuantity=new Array(100);
      var Remarks=new Array(100);

      var i=0;
      var delnum=0;

      function copyRecords(dbDeleteCheck,dbTrnOnjectID,dbItemID,dbItemName,dbRate,dbRequiredQuantity,dbRemarks,dbItemUnit,dbItemUnitValue,Numrows)
      {
            //alert(Numrows);
            for(var l=0;l<Numrows;l++)
            {
                  //alert(Remarks[l]);
                  DeleteCheck[l]=dbDeleteCheck[l];
                  TrnOnjectID[l]=dbTrnOnjectID[l];
                  ItemID[l]=dbItemID[l];
                  ItemName[l]=dbItemName[l];

                  ItemUnit[l]=dbItemUnit[l];
                  ItemUnitValue[l]=dbItemUnitValue[l];

                  Rate[l]=dbRate[l];
                  RequiredQuantity[l]=dbRequiredQuantity[l];
                  Remarks[l]=dbRemarks[l];
            }
            i=Numrows;
            //alert(i);
            drawList();
      }

      function AddGrid()
      {

            if(document.Form1.cboGL.value==-1)
            {
                  alert("Please Select any GL");
                  document.Form1.cboGL.focus();
                  return;
            }
            var Index=document.Form1.txtIndex.value;
            for(var s=0; s<Index;s++)
            {
                  if(document.Form1.cboItem.value==ItemID[s])
                  {
                        alert("You can't enter same item");
                        document.Form1.cboItem.focus();
                        return;
                  }
            }

            DeleteCheck[i]='-1';
            TrnOnjectID[i]='-1';
            ItemID[i]=document.Form1.cboItem.value;
            ItemName[i]=document.Form1.cboGL.options[document.Form1.cboGL.selectedIndex].text+"-"+document.Form1.cboItem.options[document.Form1.cboItem.selectedIndex].text;
            ItemUnit[i]=Form1.CmbUnitComb.options[Form1.CmbUnitComb.selectedIndex].text;
            ItemUnitValue[i]=Form1.CmbUnitComb.value;
            Rate[i]=document.Form1.txtRate.value;
            RequiredQuantity[i]=document.Form1.txtRequiredQuantity.value;
            // alert(document.Form1.txtRemarks.value);
            Remarks[i]=document.Form1.txtTrnRemarks.value;
            i++;
            drawList();
      }

      function deleteRow(deleteIndex)
      {
            var k=0;
            if(TrnOnjectID[deleteIndex]!='-1')
            {
                  DeletedOrder.innerHTML=DeletedOrder.innerHTML+"<input type='hidden' name='DelTrnOnjectID["+delnum+"]' value='"+TrnOnjectID[deleteIndex]+"'>";
                  delnum++;
                  Form1.txtDeleteIndex.value=delnum;
            }

            for (k=deleteIndex;k<i-1;k++)
            {
                  ItemID[k]=ItemID[k+1];
                  ItemName[k]=ItemName[k+1];

                  ItemUnit[k]=ItemUnit[k+1];
                  ItemUnitValue[k]=ItemUnitValue[k+1];

                  Rate[k]=Rate[k+1];
                  RequiredQuantity[k]=RequiredQuantity[k+1];
                  Remarks[k]=Remarks[k+1];
            }
            i--;
            drawList();
      }

      function drawList()
      {
            if(i<1)
            {
                  show.innerHTML="";
                  show.innerHTML=show.innerHTML+"Empty: No Information exist.";
                  return;
            }
            var str='';
            str=str+"<table align='center' width='100%' cellpadding='0' cellspacing='0'>";

                  str=str+"<tr>";
                        str=str+"  <td  class='top_left_curb'></td>";
                        str=str+"  <td   colspan='6' align='center' class='header_cell_e'>LC &nbsp;Record</td>";
                        str=str+"  <td  class='top_right_curb'></td>";
                  str=str+"</tr>";
        
                  str=str+"<tr>";
                        str=str+"  <td  class='lb'></td>";
        
                        str=str+"  <td  align='center' class='title_cell_e'>Delete</td>";
                        str=str+"  <td  align='center' class='title_cell_e'><b>Item</b></td>";
                        str=str+"  <td  align='center' class='title_cell_e'><b>Unit</b></td>";
                        str=str+"  <td  align='center' class='title_cell_e'><b>Rate</b></td>";
                        str=str+"  <td  align='center' class='title_cell_e'><b>Required Quantity</b></td>";
                        str=str+"  <td  align='center' class='title_cell_e'><b>Remarks</b></td>";

                        str=str+"  <td class='rb'></td>";
                  str=str+"</tr>";

            for(var j=0;j<i;j++)
            {
                  str=str+"<tr>";
                        str=str+"  <td class='lb'></td>";
                        str=str+"  <td align='center' class='td_e'><input type='button' name='Delete["+j+"]' value='Delete' onClick='deleteRow("+j+")'  style='width:50; height: 20' class='forms_button_e'></td>";
                        str=str+"  <td align='center' class='td_e'><input type='text' name='ItemName["+j+"]' value='"+ItemName[j]+"' class='input_e'></td>";
                        str=str+"  <td align='center' class='td_e'><input type='hidden' name='ItemUnitValue["+j+"]' value='"+ItemUnitValue[j]+"'  size='5'><input type='text' name='ItemUnit["+j+"]' value='"+ItemUnit[j]+"'  size='5' readonly></td>";
                        str=str+"  <td align='center' class='td_e'><input type='text' name='Rate["+j+"]' value='"+Rate[j]+"'  style='width:100; height: 20' class='input_e'></td>";
                        str=str+"  <td align='center' class='td_e'><input type='text' name='RequiredQuanity["+j+"]' value='"+RequiredQuantity[j]+"'  style='width:150; height: 20' class='input_e'></td>";
                        str=str+"  <td align='center' class='td_e'><input type='text' name='Remarks["+j+"]' value='"+Remarks[j]+"'  style='width:220; height: 20' class='input_e'></td>";
                        str=str+"  <td class='rb'></td>";
               
                        str=str+" <input type='hidden' name='ItemID["+j+"]' value='"+ItemID[j]+"' style='width:115; height: 20'readOnly>";
                        str=str+" <input type='hidden' name='TrnOnjectID["+j+"]' value='"+TrnOnjectID[j]+"'  style='width:115; height: 20'readOnly>";

                  str=str+"</tr>";

            }
                  str=str+"<tr>";
                        str=str+"  <td  class='bottom_l_curb'></td>";
                        str=str+"  <td  class='bottom_f_cell' colspan='6' ></td>";
                        str=str+"  <td  class='bottom_r_curb'></td>";
                  str=str+"</tr>";
        
            str=str+"</table>";
            str=str+"<input type='hidden' name='index' value=''+i+''>";
            show.innerHTML="";
            show.innerHTML=show.innerHTML+str;
            document.Form1.txtIndex.value=i;
      }

      function CheckGrid()
      {
            if(document.Form1.txtIndex.value<1)
            {
                  alert("Please add any item to the grid");
                  document.Form1.cboGL.focus();
                  return;
            }
            document.Form1.submit();

      }

</script>
      <link rel='stylesheet' type='text/css' href='Style/eng_form.css'>
      <link rel='stylesheet' type='text/css' href='Style/generic_form.css'>
</head>

<body class='body_e'>
<form name="Form1" method="post" action="AddToWIPEntry.php">
<?PHPPHPPHPPHP
      /*------------------ Modification ,Indentation & Add CSS BY: MD.SHARIF UR RAHMAN ------------------------*/

      /*--------------------------------------- New Table ----------------------------------------------*/
        //$cboMonth=date("m");
        //$cboYear=date("Y");
        if($deletrow=='1')
        {
            $querydel="delete from mas_wip where wipobjectid='$objectid'";
            mysql_query($querydel) or die(mysql_error());
        }
      echo"

      <table border='0' width='100%' id='table1' cellpadding='0' cellspacing='0'>
            <tr>
                  <td class='top_left_curb'></td>
                  <td align='center' colspan='4' class='header_cell_e'>WIP / Finish Goods Stock Entry</td>
                  <td class='top_right_curb'></td>
            </tr>
            <tr>
                  <td class='lb' ></td>
                  <td class='caption_e'>Year</td>
                  <td class='td_e'>
                        <select name='cboYear'  class='select_e' onchange='ShowDetail()'>";
                           comboYear("","",$cboYear);
                        echo"
                        </select>
                  </td>
                  <td class='caption_e'>Month</td>
                  <td class='td_e'>
                        <select name='cboMonth'  class='select_e' onchange='ShowDetail()'>";
                              comboMonth($cboMonth);
                        echo "
                        </select>";



                        echo "
                  </td>


                  <td class='rb' ></td>
            </tr>
            <tr>
                  <td class='lb' ></td>
                  <td class='caption_e'>P.Date:</td>
                  <td class='td_e'>
                        <input type='text' name='txtpDate' value='' size='12' class='input_e'>
                        <a href='javascript:OpenDate.popup();'><img src='img/cal.gif' width='13' height='15' border='0' alt='Click Here to Pick up the date'>
                        <script>
                              var OpenDate=new calendar1(document.forms['Form1'].elements['txtpDate']);
                              OpenDate.year_scroll=true;
                              OpenDate.time_comp=false;
                        </script>
                  </td>
                  <td class='caption_e'>Company Name:</td>
                  <td class='td_e'>
                        <select name='cbocompany' class='select_e'>";
                              createCombo("company","mas_supplier","supplier_id","company_name","","");
                  echo "</select>
                        </td>
                        <td class='rb' ></td>
                   </tr>
                   <tr>
                        <td class='lb' ></td>
                        <td class='caption_e'>Job No.</td>
                        <td class='td_e'>
                              <input type='text' name='txtjobno' size='20' value='' class='input_e'>
                        </td>

                        <td class='caption_e'>Job Name:</td>
                        <td class='td_e'>
                              <input type='text' name='txtjobname' size='20' value='' class='input_e'>
                        </td>
                        <td class='rb' ></td>
                  </tr>
                  <tr>
                        <td class='lb' ></td>
                        <td class='caption_e'>Job Quantity</td>
                        <td class='td_e' >
                              <input type='text' name='txtjobquantity' value='' class='input_e'>
                        </td>
                        <td class='caption_e'>E-Type</td>
                        <td calss='td_e'>
                              <select name='cboetype' class='select_e'>
                                    <option value='-1'>Select E-Type</option>
                                    <option value='1'>R/D</option>
                                    <option value='2'>P/C</option>
                                    <option value='3'>L/C</option>
                              </select>
                        </td>
                        <td class='rb' ></td>
                  </tr>
                  </table>
                   <table border='0' width='100%' id='table1' cellpadding='0' cellspacing='0'>
                  <tr>
                        <td class='lb' ></td>
                        <td class='title_cell_e'>&nbsp;</td>
                        <td class='title_cell_e' align='center'>Quantity</td>
                        <td class='title_cell_e' align='center'>Rate</td>

                        <td class='rb' ></td>
                  </tr>
                  <tr>
                        <td class='lb' ></td>
                        <td class='caption_e'>BOPP</td>
                        <td class='td_e' align='center'>
                              <input type='text' name='txtbpqty' style='text-align: right' value='0' class='input_e' size='10'>
                        </td>
                        <td class='td_e' align='center'>
                              <input type='text' name='txtbprate' style='text-align: right' value='0' class='input_e' size='10'>
                        </td>

                        <td class='rb' ></td>
                  </tr>
                  <tr>
                        <td class='lb' ></td>
                        <td class='caption_e'>Ink</td>
                        <td class='td_e' align='center'>
                              <input type='text' name='txtinkqty' style='text-align: right' value='0' class='input_e' size='10'>
                        </td>
                        <td class='td_e' align='center'>
                              <input type='text' name='txtinkrate' style='text-align: right' value='0' class='input_e' size='10'>
                        </td>

                        <td class='rb' ></td>
                  </tr>
                  <tr>
                        <td class='lb' ></td>
                        <td class='caption_e'>Pet</td>
                        <td class='td_e' align='center'>
                              <input type='text' name='txtpetqty' style='text-align: right' value='0' class='input_e' size='10'>
                        </td>
                        <td class='td_e' align='center'>
                              <input type='text' name='txtpetrate' style='text-align: right' value='0' class='input_e' size='10'>
                        </td>

                        <td class='rb' ></td>
                  </tr>
                  <tr>
                        <td class='lb' ></td>
                        <td class='caption_e'>Adve.</td>
                        <td class='td_e' align='center'>
                              <input type='text' name='txtadveqty' style='text-align: right' value='0' class='input_e' size='10'>
                        </td>
                        <td class='td_e' align='center'>
                              <input type='text' name='txtadverate' style='text-align: right' value='0' class='input_e' size='10'>
                        </td>

                        <td class='rb' ></td>
                  </tr>
                  <tr>
                        <td class='lb' ></td>
                        <td class='caption_e'>Solvt.</td>
                        <td class='td_e' align='center'>
                              <input type='text' name='txtsolvtqty' style='text-align: right' value='0' class='input_e' size='10'>
                        </td>
                        <td class='td_e' align='center'>
                              <input type='text' name='txtsolvtrate' style='text-align: right' value='0' class='input_e' size='10'>
                        </td>

                        <td class='rb' ></td>
                  </tr>
                  <tr>
                        <td class='lb' ></td>
                        <td class='caption_e' >Mcpp</td>
                        <td class='td_e' align='center'>
                              <input type='text' name='txtMcppqty' style='text-align: right' value='0' class='input_e' size='10'>
                        </td>
                        <td class='td_e' align='center'>
                              <input type='text' name='txtMcpprate' style='text-align: right' value='0' class='input_e' size='10'>
                        </td>

                        <td class='rb' ></td>
                  </tr>
                  <tr>
                        <td class='lb' ></td>
                        <td class='caption_e' >Mpet.</td>
                        <td class='td_e' align='center'>
                              <input type='text' name='txtmpetqty' style='text-align: right' value='0' class='input_e' size='10'>
                        </td>
                        <td class='td_e' align='center'>
                              <input type='text' name='txtmpetrate' style='text-align: right' value='0' class='input_e' size='10'>
                        </td>

                        <td class='rb' ></td>
                  </tr>
                  <tr>
                        <td class='lb' ></td>
                        <td class='caption_e' align='center'>Foil</td>
                        <td class='td_e' align='center'>
                              <input type='text' name='txtfoilqty' style='text-align: right' value='0' class='input_e' size='10'>
                        </td>
                        <td class='td_e' align='center'>
                              <input type='text' name='txtfoilrate' style='text-align: right' value='0' class='input_e' size='10'>
                        </td>

                        <td class='rb' ></td>
                  </tr>
                  <tr>
                        <td class='lb' ></td>
                        <td class='caption_e'>L.F</td>
                        <td class='td_e' align='center'>
                              <input type='text' name='txtlfqty' style='text-align: right' value='0' class='input_e' size='10'>
                        </td>
                        <td class='td_e' align='center'>
                              <input type='text' name='txtlfrate' style='text-align: right' value='0' class='input_e' size='10'>
                        </td>

                        <td class='rb' ></td>
                  </tr>
                  <tr>
                        <td class='lb' ></td>
                        <td class='caption_e' >M.F</td>
                        <td class='td_e' align='center'>
                              <input type='text' name='txtmfqty' style='text-align: right' value='0' class='input_e' size='10'>
                        </td>
                        <td class='td_e' align='center'>
                              <input type='text' name='txtmfrate' style='text-align: right' value='0' class='input_e' size='10'>
                        </td>

                        <td class='rb' ></td>
                  </tr>
                  </table>
                   <table border='0' width='100%' id='table1' cellpadding='0' cellspacing='0'>
                  <tr>
                        <td class='lb' ></td>
                        <td class='title_cell_e'>T.M.Cost</td>
                        <td class='title_cell_e'>O.H Ratio</td>
                        <td class='title_cell_e'>O.H</td>
                        <td class='title_cell_e'>T.Cost</td>

                        <td class='rb' ></td>
                  </tr>
                  <tr>
                        <td class='lb' ></td>
                        <td class='td_e' align='center'>
                              <input type='text' name='txttmcost' style='text-align: right'  value='0' class='input_e' size='10' onfocus='calculateTMCost()' readonly>
                        </td>
                        <td class='td_e' align='center'>
                              <input type='text' name='txtohrate' style='text-align: right' value='0' class='input_e' size='10' onblur='calculateoh()'>
                        </td>
                        <td class='td_e' align='center'>
                              <input type='text' name='txtoh' style='text-align: right' value='0' class='input_e' size='10' readonly>
                        </td>
                        <td class='td_e' align='center'>
                              <input type='text' name='txttcost' style='text-align: right' value='0' class='input_e' size='10' readonly>
                        </td>

                        <td class='rb' ></td>
                  </tr>
                  

            <tr>
                  <td class='lb' ></td>
                  <td class='button_cell_e' colspan='4' align='center'>
                        <input type='submit' name='btnsubmit' value='Save' class='forms_button_e'>
                  </td>
                  <td class='rb' ></td>
            </tr>
            <tr>
                  <td class='bottom_l_curb'></td>
                  <td class='bottom_f_cell'colspan='4'></td>
                  <td class='bottom_r_curb'></td>
            </tr>
      </table>";
      /*--------------------------------------- New Table ----------------------------------------------*/


?>

<?PHPPHPPHPPHP/*---------------------------------- -----------------------------------------------------------------*/?>

<?PHPPHPPHPPHP/*---------------------------------- -----------------------------------------------------------------*/?>

<?PHPPHPPHPPHP/*---------------------------------- -----------------------------------------------------------------*/?>


<?PHPPHPPHPPHP
      $TrnLCInfo="select
                        wipobjectid,
                        date_format(`pdate`,'%d-%m-%Y') as pdate,
                        `wip_month`,
                        `wip_year`,
                        `job_no`,
                        `job_name`,
                        `company_id`,
                        `job_quantity`,
                        `pet_quantity`,
                        `pet_rate`,
                        `bopp_quantity`,
                        `bopp_rate`,
                        `ink_quantity`,
                        `ink_rate`,
                        `adive_quantity`,
                        `adive_rate`,
                        `solvt_quantity`,
                        `solvt_rate`,
                        `mcpp_quantity`,
                        `mcpp_rate`,
                        `mpet_quantity`,
                        `mpet_rate`,
                        `foil_quantity`,
                        `foil_rate`,
                        `lf_quantity`,
                        `lf_rate`,
                        `mf_quantity`,
                        `mf_rate`,
                        `tm_cost`,
                        `oh`,
                        oh_rate,
                        `t_cost`,
                        `e_type`,
                        company_name

                  from
                        mas_wip
                        LEFT JOIN mas_supplier ON mas_supplier.supplier_id=mas_wip.company_id
                  where
                        wip_month='$cboMonth'
                        and wip_year='$cboYear'
                  ";
      //echo  $TrnLCInfo;

      $resultTrnLCInfo=mysql_query($TrnLCInfo) or die(mysql_error());
      $j=0;
      if(mysql_num_rows($resultTrnLCInfo)>0)
      {
            echo "<table border='1' width='100%' id='table1' cellpadding='0' cellspacing='0'>
                  <tr>
                        <td class='title_cell_e'>P.Date</td>
                        <td class='title_cell_e'>Job No</td>
                        <td class='title_cell_e'>Job Name</td>
                        <td class='title_cell_e'>Company</td>
                        <td class='title_cell_e'>Kg</td>
                        <td class='title_cell_e'>Pet</td>
                        <td class='title_cell_e'>Bopp</td>
                        <td class='title_cell_e'>Ink</td>
                        <td class='title_cell_e'>Adive.</td>
                        <td class='title_cell_e'>Solvt.</td>
                        <td class='title_cell_e'>Mcpp</td>
                        <td class='title_cell_e'>Mpet</td>
                        <td class='title_cell_e'>Foil</td>
                        <td class='title_cell_e'>L.F</td>
                        <td class='title_cell_e'>M.F</td>
                        <td class='title_cell_e'>T.M.Cost</td>
                        <td class='title_cell_e'>O.H</td>
                        <td class='title_cell_e'>T.Cost</td>
                        <td class='title_cell_e'>&nbsp;</td>
                  </tr>";
            while($rowTrnLCInfo=mysql_fetch_array($resultTrnLCInfo))
            {
                  extract($rowTrnLCInfo);
                  if($e_type=='1')
                        $edesc="R/D";
                  else if($e_type=='2')
                        $edesc="P/C";
                  else if($e_type=='3')
                        $edesc="L/C";
                  else
                        $edesc="";

                  echo"<tr style=\"cursor:hand\" onclick='setvalue($j)'>
                        <input type='hidden' name='hipdate[$j]' value='$pdate'>
                        <input type='hidden' name='hijobno[$j]' value='$job_no'>
                        <input type='hidden' name='hijobname[$j]' value='$job_name'>
                        <input type='hidden' name='hicompany[$j]' value='$company_id'>
                        <input type='hidden' name='hiquantity[$j]' value='$job_quantity'>
                        <input type='hidden' name='hietype[$j]' value='$e_type'>
                        <input type='hidden' name='hibpqty[$j]' value='$bopp_quantity'>
                        <input type='hidden' name='hibprate[$j]' value='$bopp_rate'>
                        <input type='hidden' name='hiinkqty[$j]' value='$ink_quantity'>
                        <input type='hidden' name='hiinkrate[$j]' value='$ink_rate'>
                        <input type='hidden' name='hipetqty[$j]' value='$pet_quantity'>
                        <input type='hidden' name='hipetrate[$j]' value='$pet_rate'>
                        <input type='hidden' name='hiadiveqty[$j]' value='$adive_quantity'>
                        <input type='hidden' name='hiadiverate[$j]' value='$adive_rate'>
                        <input type='hidden' name='hisolvtqty[$j]' value='$solvt_quantity'>
                        <input type='hidden' name='hisolvtrate[$j]' value='$solvt_rate'>
                        <input type='hidden' name='himcppqty[$j]' value='$mcpp_quantity'>
                        <input type='hidden' name='himcpprate[$j]' value='$mcpp_rate'>
                        <input type='hidden' name='himpetqty[$j]' value='$mpet_quantity'>
                        <input type='hidden' name='himpetrate[$j]' value='$mpet_rate'>
                        <input type='hidden' name='hifoilqty[$j]' value='$foil_quantity'>
                        <input type='hidden' name='hifoilrate[$j]' value='$foil_rate'>
                        <input type='hidden' name='hilfqty[$j]' value='$lf_quantity'>
                        <input type='hidden' name='hilfrate[$j]' value='$lf_rate'>
                        <input type='hidden' name='himfqty[$j]' value='$mf_quantity'>
                        <input type='hidden' name='himfrate[$j]' value='$mf_rate'>
                        <input type='hidden' name='hitmcost[$j]' value='$tm_cost'>
                        <input type='hidden' name='hioh[$j]' value='$oh'>
                        <input type='hidden' name='hioh_rate[$j]' value='$oh_rate'>
                        <input type='hidden' name='hitcost[$j]' value='$t_cost'>
                        <td class='td_e' align='center'>$pdate</td>
                        <td class='td_e' align='center'>$job_no</td>
                        <td class='td_e' align='center'>$job_name</td>
                        <td class='td_e' align='center'>$company_name($edesc)</td>
                        <td class='td_e' align='Right'>$job_quantity</td>
                        <td class='td_e' align='Right'>$pet_quantity</td>
                        <td class='td_e' align='Right'>$bopp_quantity</td>
                        <td class='td_e' align='Right'>$ink_quantity</td>
                        <td class='td_e' align='Right'>$adive_quantity</td>
                        <td class='td_e' align='Right'>$solvt_quantity</td>
                        <td class='td_e' align='Right'>$mcpp_quantity</td>
                        <td class='td_e' align='Right'>$mpet_quantity</td>
                        <td class='td_e' align='Right'>$foil_quantity</td>
                        <td class='td_e' align='Right'>$lf_quantity</td>
                        <td class='td_e' align='Right'>$mf_quantity</td>
                        <td class='td_e' align='Right'>$tm_cost</td>
                        <td class='td_e' align='Right'>$oh</td>
                        <td class='td_e' align='Right'>$t_cost</td>
                        <td class='td_e' align='Right'>
                              <input type='button' name='btndelet' value='Delete' class='forms_button_e' onclick='deleterow($wipobjectid)'>
                        </td>
                  </tr>" ;
                  $j++;
            }
            echo"</table>" ;
      }
      //echo "Numrows=$j;";
      //echo "copyRecords(dbDeleteCheck,dbTrnObjectID,dbItemID,dbItemName,dbRate,dbRequiredQuantity,dbRemarks,dbItemUnit,dbItemUnitValue,Numrows);";
?>



</form>
</body>
</html>
