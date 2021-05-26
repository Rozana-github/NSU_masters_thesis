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

function submitform()
{


        if(frmVoucherEntry.journalno.value=="")
        {
                alert("Please provide voucher number.");
                frmVoucherEntry.journalno.focus();
                return false;
        }

        else
        {
                frmVoucherEntry.submit();
        }




}






function callthis()
{

            document.frmVoucherEntry.action="Asset_Dep_JV.php";
            document.frmVoucherEntry.submit();

}

</script>

</head>

<body >

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

<form name='frmVoucherEntry' method='post' action='SaveAsset_Dep_JV.php'>
<input type="hidden" name="HidUpdateIndex" value="">
<input type="hidden" name="TotalIndex" value="">

  <table border='0' width='100%'  align='center' cellpadding='0' cellspacing='0'>
        <tr>
                <td colspan='4' class='header_cell_e' width='100%' align='center'>
                        Journal Voucher Entry Form
                </td>
        </tr>
        <?PHP
            if(isset($cboMonth) || isset($cboYear))
            {
                  $queryexist="select
                                    jv_no
                              from
                                    mas_asset_dep_jv
                              where
                                    proc_month='$cboMonth'
                                    and proc_year='$cboYear'
                              " ;
                   $rsexist=mysql_query($queryexist)or die(mysql_error());
                   if(mysql_num_rows($rsexist)>0)
                   {
                        while($rowexist=mysql_fetch_array($rsexist))
                        {
                              extract($rowexist);
                        }
                        echo"<input type='hidden' value='1' name='update'>";
                   }
            }
        ?>
        <tr>

            <td class='caption_e' colspan='2'>Month</td>
            <td class='td_e' colspan='2'>
                  <select name='cboMonth' class='select_e' onchange='callthis()'>
                        <?PHPcomboMonth($cboMonth);?>
                  </select>
                  <select name='cboYear' class='select_e' onchange='callthis()'>
                        <?PHPcomboYear("","",$cboYear);?>
                  </select>
            </td>

        </tr>
        <tr>
                <td  class='td_e'>Voucher Date</td>
                <td  class='td_e'>
                <?PHP
                  echo"
                        dd<input type='text' name='txtVoucherDay' value='$txtVoucherDay' size='2' maxlength='2' class='input_e'>
                        mm<input type='text' name='txtVoucherMonth' value='$txtVoucherMonth' size='2' maxlength='2' class='input_e'>
                        yyyy<input type='text' name='txtVoucherYear' value='$txtVoucherYear' size='4' maxlength='4' class='input_e'>
                  ";
                ?>
                </td>
                <td  class='td_e'>Voucher No</td>
                <td  class='td_e'>
                        <?PHP
                                if($jv_no!='')
                                    echo"<input type='text' name='journalno' value='$jv_no' readonly class='input_e'>";
                                else
                                    echo"<input type='text' name='journalno' value='$VNOrena' readonly class='input_e'>";
                        ?>
                        <input type='hidden' name='vtype' Value='JV'>
                </td>
        </tr>


        <tr>
                <td  colspan='1' class='td_e'>Description:</td>
                <td  colspan='3' align='left' height='56' width='100%' class='td_e'>
                        <textarea rows='3' name='mremarks' cols='48'></textarea>
                </td>
        </tr>
