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
            <LINK href="Style/generic_form.css" type='text/css' rel='stylesheet'>
            <link rel='stylesheet' type='text/css' href='Style/eng_form.css' />
      </head>
      <body class='body_e'>
            <?PHP
                  $query="select
                              rec_month,
                              rec_year
                          from
                              mas_accounts_reconcile
                          where
                              accountno='$cboBankAccount' AND
                              rec_month='$cboReconciliationMonth' AND
                              rec_year='$cboReconciliationYear'";

                  //echo $query;
                  $rs=mysql_query($query) or die("Error: ".mysql_error());

                  if(mysql_num_rows($rs)>0)
                  {
                        drawNormalMassage("Reconciliation Exist");
                        die();
                  }
            ?>
            <form name="MyForm" method='POST' action='ReconciliationSave.php'>
            <?PHP
                  echo "<input type='hidden' name='hidReconciliationMonth' value='$cboReconciliationMonth'>";
                  echo "<input type='hidden' name='hidReconciliationYear' value='$cboReconciliationYear'>";
                  echo "<input type='hidden' name='hidBankAccount' value='$cboBankAccount'>";

                  $query="select
                              rec_month,
                              rec_year
                          from
                              mas_accounts_reconcile
                          where
                              accountno='$cboBankAccount' AND
                              STR_TO_DATE(CONCAT('1','-',rec_month,'-',rec_year),'%e-%c-%Y')<STR_TO_DATE('1-$cboReconciliationMonth-$cboReconciliationYear','%e-%c-%Y')
                          order by
                              STR_TO_DATE(CONCAT('1','-',rec_month,'-',rec_year),'%e-%c-%Y') desc
                          limit 0,1";

                  //echo $query;
                  $rs=mysql_query($query) or die("Error: ".mysql_error());

                  if(mysql_num_rows($rs)>0)
                  {
                        while($row=mysql_fetch_array($rs))
                        {
                              extract($row);
                              
                              $query="select
                                          closing_dr,
                                          closing_cr,
                                          reconcile_date
                                      from
                                          mas_accounts_reconcile
                                      where
                                          accountno='$cboBankAccount' AND
                                          rec_month='$rec_month' AND
                                          rec_year='$rec_year'
                                          ";

                              $rs=mysql_query($query) or die("Error: ".mysql_error());

                              while($row=mysql_fetch_array($rs))
                              {
                                    extract($row);
                              }
                        }
                  }
                  else
                  {
                        $closing_dr=0;
                        $closing_cr=0;
                        $reconcile_date="";
                  }
            ?>

            <table width='100%' id='table1' cellspacing='0' cellpadding='0' align='center'>
                  <tr>
                        <td class='top_left_curb'></td>
                        <td colspan='4' class='header_cell_e' align='center'>Reconciliation Form</td>
                        <td class='top_right_curb'></td>
                  </tr>
                  <tr>
                        <td class='lb' rowspan='2'></td>
                        <td class='caption_e'>Opening Dr</td>
                        <td class='td_e'><input type='text' class='input_e' name='txtOpeningDr' value='<?PHP echo $closing_dr; ?>' readonly></td>
                        <td class='caption_e'>Opening Cr</td>
                        <td class='td_e'><input type='text' class='input_e' name='txtOpeningCr' value='<?PHP echo $closing_cr; ?>' readonly></td>
                        <td class='rb'  rowspan='2'></td>
                  </tr>
                  <tr>
                        <td class='caption_e'>Last Recon. Date</td>
                        <td class='td_e'><input type='text' class='input_e' name='txtOpeningReconciliationDate' value='<?PHP echo $reconcile_date; ?>' readonly></td>
                        <td class='caption_e'>Recon. Date</td>
                        <td class='td_e'>
                              <select name='cboReconcilDay' class='select_e'>
                                    <?PHP
                                          $D=date('d');
                                          comboDay($D);
                                    ?>
                              </select>
                              <select name='cboReconcilMonth' class='select_e'>
                                    <?PHP
                                          $M=date('m');
                                          comboMonth($M);
                                    ?>
                              </select>
                              <select name='cboReconcilYear' class='select_e'>
                                    <?PHP
                                          $Y=date('Y');
                                          $PY=$Y-10;
                                          $NY=$Y+10;
                                          comboYear($PY,$NY,$Y);
                                    ?>
                              </select>
                        </td>
                 </tr>
                 <tr>
                        <td class='bottom_l_curb'></td>
                        <td class='bottom_f_cell' colspan='4'></td>
                        <td class='bottom_r_curb'></td>
                 </tr>
            </table>

            <?PHP

                  $i=0;
                  $TotalDr=0;
                  $TotalCr=0;
                  $flag1=true;
                  $flag2=true;
                  $flag3=true;
                  
                  if($reconcile_date!="")
                        $condition="mas_journal.journaldate>STR_TO_DATE('$reconcile_date','%Y-%c-%e') AND";
                  
                  $query="select
                              mas_journal.journalid,
                              DATE_FORMAT(mas_journal.journaldate,'%e-%c-%Y') AS journaldate,
                              mas_journal.journalno,
                              mas_journal.journaltype,
                              mas_journal.chequeno,
                              mas_journal.partyid,
                              mas_journal.supplierid,
                              DATE_FORMAT(mas_journal.chequedate,'%e-%c-%Y') AS chequedate,
                              trn_journal.glcode,
                              trn_journal.ttype,
                              trn_journal.amount
                          from
                              mas_journal
                              inner join trn_journal on mas_journal.journalid=trn_journal.journalid
                          where
                              mas_journal.accountno='$cboBankAccount' AND

                              mas_journal.journaldate <= last_day(STR_TO_DATE('$cboReconciliationYear-$cboReconciliationMonth-1','%Y-%c-%e'))and
                              trn_journal.glcode='10202' AND
                              mas_journal.journaltype != 'TR' and
                              mas_journal.journal_status='1' and
                              trn_journal.reconcile_status='0'

                        union
                        select
                              mas_journal.journalid,
                              DATE_FORMAT(mas_journal.journaldate,'%e-%c-%Y') AS journaldate,
                              mas_journal.journalno,
                              mas_journal.journaltype,
                              mas_journal.chequeno,
                              mas_journal.partyid,
                              mas_journal.supplierid,
                              DATE_FORMAT(mas_journal.chequedate,'%e-%c-%Y') AS chequedate,
                              trn_journal.glcode,
                              trn_journal.ttype,
                              ifnull(trn_journal.amount,0) as amount
                          from
                              mas_journal
                              inner join trn_journal on mas_journal.journalid=trn_journal.journalid
                          where
                              mas_journal.accountno='$cboBankAccount' AND

                              mas_journal.journaldate <= last_day(STR_TO_DATE('$cboReconciliationYear-$cboReconciliationMonth-1','%Y-%c-%e'))and
                              trn_journal.glcode='10202' AND
                              mas_journal.journaltype ='TR' and
                              mas_journal.journal_status ='1' and
                              trn_journal.ttype = 'Dr' and
                              trn_journal.reconcile_status ='0'
                        union
                        select
                              mas_journal.journalid,
                              DATE_FORMAT(mas_journal.journaldate,'%e-%c-%Y') AS journaldate,
                              mas_journal.journalno,
                              mas_journal.journaltype,
                              mas_journal.chequeno,
                              mas_journal.partyid,
                              mas_journal.supplierid,
                              DATE_FORMAT(mas_journal.chequedate,'%e-%c-%Y') AS chequedate,
                              trn_journal.glcode,
                              trn_journal.ttype,
                              ifnull(trn_journal.amount,0) as amount
                          from
                              mas_journal
                              inner join trn_journal on mas_journal.journalid=trn_journal.journalid
                          where
                              mas_journal.toaccountno='$cboBankAccount' AND

                              mas_journal.journaldate <= last_day(STR_TO_DATE('$cboReconciliationYear-$cboReconciliationMonth-1','%Y-%c-%e'))and
                              trn_journal.glcode='10202' AND
                              mas_journal.journaltype ='TR' and
                              mas_journal.journal_status ='1' and
                              trn_journal.ttype = 'Cr' and
                              trn_journal.reconcile_status ='0'

                        ";
                  //echo $query."<br>";
                  $rs=mysql_query($query) or die("Error: ".mysql_error());

                  $RowCount=mysql_num_rows($rs);
                  if($RowCount>0)
                  {
                        echo "<table width='100%' id='table1' cellspacing='0' cellpadding='0' align='center'>
                                    <tr>
                                          <td class='top_l_curb'></td>
                                          <td class='top_f_cell' colspan='6'></td>
                                          <td class='top_r_curb'></td>
                                    </tr>
                                    <tr>
                                          <td class='lb' rowspan='".($RowCount+1)."'></td>
                                          <td class='title_cell_e'>Journal Date</td>
                                          <td class='title_cell_e'>Journal No</td>
                                          <td class='title_cell_e'>Type</td>
                                          <td class='title_cell_e'>Dr Amount</td>
                                          <td class='title_cell_e'>Cr Amount</td>
                                          <td class='title_cell_e'>Clear</td>
                                          <td class='rb' rowspan='".($RowCount+1)."'></td>
                                    </tr>";
                                    
                        while($row=mysql_fetch_array($rs))
                        {
                              extract($row);

                              if(($i%2)==0)
                                    $class='even_td_e';
                              else
                                    $class='odd_td_e';
                                    
                              echo "<tr>
                                          <td class='$class'>
                                                $journaldate
                                                <input type='hidden' name='txtJournalDate[$i]' value='$journaldate'>
                                                <input type='hidden' name='txtJournalID[$i]' value='$journalid'>
                                                <input type='hidden' name='txtChequeNo[$i]' value='$chequeno'>
                                                <input type='hidden' name='txtChequeDate[$i]' value='$chequedate'>
                                                <input type='hidden' name='txtPartyID[$i]' value='$PartyID'>
                                                <input type='hidden' name='txtSupplierID[$i]' value='$SupplierID'>
                                                <input type='hidden' name='txtGLCode[$i]' value='$glcode'>
                                                <input type='hidden' name='txtInsertStatus[$i]' value='I'>
                                                <input type='hidden' name='txtttype[$i]' value='$ttype'>
                                                
                                          </td>
                                          <td class='$class'>$journalno</td>
                                          <td class='$class'>
                                                $journaltype
                                                <input type='hidden' name='txtJournalType[$i]' value='$journaltype'>
                                          </td>";
                                          if(strcmp($ttype,"Dr")==0)
                                          {
                                                $TotalDr=$TotalDr+$amount;
                                                echo "<td class='$class'><input type='text' class='input_e' name='txtDrAmount[$i]' value='$amount' readonly></td>";
                                                echo "<td class='$class'><input type='text' class='input_e' name='txtCrAmount[$i]' value='' readonly></td>";
                                          }
                                          else if(strcmp($ttype,"Cr")==0)
                                          {
                                                $TotalCr=$TotalCr+$amount;
                                                echo "<td class='$class'><input type='text' class='input_e' name='txtDrAmount[$i]' value='' readonly></td>";
                                                echo "<td class='$class'><input type='text' class='input_e' name='txtCrAmount[$i]' value='$amount' readonly></td>";
                                          }
                                          else
                                          {
                                                die("Error: Dr or Cr not specified.");
                                          }
                                          echo "<td class='$class'><input type='checkbox' name='chkClear[$i]' value='ON' onclick=\"calculateAmount()\"></td>
                                    </tr>";
                              $i++;
                        }
                        echo "<tr>
                                    <td class='bottom_l_curb'></td>
                                    <td class='bottom_f_cell' colspan='6'></td>
                                    <td class='bottom_r_curb'></td>
                              </tr>";
                        echo "</table>";
                  }
                  else
                  {
                        $flag1=false;
                  }
            ?>
            
            <?PHP
                /*  $query="select
                              mas_journal.journalid,
                              DATE_FORMAT(mas_journal.journaldate,'%e-%c-%Y') AS journaldate,
                              mas_journal.journalno,
                              mas_journal.journaltype,
                              mas_journal.chequeno,
                              mas_journal.partyid,
                              mas_journal.supplierid,
                              DATE_FORMAT(mas_journal.chequedate,'%e-%c-%Y') AS chequedate,
                              trn_journal.glcode,
                              trn_journal.ttype,
                              ifnull(trn_journal.amount,0) as amount
                          from
                              mas_journal
                              inner join trn_journal on mas_journal.journalid=trn_journal.journalid
                          where
                              mas_journal.accountno='$cboBankAccount' AND
                              $condition
                              trn_journal.glcode='10202' AND
                              mas_journal.journaltype ='TR' and
                              mas_journal.journal_status ='1' and
                              trn_journal.ttype = 'Dr' and
                              trn_journal.reconcile_status ='0'";
                  echo $query;
                  $rs=mysql_query($query) or die("Error: ".mysql_error());

                  $RowCount=mysql_num_rows($rs);
                  if($RowCount>0)
                  {
                        echo "<table width='100%' id='table1' cellspacing='0' cellpadding='0' align='center'>
                                    <tr>
                                          <td class='top_l_curb'></td>
                                          <td class='top_f_cell' colspan='6'></td>
                                          <td class='top_r_curb'></td>
                                    </tr>
                                    <tr>
                                          <td class='lb' rowspan='".($RowCount+1)."'></td>
                                          <td class='title_cell_e'>Journal Date</td>
                                          <td class='title_cell_e'>Journal No</td>
                                          <td class='title_cell_e'>Type</td>
                                          <td class='title_cell_e'>Dr Amount</td>
                                          <td class='title_cell_e'>Cr Amount</td>
                                          <td class='title_cell_e'>Clear</td>
                                          <td class='rb' rowspan='".($RowCount+1)."'></td>
                                    </tr>";

                        while($row=mysql_fetch_array($rs))
                        {
                              extract($row);

                              $TotalDr=$TotalDr+$amount;
                              //$TotalCr=$TotalCr+$amount;

                              if(($i%2)==0)
                                    $class='even_td_e';
                              else
                                    $class='odd_td_e';

                              echo "<tr>
                                          <td class='$class'>
                                                $journaldate
                                                <input type='hidden' name='txtJournalID[$i]' value='$journalid'>
                                                <input type='hidden' name='txtInsertStatus[$i]' value='U'>
                                          </td>
                                          <td class='$class'>$journalno</td>
                                          <td class='$class'>$journaltype</td>
                                          <td class='$class'><input type='text' class='input_e' name='txtDrAmount[$i]' value='$amount' readonly></td>
                                          <td class='$class'><input type='text' class='input_e' name='txtCrAmount[$i]' value='$cr_amount' readonly></td>
                                          <td class='$class'><input type='checkbox' name='chkClear[$i]' value='ON' onclick=\"calculateAmount()\"></td>
                                    </tr>";
                              $i++;
                        }
                        echo "<tr>
                                    <td class='bottom_l_curb'></td>
                                    <td class='bottom_f_cell' colspan='6'></td>
                                    <td class='bottom_r_curb'></td>
                              </tr>";
                        echo "</table>";
                  }
                  else
                  {
                        $flag2=false;
                  }
           ?>
            
            <?PHP
                  $query="select
                              mas_journal.journalid,
                              DATE_FORMAT(mas_journal.journaldate,'%e-%c-%Y') AS journaldate,
                              mas_journal.journalno,
                              mas_journal.journaltype,
                              mas_journal.chequeno,
                              mas_journal.partyid,
                              mas_journal.supplierid,
                              DATE_FORMAT(mas_journal.chequedate,'%e-%c-%Y') AS chequedate,
                              trn_journal.glcode,
                              trn_journal.ttype,
                              ifnull(trn_journal.amount,0) as amount
                          from
                              mas_journal
                              inner join trn_journal on mas_journal.journalid=trn_journal.journalid
                          where
                              mas_journal.toaccountno='$cboBankAccount' AND
                              $condition
                              trn_journal.glcode='10202' AND
                              mas_journal.journaltype ='TR' and
                              mas_journal.journal_status ='1' and
                              trn_journal.ttype = 'Cr' and
                              trn_journal.reconcile_status ='0'";
                  echo $query;
                  $rs=mysql_query($query) or die("Error: ".mysql_error());

                  $RowCount=mysql_num_rows($rs);
                  if($RowCount>0)
                  {
                        echo "<table width='100%' id='table1' cellspacing='0' cellpadding='0' align='center'>
                                    <tr>
                                          <td class='top_l_curb'></td>
                                          <td class='top_f_cell' colspan='6'></td>
                                          <td class='top_r_curb'></td>
                                    </tr>
                                    <tr>
                                          <td class='lb' rowspan='".($RowCount+1)."'></td>
                                          <td class='title_cell_e'>Journal Date</td>
                                          <td class='title_cell_e'>Journal No</td>
                                          <td class='title_cell_e'>Type</td>
                                          <td class='title_cell_e'>Dr Amount</td>
                                          <td class='title_cell_e'>Cr Amount</td>
                                          <td class='title_cell_e'>Clear</td>
                                          <td class='rb' rowspan='".($RowCount+1)."'></td>
                                    </tr>";

                        while($row=mysql_fetch_array($rs))
                        {
                              extract($row);

                              $TotalDr=$TotalDr+$amount;
                              $TotalCr=$TotalCr+$amount;
                              
                              if(($i%2)==0)
                                    $class='even_td_e';
                              else
                                    $class='odd_td_e';

                              echo "<tr>
                                          <td class='$class'>
                                                $journaldate
                                                <input type='hidden' name='txtJournalID[$i]' value='$journalid'>
                                                <input type='hidden' name='txtInsertStatus[$i]' value='U'>
                                          </td>
                                          <td class='$class'>$journalno</td>
                                          <td class='$class'>$journaltype</td>
                                          <td class='$class'><input type='text' class='input_e' name='txtDrAmount[$i]' value='$dr_amount' readonly></td>
                                          <td class='$class'><input type='text' class='input_e' name='txtCrAmount[$i]' value='$amount' readonly></td>
                                          <td class='$class'><input type='checkbox' name='chkClear[$i]' value='ON' onclick=\"calculateAmount()\"></td>
                                    </tr>";
                              $i++;
                        }
                        echo "<tr>
                                    <td class='bottom_l_curb'></td>
                                    <td class='bottom_f_cell' colspan='6'></td>
                                    <td class='bottom_r_curb'></td>
                              </tr>";
                        echo "</table>";
                  }
                  else
                  {
                        $flag3=false;
                  }
                  echo "<input type='hidden' name='hidIndex' value='$i'>";

                  if(!$flag1 && !$flag2 && !$flag3)
                  {
                        drawNormalMassage("No Information Available.");
                        die();
                  } */
                  echo "<input type='hidden' name='hidIndex' value='$i'>";
                  if(!$flag1 )
                  {
                        drawNormalMassage("No Information Available.");
                        die();
                  }
            ?>
            <table width='100%' id='table1' cellspacing='0' cellpadding='0' align='center'>
                  <tr>
                        <td class='top_l_curb'></td>
                        <td class='top_f_cell' colspan='6'></td>
                        <td class='top_r_curb'></td>
                  </tr>
                  <tr>
                        <td class='lb' rowspan='4'></td>
                        <td class='caption_e'>Total Dr</td>
                        <td class='td_e'><input type='text' class='input_e' name='txtTotalDr' value='<?PHP echo $TotalDr; ?>' readonly></td>
                        <td class='caption_e'>Reconciliation Dr</td>
                        <td class='td_e'><input type='text' class='input_e' name='txtReconciliationDr' readonly></td>
                        <td class='caption_e'>Unreconciliation Dr</td>
                        <td class='td_e'><input type='text' class='input_e' name='txtUnreconciliationDr' value='<?PHP echo $TotalDr; ?>' readonly></td>
                        <td class='rb' rowspan='4'></td>
                  </tr>
                  <tr>
                        <td class='caption_e'>Total Cr</td>
                        <td class='td_e'><input type='text' class='input_e' name='txtTotalCr' value='<?PHP echo $TotalCr; ?>' readonly></td>
                        <td class='caption_e'>Reconciliation Cr</td>
                        <td class='td_e'><input type='text' class='input_e' name='txtReconciliationCr' readonly></td>
                        <td class='caption_e'>Unreconciliation Cr</td>
                        <td class='td_e'><input type='text' class='input_e' name='txtUnreconciliationCr' value='<?PHP echo $TotalCr; ?>' readonly></td>
                  </tr>
                  <tr>
                        <td class='caption_e'>Remarks</td>
                        <td class='td_e' colspan='5'><textarea name='txaRemarks' cols='70'></textarea></td>
                  </tr>
                  <tr>
                        <td class='button_cell_e' align='center' colspan='6'><input value='Submit' type='button' name='btnsubmit' class='forms_button_e' onclick='sendValue()'></td>
                  </tr>
                  <tr>
                        <td class='bottom_l_curb'></td>
                        <td class='bottom_f_cell' colspan='6'></td>
                        <td class='bottom_r_curb'></td>
                  </tr>
            </table>
            </form>
      </body>
</html>
