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

<form name='frmNotes' method='post' action='AddToIncome.php' target='bottomfrmForReport'>
<?PHP
    $i=0;
    $total=0;

    if($fMonth=='-1')
		drawCompanyInformation("Statement of Income and Expenditure","For the year ended ".date("Y", mktime(0, 0, 0, 1, 1, $fYear)));
	else
		drawCompanyInformation("Statement of Income and Expenditure","For the Month ended ".date("F, Y", mktime(0, 0, 0, $fMonth, 1, $fYear)));
	
	echo "	<table width='70%' id='table1' cellspacing='0' cellpadding='0' align='center'>
			<tr>
				<Td  class='title_cell_e_l'  align='center'>Particulars</td>
				<Td  class='title_cell_e'  align='center'>Note</td>
				<Td  class='title_cell_e'  align='center'>".date("F,Y",mktime(0, 0, 0, $fMonth, 1, $fYear))."</td>
				<Td  class='title_cell_e'  align='center'>".date("F,Y",mktime(0, 0, 0, 1, 1,$fYear))." TO ".date("F,Y",mktime(0, 0, 0, $fMonth, 1, $fYear))."</td>
			</tr>
			<tr>
				<Td  colspan='4'><b>Income<b></td>
			</tr>";
			
			/*****************   income      ***************/
			/*****************   Sales from printing works supplied      ***************/
			$queryopeningrawmaterial="	select
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
			$trn_amnt = 0;
			$cum_amnt = 0;
			while($rowopeningrawmaterial=mysql_fetch_array($rsopeningrawmaterial))
			{
				extract($rowopeningrawmaterial);

				echo "
					<tr>
						<Td    >Sales from printing works supplied</td>
						<Td    align='center'>$note_no</td>
						<Td    align='right'>".number_format(abs($trn_amount),0,'.',',')."</td>
						<Td    align='right'>".number_format(abs($cum_amount),0,'.',',')."</td>
					</tr>";
				$trn_amnt = $trn_amount;
				$cum_amnt = $cum_amount;
			}
			/*****************  Add: Miscellaneous receipt    ***************/

			$queryissuedstore="	select
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
				echo "
					<tr>
						<Td colspan='2'>Add: Miscellaneous receipt</td>
						<Td align='right'>".number_format(abs($Mis_Receipt),0,'.',',')."</td>
						<Td align='right'>".number_format(abs($total_Mis_Receipt), 0, '.', ',')."</td>
					</tr>";
			}

			/*****************  Add: Interest from loans and advance    ***************/
			$queryissuedstore="	select
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
				echo "	<tr>
							<Td colspan='2'>Add: Interest from loans and advance</td>
							<Td align='right'>".number_format(abs($loan_advance),0,'.',',')."</td>
							<Td align='right'>".number_format(abs($total_loan_advance),0,'.',',')."</td>
						</tr>";

				$totalincome = $trn_amnt + $Mis_Receipt + $loan_advance;
				$totalincomecum=$cum_amnt+$total_Mis_Receipt+$total_loan_advance;
				echo "	<tr>
							<Td   align='right' colspan='3'><b>".number_format(abs($totalincome),0,'.',',')."</b></td>
							<Td    align='right'>".number_format(abs($totalincomecum),0,'.',',')."</td>
						</tr>";
			}
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

					echo "<tr>

                                    <Td    >Less: Cost of printing work supplied</td>
                                    <Td    align='center'>$note_no</td>
                                    <Td   align='right'>".number_format(abs($trn_amount),0,'.',',')."</td>
                                    <Td    align='right'>".number_format(abs($cum_amount),0,'.',',')."</td>

                              </tr>";
					$totalincome=$totalincome- $trn_amount;
					$totalincomecum=$totalincomecum- $cum_amount;

					echo "	<tr>
                                    <Td    align='right' colspan='3'><b>".number_format(abs($totalincome),0,'.',',')."</b></td>
                                    <Td    align='right'>".number_format(abs($totalincomecum),0,'.',',')."</td>
							</tr>";
                }
				/************************** Expenditure *********************************/
				/************************* A.Expenditure: Administrative Expenses *********************************/
				echo "
					<tr>
						<Td    colspan='4'><b>A.Expenditure: Administrative Expenses<b></td>
                    </tr>";
	
				$queryexpanditureA="
							SELECT
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
					echo " 
						<tr>
							<Td    colspan='2'>$description</td>
							<Td    align='right'>".number_format(abs($balance),0,'.',',')."</td>
							<Td    align='right'>".number_format(abs($cum_balance),0,'.',',')."</td>
						</tr>";
                        $totalexpanditureA=$totalexpanditureA+$balance;
                        $totalexpanditureACum=$totalexpanditureACum+$cum_balance;
					
					echo "
						<tr>
							<Td    align='right' colspan='3'><b>".number_format(abs($totalexpanditureA),0,'.',',')."</b></td>
							<Td    align='right'><b>".number_format(abs($totalexpanditureACum),0,'.',',')."</b></td>
						</tr>";
				}
					/******************************end of A.Expenditure: Administrative Expenses ***********************/
					/************************** B. Selling and Distribution expanses*********************************/
					echo "
						<tr>
							<Td     colspan='4'><b>B. Selling and Distribution expanses</b></td>
						</tr>";
                   
					$queryexpanditureB="
							SELECT
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

                                    <Td     colspan='2'>$description</td>

                                    <Td    align='right'>".number_format(abs($balance),0,'.',',')."</td>
                                    <Td    align='right'>".number_format(abs($cum_balance),0,'.',',')."</td>

                              </tr>";
                        $totalexpanditureB=$totalexpanditureB+$balance;
                        $totalexpanditureBcum=$totalexpanditureBcum+$cum_balance;
                }

                 echo "	<tr>
							<Td    align='right' colspan='3'><b>".number_format(abs($totalexpanditureB),0,'.',',')."</b></td>
							<Td    align='right'>".number_format(abs($totalexpanditureBcum),0,'.',',')."</td>
						</tr>";

                  /******************************end of B. Selling and Distribution expanses ***********************/
                   $totalexpanditure=$totalexpanditureA+$totalexpanditureB;
                   $totalexpenditurecum=$totalexpanditureACum+$totalexpanditureBcum;
                
				echo "
					<tr>
						<Td     colspan='2'>Total Expanditure(A+B)</td>
						<Td    align='right'>".number_format(abs($totalexpanditure),0,'.',',')."</td>
						<Td   align='right'>".number_format(abs($totalexpenditurecum),0,'.',',')."</td>
					</tr>";

				/****************************** End of Expanditure    ******************************************/
				$netprofit=$totalincome-$totalexpanditure;
				$netprofitcum=$totalincomecum-$totalexpenditurecum;
				echo "
					<tr>
						<Td     colspan='2'>Net Profit</td>
						<Td    align='right'><b>".number_format(abs($netprofit),0,'.',',')."</b></td>
						<Td    align='right'>".number_format(abs($netprofitcum),0,'.',',')."</td>
					</tr>
					</table>";
?>

</body>
</html>
