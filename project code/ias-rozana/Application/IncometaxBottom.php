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
<link rel='stylesheet' type='text/css' href='Style/eng_form.css'>
<link rel='stylesheet' type='text/css' href='Style/generic_form.css'>
<link rel='stylesheet' type='text/css' href='Style/interface_styles.css' />

<script language="JavaScript" src="Script/NumberFormat.js"></script>

<script language="JavaScript" src="Script/calendar1.js"></script>

<script language='JavaScript'>


</script>

</head>

<body >

<form name='frmNotes' method='post' action='AddToIncome.php' target='bottomfrmForReport'>




<?PHP

      $i=0;
      $total=0;


                               //echo $employeequery;

                  echo "<table width='70%' id='table1' cellspacing='0' cellpadding='0' align='center'>
                              <tr>
                                    <td class='top_l_curb'></td>
                                          <td class='top_f_cell' colspan='4'></td>
                                          <td class='top_r_curb'></td>
                                    </tr>


                              <tr>
                                    <td class='lb'></td>
                                    <Td  class='title_cell_e'  align='center'>Particulars</td>
                                    <Td  class='title_cell_e'  align='center'>Note</td>
                                    <Td  class='title_cell_e'  align='center'>".date("F,Y",mktime(0,0,0,$fMonth,1,$fYear))."</td>
                                    <Td  class='title_cell_e'  align='center'>".date("F",mktime(0,0,0,1,1,1))." to ".date("F,Y",mktime(0,0,0,$fMonth,1,$fYear))."</td>
                                    <td class='rb'></td>
                              </tr>";



                  /*****************   income      ***************/
                  /*****************   Sales from printing works supplied      ***************/
                  
                  $queryopeningrawmaterial="select
                                                note_no,
                                                trn_amount,
                                                cum_amount
                                            from
                                                mas_ytd_note
                                            where
                                                mas_ytd_note.proc_year = '$fYear'
                                                AND mas_ytd_note.proc_month = '$fMonth'
                                                and mas_ytd_note.glcode ='30000'
                                          ";
                  $rsopeningrawmaterial=mysql_query($queryopeningrawmaterial)or die(mysql_error());
                  while($rowopeningrawmaterial=mysql_fetch_array($rsopeningrawmaterial))
                  {
                        extract($rowopeningrawmaterial);
                        $i++;


                  }
                  /*$qyerycumopen="select
                                                note_no,
                                                sum(cum_amount) as cum_amount
                                            from
                                                mas_ytd_note
                                            where
                                                mas_ytd_note.proc_year = '$fYear'
                                                AND mas_ytd_note.proc_month = '$fMonth'
                                                and mas_ytd_note.glcode ='30000'
                                                and note_no='8'
                                             group by
                                                mas_ytd_note.proc_year
                                          ";
                   echo $qyerycumopen;
                   $rscumopen=mysql_query($qyerycumopen)or die(mysql_error());
                   while($rowcum=mysql_query($rscumopen))
                   {
                        extract($rowcum);
                   } */
                   echo"<tr>
                                    <td class='lb'></td>
                                    <Td  class='even_td_e'  >Sales from printing works supplied</td>
                                    <Td  class='even_td_e'  align='center'>$note_no</td>
                                    <Td  class='even_td_e'  align='right'>".number_format(abs($trn_amount),0,'.',',')."</td>
                                    <Td  class='even_td_e'  align='right'>".number_format(abs($cum_amount),0,'.',',')."</td>
                                    <td class='rb'></td>
                              </tr>";

                  /*****************  Add: Miscellaneous receipt    ***************/
                  
                  $queryissuedstore="select
                                          ifnull(sum(mas_ytd_fin.closing_cr - mas_ytd_fin.closing_dr),0) as total_Mis_Receipt,
                                          ifnull(sum(mas_ytd_fin.month_cr - mas_ytd_fin.month_dr),0) as Mis_Receipt
                                          
                                    from
                                          mas_ytd_fin
                                    where
                                          mas_ytd_fin.proc_year = '$fYear'
                                          AND mas_ytd_fin.proc_month = '$fMonth'
                                          and mas_ytd_fin.glcode in( '30204','30210')
                                    ";
                   $rsissuedstore=mysql_query($queryissuedstore)or die(mysql_error());
                   while($rowissuedstore=mysql_fetch_array($rsissuedstore))
                   {
                        extract($rowissuedstore);
                        $i++;
                        echo"<tr>
                                    <td class='lb'></td>
                                    <Td  class='even_td_e'  colspan='2'>Add: Miscellaneous receipt</td>

                                    <Td  class='even_td_e'  align='right'>".number_format(abs($Mis_Receipt),0,'.',',')."</td>
                                    <Td  class='even_td_e'  align='right'>".number_format(abs($total_Mis_Receipt),0,'.',',')."</td>
                                    <td class='rb'></td>
                              </tr>";
                   }
                   
                   /*****************  Add: Interest from loans and advance    ***************/

                  $queryissuedstore="select
                                          ifnull(sum(mas_ytd_fin.closing_cr - mas_ytd_fin.closing_dr),0) as total_loan_advance,
                                          ifnull(sum(mas_ytd_fin.month_cr - mas_ytd_fin.month_dr),0) as loan_advance
                                    from
                                          mas_ytd_fin
                                    where
                                          mas_ytd_fin.proc_year = '$fYear'
                                          AND mas_ytd_fin.proc_month = '$fMonth'
                                          and mas_ytd_fin.glcode = '30205'
                                    ";
                   $rsissuedstore=mysql_query($queryissuedstore)or die(mysql_error());
                   while($rowissuedstore=mysql_fetch_array($rsissuedstore))
                   {
                        extract($rowissuedstore);
                        $i++;
                        echo"<tr>
                                    <td class='lb'></td>
                                    <Td  class='even_td_e'  colspan='2'>Add: Interest from loans and advance</td>

                                    <Td  class='even_td_e'  align='right'>".number_format(abs($loan_advance),0,'.',',')."</td>
                                    <Td  class='even_td_e'  align='right'>".number_format(abs($total_loan_advance),0,'.',',')."</td>
                                    <td class='rb'></td>
                              </tr>";
                   }

                   $totalincome=$trn_amount+$Mis_Receipt+$loan_advance;
                   $totalincomecum=$cum_amount+$total_Mis_Receipt+$total_loan_advance;
                   echo"<tr>
                                    <td class='lb'></td>

                                    <Td  class='even_td_e'  align='right' colspan='3'><b>".number_format(abs($totalincome),0,'.',',')."</b></td>
                                    <Td  class='even_td_e'  align='right'>".number_format(abs($totalincomecum),0,'.',',')."</td>
                                    <td class='rb'></td>
                              </tr>";

                   /********* Start of Less: Cost of printing work supplied  **********/


                   $queryworksupplied="select
                                                note_no,
                                                trn_amount,
                                                cum_amount
                                            from
                                                mas_ytd_note
                                            where
                                                mas_ytd_note.proc_year = '$fYear'
                                                AND mas_ytd_note.proc_month = '$fMonth'
                                                and mas_ytd_note.glcode ='30203'
                                          ";
                  $rsworksupplied=mysql_query($queryworksupplied)or die(mysql_error());
                  while($rowworksupplied=mysql_fetch_array($rsworksupplied))
                  {
                        extract($rowworksupplied);
                        $i++;


                  }
                  /*$queryworksuppliedcum="select
                                                note_no,
                                                sum(trn_amount) cum_amount
                                            from
                                                mas_ytd_note
                                            where
                                                mas_ytd_note.proc_year = '$fYear'
                                                AND mas_ytd_note.proc_month <= '$fMonth'
                                                and mas_ytd_note.glcode ='30203'
                                            group by
                                                mas_ytd_note.proc_year
                                          ";
                  $rsworksuppliedcum=mysql_query($queryworksuppliedcum)or die(mysql_error());
                  while($rowworksuppliedcum=mysql_fetch_array($rsworksuppliedcum))
                  {
                        extract($rowworksuppliedcum);
                  }*/
                  
                  echo"<tr>
                                    <td class='lb'></td>
                                    <Td  class='even_td_e'  >Less: Cost of printing work supplied</td>
                                    <Td  class='even_td_e'  align='center'>$note_no</td>
                                    <Td  class='even_td_e'  align='right'>".number_format(abs($trn_amount),0,'.',',')."</td>
                                    <Td  class='even_td_e'  align='right'>".number_format(abs($cum_amount),0,'.',',')."</td>
                                    <td class='rb'></td>
                              </tr>";
                  $totalincome=$totalincome- $trn_amount;
                  $totalincomecum=$totalincomecum- $cum_amount;
                  
                  echo"<tr>
                                    <td class='lb'></td>

                                    <Td  class='even_td_e'  align='right' colspan='3'><b>".number_format(abs($totalincome),0,'.',',')."</b></td>
                                    <Td  class='even_td_e'  align='right'>".number_format(abs($totalincomecum),0,'.',',')."</td>
                                    <td class='rb'></td>
                              </tr>";
                  /************************** Expenditure *********************************/
                  /************************** A.Expenditure: Administrative Expenses *********************************/
                   echo"<tr>
                                    <td class='lb'></td>
                                    <Td  class='even_td_e'  colspan='4'><b>A.Expenditure: Administrative Expenses<b></td>

                                    <td class='rb'></td>
                              </tr>";

                   $queryexpanditureA="SELECT
                                    mas_gl.description,
                                    mas_ytd_fin.glcode,
                                    sum(mas_ytd_fin.closing_dr - mas_ytd_fin.closing_cr) AS cum_balance,
                                    sum(mas_ytd_fin.month_dr - mas_ytd_fin.month_cr) AS balance
                              FROM
                                    mas_ytd_fin
                                    INNER JOIN mas_gl ON mas_ytd_fin.glcode = mas_gl.gl_code
                              WHERE
                                    mas_ytd_fin.proc_year = '$fYear'
                                    AND mas_ytd_fin.proc_month = '$fMonth'
                                    and mas_ytd_fin.glcode >'40000'
                                    and mas_ytd_fin.cost_code between '201' and '299'
                              group by
                                    mas_ytd_fin.glcode
                        ";
                 $totalexpanditureA=0;
                 $totalexpanditureACum=0;
                 $rsexpanditureA=mysql_query($queryexpanditureA)or die(mysql_error());
                 while($rowexpanditureA=mysql_fetch_array($rsexpanditureA))
                 {
                        extract($rowexpanditureA);
                        echo"<tr>
                                    <td class='lb'></td>
                                    <Td  class='even_td_e'  colspan='2'>$description</td>

                                    <Td  class='even_td_e'  align='right'>".number_format(abs($balance),0,'.',',')."</td>
                                    <Td  class='even_td_e'  align='right'>".number_format(abs($cum_balance),0,'.',',')."</td>
                                    <td class='rb'></td>
                              </tr>";
                        $totalexpanditureA=$totalexpanditureA+$balance;
                        $totalexpanditureACum=$totalexpanditureACum+$cum_balance;
                 }
                 
                 echo"<tr>
                                    <td class='lb'></td>

                                    <Td  class='even_td_e'  align='right' colspan='3'><b>".number_format(abs($totalexpanditureA),0,'.',',')."</b></td>
                                    <Td  class='even_td_e'  align='right'><b>".number_format(abs($totalexpanditureACum),0,'.',',')."</b></td>
                                    <td class='rb'></td>
                              </tr>";
                  
                  /******************************end of A.Expenditure: Administrative Expenses ***********************/


                  /************************** B. Selling and Distribution expanses*********************************/
                  echo"<tr>
                                    <td class='lb'></td>
                                    <Td  class='even_td_e'   colspan='4'><b>B. Selling and Distribution expanses</b></td>

                                    <td class='rb'></td>
                              </tr>";
                   $queryexpanditureB="SELECT
                                    mas_gl.description,
                                    mas_ytd_fin.glcode,
                                    sum(mas_ytd_fin.closing_dr - mas_ytd_fin.closing_cr) AS cum_balance,
                                    sum(mas_ytd_fin.month_dr - mas_ytd_fin.month_cr) AS balance
                              FROM
                                    mas_ytd_fin
                                    INNER JOIN mas_gl ON mas_ytd_fin.glcode = mas_gl.gl_code
                              WHERE
                                    mas_ytd_fin.proc_year = '$fYear'
                                    AND mas_ytd_fin.proc_month = '$fMonth'
                                    and mas_ytd_fin.glcode >'40000'
                                    and mas_ytd_fin.cost_code between '301' and '399'
                              group by
                                    mas_ytd_fin.glcode
                        ";
                 $totalexpanditureB=0;
                 $totalexpanditureBcum=0;
                 $rsexpanditureB=mysql_query($queryexpanditureB)or die(mysql_error());
                 while($rowexpanditureB=mysql_fetch_array($rsexpanditureB))
                 {
                        extract($rowexpanditureB);
                        echo"<tr>
                                    <td class='lb'></td>
                                    <Td  class='even_td_e'   colspan='2'>$description</td>

                                    <Td  class='even_td_e'  align='right'>".number_format(abs($balance),0,'.',',')."</td>
                                    <Td  class='even_td_e'  align='right'>".number_format(abs($cum_balance),0,'.',',')."</td>
                                    <td class='rb'></td>
                              </tr>";
                        $totalexpanditureB=$totalexpanditureB+$balance;
                        $totalexpanditureBcum=$totalexpanditureBcum+$cum_balance;
                 }


                 echo"<tr>
                                    <td class='lb'></td>

                                    <Td  class='even_td_e'  align='right' colspan='3'><b>".number_format(abs($totalexpanditureB),0,'.',',')."</b></td>
                                    <Td  class='even_td_e'  align='right'>".number_format(abs($totalexpanditureBcum),0,'.',',')."</td>
                                    <td class='rb'></td>
                              </tr>";


                  /******************************end of B. Selling and Distribution expanses ***********************/
                   $totalexpanditure=$totalexpanditureA+$totalexpanditureB;
                   $totalexpenditurecum=$totalexpanditureACum+$totalexpanditureBcum;
                   echo"<tr>
                                    <td class='lb'></td>
                                    <Td  class='even_td_e'   colspan='2'>Total Expanditure(A+B)</td>

                                    <Td  class='even_td_e'  align='right'>".number_format(abs($totalexpanditure),0,'.',',')."</td>
                                    <Td  class='even_td_e'  align='right'>".number_format(abs($totalexpenditurecum),0,'.',',')."</td>
                                    <td class='rb'></td>
                              </tr>";
                              
                   /****************************** End of Expanditure    ******************************************/
                   $netprofit=$totalincome-$totalexpanditure;
                   $netprofitcum=$totalincomecum-$totalexpenditurecum;
                   echo"<tr>
                                    <td class='lb'></td>
                                    <Td  class='even_td_e'   colspan='2'>Net Profit</td>

                                    <Td  class='even_td_e'  align='right'><b>".number_format(abs($netprofit),0,'.',',')."</b></td>
                                    <Td  class='even_td_e'  align='right'>".number_format(abs($netprofitcum),0,'.',',')."</td>
                                    <td class='rb'></td>
                              </tr>";


            echo "      <tr>
                              <td class='bottom_l_curb'></td>
                              <td class='bottom_f_cell' colspan='4'></td>
                              <td class='bottom_r_curb'></td>
                        </tr>
                  </table>
                  <input type='hidden' name='txttotal' value='".abs($netprofit)."'>
                  <input type='hidden' name='txttotalcum' value='".abs($netprofitcum)."'>
                  <input type='hidden' name='txtMonth' value='$fMonth'>
                  <input type='hidden' name='txtyear' value='$fYear'>";
      
?>
<table width=100%><tr><td class='button_cell_e' align='center'>
<input type='submit' value='Process' class='forms_Button_e' >
</td></tr></table>
</body>
</html>
