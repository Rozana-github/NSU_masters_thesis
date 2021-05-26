<?PHP
session_start();

        include_once("Library/dbconnect.php");
        include_once("Library/Library.php");

?>

<html xmlns:ycode>

<style>
        yCode\:combobox {behavior: url(combobox.htc); }
</style>

<head>

<link rel='stylesheet' type='text/css' href='Style/eng_form.css'>
<link rel='stylesheet' type='text/css' href='Style/generic_form.css'>
<link rel='stylesheet' type='text/css' href='Style/interface_styles.css' />

<script language="JavaScript" src="Script/NumberFormat.js"></script>

<script language="JavaScript" src="Script/calendar1.js"></script>

<script language='JavaScript'>


function Submitfrom()
{

            document.frmEmployeeEntry.submit();

}
function CreateNewParty()
{
        var popit=window.open('EmployeeInfoEntry.php','console','status,scrollbars,width=700,height=300');
}

function EditPartyEntry(val)
{
        var popit=window.open("EmpInfoUpdate.php?EmployeeID="+val+"",'console','status,scrollbars,width=700,height=300');
}


</script>

</head>

<body class='body_e'>




<form name='frmEmployeeEntry' method='post' action='AddTomas_asset_dep_setup.php'>


<?PHP
      echo "<input type='hidden' name='mkdecession' value=''>";
      $queryasset="SELECT
                        gl_code,
                        description,
                        cost_code,
                        asset_dep_glcode,
                        asset_acm_glcode
                  FROM
                        mas_gl
                        LEFT JOIN mas_asset_dep_setup ON asset_glcode = gl_code
                  WHERE
                        gl_code BETWEEN '10101' AND '10199'
                  ";
      //echo $employeequery;
      $rsasset=mysql_query($queryasset) or die(mysql_error());
      $numrows=mysql_num_rows($rsasset);
      if($numrows>0)
      {

            $i=0;
            echo "
                   <table border='0' width='100%'  cellspacing='0' cellpadding='0'>

                              <tr>
                                    <td class='top_left_curb'></td>
                                    <td colspan='5' align='center' class='header_cell_e'>Asset Depreciation Setup</td>
                                    <td class='top_right_curb'></td>
                              </tr>
                              <TR>
                                    <td class='lb'></td>
                                    <Td class='title_cell_e'>Gl Code</Td>
                                    <Td class='title_cell_e'>Asset Name</Td>
                                    <Td class='title_cell_e'>Depreciation Asset</Td>
                                    <Td class='title_cell_e'>Accumulated Asset</Td>
                                    <Td class='title_cell_e'>Cost Center</Td>
                                    <td class='rb'></td>
                              </TR>

                  ";
            while($rows=mysql_fetch_array($rsasset))
            {
                  extract($rows);
                  if($i%2==0)
                        $cls='even_td_e';
                  else
                        $cls='odd_td_e';

                   echo"
                              <TR  >
                                     <td class='lb'></td>
                                    <TD class='$cls' ><input type='text' name='txtasset_gl[$i]' value='$gl_code' class='input_e' size='5' readonly></TD>
                                    <TD class='$cls' >$description</TD>
                                    <TD class='$cls'  align='center'>
                                          <select name='cbodepreciation[$i]' class='select_e'>";
                                                createCombo("Asset","mas_gl","gl_code","description","where gl_code between '40801' and '40899'","$asset_dep_glcode");
                   echo"                  </select>
                                    </TD>
                                    <TD class='$cls' align='center'>
                                          <select name='cboAccumulated[$i]' class='select_e'>";
                                                createCombo("Asset","mas_gl","gl_code","description","where gl_code between '10701' and '10799'","$asset_acm_glcode");
                   echo"                  </select>
                                    </TD>
                                    <TD class='$cls' align='center'>
                                          <select name='cbocost_center[$i]' class='select_e'>";
                                                createCombo("Cost Center","mas_cost_center","cost_code","description","where id not in (select pid from mas_cost_center)","$cost_code");
                   echo"                  </select>
                                    </TD>
                                    <td class='rb'></td>


                        </TR>
                        ";
                        $i++;
                  
                  



            }
            echo  "<tr>
                        <input type='hidden' value='$i' name='txtTotalrow'>
                        <td class='lb'></td>
                        <td  colspan='5' align='center' class='button_cell_e'>
                              <input type='button' value='Submit' class='forms_Button_e' onclick='Submitfrom()'>
                        </td>
                        <td class='rb'></td>
                 </tr>
                 <tr>
                        <td class='bottom_l_curb'></td>
                        <td class='bottom_f_cell' colspan='5'></td>
                        <td class='bottom_r_curb'></td>

                  </tr>
                  </TABLE>";

      }
?>




</form>



</body>

</html>
