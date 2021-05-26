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
       if(frmVoucherEntry.cboSupplier.value=="-1")
      {
            alert("Please provide a Supplier name.");
            frmVoucherEntry.cboSupplier.focus();
            return false;
      }
        else
        {
                frmVoucherEntry.submit();
        }




}






function callthis()
{
       if(document.frmVoucherEntry.jvtype.checked==false)
       {
            alert("select the jv type");

       }
       else
       {
            document.frmVoucherEntry.action="HR_JV.php";
            document.frmVoucherEntry.submit();
      }
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

<form name='frmVoucherEntry' method='post' action='SaveHR_JV.php'>
<input type="hidden" name="HidUpdateIndex" value="">
<input type="hidden" name="TotalIndex" value="">

  <table border='0' width='100%'  align='center' cellpadding='0' cellspacing='0'>
        <tr>
                <td colspan='10' class='header_cell_e' width='100%' align='center'>
                        Journal Voucher Entry Form
                </td>
        </tr>
        <tr>

            <td class='td_e' align='left' colspan='6' width='30%'>
            <?PHP
               if(!isset($jvtype))
               {
                  echo"<input type='radio' value='1'  name='jvtype'>Salary
                        <input type='radio' value='2'  name='jvtype'>Over Time
                        <input type='radio' value='3'  name='jvtype'>Bonus
                        <input type='radio' value='4'  name='jvtype'>Gratuity
                 ";
               }
               else
               {
                  if($jvtype==1)
                  {
                        echo"<input type='radio' value='1' checked name='jvtype'>Salary
                        <input type='radio' value='2'  name='jvtype'>Over Time
                        <input type='radio' value='3'  name='jvtype'>Bonus
                        <input type='radio' value='4'  name='jvtype'>Gratuity";

                  }
                  else if($jvtype==2)
                  {
                         echo"<input type='radio' value='1'  name='jvtype'>Salary
                        <input type='radio' value='2'  checked name='jvtype'>Over Time
                        <input type='radio' value='3'  name='jvtype'>Bonus
                        <input type='radio' value='4'  name='jvtype'>Gratuity";
                  }
                  else if($jvtype==3)
                  {
                         echo"<input type='radio' value='1'  name='jvtype'>Salary
                        <input type='radio' value='2'  name='jvtype'>Over Time
                        <input type='radio' value='3' checked name='jvtype'>Bonus
                        <input type='radio' value='4'  name='jvtype'>Gratuity";
                  }
                  else if($jvtype==4)
                  {
                        echo"<input type='radio' value='1'  name='jvtype'>Salary
                        <input type='radio' value='2'  name='jvtype'>Over Time
                        <input type='radio' value='3'  name='jvtype'>Bonus
                        <input type='radio' value='4' checked name='jvtype'>Gratuity";
                  }
                  
                  
               }
            ?>
            </td>
            <td class='caption_e' width='10%'>Month</td>
            <td class='td_e' width='30%' >
                  <select name='cboMonth' class='select_e'>
                        <?PHPcomboMonth($cboMonth);?>
                  </select>


                  <select name='cboYear' class='select_e'>
                        <?PHPcomboYear("","",$cboYear);?>
                  </select>
            </td>
            <td class='td_e' width='10%'>Department</td>
            <td class='td_e' width='20%'>
                  <select name='cboDepartment' class='select_e' onchange='callthis()'>
                        <?PHP
                              $querydepartment="select
                                                      cost_code,
                                                      description
                                                from
                                                      mas_cost_center
                                                where
                                                      pid not in('-1','1')
                                                order by
                                                      description
                                                ";
                              createQueryCombo("Department",$querydepartment,"","$cboDepartment");
                        ?>
                  </select>
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
                        <select name='cboSupplier' class='select_e' >
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
                <td width='20%' colspan='2' class='td_e'>&nbsp;</td>
                <td width='30%' colspan='3' class='td_e'>
                        &nbsp;
                </td>
        </tr>

        <tr>
                <td width='20%' colspan='2' class='td_e'>Description:</td>
                <td width='80%' colspan='8' align='left' height='56' width='100%' class='td_e'>
                        <textarea rows='3' name='mremarks' cols='48'></textarea>
                </td>
        </tr>
</table>
<?PHP
      if($cboDepartment!='-1' )
      {
      $queryexist="select
                        hr_jv_month,
                        hr_jv_year,
                        department_id,
                        jv_no,
                        jv_type
                  from
                        mas_hr_jv
                  where
                        hr_jv_month='$cboMonth' and
                        hr_jv_year='$cboYear' and
                        department_id='$cboDepartment' and
                        jv_type='$jvtype'
                  ";
      $rsexist=mysql_query($queryexist)or die(mysql_error());
      if(mysql_num_rows($rsexist)>0)
      {
            drawNormalMassage("This month has already been processed for the selected department");
      }
      else
      {
              if(isset($jvtype))
              {
              if($jvtype==1)
              {
                  $queryjv="SELECT
                                    sum(net_pay) AS total

                              FROM
                                    trn_emp_sal
                                    INNER JOIN trn_employees ON trn_employees.emp_id = trn_emp_sal.emp_id AND jobstatus = '1'
                              WHERE
                                    sal_year = '$cboYear'
                                    AND sal_month = '$cboMonth'
                                    AND department_id = '$cboDepartment'
                              ";
               }
               else if($jvtype==2)
               {
                  $queryjv="SELECT
                                    sum(month_ot_amount+night_allowance) AS total

                              FROM
                                    emp_month_ot
                                    INNER JOIN trn_employees ON trn_employees.emp_id = emp_month_ot.emp_id AND jobstatus = '1'
                              WHERE
                                    genarat_year = '$cboYear'
                                    AND genarat_month = '$cboMonth'
                                    AND department_id = '$cboDepartment'
                              ";
               }
               else if($jvtype==3)
               {
                    $queryjv="SELECT
                                    sum(b_amount) AS total

                              FROM
                                    trn_emp_bonus
                                    INNER JOIN trn_employees ON trn_employees.emp_id = trn_emp_bonus.emp_id AND jobstatus = '1'
                              WHERE
                                    b_year = '$cboYear'
                                    AND b_month = '$cboMonth'
                                    AND department_id = '$cboDepartment'
                              ";
               }
               else if($jvtype==4)
               {
                    $queryjv="SELECT
                                    sum(gratuaty_amount) AS total

                              FROM
                                    trn_emp_gratuaty
                                    INNER JOIN trn_employees ON trn_employees.emp_id = trn_emp_gratuaty.emp_id AND jobstatus = '1'
                              WHERE
                                    gratuaty_year = '$cboYear'
                                    AND gratuaty_month = '$cboMonth'
                                    AND department_id = '$cboDepartment'
                              ";
               }

             // echo $queryjv;
                  $rsjv=mysql_query($queryjv)or die(mysql_error());
                  if(mysql_num_rows($rsjv)>0)
                  {
                        $i=0;
                        while($rowjv=mysql_fetch_array($rsjv))
                        {
                              extract($rowjv);
                        }
                        if($total!='')
                        {
                              echo"<table border='0' width='100%'  align='center' cellpadding='0' cellspacing='0'>
                                          <tr>
                                                <td class='title_cell_e' width='25%'>Gl Code</td>
                                                <td class='title_cell_e' width='25%'>Head Title</td>
                                                <td class='title_cell_e' width='25%'>Dr</td>
                                                <td class='title_cell_e' width='25%'>Cr</td>
                                          </tr>
                              ";
                        echo"<tr>";
                        if($jvtype==1)
                        {
                              if($cboDepartment=='201' || $cboDepartment=='202' || $cboDepartment=='301' || $cboDepartment=='302')
                              {
                                    echo"<td class='td_e' align='center'>
                                          <input type='text' name='txtsalgl' value='40303' class='input_e' readonly size='5'>
                                          </td>
                                         <td class='td_e' >
                                          Salaray
                                          </td>";
                              }
                              else
                              {
                                    echo"<td class='td_e' align='center'>
                                          <input type='text' name='txtsalgl' value='40304' class='input_e' readonly size='5'>
                                    </td>
                                    <td class='td_e' >
                                          Wages
                                    </td>";
                              }
                        }
                        else if($jvtype==2)
                        {
                             echo"<td class='td_e' align='center'>
                                          <input type='text' name='txtsalgl' value='40702' class='input_e' readonly size='5'>
                                    </td>
                                    <td class='td_e' >
                                          Over Time Allowance
                                    </td>";
                        }
                        else if($jvtype==3)
                        {
                              echo"<td class='td_e' align='center'>
                                          <input type='text' name='txtsalgl' value='40301' class='input_e' readonly size='5'>
                                    </td>
                                    <td class='td_e' >
                                          Bonus
                                    </td>";
                        }
                        else
                        {
                              echo"<td class='td_e' align='center'>
                                          <input type='text' name='txtsalgl' value='' class='input_e' readonly size='5'>
                                    </td>
                                    <td class='td_e' >
                                          Gratuity
                                    </td>";
                        }
                        echo"       <td class='td_e' align='center'>
                                    <input type='text' name='txtdr' value='$total' style='text-align: right' class='input_e' readonly>
                                   </td>
                                     <td class='td_e' >
                                    &nbsp;
                                    </td>
                              </tr>
                              <tr>
                                    <td class='td_e' align='center'> ";
                                    if($jvtype==1)
                                    {
                                          echo"<input type='text' name='txtprovgl' value='20507' class='input_e' readonly size='5'>";
                                    }
                                    else if($jvtype==2)
                                    {
                                          echo"<input type='text' name='txtprovgl' value='20510' class='input_e' readonly size='5'>";
                                    }
                                    else if($jvtype==3)
                                    {
                                          echo"<input type='text' name='txtprovgl' value='20511' class='input_e' readonly size='5'>";
                                    }
                                    else if($jvtype==4)
                                    {
                                          echo"<input type='text' name='txtprovgl' value='20401' class='input_e' readonly size='5'>";
                                    }
                                    echo"</td>
                                    <td class='td_e' >
                                    Provision
                                    </td>
                                    <td class='td_e'>
                                     &nbsp;
                                    </td>
                                    <td class='td_e' align='center'>

                                    <input type='text' name='txtcr' value='$total' style='text-align: right' class='input_e' readonly>
                                    </td>
                              </tr>
                              ";



                        echo" <tr>
                                    <td class='button_cell_e' align='center' colspan='4'>
                                          <input type='hidden' value='$i' name='TotalIndex'>
                                          <input type='button' value='Submit' name='btnsubmit' class='forms_button_e' onclick='submitform()'>
                                    </td>
                              </tr>
                              </table>";
                  }
              }
            }
            }
      }
      

?>



</form>

</body>

</html>
