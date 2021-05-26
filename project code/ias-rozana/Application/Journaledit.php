<?PHP
        include "Library/dbconnect.php";
        include "Library/Library.php";
        include "Library/SessionValidate.php";
?>
<?PHP

?>
<?PHP
if ($rtype=='E')
{
      $query="SELECT
                  mas_journal.journalno,
                  mas_journal.chequeno,
                  DATE_FORMAT(mas_journal.journaldate,'%d-%m-%Y') as journaldate,
                  DATE_FORMAT(mas_journal.chequedate,'%d-%m-%Y') as chequedate,
                  mas_journal.paytype,
                  mas_journal.journaltype,
                  mas_journal.remarks,
                  mas_supplier.supplier_id,
                  mas_supplier.Company_Name as supplier,
                  mas_customer.customer_id,
                  mas_customer.Company_Name as customer,
                  mas_journal.bankid,
                  mas_journal.accountno,
                  mas_journal.tobankid,
                  mas_journal.toaccountno
            FROM
                  mas_journal
                  LEFT JOIN mas_supplier on mas_supplier.supplier_id=mas_journal.supplierid
                  LEFT JOIN mas_customer on mas_customer.customer_id=mas_journal.partyid
            WHERE
                  mas_journal.journalid='$sjournalid'
            ";

}
      // echo $query;

        $ResultSet= mysql_query($query)
                or die("Information was not processed");

        while ($qry_row=mysql_fetch_array($ResultSet))
        {
                  $journalno=$qry_row["journalno"];
                  $journaldate=$qry_row["journaldate"];
                  $payto=$qry_row["supplier"].$qry_row["customer"];
                  $journaltype=$qry_row["journaltype"];
                  $remarks=$qry_row["remarks"];
                  $chequeno=$qry_row["chequeno"];
                  $chequedate=$qry_row["chequedate"];
                  $paytype=$qry_row["paytype"];
                  $customerid=$qry_row["customer_id"];
                  $supplierid=$qry_row["supplier_id"];
                  $bank=$qry_row["bankid"];
                  $account=$qry_row["accountno"];
                  $tobank=$qry_row["tobankid"];
                  $toaccount=$qry_row["toaccountno"];
        }
        $vdate=explode("-",$journaldate) ;
        if($chequedate=='00-00-0000')
            $chequedate1='';
        else
            $chequedate1=$chequedate;

       $chdate=explode("-",$chequedate1) ;


if ($journaltype=='Rec' || $journaltype=='REC')
{
                //$vtype=Receipt;
               // drawCompanyInformation("Credit Voucher");
               //include "editRV.php";
               include "editCashReceivedBottom.php";
}
else if ($journaltype=='Pay')
{
                //$vtype=Payment;
               // drawCompanyInformation("Debit Voucher");
               include "editPV.php";
}
else if ($journaltype=='JV')
{
                //$vtype=Journal;
                //drawCompanyInformation("Journal Voucher");
                include "editJV.php";
}
else if ($journaltype=='TR')
{

                include "editTV.php";
}



