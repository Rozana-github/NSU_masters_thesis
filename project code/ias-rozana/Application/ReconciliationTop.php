<?PHP
      include "Library/dbconnect.php";
      include "Library/Library.php";
      include "Library/SessionValidate.php";
?>

<html>
      <head>
            <meta http-equiv='Content-Type' content='text/html; charset=windows-1252'>
            <title>Invoice Posting</title>
            <script language=javascript>

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
                        //xmlHttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded; charset=UTF-8");

                        xmlHttp.setRequestHeader("Method", "POST " + url + " HTTP/1.1");
                        xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                        xmlHttp.onreadystatechange = updatePage;
                        xmlHttp.send(URLQuery);
                  }

                  function updatePage()
                  {
                        // alert(xmlHttp.readyState);
                        if (xmlHttp.readyState == 4)
                        {
                              var response = xmlHttp.responseText;
                              //alert(response);
                              window.BankAccountX.innerHTML="";
                              window.BankAccountX.innerHTML=response;
                        }
                  }
                  function sendBank(val)
                  {
                        var FunctionName="createCombo";
                        var ComboName="cboBankAccount";
                        var SelectA="Bank Account";
                        var TableName="trn_bank";
                        var ID="account_object_id";
                        var Name="account_no";
                        var Condition=escape("where bank_id='"+val+"' order by account_no");
                        var selectedValue="";
                        var OnChangeEvent="";

                        var URLQuery="FunctionName="+FunctionName+"&ComboName="+ComboName+"&SelectA="+SelectA+"&TableName="+TableName+"&ID="+ID+"&Name="+Name+"&Condition="+Condition+"&selectedValue="+selectedValue+"&OnChangeEvent="+OnChangeEvent+"";
                        //alert(URLQuery);
                        callServer(URLQuery);
                  }
            </script>
            <script language='javascript'>
                  function sendData()
                  {
                        if((parseInt(document.MyForm.cboBank.value)==-1) || (parseInt(document.MyForm.cboBankAccount.value)==-1))
                        {
                              alert("Bank And Bank Account No Is Required.");
                              return;
                        }
                        document.MyForm.submit();
                  }
            </script>
            <LINK href="Style/generic_form.css" type='text/css' rel='stylesheet'>
            <link rel='stylesheet' type='text/css' href='Style/eng_form.css' />
      </head>
      <body class='body_e'>
            <form name="MyForm" method='POST' action='ReconciliationBottom.php' target='ReconciliationBottom'>
            <table width='100%' id='table1' cellspacing='0' cellpadding='0' align='center'>
                  <tr>
                        <td class='top_left_curb'></td>
                        <td colspan='6' class='header_cell_e' align='center'>Reconciliation (Bank Account, Date Selection)</td>
                        <td class='top_right_curb'></td>
                  </tr>
                  <tr>
                        <td class='lb' rowspan='2'></td>
                        <td class='caption_e'>Bank</td>
                        <td class='td_e'>
                              <select name='cboBank' class='select_e' onchange='sendBank(this.value)'>
                              <?PHP
                                    createCombo("Bank","mas_bank","bank_id","bank_name","order by bank_name","");
                              ?>
                              </select>
                        </td>
                        <td class='caption_e'>Bank Account</td>
                        <td class='td_e'>
                              <span id="BankAccountX">
                                    <select name='cboBankAccount' class='select_e'>
                                           <option value='-1'>Select a Bank Account</option>
                                    </select>
                              </span>
                        </td>
                        <td class='caption_e'>Reconciliation Date</td>
                        <td class='td_e'>
                              <select name='cboReconciliationMonth' class='select_e'>
                                    <?PHP
                                          $M=date('m');
                                          comboMonth($M);
                                    ?>
                              </select>
                              <select name='cboReconciliationYear' class='select_e'>
                                    <?PHP
                                          $Y=date('Y');
                                          $PY=$Y-10;
                                          $NY=$Y+10;
                                          comboYear($PY,$NY,$Y);
                                    ?>
                              </select>
                        </td>
                        <td class='rb' rowspan='2'></td>
                  </tr>
                  <tr>
                        <td class='button_cell_e' align='center' colspan='6'><input value='Show Detail' type='button' name='btnsubmit' class='forms_button_e' onclick='sendData()'></td>
                  </tr>
                  <tr>
                        <td class='bottom_l_curb'></td>
                        <td class='bottom_f_cell' colspan='6'></td>
                        <td class='bottom_r_curb'></td>
                  </tr>
            </table>
            </form>
      </body>
</html>
<?PHP
      mysql_close();
?>
