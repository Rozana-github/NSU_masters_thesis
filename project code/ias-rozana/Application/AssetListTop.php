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


<script language="JavaScript" src="Script/NumberFormat.js"></script>

<script language="JavaScript" src="Script/calendar1.js"></script>

<script language='JavaScript'>



function submitfrom()
{


        //frmMasAssetEntry.TotalIndex.value=index;

        if(document.frmMasAssetEntry.cboglcode.value=='-1')
        {
             alert('Value Required');
             document.frmMasAssetEntry.cboglcode.focus();
        }
        else
        {
                frmMasAssetEntry.submit();
        }
}




</script>

</head>

<body >




<form name='frmMasAssetEntry' method='post' action='AssetListBottom.php' target='bottomfrmForReport'>

<table border='0' width='90%'  align='center' cellpadding='3' cellspacing='0'>
        <tr>
                <td class='top_left_curb'></td>
                <td align='center' colspan='2' width='100%' class='header_cell_e'>
                        Asset List
                </td>
                <td class='top_right_curb'></td>
        </tr>
        <tr>
                <td class='lb'></td>
                <td align='right' class='td_e' >
                        Choose GLCode:
                </td>
                <td align='left'   class='td_e' >
                        <select name='cboglcode' class='select_e' onchange='submitfrom()'>
                        <?PHP
                              createCombo("GL","mas_gl","gl_code","description","where gl_code>10100 and gl_code<10200","");
                        ?>
                        </select>
               </td>
               <td class='rb'></td>
        </tr>
        <tr>
                <td class='bottom_l_curb'></td>
                <td colspan='2' width='100%' class='bottom_f_cell'>

                </td>
                <td class='bottom_r_curb'></td>
        </tr>
</table>


</form>



</body>

</html>