?>
<?PHP /*
<br>
<center><b><u><font color="#000000" face="Verdana" size="3"> <?PHP //echo "$vtype Voucher"; ?> </b></u></center>
<br>
<TABLE width="100%">
<tr>
  <td width="20%" >
  <strong><font color="#000000" face="Verdana" size="2">Voucher No.
  </font></strong>
  </td>
  <td width="2%" >
  <strong><font color="#000000" face="Verdana" size="2"> :
  </font></strong>
  </td>
  <td width="36%" >
  <strong> <font color="#000000" face="Verdana" size="2"> <?PHP echo "$journalno"; ?>
  </font></strong>
  </td>
  <td width="20%" >
  <strong><font color="#000000" face="Verdana" size="2">Voucher Date.
  </font></strong>
  </td>
  <td width="2%" >
  <strong><font color="#000000" face="Verdana" size="2">:
  </font></strong>
  </td>
  <td width="20%" >
  <strong><font color="#000000" face="Verdana" size="2"><?PHP echo "<input type='text' name='vdate' value='$journaldate' >"; ?>
  </font></strong>
  </td>
</tr>



<tr>
  <td width="20%" >
  <strong><font color="#000000" face="Verdana" size="2"><?PHP if ($journaltype=='REC') { echo "Receive From";}else{echo "Pay To";} ?>
  </font></strong>
  </td>
  <td width="2%" >
  <strong><font color="#000000" face="Verdana" size="2"> :
  </font></strong>
  </td>
  <td width="36%" >
  <font color="#000000" face="Verdana" size="2">

      <?PHP
            if($journaltype=='REC')
            {
                  echo "<select name='cbocustomer'>";
                  createCombo("Supplier","mas_supplier","supplier_id","Company_Name","",$supplierid);
                  echo "</select>";
            }
            else
            {
                  echo "<select name='cbocustomer'>";
                  createCombo("Customer","mas_customer","customer_id","Company_Name","",$customerid);
                  echo "</select>";
            }
      ?>
  </font>
  </td>
  <td width="20%" >
  <strong><font color="#000000" face="Verdana" size="2"> Pay By
  </font></strong>
  </td>
  <td width="2%" >
  <strong><font color="#000000" face="Verdana" size="2"> :
  </font></strong>
  </td>
  <td width="20%" >
  <font color="#000000" face="Verdana" size="2">  <?PHP if($paytype=='Q'){ echo "Cheque";} if($paytype=='C'){ echo "Cash";} ?>
  </font>
  </td>
</tr>

<?PHP if ($journaltype=='Pay' || $journaltype=='REC') { ?>
<tr>
  <td width="20%" >
  <strong><font color="#000000" face="Verdana" size="2">Cheque No.
  </font></strong>
  </td>
  <td width="2%" >
  <strong><font color="#000000" face="Verdana" size="2"> :
  </font></strong>
  </td>
  <td width="36%" >
  <font color="#000000" face="Verdana" size="2">  <?PHP echo "$chequeno"; ?>
  </font>
  </td>
  <td width="20%" >
  <strong><font color="#000000" face="Verdana" size="2"> Cheque Date:
  </font></strong>
  </td>
  <td width="2%" >
  <strong><font color="#000000" face="Verdana" size="2"> :
  </font></strong>
  </td>
  <td width="20%" >
  <font color="#000000" face="Verdana" size="2">  <?PHP if($chequedate!="00-00-0000"){echo "$chequedate";} ?>
  </font>
  </td>
</tr>

<?PHP } ?>

<tr>
  <td width="20%" >
  <strong><font color="#000000" face="Verdana" size="2"> &nbsp;
  </font></strong>
  </td>
  <td width="2%" >
  <strong><font color="#000000" face="Verdana" size="2">
  </font></strong>
  </td>
  <td width="36%" >
  <strong><font color="#000000" face="Verdana" size="2">
  </font></strong>
  </td>
  <td width="20%" >
  <strong><font color="#000000" face="Verdana" size="2">
  </font></strong>
  </td>
  <td width="2%" >
  <strong><font color="#000000" face="Verdana" size="2">
  </font></strong>
  </td>
  <td width="20%" >
  <strong><font color="#000000" face="Verdana" size="2">
  </font></strong>
  </td>
</tr>
</TABLE>


<TABLE border="1" cellpadding="0" cellspacing="0" width="100%">
<TR height=22>
  <td width= "40%" >
  <strong>  <font color="#000000" face="Verdana" size="2"> <center> PARTICULARS</center></font>
  </strong>
  </td>
  <td width= "30%" >
  <strong>  <font color="#000000" face="Verdana" size="2"> <center> Heads of Accounts</center></font>
  </strong>
  </td>

  <td width= "15%" >
  <strong>  <font color="#000000" face="Verdana" size="2"> <center> Debit     </center></font></strong>
  </td>

  <td width= "15%" >
  <strong>  <font color="#000000" face="Verdana" size="2"> <center> Credit     </center></font></strong>
  </td>

</TR> */?>

