<?PHP
session_start();

        include_once("Library/dbconnect.php");
        include_once("Library/Library.php");
?>


<html>

<head>
      <meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
      <title>Asset Register Entry</title>
      <script language="JavaScript" src="Script/NumberFormat.js"></script>
      <script language="JavaScript" src="Script/calendar1.js"></script>

      <script language='javascript'>

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
                        //window.GridAccount.innerHTML="";
                        //window.GridAccount.innerHTML=response;
                        document.frmVoucherEntry.txtDepRate.value=response;
                  }
            }

            function setAccount(val)
            {
                  var FunctionName="pick";
                  var TableName="mas_asset";
                  var FieldName="depreciation_rate";
                  var Condition=escape("where assetobjectid='"+val+"'");

                  var URLQuery="FunctionName="+FunctionName+"&TableName="+TableName+"&FieldName="+FieldName+"&Condition="+Condition+"";
                  callServer(URLQuery);
            }
            function submitData()
            {
                  //alert("Done");
                  document.frmVoucherEntry.action="AddTo_AssetRegEntry.php";
                  document.frmVoucherEntry.submit();
            }



            var DeleteCheck=new Array(100);
            var SubPackageID=new Array(100);
            var Title=new Array(100);
            var Heading=new Array(100);
            var Description=new Array(100);
            var PurchaseCost=new Array(100);
            var Remarks=new Array(100);

                var i=0;
                var delnum=0;

                function copyRecords(dbDeleteCheck,dbSubPackageID,dbTitle,dbHeading,dbDescription,dbPurchaseCost,dbRemarks,RecordNum)
                {
                   for(var l=0;l<RecordNum;l++)
                   {
                         DeleteCheck[l]=dbDeleteCheck[l];
                         SubPackageID[l]=dbSubPackageID[l];
                         Title[l]=dbTitle[l];
                         Heading[l]=dbHeading[l];
                         Description[l]=dbDescription[l];
                         PurchaseCost[l]=dbPurchaseCost[l];
                         Remarks[l]=dbRemarks[l];
                   }
                   i=RecordNum;
                   drawList();
                }

                function AddList()
                {
                   if(i>90)
                   {
                        alert("You can not add any more");
                        return;
                   }

                   if(document.frmVoucherEntry.txtAsset.value=="")
                   {
                        alert("Asset Can Not Be Empty.");
                        document.frmVoucherEntry.txtAsset.focus();
                        return;
                   }
                   if(document.frmVoucherEntry.txtDepRate.value=="")
                   {
                        alert("Depreciation Rate Can Not Be Empty.");
                        document.frmVoucherEntry.txtDepRate.focus();
                        return;
                   }
                   if(document.frmVoucherEntry.taxtQty.value=="")
                   {
                        alert("Quantity Can Not Be Empty.");
                        document.frmVoucherEntry.taxtQty.focus();
                        return;
                   }
                   if(document.frmVoucherEntry.taxtPurchCost.value=="")
                   {
                        alert("Pruchase Cost Can Not Be Empty.");
                        document.frmVoucherEntry.taxtPurchCost.focus();
                        return;
                   }
                   if(document.frmVoucherEntry.taxtRemarks.value=="")
                   {
                        alert("Remarks Cost Can Not Be Empty.");
                        document.frmVoucherEntry.taxtRemarks.focus();
                        return;
                   }
                   for(var l=0;l<i;l++)
                   {
                        if(frmVoucherEntry.txtAsset.value==Title[l])
                        {
                                alert("This Asset is alrady exist.");
                                MyForm.txtAsset.focus();
                                return;
                        }
                   }


                   DeleteCheck[i]='-1';
                   SubPackageID[i]='-1';
                   Title[i]=frmVoucherEntry.txtAsset.value;
                   Heading[i]=frmVoucherEntry.txtDepRate.value;
                   Description[i]=frmVoucherEntry.taxtQty.value;
                   PurchaseCost[i]=frmVoucherEntry.taxtPurchCost.value;
                   Remarks[i]=frmVoucherEntry.taxtRemarks.value;

                   i++;
                   drawList();
                }


                  function deleteRow(deleteIndex)
                  {
                        var k=0;

                        if(SubPackageID[deleteIndex]!='-1')
                        {
                                 DeletedSubPackage.innerHTML=DeletedSubPackage.innerHTML+"<input type='hidden' name='DelSubPackageID["+delnum+"]' value='"+SubPackageID[deleteIndex]+"'>";
                                 delnum++;
                                 MyForm.DelNumber.value=delnum;

                        }

                        for (k=deleteIndex;k<i-1;k++)
                        {
                                 DeleteCheck[k]=DeleteCheck[k+1];
                                 SubPackageID[k]=SubPackageID[k+1];
                                 Title[k]=Title[k+1];
                                 Heading[k]=Heading[k+1];
                                 Description[k]=Description[k+1];
                                 PurchaseCost[k]=PurchaseCost[k+1];
                                 Remarks[k]=Remarks[k+1];
                        }
                        i--;
                        drawList();
                  }
                  function saveChangedData(ChangedIndex)
                  {
                        var TotalAmount=0;

                        Title[ChangedIndex]=frmVoucherEntry.elements["Title"+"["+ChangedIndex+"]"].value;
                        Heading[ChangedIndex]=frmVoucherEntry.elements["Heading"+"["+ChangedIndex+"]"].value;
                        Description[ChangedIndex]=frmVoucherEntry.elements["Description"+"["+ChangedIndex+"]"].value;
                        PurchaseCost[ChangedIndex]=frmVoucherEntry.elements["Heading"+"["+ChangedIndex+"]"].value;
                        Remarks[ChangedIndex]=frmVoucherEntry.elements["Description"+"["+ChangedIndex+"]"].value;
                  }
                



            function drawList()
            {
                  var TotalAmount=0;

                   if(i<1)
                   {
                        AssetDisplay.innerHTML="";
                        AssetDisplay.innerHTML=AssetDisplay.innerHTML+"Empty: No Item exist.";
                        return;
                   }
                   var str="";
                   str=str+"<table align='center' style=\"border-collapse: collapse\" cellpadding='0' cellspacing='0' width='100%'>";
                   str=str+"<tr>";
                        str=str+"<td class='top_l_curb'></td>";
                        str=str+"<td colspan='6' class='top_f_cell'></td>";
                        str=str+"<td class='top_r_curb'></td>";
                   str=str+"</tr>";
                   str=str+"<tr>";
                        str=str+"<td class='lb'></td>";
                        str=str+"<td align='center' class='title_cell_e'>&nbsp;</td>";
                        str=str+"<td align='center' class='title_cell_e'>Asset Name</td>";
                        str=str+"<td align='center' class='title_cell_e'>Depreciation Rate</td>";
                        str=str+"<td align='center' class='title_cell_e'>Quantity</td>";
                        str=str+"<td align='center' class='title_cell_e'>Cost</td>";
                        str=str+"<td align='center' class='title_cell_e'>Remark</td>";
                        str=str+"<td class='rb'></td>";
                   str=str+"</tr>";
                   for (var j=0;j<i;j++)
                   {
                        if(j%2==0)
                                TDClass="even_td_e";
                        else
                                TDClass="odd_td_e";

                        str=str+"<tr>";
                        str=str+"<td class='lb'></td>";
                        if(DeleteCheck[j]=='-1')
                              str=str+"  <td align='center' height='25' class="+TDClass+"><input type='button' name='Delete["+j+"]' value='Delete' onClick='deleteRow("+j+")' size='6' class='forms_button_e'></td>";
                        else
                              str=str+"  <td align='center' height='25' class="+TDClass+"></td>";

                        //str=str+"  <input type='hidden' name='SubPackageID["+j+"]' value='"+SubPackageID[j]+"'>";

                        str=str+"  <td align='center' class="+TDClass+"><input type='text' name='Title["+j+"]' value='"+Title[j]+"'  OnChange='saveChangedData("+j+")' class='input_e'></td>";
                        str=str+"  <td align='center' class="+TDClass+"><input type='text' name='Heading["+j+"]' value='"+Heading[j]+"' SIZE='8'  OnChange='saveChangedData("+j+")' class='input_e'></td>";
                        str=str+"  <td align='center' class="+TDClass+"><input type='text' name='Description["+j+"]' value='"+Description[j]+"' SIZE='10' OnChange='saveChangedData("+j+")' class='input_e'></td>";

                        str=str+"  <td align='center' class="+TDClass+"><input type='text' name='PurchCost["+j+"]' value='"+PurchaseCost[j]+"' OnChange='saveChangedData("+j+")' class='input_e'></td>";
                        str=str+"  <td align='center' class="+TDClass+"><input type='text' name='Remarks["+j+"]' value='"+Remarks[j]+"' OnChange='saveChangedData("+j+")' class='input_e'></td>";
                        str=str+"<td class='rb'></td>";
                   }
                   str=str+"<tr>";
                        str=str+"<td class='lb'></td>";
                        str=str+"<td align='center' class='td_e' colspan='6' class='button_cell_e'><input type='button' value='Save' name='Save' class='forms_button_e' onclick='submitData()'>";
                        str=str+"</td>";
                        str=str+"<td class='rb'></td>";
                   str=str+"<tr>";
                        str=str+"<td class='bottom_l_curb'></td>";
                        str=str+"<td class='bottom_f_cell' colspan='6'></td>";
                        str=str+"<td class='bottom_r_curb'></td>";
                   str=str+"</tr>";
                   str=str+"</table>";
                   str=str+"<input type='hidden' name='index' value='"+i+"'>";
                   window.AssetDisplay.innerHTML="";
                   window.AssetDisplay.innerHTML=window.AssetDisplay.innerHTML+str;
            }
            


      </script>

      <link rel='stylesheet' type='text/css' href='Style/eng_form.css'>
      <link rel='stylesheet' type='text/css' href='Style/generic_form.css'>
