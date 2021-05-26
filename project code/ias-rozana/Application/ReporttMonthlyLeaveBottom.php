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

<link rel='stylesheet' type='text/css' href='Style/eng_report.css' />
<link rel='stylesheet' type='text/css' href='Style/interface_styles.css' />

<script language="JavaScript" src="Script/NumberFormat.js"></script>

<script language="JavaScript" src="Script/calendar1.js"></script>

<script language='JavaScript'>

</script>

</head>

<body class='body_e'>




<form name='frmEmployeeEntry' method='post' action=''>



<?PHP
      echo "<input type='hidden' name='mkdecession' value=''>";
      $employeequery="
                       SELECT
                              mas_employees.employee_name,
                              mas_designation.description,
                              sum(a.numberofday) as leavedays
                        FROM
                              (select
                                    emp_id,
                                    datediff(trn_emp_leave.ending_date,trn_emp_leave.starting_date) as numberofday
                              from
                                    trn_emp_leave
                              where
                                   trn_emp_leave.starting_date between STR_TO_DATE('1-$cboMonth-$cboYear','%d-%m-%Y')
                                   and last_day(str_to_date('1-$cboMonth-$cboYear','%d-%m-%Y'))
                              ) as a
                              left join mas_employees on mas_employees.employeeobjectid=a.emp_id
                              left join  mas_designation on mas_designation.designationid=mas_employees.designationid
                        group by
                              a.emp_id




                  ";
       //echo $employeequery;
      $rsemployee=mysql_query($employeequery) or die();
      $numrows=mysql_num_rows($rsemployee);
      if($numrows>0)
      {

            $i=0;
            drawCompanyInformation("Leave Information for the Month of ".date("F, Y", mktime(0, 0, 0, $cboMonth,1,$cboYear)),"");
            echo "
                   <table border='0' width='95%' align='center' cellspacing='0' cellpadding='0'>

                              <TR>
                                    <Td class='title_cell_e_l'>Employee Name</Td>
                                    <Td class='title_cell_e_l'>Designation</Td>
                                     <Td class='title_cell_e'>Number Of Days</Td>

                                    
                              </TR>

                  ";
            while($rows=mysql_fetch_array($rsemployee))
            {
                  extract($rows);
                   if(($i%2)==0)
                              {
                                    $cls="even_td_e";
                                    $lcls="even_left_td_e";
                              }
                              else
                              {
                                    $cls="odd_td_e";
                                    $lcls="odd_left_td_e";
                              }

                   echo"
                              <TR >
                                    <TD class='$lcls' >$employee_name</TD>
                                    <TD class='$lcls' align='center' >$description</TD>
                                    <TD class='$cls'  align='center'>$leavedays</TD>




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
