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

<form name='frmNotes' method='post' action='AddToNotesProcess.php' target='bottomfrmForReport'>




<?PHP

      $j=0;
      $totalcall=0;

                               //echo $employeequery;

                  echo "<table width='70%' id='table1' cellspacing='0' cellpadding='0' align='center'>
                              <tr>
                                    <td class='top_l_curb'></td>
                                          <td class='top_f_cell' colspan='3'></td>
                                          <td class='top_r_curb'></td>
                                    </tr>

                              <tr>
                                    <td class='lb'></td>
                                    <Td  class='button_cell_e' colspan='3' align='center'>Note-2.Accounts Receivable:</td>
                                    <td class='rb'></td>
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
                              </tr>";
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
                        if($glcode!='10311'  &&  $glcode!='10312')
                              $total=$total+$balance;

                        if($i%2==0)
                        {
                              $cls='even_td_e';

                        }
                        else
                        {
                              $cls='odd_td_e';

                        }
                        if($glcode!='10311' &&  $glcode!='10312')
                        {
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
                        $j=0;
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
                                          <TD class='$cls' align='center'>&nbsp;</TD>
                                          <TD class='$cls' >".($j+1).". $description&nbsp;</TD>
                                          <TD class='$cls' align='Right'>".number_format(abs($balance),0,'.',',')."</TD>
                                          <td class='rb'></td>
                                          <input type='hidden' name='txttrnglcode[$i]' value='$glcode'>
                                          <input type='hidden' name='txttrnbalance[$i]' value='".abs($balance)."'>
                                    </TR>
                              ";
                              $j++;
                        }
                  }
                  if($Startglcode==10300)
                  {
                       //***************************** Raw Materials on floor **************************/
                       
                        $querycurrentrawmaterial="select
                                                      ifnull(sum(amount),0) as CurrentRawMaterial
                                                from
                                                      mas_closing_flr
                                                where
                                                      flr_year = '$fYear'
                                                      AND flr_month = '$fMonth'
                                          ";
                        $rscurrentrawmaterial=mysql_query($querycurrentrawmaterial)or die(mysql_error());
                        while($rowcurrentrawmaterial=mysql_fetch_array($rscurrentrawmaterial))
                        {
                              extract($rowcurrentrawmaterial);
                        }
                        
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
                                          <TD class='$cls' >Raw Materials on floor</TD>
                                          <TD class='$cls' align='Right'>".number_format(abs($CurrentRawMaterial),0,'.',',')."</TD>
                                          <td class='rb'></td>

                                    </TR>
                              ";
                        $total=$total+$CurrentRawMaterial;
                        $i++;
                        
                        
                        //*************************** wip *****************************/
                        
                        $querywip="select
                                          ifnull(sum(t_cost),0) as wip_amount
                                    from
                                          mas_wip
                                    where
                                          wip_year = '$fYear'
                                          AND wip_month = '$fMonth'
                                          and e_type in ('2','3')
                                    ";
                        $rswip=mysql_query($querywip)or die(mysql_error());
                        while($rowwip=mysql_fetch_array($rswip))
                        {
                              extract($rowwip);
                        }
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
                                          <TD class='$cls' >Work in Progress</TD>
                                          <TD class='$cls' align='Right'>".number_format(abs($wip_amount),0,'.',',')."</TD>
                                          <td class='rb'></td>

                                    </TR>
                              ";
                        $total=$total+$wip_amount;
                        $i++;
                        
                        //*************************** Finished Goodes *****************************/
                        
                        $queryopeningstock="select
                                                ifnull(sum(t_cost),0) as closingstock
                                          from
                                                mas_wip
                                          where
                                                wip_year='$fYear'
                                                and wip_month = '$fMonth'
                                                and e_type in ('1')
                                          ";
                                          
                        $rsopeningstock=mysql_query($queryopeningstock)or die(mysql_error());
                        while($rowopeningstock=mysql_fetch_array($rsopeningstock))
                        {
                              extract($rowopeningstock);
                        }

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
                                          <TD class='$cls' >Stock Of Finished Goods</TD>
                                          <TD class='$cls' align='Right'>".number_format(abs($closingstock),0,'.',',')."</TD>
                                          <td class='rb'></td>

                                    </TR>
                              ";
                        $total=$total+$closingstock;
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
<table width=100%><tr><td class='button_cell_e' align='center'>
<input type='submit' value='Process' class='forms_Button_e' >
</td></tr></table>
</body>
</html>