</head>

<body class='body_e'>
<?PHP/*--------------------------------- DEVELOPED BY: MD SHARIF UR RAHMAN ----------------------------------------*/?>

<form name='frmVoucherEntry' method='post' action='AddTo_AssetRegEntry.php'>
<?PHP        
        /*------------------------- Find Max ID *------------------------*/
            $linsertID="SELECT 
                              MAX(assetregisterobjectid) as LastID
                        FROM
                              mas_asset_register
                       ";

            $Exdata=mysql_query($linsertID) or die(mysql_error());
            while($RowLID=mysql_fetch_array($Exdata))
            {
                        extract($RowLID);
            }
          $MaxID=$LastID+1;
        /*----------------------- END Find Last Insert ID -----------------*/
?>
<table border="0" width="100%" id="table1" cellpadding='0' cellspacing='0'>
      <tr>
            <td class='top_left_curb'></td>
            <td colspan='6' class='header_cell_e' align='center'>Register Entry Form</td>
            <td class='top_right_curb'></td>
      </tr>
      <tr>
            <td class='lb'></td>
            <td class='caption_e'>Register No:</td>
            <td>
                  <?PHP echo "<input type='text' name='txtRegNo' value='$MaxID' size='10' readonly class='input_e'>"; ?>
            </td>
            <td class='caption_e'>Purchase Date:</td>
            <td>
                  <input type='text' name='txtChequeDate' size='10' readonly class='input_e'>
            &nbsp;
            <a href="javascript:ComplainDate1.popup();">
               <img src="img/cal.gif" width="13" height="13" border="0" alt="Click Here to Pick up the date">
            </a>
            </td>
            <td class='caption_e'>Supplier</td>
            <td>
            <?PHP
                  echo "<select size='1' name='user'  class='select_e'>";
                  createCombo("supplier","mas_supplier","supplierobject_id","Company_Name","","");
                  echo "</select>";
            ?>
            </td>
            <td class='rb'></td>
      </tr>
      <tr>
            <td class='bottom_l_curb'></td>
            <td class='bottom_f_cell'colspan='6'></td>
            <td class='bottom_r_curb'></td>
      </tr>
