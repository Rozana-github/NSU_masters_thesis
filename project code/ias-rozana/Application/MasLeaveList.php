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



function Createnewdesignation()
{
        window.location="MasLeaveEntry.php";
}

function Editdesignation(val)
{
        window.location="MasLeaveEntry.php?updatevalue=1&leaveID="+val+"";
}


</script>

</head>

<body class='body_e'>




<form name='frmEmployeeEntry' method='post' action=''>
<TABLE width='100%' cellSpacing=0 cellPadding=0>
        <THEAD>
                <TR>
                        <TD  align='center' class='button_cell_e'>
                                <INPUT type='button' value='New Leave' onClick="Createnewdesignation()" class='forms_button_e' style="WIDTH:100px">
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
                              leave_id,
                              leave_name,
                              yearly_allocated
                        from
                              mas_leave


                  ";
      //echo $employeequery;
      $rsemployee=mysql_query($employeequery) or die(mysql_error());
      $numrows=mysql_num_rows($rsemployee);
      if($numrows>0)
      {

            $i=0;
            echo "
                   <table border='0' width='90%' align='center'  cellspacing='0' cellpadding='0'>

                              <TR>
                                    <Td class='title_cell_e'>SL No.</Td>
                                    <Td class='title_cell_e'>Description</Td>

                                    <Td class='title_cell_e'>Number Of Days</Td>

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
                              <TR  id=set1_row1 onClick='Editdesignation(\"$leave_id\")' style=\"cursor: hand;\">

                                    <TD class='$cls' style=\"cursor: hand;\"  align='center'>".($i+1)."</TD>
                                    <TD class='$cls' style=\"cursor: hand;\"  >$leave_name</TD>

                                    <TD class='$cls' style=\"cursor: hand;\"  align='right'>$yearly_allocated</TD>

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
