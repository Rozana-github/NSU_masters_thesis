<?PHP
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
           document.Form1.action="StoreLCEntry.php";
           document.Form1.submit();
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
<form name="Form1" method="post" action="AddToStoreLCEntry.php">
<?PHP
      /*------------------ Modification ,Indentation & Add CSS BY: MD.SHARIF UR RAHMAN ------------------------*/

      /*--------------------------------------- New Table ----------------------------------------------*/
      echo"
      <table border='0' width='100%' id='table1' cellpadding='0' cellspacing='0'>
            <tr>
                  <td class='top_left_curb'></td>
                  <td align='center' colspan='6' class='header_cell_e'>LC Entry</td>
                  <td class='top_right_curb'></td>
            </tr>
            <tr>
                  <td class='lb' rowspan='7'></td>
                  <td class='caption_e'>Local Agent:</td>
                  <td class='td_e'>
                        <select name='cboParty' onChange=\"SelectLC()\" class='select_e'>";
                          $searchMasParty="select
                                                 supplier_id,
                                                 company_name
                                           from
                                                 mas_supplier
                                                 order by company_name
                                          ";
                           CreateQueryComboS("Party",$searchMasParty,"-1",$cboParty);
                        echo"
                        </select>
                  </td>
                  <td class='caption_e'>Select LC for edit:</td>
                  <td class='td_e'>
                        <select name='cboLC' onChange=\"ShowDetail()\" class='select_e'>";
                              $searchLC="select
                                                LCOBJECTID,
                                                lcno
                                          from
                                                mas_lc
                                          where
                                                PARTYID='".$cboParty."' and LCSTATUS='0'
                                          ";
                              CreateQueryComboS("lcno",$searchLC,"-1",$cboLC);
                        echo "
                        </select>";

                        $LCInfo="select
                                        LCNO as txtLCNo,
                                        LCVALUE as txtLCValue,
                                        DATE_FORMAT(OPENDATE,'%d-%m-%Y') as txtOpenDate,
                                        DATE_FORMAT(LASTSHIPMENTDATE,'%d-%m-%Y') as txtShipmentDate,
                                        DATE_FORMAT(DATEOFMATURITY,'%d-%m-%Y') as txtMaturityDate,
                                        DATE_FORMAT(ARRIVALDATE,'%d-%m-%Y') as txtAriavalDT,
                                        DATE_FORMAT(doc_receivedate,'%d-%m-%Y') as txtDRecivedDate,
                                        DATE_FORMAT(barthingdate,'%d-%m-%Y') as txtBirthDate,
                                        DATE_FORMAT(amend_date,'%d-%m-%Y') as txtAmendmentDate,
                                        DATE_FORMAT(amend_neg_date,'%d-%m-%Y') as txtAmendmentNegotiationDate,
                                        name_cf_agent as txtCFagent,
                                        REMARKS as txtRemarks ,
                                        nameofcompany,
                                        lcvaluetaka,
                                        bankid as cboBank,
                                        accountno,
                                        countryorigin
                                      from
                                           mas_lc
                                      where
                                          LCOBJECTID='".$cboLC."'
                                     ";
                        $resultLCInfo=mysql_query($LCInfo) or die(mysql_error());
                        if(mysql_num_rows($resultLCInfo)>0)
                        {
                              while($rowLCInfo=mysql_fetch_array($resultLCInfo))
                              {
                                    extract($rowLCInfo);
                              }
                              $MOD=2;
                        }

                        echo "
                  </td>
                  <td class='caption_e'>LC No:</td>
                  <td class='td_e'>
                        <input type='text' name='txtLCNo' size='20' value='$txtLCNo' style='width: 137' class='input_e'>
                  </td>
                  <td class='rb' rowspan='5'></td>
            </tr>
            <tr>
                  <td class='caption_e'>LC Value($):</td>
                  <td class='td_e'>
                        <input type='text' name='txtLCValue' size='20' value='$txtLCValue' class='input_e'>
                  </td>
                  <td class='caption_e'>Open Date:</td>
                  <td class='td_e'>
                        <input type='text' name='txtOpenDate' value='$txtOpenDate' size='12' class='input_e'>
                        <a href='javascript:OpenDate.popup();'><img src='img/cal.gif' width='13' height='15' border='0' alt='Click Here to Pick up the date'>
                        <script>
                              var OpenDate=new calendar1(document.forms['Form1'].elements['txtOpenDate']);
                              OpenDate.year_scroll=true;
                              OpenDate.time_comp=false;
                        </script>
                  </td>
                  <td class='caption_e'>Shipment Date:</td>
                  <td class='td_e'>
                        <input type='text' name='txtShipmentDate' value='$txtShipmentDate' size='12'  class='input_e'>
                        <a href='javascript:ShipmentDate.popup();'><img src='img/cal.gif' width='13' height='15' border='0' alt='Click Here to Pick up the date'>
                        <script>
                              var ShipmentDate=new calendar1(document.forms['Form1'].elements['txtShipmentDate']);
                              ShipmentDate.year_scroll=true;
                              ShipmentDate.time_comp=false;
                        </script>
                  </td>
            </tr>
            <tr>
                  <td class='caption_e'>Company:</td>
                  <td class='td_e'>
                        <input type='text' name='txtNofCompany' value='$nameofcompany' class='input_e'>
                  </td>
                  <td class='caption_e'>Country:</td>
                  <td class='td_e'>
                        <input type='text' name='txtCountry' value='$countryorigin' class='input_e'>
                  </td>
                  <td class='caption_e'>LC Value(Taka)</td>
                  <td class='td_e'>
                        <input type='text' name='txtLcValTK' value='$lcvaluetaka' class='input_e'>
                  </td>
            </tr>
            <tr>
                  <td class='caption_e'>Received Date:</td>
                  <td class='td_e'>
                        <input type='text' name='txtrecivedDate' value='$txtrecivedDate' size='12'  class='input_e'>
                        <a href='javascript:recivedDate.popup();'><img src='img/cal.gif' width='13' height='15' border='0' alt='Click Here to Pick up the date'>
                        <script>
                              var recivedDate=new calendar1(document.forms['Form1'].elements['txtrecivedDate']);
                              recivedDate.year_scroll=true;
                              recivedDate.time_comp=false;
                        </script>
                  </td>
                  <td class='caption_e'>Bank Name:</td>
                  <td class='td_e'>
                        <select name='cboBank' onChange=\"setAccount(this,'$accountno')\" class='select_e'>";
                          $searchMasBank="select
                                                 bank_id,
                                                 bank_name
                                           from
                                                 mas_bank
                                           order by
                                                bank_name
                                          ";
                           CreateQueryComboS("Bank",$searchMasBank,"-1",$cboBank);
                        echo"
                        </select>
                  </td>
                  <td class='caption_e'>Account No:</td>
                  <td class='td_e'>
                        <div id='GridAAC'>
                              <select name='cboBanKAccount' class='select_e'>";
                                    echo "<option value='-1'>Select a Account</option>";
                                    if($MOD=='2')
                                    {
                                          $RQ="select
                                                      account_object_id,
                                                      account_no
                                                from
                                                      trn_bank
                                                where
                                                      bank_id='".$cboBank."'
                                                order by
                                                      account_no
                                                ";
                                          $ERQ=mysql_query($RQ) or die(mysql_error());
                                          while($Row3=mysql_fetch_array($ERQ))
                                          {
                                                extract($Row3);
                                                if($account_no==$accountno)
                                                      echo "<option value='$account_object_id' selected>$account_no</option>";
                                                else
                                                      echo "<option value='$account_object_id'>$account_no</option>";
                                          }

                                    }
                                    echo "
                              </select>
                        </div>";
                  echo "
                  </td>
            </tr>
            <tr>
                  <td class='caption_e'>Negotiation:</td>
                  <td class='td_e'>
                        <input type='text' name='txtMaturityDate' value='$txtMaturityDate' size='12'  class='input_e'>
                        <a href='javascript:MaturityDate.popup();'><img src='img/cal.gif' width='13' height='15' border='0' alt='Click Here to Pick up the date'>
                              <script>
                                    var MaturityDate=new calendar1(document.forms['Form1'].elements['txtMaturityDate']);
                                    MaturityDate.year_scroll=true;
                                    MaturityDate.time_comp=false;
                              </script>
                  </td>
                  <td class='caption_e'>Remarks:</td>
                  <td class='td_e' colspan='3'>
                        <input type='text' name='txtRemarks' value='$txtRemarks' style='width: 380' class='input_e'>
                  </td>
            </tr>
            <tr>
                  <td class='caption_e'>NameOf C&F Agent:</td>
                  <td class='td_e'>
                        <input type='text' name='txtCFagent' size='20' value='$txtCFagent' class='input_e'>
                  </td>
                  <td class='caption_e'>Doc Recived Date:</td>
                  <td class='td_e'>
                        <input type='text' name='txtDRecivedDate' value='$txtDRecivedDate' size='12' class='input_e'>
                        <a href='javascript:DRecivedDate.popup();'><img src='img/cal.gif' width='13' height='15' border='0' alt='Click Here to Pick up the date'>
                        <script>
                              var DRecivedDate=new calendar1(document.forms['Form1'].elements['txtDRecivedDate']);
                              DRecivedDate.year_scroll=true;
                              DRecivedDate.time_comp=false;
                        </script>
                  </td>
                  <td class='caption_e'>Birth Date at Ctg.:</td>
                  <td class='td_e'>
                        <input type='text' name='txtBirthDate' value='$txtBirthDate' size='12' class='input_e'>
                        <a href='javascript:DRecivedDat.popup();'><img src='img/cal.gif' width='13' height='15' border='0' alt='Click Here to Pick up the date'>
                        <script>
                              var DRecivedDat=new calendar1(document.forms['Form1'].elements['txtBirthDate']);
                              DRecivedDat.year_scroll=true;
                              DRecivedDat.time_comp=false;
                        </script>
                  </td>

            </tr>
            <tr>
            <td class='caption_e'>Amendment Date:</td>
                  <td class='td_e'>
                        <input type='text' name='txtAmendmentDate' value='$txtAmendmentDate' size='12' class='input_e'>
                        <a href='javascript:AmendmentDate.popup();'><img src='img/cal.gif' width='13' height='15' border='0' alt='Click Here to Pick up the date'>
                        <script>
                              var AmendmentDate=new calendar1(document.forms['Form1'].elements['txtAmendmentDate']);
                              AmendmentDate.year_scroll=true;
                              AmendmentDate.time_comp=false;
                        </script>
                  </td>
                  <td class='caption_e'>Amendment Negotiation Date:</td>
                  <td class='td_e' >
                        <input type='text' name='txtAmendmentNegotiationDate' value='$txtAmendmentNegotiationDate' size='12' class='input_e'>
                        <a href='javascript:AmendmentNegotiationDate.popup();'><img src='img/cal.gif' width='13' height='15' border='0' alt='Click Here to Pick up the date'>
                        <script>
                              var AmendmentNegotiationDate=new calendar1(document.forms['Form1'].elements['txtAmendmentNegotiationDate']);
                              AmendmentNegotiationDate.year_scroll=true;
                              AmendmentNegotiationDate.time_comp=false;
                        </script>
            </td>
            </tr>


            <tr>
                  <td class='bottom_l_curb'></td>
                  <td class='bottom_f_cell'colspan='6'></td>
                  <td class='bottom_r_curb'></td>
            </tr>
      </table>";
      /*--------------------------------------- New Table ----------------------------------------------*/


