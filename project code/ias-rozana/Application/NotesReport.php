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
<link rel='stylesheet' type='text/css' href='Style/eng_report.css' />
<link rel='stylesheet' type='text/css' href='Style/interface_styles.css' />

<script language="JavaScript" src="Script/NumberFormat.js"></script>

<script language="JavaScript" src="Script/calendar1.js"></script>

<script language='JavaScript'>


</script>

</head>

<body >

<form name='frmNotes' method='post' action='AddToNotesProcess.php' target='bottomfrmForReport'>




<?PHP

      $j=0;
      $totalcall=0;

                               //echo $employeequery;
                  if($fMonth=='-1')
                        drawCompanyInformation("Notes Report","For the year ended ".date("Y", mktime(0, 0, 0, 1,1,$fYear)));
                  else
                        drawCompanyInformation("Notes Report","For the Month ended ".date("F, Y", mktime(0, 0, 0, $fMonth,1,$fYear)));

                  echo "<table width='70%' id='table1' cellspacing='0' cellpadding='0' align='center'>
                              <tr>

                                          <td class='top_f_cell' colspan='3'></td>

                                    </tr>

                              <tr>

                                    <Td  class='button_cell_e' colspan='3' align='center'>Note-2.Accounts Receivable:</td>

                              </tr>";
                  drawreport(10400,$fYear,$fMonth);
                  echo "<br><table width='70%' id='table1' cellspacing='0' cellpadding='0' align='center'>

                              <tr>
                                    <td class='top_l_curb'></td>
                                          <td class='top_f_cell' colspan='3'></td>
                                          <td class='top_r_curb'></td>
                                    </tr>
                              <tr>
                                    <td class='lb'></td>
                                    <Td  class='button_cell_e' colspan='3' align='center'>
                                    Note-3.Stock,Stores & Spares:</td>
                                    <td class='rb'></td>
                              </tr>";
                  drawreport(10300,$fYear,$fMonth);
                  echo "<br><table width='70%' id='table1' cellspacing='0' cellpadding='0' align='center'>
                              <tr>
                                    <td class='top_l_curb'></td>
                                          <td class='top_f_cell' colspan='3'></td>
                                          <td class='top_r_curb'></td>
                                    </tr>

                              <tr>
                                    <td class='lb'></td>
                                    <Td  class='button_cell_e' colspan='3' align='center'>Note-4.Advance,Deposits & Prepayments:</td>
                                    <td class='rb'></td>
                              </tr>";
                  drawreport(10600,$fYear,$fMonth);
                  echo "<br><table width='70%' id='table1' cellspacing='0' cellpadding='0' align='center'>
                              <tr>
                                    <td class='top_l_curb'></td>
                                          <td class='top_f_cell' colspan='3'></td>
                                          <td class='top_r_curb'></td>
                                    </tr>

                              <tr>
                                    <td class='lb'></td>
                                    <Td  class='button_cell_e' colspan='3' align='center'>Note-5.Cash & Bank Balance</td>
                                    <td class='rb'></td>
                              </tr>";
                              
                  drawreport(10200,$fYear,$fMonth);
                  

                   $query6note="select
                                    proc_year,
                                    proc_month,
                                    trn_amount
                              from
                                    mas_ytd_balance
                              where
                                    proc_year='$fYear'
                                    and note_no ='6'
                              Order by
                                    proc_month";
                   $rs6note=mysql_query($query6note)or die(mysql_error());
                   if(mysql_num_rows($rs6note)>0)
                   {
                       echo "<br><table width='70%' id='table1' cellspacing='0' cellpadding='0' align='center'>
                              <tr>
                                    <td class='top_l_curb'></td>
                                          <td class='top_f_cell' colspan='3'></td>
                                          <td class='top_r_curb'></td>
                                    </tr>

                              <tr>
                                    <td class='lb'></td>
                                    <Td  class='button_cell_e' colspan='3' align='center'>Note-6.Retained Earnings for the Period ended $fYear</td>
                                    <td class='rb'></td>
                              </tr>
                              <TR>
                                    <td class='lb'></td>
                                    <Td  class='title_cell_e'>SLNo</Td>
                                    <Td  class='title_cell_e'>Name of the Project</Td>
                                    <Td  class='title_cell_e'>Amount</Td>
                                    <td class='rb'></td>
                              </TR>";
                        $i=0;
                        $totalprofit=0;
                        while($row6note=mysql_fetch_array($rs6note))
                        {
                              extract($row6note);
                              if($i%2==0)
                              {
                                    $cls='even_td_e';
                              }
                              else
                              {
                                    $cls='odd_td_e';
                              }
                              $totalprofit=$totalprofit+ $trn_amount;
                              echo"   <tr>
                                          <td class='lb'></td>
                                          <TD class='$cls' align='center'>".($i+1)."&nbsp;</TD>
                                          <TD class='$cls' >Profit/Loss for ".date("F, Y", mktime(0, 0, 0, $proc_month,1,$fYear))."</TD>
                                          <TD class='$cls' align='Right'>".number_format(abs($trn_amount),0,'.',',')."</TD>
                                          <td class='rb'></td>
                                    </tr>
                              ";
                              $i++;
                              
                        }
                        echo"   <tr>
                                          <td class='lb'></td>
                                          <TD class='$cls' align='center'>&nbsp;</TD>
                                          <TD class='$cls' >&nbsp;</TD>
                                          <TD class='$cls' align='Right'>".number_format(abs($totalprofit),0,'.',',')."</TD>
                                          <td class='rb'></td>
                                    </tr>
                              </table>
                              ";
                        
                   }
                   
                  /*echo "<br><br><table><tr><td><b>Note-6.Retained Earnings for the period ended 2008:</b></td></tr></table>";
                  drawreport($employeequery); */
                  echo "<br><table width='70%' id='table1' cellspacing='0' cellpadding='0' align='center'>
                              <tr>
                                    <td class='top_l_curb'></td>
                                          <td class='top_f_cell' colspan='3'></td>
                                          <td class='top_r_curb'></td>
                                    </tr>

                              <tr>
                                    <td class='lb'></td>
                                    <Td  class='button_cell_e' colspan='3' align='center'>Note-7.Liablities for Goods and Other finance</td>
                                    <td class='rb'></td>
                              </tr>
                              ";
                                    drawreport(20500,$fYear,$fMonth);
                  




            function drawreport($Startglcode,$fYear,$fMonth)
            {



                   $employeequery="SELECT
                                    mas_gl.description,
                                    mas_ytd_fin.glcode,
                                    sum(mas_ytd_fin.closing_dr - mas_ytd_fin.closing_cr) AS balance
                              FROM
                                    mas_ytd_fin
                                    INNER JOIN mas_gl ON mas_ytd_fin.glcode = mas_gl.gl_code
                              WHERE
                                    mas_ytd_fin.proc_year = '$fYear'
                                    AND mas_ytd_fin.proc_month = '$fMonth'
                                    and mas_ytd_fin.glcode between '".($Startglcode+1)."' and '".($Startglcode+99)."'
                              group by
                                    mas_ytd_fin.glcode
                        ";

                  //echo $employeequery;
                  echo "
                              <TR>
                                    <td class='lb'></td>
                                    <Td  class='title_cell_e'>SLNo</Td>
                                    <Td  class='title_cell_e'>Name of the Project</Td>
                                    <Td  class='title_cell_e'>Amount</Td>
                                    <td class='rb'></td>
                              </TR>


                        ";
                  global $j;
                  global $totalcall;
                  $i=0;
                  $total=0;
                  $rsfemployee=mysql_query($employeequery)or die(mysql_error());
                  while($rows=mysql_fetch_array($rsfemployee))
                  {
                        extract($rows);
                        $total=$total+$balance;
                        if($i%2==0)
                        {
                              $cls='even_td_e';

                        }
                        else
                        {
                              $cls='odd_td_e';

                        }
                        echo"
                              <TR >
                                    <td class='lb'></td>
                                    <TD class='$cls' align='center'>".($i+1)."&nbsp;</TD>
                                    <TD class='$cls' >&nbsp;$description</TD>
                                    <TD class='$cls' align='Right'>".number_format(abs($balance),0,'.',',')."</TD>
                                    <td class='rb'></td>
                                    <input type='hidden' name='txttrnglcode[$i]' value='$glcode'>
                                    <input type='hidden' name='txttrnbalance[$i]' value='".abs($balance)."'>



                              </TR>
                        ";
                        $i++;

                  }
                  if($i%2==0)
                        {
                              $cls='even_td_e';

                        }
                        else
                        {
                              $cls='odd_td_e';

                        }
                        
                  if($Startglcode==10600)
                  {
                        $totalimort="select sum(a.balance) as totalbalance
                           from
                              (SELECT
                                    mas_gl.description,
                                    mas_ytd_fin.glcode,
                                    sum(mas_ytd_fin.closing_dr - mas_ytd_fin.closing_cr) AS balance
                              FROM
                                    mas_ytd_fin
                                    INNER JOIN mas_gl ON mas_ytd_fin.glcode = mas_gl.gl_code
                              WHERE
                                    mas_ytd_fin.proc_year = '$fYear'
                                    AND mas_ytd_fin.proc_month = '$fMonth'
                                    and mas_ytd_fin.glcode between '".(10800+1)."' and '".(10800+99)."'
                              group by
                                    mas_ytd_fin.glcode)as a ";                  
                  $rstotalimp=mysql_query($totalimort)or die(mysql_error());
                        while($rowsimp=mysql_fetch_array($rstotalimp))
                  {
                        extract($rowsimp);
                  }
                        echo "<td class='lb'></td>
                                    <TD class='$cls' align='center'>".($i+1)."&nbsp;</TD>
                                    <TD class='$cls' >Import Cntrol</TD>
                                    <TD class='$cls' align='Right'>".number_format(abs($totalbalance),0,'.',',')."</TD>
                                    <td class='rb'></td>";
                  $i++;
                           
                        $inputcontrolquery="SELECT
                                    mas_gl.description,
                                    mas_ytd_fin.glcode,
                                    sum(mas_ytd_fin.closing_dr - mas_ytd_fin.closing_cr) AS balance
                              FROM
                                    mas_ytd_fin
                                    INNER JOIN mas_gl ON mas_ytd_fin.glcode = mas_gl.gl_code
                              WHERE
                                    mas_ytd_fin.proc_year = '$fYear'
                                    AND mas_ytd_fin.proc_month = '$fMonth'
                                    and mas_ytd_fin.glcode between '".(10800+1)."' and '".(10800+99)."'
                              group by
                                    mas_ytd_fin.glcode
                        ";
                        $rsinputcontrol=mysql_query($inputcontrolquery)or die(mysql_error());
                        while($rowsinputcontrol=mysql_fetch_array($rsinputcontrol))
                        {
                              extract($rowsinputcontrol);
                              $total=$total+$balance;
                              if($i%2==0)
                              {
                                    $cls='even_td_e';
                              }
                              else
                              {
                                    $cls='odd_td_e';
                              }
                              echo"
                                    <TR >
                                          <td class='lb'></td>
                                          <TD class='$cls' align='center'>".($i+1)."&nbsp;</TD>
                                          <TD class='$cls' >$description&nbsp;</TD>
                                          <TD class='$cls' align='Right'>".number_format(abs($balance),0,'.',',')."</TD>
                                          <td class='rb'></td>
                                          <input type='hidden' name='txttrnglcode[$i]' value='$glcode'>
                                          <input type='hidden' name='txttrnbalance[$i]' value='".abs($balance)."'>
                                    </TR>
                              ";
                              $i++;
                        }
                  }
                  echo  "
                              <TR >
                                    <td class='lb'></td>
                                    <TD class='$cls' align='right' colspan='2'><b>Total</b></TD>

                                    <TD class='$cls' align='Right'>".number_format(abs($total),0,'.',',')."</TD>
                                     <td class='rb'></td>
                                    <input type='hidden' name='txttolalamount[$totalcall]' value='".abs($total)."'>
                                    <input type='hidden' name='txtStartglcode[$totalcall]' value='$Startglcode'>
                                    <input type='hidden' name='totalsubrow[$totalcall]' value='$i'>



                              </TR>
                              <tr>
                                    <td class='bottom_l_curb'></td>
                                          <td class='bottom_f_cell' colspan='3'></td>
                                          <td class='bottom_r_curb'></td>
                                    </tr>

                        </TABLE>";
                        $totalcall++;
            }
            
            echo "<input type='hidden' name='totalrows' value='$totalcall'>
                  <input type='hidden' name='txtMonth' value='$fMonth'>
                  <input type='hidden' name='txtyear' value='$fYear'>";
      
?>

</body>
</html>