</table>
<table border="0" width="100%" id="table1" cellpadding='0' cellspacing='0'>
      <tr>
            <td class='top_l_curb'></td>
            <td colspan='5' class='top_f_cell'></td>
            <td class='top_r_curb'></td>
      </tr>
      <tr>
            <td class='lb' rowspan='2'></td>
            <td class='title_cell_e'>Asset Num:</td>
            <td class='title_cell_e'>DepRate:</td>
            <td class='title_cell_e'>Quantity:</td>
            <td class='title_cell_e'>Purchase Cost:</td>
            <td class='title_cell_e'>Remarks:</td>
            <td class='rb' rowspan='2'></td>
      </tr>
      <tr>
            <td class='td_e'>
            <?PHP
                  echo "<select size='1' name='txtAsset'  class='select_e' onchange='setAccount(this.value)'>";
                  createCombo("Asset","mas_asset","assetobjectid","description","","");
                  echo "</select>";
            ?>
            </td>
            <td class='td_e'>

                  <input type='text' name='txtDepRate' value='' class='input_e'>

            </td>
            <td class='td_e'>
                  <?PHP echo "<input type='text' name='taxtQty' value='' class='input_e'>"; ?>
            </td>
            <td class='td_e'>
                  <?PHP echo "<input type='text' name='taxtPurchCost' value='' class='input_e'>"; ?>
            </td>
            <td class='td_e'>
                  <?PHP echo "<input type='text' name='taxtRemarks' value='' class='input_e'>"; ?>
            </td>
      </tr>
      <tr>
            <td class='lb'></td>
            <td colspan='5' class='button_cell_e' align='center'>
                  <input type='button' value='ADD' name='addBtn' onClick='AddList()' class='forms_button_e'>
            </td>
            <td class='rb'></td>
      </tr>
      <tr>
            <td class='bottom_l_curb'></td>
            <td class='bottom_f_cell' colspan='5'></td>
            <td class='bottom_r_curb'></td>
      </tr>
</table>
<table border='0' align='center' width='100%' cellpadding='0' cellspacing='0'>
      <tr>
            <td align='left'>
                  <span style='position:absolute;' ID='AssetDisplay' class='scroll'>
                        Empty: No Item exist.
                  </span>
            </td>
      </tr>
</table>

</form>
<?PHP/*---------------------------------- FOR CALENDER -----------------------------------------------------*/ ?>
<script language="JavaScript">

        // create calendar object(s) just after form tag closed
        // specify form element as the only parameter (document.forms['formname'].elements['inputname']);
        // note: you can have as many calendar objects as you need for your application

        var ComplainDate1 = new calendar1(document.forms['frmVoucherEntry'].elements['txtChequeDate']);
        ComplainDate1 .year_scroll = true;
        ComplainDate1 .time_comp = false;
</script>
<?PHP/*-------------------------------------END FOR CALENDER ---------------------------------------------*/  ?>
</body>
</html>