<?PHP  /*

if ($rtype=='P'){
        $query="SELECT
                        mas_journal.journalno,
                        mas_journal.journaltype,
                        mas_journal.journaldate,
                        trn_journal.remarks,
                        mas_journal.payto,
                        trn_journal.amount,
                        trn_journal.ttype,
                        mas_gl.id,
                        mas_gl.description
                FROM
                        mas_journal
                        INNER JOIN trn_journal ON mas_journal.journalid = trn_journal.journalid
                        INNER JOIN mas_gl ON trn_journal.glcode = mas_gl.gl_code
                WHERE
                        mas_journal.journalid='$sjournalid'
                GROUP BY
                        mas_journal.journalno, mas_journal.journaltype, mas_journal.journaldate, mas_journal.payto, trn_journal.amount, trn_journal.ttype, mas_gl.gl_code, mas_gl.description
                ORDER BY
                        trn_journal.ttype Desc
                ";
}

//echo $query;

$TOTCR=0;
$TODDR=0;


        $ResultSet= mysql_query($query)
                or die("Information was not processed");

        while ($qry_row=mysql_fetch_array($ResultSet))
        {
                $descrip=$qry_row[remarks];
                $Type=$qry_row["ttype"];
                $DR=0;
                $CR=0;

                if($Type=="Dr")
                {
                        $DR=$qry_row["amount"];
                        $TOTDR=$TOTDR+$DR;
                        $CR=0;

                }
                else
                {
                        $DR=0;
                        $CR=$qry_row["amount"];
                        $TOTCR=$TOTCR+$CR;
                }
?>


 <TR height=22>
    <TD width="40%" > <font color="#000000" face="Arial"
        size="2"> <?PHP
                        if ($qry_row[journaltype]=='REC' && $qry_row[ttype]=='Dr'){echo"";}
                        if ($qry_row[journaltype]=='Pay' && $qry_row[ttype]=='Cr'){echo"";}
                        if ($qry_row[journaltype]=='JV' && $qry_row[ttype]=='Dr') {echo"";}
                        echo "&nbsp; $qry_row[remarks]";
                  ?> </font>
    </TD>
    <TD width="30%" > <font color="#000000" face="Arial"
        size="2"> <?PHP
                        if ($qry_row[journaltype]=='REC' && $qry_row[ttype]=='Dr'){ echo "&nbsp; To"; }
                        if ($qry_row[journaltype]=='Pay' && $qry_row[ttype]=='Cr'){ echo "&nbsp; To"; }
                        if ($qry_row[journaltype]=='JV' && $qry_row[ttype]=='Dr'){ echo "&nbsp; By"; }
                        echo "&nbsp; $qry_row[description]";
                  ?> </font>
    </TD>
    <TD width="15%" align="right"> <font color="#000000" face="Arial"
        size="2">
    <?PHP $nf=number_format($DR,2); echo "$nf";?> &nbsp;</font>
    </TD>
    <TD width="15%" align="right"> <font color="#000000" face="Arial"
        size="2">
    <?PHP $nf=number_format($CR,2); echo "$nf";?> &nbsp;</font>
    </TD>
 </TR>


<?PHP } ?>


 <TR height=22>
    <TD width="40%" > <font color="#000000" face="Arial"size="2">&nbsp; </font> </TD>
    <TD width="30%" > <font color="#000000" face="Arial" size="2">&nbsp;</font> </TD>
    <TD width="15%" > <font color="#000000" face="Arial" size="2">&nbsp;</font> </TD>
    <TD width="15%" > <font color="#000000" face="Arial" size="2">&nbsp;</font> </TD>
 </TR>

 <TR height=22>
    <TD width="40%" colspan="2" align="left"> <font color="#000000" face="Arial"size="2"><b> TOTAL </font> </TD>

    <TD width="15%" align="right"> <font color="#000000" face="Arial" size="2"><b><?PHP $nf=number_format($TOTDR,2); echo "$nf";?> &nbsp;</font> </TD>
    <TD width="15%" align="right"> <font color="#000000" face="Arial" size="2"><b><?PHP $nf=number_format($TOTCR,2); echo "$nf";?> &nbsp;</font> </TD>
 </TR>

 <TR height=22>
    <TD width="100%" colspan="4"> <font color="#000000" face="Arial"size="2" ><b>Narration:</b> &nbsp; <?PHP echo "$descrip"; ?> &nbsp; </font> </TD>

 </TR>

</TABLE>





<TABLE border='0' width="100%">
 <TR><TD width="25%">&nbsp;</TD> <TD width="25%">&nbsp;</TD><TD width="25%">&nbsp;</TD> <TD width="25%">&nbsp;</TD></TR>
 <TR><TD width="25%">&nbsp;</TD> <TD width="25%">&nbsp;</TD><TD width="25%">&nbsp;</TD> <TD width="25%">&nbsp;</TD></TR>
 <TR><TD width="25%">&nbsp;</TD> <TD width="25%">&nbsp;</TD><TD width="25%">&nbsp;</TD> <TD width="25%">&nbsp;</TD></TR>
 <TR><TD width="30%">__________</TD> <TD width="40%">__________</TD><TD width="30%">___________</TD></TR>
 <TR><TD width="30%">Prepared by</TD> <TD width="40%">Checked by</TD><TD width="30%">Authorized By</TD></TR>
</TABLE>   */