echo "
<br>
      <table border='0' width='100%' id='table2' cellspacing='0' cellpadding='1'>

            <tr>
                  <td class='top_left_curb'></td>
                  <td colspan='7' class='header_cell_e' align='center'>Details LC</td>
                  <td class='top_right_curb'></td>
            </tr>
            <tr>
                  <td class='lb' rowspan='3'></td>
                  <td align='center' class='title_cell_e'><b>Item</b></td>
                  <td align='center' class='title_cell_e'><b>Sub-Item</b></td>
                  <td align='center' class='title_cell_e'><b>Unit</b></td>
                  <td align='center' class='title_cell_e'><b>Rate</b></td>
                  <td align='center' class='title_cell_e'><b>Required Quantity</b></td>
                  <td align='center' class='title_cell_e'><b>Remarks</b></td>
                  <td align='right' class='title_cell_e'>&nbsp;</td>
                  <td class='rb' rowspan='3'></td>
            </tr>
            <tr>
                  <td align='center' class='td_e'>
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

                              CreateQueryComboS("Item",$searchMasItem,"-1","");
                        echo"
                        </select></td> ";
                        

                  //echo $searchMasItem;
                  echo "<td align='center' class='td_e'>
                        <span id='GridTest'>
                              <select name='cboItem' class='select_e'>
                                    <option value='-1'>Select a Sub-Item</option>
                              </select>
                        </span>

                  </td>
                  <td class='td_e'>
                        <select name='CmbUnitComb' class='select_e'>";
                              createNewCombo("Unit","mas_unit ","unitid","unitdesc","","");
                        echo "
                        </select>
                  </td>
                  <td align='center' class='td_e'>
                        <input type='text' name='txtRate' size='12' class='input_e'>
                  </td>
                  <td align='center' class='td_e'>
                        <input type='text' name='txtRequiredQuantity' size='10' class='input_e'>
                  </td>
                  <td align='center' class='td_e'>
                        <input type='text' name='txtTrnRemarks' size='20' class='input_e'>
                  </td>
                  <td align='right' class='td_e'>
                        <input type='button' value='Add' name='btnAdd' onClick=\"AddGrid()\" class='forms_button_e'>
                  </td>
            </tr>
            <tr>
                  <td colspan='7' align='center' class='button_cell_e'>
                        <input type='button' value='Submit' name='btnAdd' onClick=\"CheckGrid()\" class='forms_button_e'>
                  </td>
            </tr>
            <tr>
                  <td class='bottom_l_curb'></td>
                  <td class='bottom_f_cell'colspan='7'>&nbsp;</td>
                  <td class='bottom_r_curb'></td>
            </tr>
      </table>";
