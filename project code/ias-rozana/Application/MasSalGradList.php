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
      if(document.frmEmployeeEntry.txtempno.value=='' )
      {
            alert("You Must Enter Employee No");
            document.frmEmployeeEntry.txtempno.focus();
      }
      else if(document.frmEmployeeEntry.txtempname.value=='' )
      {
            alert("You Must Enter Employee Name");
            document.frmEmployeeEntry.txtempname.focus();
      }
      else
      {
            document.frmEmployeeEntry.submit();
      }
}
function Createnewdesignation()
{
        window.location="MasSalGradEntry.php";
}

function Editdesignation(val)
{
        window.location="MasSalGradEntry.php?updatevalue=1&allowanceID="+val+"";
}


</script>

</head>

<body class='body_e'>




<form name='frmEmployeeEntry' method='post' action='AddToEmployeeEntry.php'>
<TABLE width='100%' cellSpacing=0 cellPadding=0>
        <THEAD>
                <TR>
                        <TD  align='center' class='button_cell_e'>
                                <INPUT type='button' value='New Grad' onClick="Createnewdesignation()" class='forms_button_e' style="WIDTH:100px">
                        </TD>
                </TR>
                <TR>
                        <TD style="WIDTH:100%" align='center'>
                                &nbsp;
                        </TD>
                </TR>

        </THEAD>
</TABLE>


<?PHP
      echo "<input type='hidden' name='mkdecession' value=''>";
      $employeequery="
                        select
                              sal_grad_id,
                              grad_name as description,
                              basic_salary,
                              medical_allowance,
                              convance,
                              utility_allowance,
                              special_allowance,
                              maintenance_allowance,
                              inflation_allowance,
                              transport,
                              others_allowance_id,
                              date_format(effctive_from,'%d-%m-%Y') as effectdate,
                              status,
                              entry_date,
                              increment_date
                        from
                              mas_sal_info


                  ";
      //echo $employeequery;
      $rsemployee=mysql_query($employeequery) or die(mysql_error());
      $numrows=mysql_num_rows($rsemployee);
      if($numrows>0)
      {

            $i=0;
            echo "
                   <table border='0' width='100%'  cellspacing='0' cellpadding='0'>

                              <TR>
                                    <Td class='title_cell_e'>Description</Td>

                                    <Td class='title_cell_e'>Effctive Date</Td>

                              </TR>

                  ";
            while($rows=mysql_fetch_array($rsemployee))
            {
                  extract($rows);
                  if($i%2==0)
                        $cls='even_td_e';
                  else
                        $cls='odd_td_e';

                   echo"
                              <TR  id=set1_row1 onClick='Editdesignation(\"$sal_grad_id\")' style=\"cursor: hand;\">

                                    <TD class='$cls' style=\"cursor: hand;\"  align='center'>$description</TD>

                                    <TD class='$cls' style=\"cursor: hand;\"  align='center'>$effectdate</TD>

                              </TR>
                        ";
                        $i++;
                  
                  



            }
            echo  "
                  </TABLE>";

      }
?>




</form>



</body>

</html>