</table>
<?PHP

      $queryjv="SELECT
                  trn_asset_depreciation.assetid,
                  asset_glcode,
                  mas_asset_dep_setup.cost_code,
                  asset_dep_glcode,
                  asset_acm_glcode,
                  sum( trn_asset_depreciation.current_depreciation ) as amount,
                  mas_gl.description
               FROM
                  trn_asset_depreciation
                  INNER JOIN trn_asset_register ON trn_asset_register.assetid = trn_asset_depreciation.assetid
                  INNER JOIN mas_asset ON mas_asset.assetobjectid = trn_asset_register.assetobjectid
                  INNER JOIN mas_asset_dep_setup ON mas_asset_dep_setup.asset_glcode = mas_asset.gl_code
                  inner join mas_gl on mas_gl.gl_code=asset_glcode
               WHERE
                  proc_year = '$cboYear'
                  AND proc_month = '$cboMonth'
               GROUP BY
                  asset_glcode
              ";

                  $rsjv=mysql_query($queryjv)or die(mysql_error());
                  if(mysql_num_rows($rsjv)>0)
                  {
                        $i=0;

                              
                        echo"<table border='0' width='100%'  align='center' cellpadding='0' cellspacing='0'>
                                          <tr>
                                                <td class='title_cell_e' >Gl Code</td>
                                                <td class='title_cell_e' >Cost Center</td>
                                                <td class='title_cell_e' >Head Title</td>
                                                <td class='title_cell_e' >Dr</td>
                                                <td class='title_cell_e' >Cr</td>
                                          </tr>
                              ";
                              $total=0;
                        while($rowjv=mysql_fetch_array($rsjv))
                        {
                              if($i%2==0)
                                    $cls='even_td_e';
                              else
                                    $cls='odd_td_e';
                              extract($rowjv);
                              $total=$total+$amount;
                              
                              echo" <tr>
                                          <td class='$cls' >
                                                <input type='text' name='txtgl[$i]' value='$asset_dep_glcode' class='input_e' readonly size='5'>
                                          </td>
                                          <td class='$cls' >
                                                <input type='hidden' name='txtcostcenter[$i]' value='".$cost_code."' class='input_e' readonly size='5'>";
                                                echo pick("mas_cost_center","description","cost_code='".$cost_code."'");
                              echo"       </td>
                                          <td class='$cls' >";
                                                echo pick("mas_gl","description","gl_code='$asset_dep_glcode'");
                              echo"       </td>
                                          <td class='$cls' >
                                                <input type='text' value='$amount' name='dramount[$i]' style='text-align: right' class='input_e' readonly>
                                          </td>
                                          <td class='$cls' >

                                                <input type='text' value='' name='cramount[$i]' style='text-align: right' class='input_e' readonly>
                                          </td>
                                    </tr>";
                              $i++;
                              if($i%2==0)
                                    $cls='even_td_e';
                              else
                                    $cls='odd_td_e';
                                    
                              echo"      <tr>
                                          <td class='$cls' >
                                                <input type='text' name='txtgl[$i]' value='$asset_acm_glcode' class='input_e' readonly size='5' >
                                          </td>

                                          <td class='$cls' >
                                                <input type='hidden' name='txtcostcenter[$i]' value='".$cost_code."' class='input_e' readonly size='5'>";
                                                echo pick("mas_cost_center","description","cost_code='".$cost_code."'");
                              echo"       </td>
                                          <td class='$cls' >";
                                                echo pick("mas_gl","description","gl_code='$asset_acm_glcode'");
                              echo"       </td>
                                          <td class='$cls' >

                                                <input type='text' value='' name='dramount[$i]' style='text-align: right' class='input_e' readonly>
                                          </td>
                                          <td class='$cls' >

                                                <input type='text' value='$amount' name='cramount[$i]' style='text-align: right' class='input_e' readonly>
                                          </td>
                                    </tr>";
                              $i++;
                        }

                        if($i%2==0)
                                    $cls='even_td_e';
                              else
                                    $cls='odd_td_e';
                        echo" <tr>
                                          <td class='caption_e' colspan='3' align='right'>
                                                  Total
                                          </td>

                                          <td class='$cls' >
                                                <input type='text' value='$total' name='totaldr' style='text-align: right' class='input_e' readonly>
                                          </td>
                                          <td class='$cls' >

                                                <input type='text' value='$total' name='totalcr' style='text-align: right' class='input_e' readonly>
                                          </td>
                                    </tr>
                              <tr>
                                    <td class='button_cell_e' align='center' colspan='5'>
                                          <input type='hidden' value='$i' name='TotalIndex'>
                                          <input type='button' value='Submit' name='btnsubmit' class='forms_button_e' onclick='submitform()'>
                                    </td>
                              </tr>
                              </table>";

                  }

      

?>



</form>

</body>

</html>
