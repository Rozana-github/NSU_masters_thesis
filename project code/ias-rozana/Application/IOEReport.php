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
<meta http-equiv='Content-Type' content='text/html; charset=windows-1252'>
<LINK href="Style/generic_report.css" type='text/css' rel='stylesheet'>
<link rel='stylesheet' type='text/css' href='Style/eng_report.css' />

<script language="JavaScript" src="Script/NumberFormat.js"></script>

<script language="JavaScript" src="Script/calendar1.js"></script>

<script language='JavaScript'>


</script>

</head>

<body >






<?PHP

            if(isset($enabledate))
            {
                  if($rdotype!='-1')
                  {
                        $employeequery="
                                    SELECT
                                          mas_ioe.serial_no,
                                          mas_ioe.employeeobjectid,
                                          mas_ioe.amount,
                                          DATE_FORMAT(mas_ioe.received_date, '%d-%m-%Y') As Issuedate,
                                          DATE_FORMAT(mas_ioe.expected_pay_date, '%d-%m-%Y') As exppaydate,
                                          mas_ioe.purpose,
                                          mas_ioe.remarks,
                                          DATE_FORMAT(mas_ioe.pay_date, '%d-%m-%Y') As paydate,
                                          mas_employees.employee_name

                                    FROM
                                          mas_ioe
                                          left join mas_employees on mas_ioe.employeeobjectid=mas_employees.employeeobjectid
                                    where
                                          mas_ioe.received_date between STR_TO_DATE('$fYear-$fMonth-$fDay','%Y-%c-%e') and STR_TO_DATE('$tYear-$tMonth-$tDay','%Y-%c-%e')
                                          and mas_ioe.status='".$rdotype."'
                                    ";
                   }
                   else
                   {
                        $employeequery="
                                    SELECT
                                          mas_ioe.serial_no,
                                          mas_ioe.employeeobjectid,
                                          mas_ioe.amount,
                                          DATE_FORMAT(mas_ioe.received_date, '%d-%m-%Y') As Issuedate,
                                          DATE_FORMAT(mas_ioe.expected_pay_date, '%d-%m-%Y') As exppaydate,
                                          mas_ioe.purpose,
                                          mas_ioe.remarks,
                                          DATE_FORMAT(mas_ioe.pay_date, '%d-%m-%Y') As paydate,
                                          mas_employees.employee_name

                                    FROM
                                          mas_ioe
                                          left join mas_employees on mas_ioe.employeeobjectid=mas_employees.employeeobjectid
                                    where
                                          mas_ioe.received_date between STR_TO_DATE('$fYear-$fMonth-$fDay','%Y-%c-%e') and STR_TO_DATE('$tYear-$tMonth-$tDay','%Y-%c-%e')

                                    ";
                   }
            }
            else
            {
                  if($rdotype!='-1')
                  {
                        $employeequery="
                                    SELECT
                                          mas_ioe.serial_no,
                                          mas_ioe.employeeobjectid,
                                          mas_ioe.amount,
                                          DATE_FORMAT(mas_ioe.received_date, '%d-%m-%Y') As Issuedate,
                                          DATE_FORMAT(mas_ioe.expected_pay_date, '%d-%m-%Y') As exppaydate,
                                          mas_ioe.purpose,
                                          mas_ioe.remarks,
                                          DATE_FORMAT(mas_ioe.pay_date, '%d-%m-%Y') As paydate,
                                          mas_employees.employee_name

                                    FROM
                                          mas_ioe
                                          left join mas_employees on mas_ioe.employeeobjectid=mas_employees.employeeobjectid
                                    where
                                          mas_ioe.status='".$rdotype."'
                                    ";
                   }
                   else
                   {
                        $employeequery="
                                          SELECT
                                                mas_ioe.serial_no,
                                                mas_ioe.employeeobjectid,
                                                mas_ioe.amount,
                                                DATE_FORMAT(mas_ioe.received_date, '%d-%m-%Y') As Issuedate,
                                                DATE_FORMAT(mas_ioe.expected_pay_date, '%d-%m-%Y') As exppaydate,
                                                mas_ioe.purpose,
                                                mas_ioe.remarks,
                                                DATE_FORMAT(mas_ioe.pay_date, '%d-%m-%Y') As paydate,
                                                mas_employees.employee_name

                                          FROM
                                                mas_ioe
                                                left join mas_employees on mas_ioe.employeeobjectid=mas_employees.employeeobjectid
                                          ";
                   }
            }
            //echo $employeequery;
            $rsemployee=mysql_query($employeequery) or die();
            $numrows=mysql_num_rows($rsemployee);
            $total=0;
            if($numrows>0)
            {
                 if(isset($enabledate))
                 {
                        drawCompanyInformation("IOU Report","For the period of ".date("jS F, Y", mktime(0, 0, 0, $fMonth,$fDay,$fYear))." To ".date("jS F, Y", mktime(0, 0, 0, $tMonth,$tDay,$tYear)));
                 }
                 else
                 {
                        drawCompanyInformation("IOU Report","From Starting To ".date("jS F, Y"));
                 }
                  echo "
                         <TABLE  cellSpacing=0 cellPadding=0 width='100%'>


                              <TR>
                                    <Td  class='title_cell_e_l'>SLNo</Td>
                                    <Td  class='title_cell_e'>Employee Name</Td>
                                    <Td  class='title_cell_e'>Amount</Td>
                                    <Td  class='title_cell_e'>Isue Date</Td>
                                    <Td  class='title_cell_e'>Purpose</Td>
                                    <Td  class='title_cell_e'>Remarks</Td>
                                    
                              </TR>


                        ";
                  $i=0;
                  while($rows=mysql_fetch_array($rsemployee))
                  {
                        extract($rows);
                        $total=$total+$amount;
                        if($i%2==0)
                        {
                              $cls='even_td_e';
                              $lclass="even_left_td_e";
                        }
                        else
                        {
                              $cls='odd_td_e';
                              $lclass="odd_left_td_e";
                        }
                        echo"
                              <TR >
                                    <TD class='$lclass' align='center'>$serial_no&nbsp;</TD>
                                    <TD class='$cls' >&nbsp;$employee_name</TD>
                                    <TD class='$cls' align='Right'>&nbsp;$amount</TD>
                                    <TD class='$cls' align='center'>&nbsp;$Issuedate</TD>
                                    <TD class='$cls' >&nbsp;$purpose </TD>
                                    <TD class='$cls' >&nbsp;$remarks </TD>

                                    
                              </TR>
                        ";
                        $i++;
                  }
                  echo  "
                              <TR >
                                    <TD class='td_e_b_l' align='right' colspan='2'><b>Total</b></TD>

                                    <TD class='td_e_b' align='Right'>$total</TD>
                                    <TD class='td_e_b' align='center' colspan='3'>&nbsp;</TD>



                              </TR>
                        </TABLE>";

            }
            else
            {

                  drawNormalMassage("There is no Record");

            }

      
?>

</body>
</html>
