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

function CreateNewParty()
{
        var popit=window.open('IOEDetailEntry.php','console','status,scrollbars,width=620,height=200');
}

function EditPartyEntry(val)
{
        var popit=window.open("IOEDetailUpdate.php?Serialno="+val+"",'console','status,scrollbars,width=620,height=200');
}
</script>

</head>

<body class='body_e'>




<form name='frmIOEEntry' method='post' action='AddToEmployeeEntry.php'>
<TABLE cellSpacing=0 cellPadding=0 width='100%'>
        <THEAD>
                <TR>
                        <TD align='center' class='button_cell_e'>
                                <INPUT type='button' value='New IOU' onClick="CreateNewParty()" class='forms_button_e' style="WIDTH:100px">
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

      $employeequery="
                        SELECT
                              mas_ioe.serial_no,
                              mas_ioe.employeeobjectid,
                              mas_ioe.amount,
                              mas_ioe.received_date,
                              DATE_FORMAT(mas_ioe.expected_pay_date, '%d-%m-%Y') As paydate,
                              mas_ioe.purpose,
                              mas_ioe.pay_date,
                              mas_employees.employee_name,
                              mas_designation.description
                              
                        FROM
                              mas_ioe
                              left join mas_employees on mas_ioe.employeeobjectid=mas_employees.employeeobjectid
                              left join mas_designation on mas_designation.designationid=mas_employees.designationid

                  ";
      $rsemployee=mysql_query($employeequery) or die();
      $numrows=mysql_num_rows($rsemployee);
      if($numrows>0)
      {
           echo "
                   <table border='0' width='100%'  cellspacing='0' cellpadding='0'>

                              <TR>
                                    <Td class='title_cell_e'>SLNo</Td>
                                    <Td class='title_cell_e'>Employee Name</Td>
                                    <Td class='title_cell_e'>Designation</Td>
                                    <Td class='title_cell_e'>Amount</Td>
                                    <Td class='title_cell_e'>Pay Date</Td>
                              </TR>


                  ";
            $i=0;
            while($rows=mysql_fetch_array($rsemployee))
            {
                  extract($rows);
                  if($i%2==0)
                        $cls='even_td_e';
                  else
                        $cls='odd_td_e';
                  echo"
                              <TR id=set1_row1 onClick='EditPartyEntry(\"$serial_no\")' style='border:0;cursor:hand'>
                                    <TD class='$cls' style=\"cursor: hand;\">$serial_no</TD>
                                    <TD class='$cls' style=\"cursor: hand;\" >$employee_name</TD>
                                    <TD class='$cls' style=\"cursor: hand;\" >$description</TD>
                                    <TD class='$cls' style=\"cursor: hand;\" align='right'>$amount</TD>
                                    <TD class='$cls' style=\"cursor: hand;\" align='center'>$paydate</TD>
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
