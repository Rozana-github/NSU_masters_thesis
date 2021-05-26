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
                  function calculateAmount()
                  {
                        var Index=parseInt(document.MyForm.hidIndex.value);
                        var TotalDrAmount=0;
                        var TotalCrAmount=0;

                        for (var i=0;i<Index;i++)
                        {
                              if(document.MyForm.elements["chkClear["+i+"]"].checked)
                              {
                                    var DrAmount=document.MyForm.elements["txtDrAmount["+i+"]"].value;
                                    var CrAmount=document.MyForm.elements["txtCrAmount["+i+"]"].value;
                                    
                                    if(!isNaN(DrAmount) && DrAmount!="")
                                          TotalDrAmount=TotalDrAmount+parseFloat(document.MyForm.elements["txtDrAmount["+i+"]"].value);
                                    if(!isNaN(CrAmount) && CrAmount!="")
                                          TotalCrAmount=TotalCrAmount+parseFloat(document.MyForm.elements["txtCrAmount["+i+"]"].value);
                              }
                        }
                        document.MyForm.txtReconciliationDr.value=TotalDrAmount;
                        document.MyForm.txtReconciliationCr.value=TotalCrAmount;
                        
                        document.MyForm.txtUnreconciliationDr.value=parseFloat(document.MyForm.txtTotalDr.value)-TotalDrAmount;
                        document.MyForm.txtUnreconciliationCr.value=parseFloat(document.MyForm.txtTotalCr.value)-TotalCrAmount;
                  }
                  function sendValue()
                  {
                        var Index=parseInt(document.MyForm.hidIndex.value);

                        var Flag=true;
                        for (var i=0;i<Index;i++)
                        {
                              if(document.MyForm.elements["chkClear["+i+"]"].checked)
                              {
                                    Flag=false;
                              }
                        }
                        if(Flag)
                        {
                              alert("Please Select At List One Journal.");
                              return;
                        }

                        document.MyForm.action="ReconciliationSave.php";
                        document.MyForm.submit();
                  }
            </script>
            <link rel='stylesheet' type='text/css' href='Style/eng_report.css' />
<link rel='stylesheet' type='text/css' href='Style/interface_styles.css' />
      </head>
      <body class='body_e'>
            <?PHP
                 if($cboReconciliationMonth==1)
                 {
                        $pirvmonth=12;
                        $privyear=$cboReconciliationYear-1;
                }
                else
                {
                      $pirvmonth=$cboReconciliationMonth-1;
                        $privyear=$cboReconciliationYear;
                }
                $opendr=0;
                $opencr=0;
                 $querymas="select
                                          ifnull(closing_dr,0) as closing_dr,
                                          ifnull(closing_cr,0) as closing_cr,
                                          date_format(reconcile_date,'%d-%m-%Y') as last_reconcile_date
                                      from
                                          mas_accounts_reconcile
                                      where
                                          accountno='$cboBankAccount' AND
                                          rec_month='$pirvmonth' AND
                                          rec_year='$privyear'
                                          ";
                              //echo  $querymas;
                              $rsmas=mysql_query($querymas) or die("Error: ".mysql_error());

                              while($rowmas=mysql_fetch_array($rsmas))
                              {
                                    extract($row);
                               }

                $query="SELECT
                                journalid ,
                                journaltype ,
                                date_format(journaldate,'%d-%m-%Y') as journaldate,
                                chequeno ,
                                date_format(chequedate,'%d-%m-%Y') as chequedate ,
                                partyid ,
                                supplierid ,
                                glcode ,
                                dr_amount ,
                                cr_amount ,
                                reconcile_date ,
                                reconcile_status
                        FROM
                                trn_accounts_reconcile
                        WHERE
                                rec_year = '$cboReconciliationYear'
                                AND rec_month ='$cboReconciliationMonth'
                                AND accountno ='$cboBankAccount'
                        order by
                               journaldate
                        ";
                $rs=mysql_query($query)or die(mysql_error());
                if(mysql_num_rows($rs)>0)
                {
                        $i=0;
                        if($closing_dr=="")
                        {
                                $closing_dr=0;
                                $closing_cr=0;
                        }
                        $TotalDr=$TotalDr+$closing_dr;
                        $TotalCr=$TotalCr+$closing_cr;
                        $customer=pick("mas_customer","company_name","customer_id='$partyid'");
                        $supplier=pick("mas_supplier","company_name","supplier_id='$supplierid'");
                        drawCompanyInformation("Bank Reconciliation Report<br> For the month of  ".date("F, Y", mktime(0, 0, 0, $cboReconciliationMonth,1,$cboReconciliationYear)),"Account No: ".pick("trn_bank","account_no","account_object_id='$cboBankAccount'"));
                        
                       echo" <table width='100%' id='table1' cellspacing='0' cellpadding='0' align='center'>

                  <tr>
                        <td class='title_cell_e_l'>Last Reconciliation Date</td>
                        <td class='title_cell_e'>Opening Dr</td>
                        <td class='title_cell_e'>Opening Cr</td>
                  </tr>
                  <tr>
                        <td class='odd_left_td_e'>$last_reconcile_date&nbsp;</td>

                        <td class='odd_td_e'>$closing_dr</td>
                        <td class='odd_td_e'>$closing_cr</td>

                  </tr> </table>

                  ";
                        echo "<table width='100%' id='table1' cellspacing='0' cellpadding='0' align='center'>
                                    <tr><td colspan='11' class='odd_left_td_e'>Transection during the period:</td></tr>
                                    <tr>
                                          <td class='title_cell_e_l' >Sl.No</td>
                                          <td class='title_cell_e'>Journal Date</td>
                                          <td class='title_cell_e'>Journal No</td>
                                          <td class='title_cell_e'>Type</td>
                                          <td class='title_cell_e'>Cheque No</td>
                                          <td class='title_cell_e'>Cheque Date</td>
                                          <td class='title_cell_e'>Creditor</td>
                                          <td class='title_cell_e'>Debtor</td>
                                          <td class='title_cell_e'>Dr Amount</td>
                                          <td class='title_cell_e'>Cr Amount</td>
                                          <td class='title_cell_e'>status</td>

                                    </tr>
                                    ";
                        while($row=mysql_fetch_array($rs))
                        {
                                extract($row);
                                $TotalDr=$TotalDr+$dr_amount;
                                $TotalCr=$TotalCr+$cr_amount;
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
                                if($reconcile_status==1)
                                        $status='Cleared';
                                else
                                        $status='Not Cleared';
                                
                                echo "<tr>
                                          <td class='$lcls' >".($i+1)."</td>
                                          <td class='$cls'>$journaldate</td>
                                          <td class='$cls'>$journalid</td>
                                          <td class='$cls'>$journaltype</td>
                                          <td class='$cls'>$chequeno&nbsp;</td>
                                          <td class='$cls'>$chequedate&nbsp;</td>
                                          <td class='$cls'>$customer&nbsp;</td>
                                          <td class='$cls'>$supplier&nbsp;</td>
                                          <td class='$cls' align='right'>$dr_amount</td>
                                          <td class='$cls' align='right'>$cr_amount</td>
                                          <td class='$cls'>$status</td>

                                    </tr>";
                                    $i++;
                        }
                        echo "<tr>
                                          <td class='td_e_b_l' colspan='8' align='right' >Total</td>

                                          <td class='td_e_b' align='right'>$TotalDr</td>
                                          <td class='td_e_b' align='right'>$TotalCr</td>
                                          <td class='td_e_b'>&nbsp;</td>

                                    </tr>
                                </table>";
                }
                else
                {

                }

            ?>
      </body>
</html>
