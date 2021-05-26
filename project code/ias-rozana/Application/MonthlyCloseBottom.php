<?PHP
      include "Library/dbconnect.php";
      include "Library/Library.php";
      include "Library/SessionValidate.php";
?>

<html>
      <head>
            <meta http-equiv='Content-Type' content='text/html; charset=windows-1252'>
            <title>Invoice Posting</title>
            <script language='javascript'>
                  function sendData()
                  {
                        document.MyForm.submit();
                  }
            </script>
            <LINK href="Style/generic_form.css" type='text/css' rel='stylesheet'>
            <link rel='stylesheet' type='text/css' href='Style/eng_form.css' />
      </head>
      <body class='body_e'>
            <?PHP
                  $query="select
                              proc_month,
                              proc_year
                          from
                              mas_monthly_process
                          where
                              STR_TO_DATE(CONCAT('1','-',proc_month,'-',proc_year),'%e-%c-%Y')=DATE_SUB(STR_TO_DATE('1-$cboClosingMonth-$cboClosingYear','%e-%c-%Y'), INTERVAL 1 MONTH)
                         ";

                  //echo $query;
                  $rs=mysql_query($query) or die("Error: ".mysql_error());

                  if(mysql_num_rows($rs)<1)
                  {
                        drawNormalMassage("Can Not Be Processed, Previous Process Not Found.");
                        die();
                  }
                  else
                  {
                        $query="select
                                    proc_month,
                                    proc_year
                                from
                                    mas_monthly_process
                                where
                                    STR_TO_DATE(CONCAT('1','-',proc_month,'-',proc_year),'%e-%c-%Y')=DATE_ADD(STR_TO_DATE('1-$cboClosingMonth-$cboClosingYear','%e-%c-%Y'), INTERVAL 1 MONTH)
                         ";

                        //echo $query;
                        $rs=mysql_query($query) or die("Error: ".mysql_error());

                        if(mysql_num_rows($rs)>0)
                        {
                              drawNormalMassage("Can Not Be Processed, Next Process Found.");
                              die();
                        }
                        else
                        {
                              $query="select
                                          proc_month,
                                          proc_year,
                                          trial_balance,
                                          debtor,
                                          creditor
                                      from
                                          mas_monthly_process
                                      where
                                          proc_month='$cboClosingMonth' AND
                                          proc_year='$cboClosingYear'
                                     ";

                              //echo $query;
                              $rs=mysql_query($query) or die("Error: ".mysql_error());

                              if(mysql_num_rows($rs)>0)
                              {
                                    while($row=mysql_fetch_array($rs))
                                    {
                                          extract($row);
                                          $NewEntryFlag=true;
                                    }
                              }
                              else
                              {
                                    $trial_balance=0;
                                    $debtor=0;
                                    $creditor=0;
                                    $NewEntryFlag=false;
                              }
                        }
                  }
            ?>
            <form name="MyForm" method='POST' action='MonthlyCloseSave.php' target='MonthlyCloseBottom'>
            <?PHP
                  echo "<input type='hidden' name='ClosingMonth' value='$cboClosingMonth'>";
                  echo "<input type='hidden' name='ClosingYear' value='$cboClosingYear'>";

                  if($NewEntryFlag)
                        echo "<input type='hidden' name='NewEntryFlag' value='1'>";
            ?>
            <table width='20%' id='table1' cellspacing='0' cellpadding='0' align='center'>
                  <tr>
                        <td class='top_left_curb'></td>
                        <td colspan='2' class='header_cell_e' align='center'>Month Closing Detail</td>
                        <td class='top_right_curb'></td>
                  </tr>
                  <tr>
                        <td class='lb' rowspan='4'></td>
                        <td class='caption_e'>Trial Balance</td>
                        <td class='td_e'><input type='checkbox' name='chkTrialBalance' value='ON' <?PHP if($trial_balance!=0) echo "checked"; ?> ></td>
                        <td class='rb' rowspan='4'></td>
                  </tr>
                  <tr>
                        <td class='caption_e'>Debtor Ledger</td>
                        <td class='td_e'><input type='checkbox' name='chkDebtorLedger' value='ON' <?PHP if($debtor!=0) echo "checked"; ?> ></td>
                  </tr>
                  <tr>
                        <td class='caption_e'>Creditor Ledger</td>
                        <td class='td_e'><input type='checkbox' name='chkCreditorLedger' value='ON' <?PHP if($creditor!=0) echo "checked"; ?> ></td>
                  </tr>
                  <tr>
                        <td class='button_cell_e' align='center' colspan='2'><input value='process' type='button' name='btnsubmit' class='forms_button_e' onclick='sendData()'></td>
                  </tr>
                  <tr>
                        <td class='bottom_l_curb'></td>
                        <td class='bottom_f_cell' colspan='2'></td>
                        <td class='bottom_r_curb'></td>
                  </tr>
            </table>
            </form>
      </body>
</html>
<?PHP
      mysql_close();
?>
