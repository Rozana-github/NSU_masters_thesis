<?PHP
      include "Library/dbconnect.php";
      include "Library/Library.php";
      include "Library/SessionValidate.php";
?>

<html>
      <head>
            <meta http-equiv='Content-Type' content='text/html; charset=windows-1252'>
            <title>Invoice Posting</title>
            <LINK href="Style/generic_report.css" type='text/css' rel='stylesheet'>
            <link rel='stylesheet' type='text/css' href='Style/eng_report.css' />

 <script language='javascript'>

    function deleterow(object_id)
      {
            document.SelectQuery.action="CloseingFloorBottom.php?deletrow=1&objectid="+object_id+"";
            document.SelectQuery.target="closingFloorBottom";
            document.SelectQuery.submit();
            alert(object_id);
      }

            </script>

      </head>

       <body class='body_e'>



<form name='SelectQuery' method='post'>


<?PHP
echo"$deletrow";
     if($deletrow=='1')
                    {
                    $querydel="delete from mas_closing_flr where object_id='$objectid'";
                         mysql_query($querydel) or die(mysql_error());
                      }
?>
<?PHP


                        if($fMonth=='1' || $fMonth=='-1')
                        {
                              $pyear=$fYear-1;
                              $pmonth=12;
                        }
                        else
                        {
                              $pyear=$fYear;
                              $pmonth=$fMonth-1;
                        }


                         $query="SELECT
                                          mas_closing_flr.object_id,
                                          mas_closing_flr.product_id ,
                                          mas_closing_flr.product_qty ,
                                          mas_closing_flr.rate,
                                          mas_closing_flr.amount,
                                          mas_closing_flr.remarks,
                                          mas_closing_flr.year,
                                          mas_closing_flr.month
                                          
                                    FROM
                                          `mas_closing_flr`

                                   where
                                        month='$fMonth'
                                   and
                                        year='$fYear'
                                ";

                        // echo $query;
                         $rs=mysql_query($query) or die("Error: ".mysql_error());

                        if(mysql_num_rows($rs)>0)
                        {
                                if($fMonth=='-1')
                                {
                                        drawCompanyInformation("Closing Floor","For the Year of ".date("Y", mktime(0, 0, 0, 1,1,$fYear)));

                                }
                                else
                                {
                                        drawCompanyInformation(" ","For the Month of ".date("F,Y", mktime(0, 0, 0, $fMonth,1,$fYear)));

                                }


                                echo "<table width='95%' id='table1' cellspacing='0' cellpadding='0' align='center'>
                                        <tr>
                                                <td class='title_cell_e_l' >SL. No</td>
                                                <td class='title_cell_e' >Product Name</td>
                                                <td class='title_cell_e' >Quantity</td>
                                                <td class='title_cell_e' >Rate</td>
                                                <td class='title_cell_e' >Amount</td>
                                                <td class='title_cell_e' >Remarks</td>
                                                <td class='title_cell_e' >Delete</td>
                                        </tr>

                                    ";

                                $i=0;
                                $totalopen_balance=0;
                                $totalinvoice=0;
                                $totalcollected=0;
                                $totaldue=0;

                                while($row=mysql_fetch_array($rs))
                                {
                                        extract($row);

                                        if(($i%2)==0)
                                        {
                                                $class="even_td_e";
                                                $lclass="even_left_td_e";
                                        }
                                        else
                                        {
                                                $class="odd_td_e";
                                                $lclass="odd_left_td_e";
                                        }
                              
                                        $dueamount=($open_balance+$Invoice_Amount)-$collcedamount;
                                        $totalopen_balance=$totalopen_balance+$open_balance;
                                        $totalinvoice=$totalinvoice+$Invoice_Amount;
                                        $totalcollected=$totalcollected+$collcedamount;
                                        $totaldue=$totaldue+$dueamount;

                              //////////////////////////////////////////

                                        echo "<tr>
                                                <td class='$lclass' align='center'>".($i+1)."</td>
                                                <td class='$class' > ".$company_name."&nbsp;</td>
                                                <td class='$class' align='right'>".number_format($open_balance,2,'.',',')."</td>
                                                <td class='$class' align='right'>".number_format($Invoice_Amount,2,'.',',')."</td>
                                                <td class='$class'align='right'>".number_format($collcedamount,2,'.',',')."</td>
                                                <td class='$class' align='right'>".number_format($dueamount,2,'.',',')."</td>
                                                <td class='' align='middle'><input type='button' name='btndelet' value='Delete'onclick='deleterow($object_id)'></td>
                                             </tr>";

                                        $i++;
                                }
                                echo "<tr>
                                        <td class='td_e_b_l' colspan='2' align='right'><b></b></td>
                              <td class='td_e_b' align='right'>".number_format($totalopen_balance,2,'.',',')."</td>
                                        <td class='td_e_b' align='right'>".number_format($totalinvoice,2,'.',',')."</td>
                                        <td class='td_e_b' align='right'>".number_format($totalcollected,2,'.',',')."</td>
                                        <td class='td_e_b' align='right'>".number_format($totaldue,2,'.',',')."</td>
                                     </tr>";
                                echo "</table>";
                        }
                        else
                        {
                                drawNormalMassage("Data Not Found.");
                        }
                ?>

        </form>
        </body>

        </html>