?>

<?PHP/*---------------------------------- -----------------------------------------------------------------*/?>
<br>
<table border='0' width='100%' cellpadding='0' cellspacing='0'  bordercolor='#111111'>
      <tr>
            <td  align='left'>
                  <span ID='show'>
                        Empty: No Information exist.
                  </span>
            </td>
      </tr>
</table>
<?PHP/*---------------------------------- -----------------------------------------------------------------*/?>

<?PHP/*---------------------------------- -----------------------------------------------------------------*/?>
<input type='hidden' name='txtIndex' value='0'>
<script language='JavaScript'>
        var dbDeleteCheck=new Array(100);
        var dbTrnObjectID=new Array(100);
        var dbItemID=new Array(100);
        var dbItemName=new Array(100);
        var dbItemUnit=new Array(100);
        var dbItemUnitValue=new Array(100);
        var dbRate=new Array(100);
        var dbRequiredQuantity=new Array(100);
        var dbRemarks=new Array(100);;
        var Numrows=0;

<?PHP
      $TrnLCInfo="select
                        trn_lc.*,
                        mas_unit.unitdesc
                  from
                        trn_lc
                        LEFT JOIN mas_unit ON trn_lc.UNITID=mas_unit.UNITID
                  where
                        lcobjectid='".$cboLC."'
                  ";
      $resultTrnLCInfo=mysql_query($TrnLCInfo) or die(mysql_error());
      $j=0;
      while($rowTrnLCInfo=mysql_fetch_array($resultTrnLCInfo))
      {
            extract($rowTrnLCInfo);
            $ItamName="select
                              itemdescription
                        from
                              mas_item
                        where
                              itemcode='".$itemcode."'
                        ";
            $ResultItamName=mysql_query($ItamName) or die(mysql_error());
            while($RowItamName=mysql_fetch_array($ResultItamName))
            {
                  extract($RowItamName);
            }

            echo   "dbTrnObjectID[$j]=\"$lcobjectdetailid\";";
            echo   "dbItemID[$j]=\"$itemcode\";";
            echo   "dbItemName[$j]=\"$itemdescription\";";

            echo "dbItemUnitValue[$j]=\"$unitid\";";
            echo "dbItemUnit[$j]=\"$unitdesc\";";

            echo   "dbRate[$j]=\"$rate\";";
            echo   "dbRequiredQuantity[$j]=\"$reqqty\";";
            echo   "dbRemarks[$j]=\"$remarks\";";
      $j++;
      }
      echo "Numrows=$j;";
      echo "copyRecords(dbDeleteCheck,dbTrnObjectID,dbItemID,dbItemName,dbRate,dbRequiredQuantity,dbRemarks,dbItemUnit,dbItemUnitValue,Numrows);";
?>
</script>
      <span style='position:absolute;left:9px; top:370px; width:691px; height:325px' ID = 'DeletedOrder'>
      </span>
      <input type='hidden' name='txtDeleteIndex' value='0'>

</form>
</body>
</html>
