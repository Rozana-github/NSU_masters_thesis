<?PHP
      include "Library/dbconnect.php";
      include "Library/Library.php";
      include "Library/SessionValidate.php";
?>

<html>
      <head>
            <meta http-equiv='Content-Type' content='text/html; charset=windows-1252'>
            <meta content="Author" name="Md.Sharif Ur Rahman">
            <title>Invoice Posting</title>
            <script language='javascript'>
                  function sendData(Llcobjectid,Rrpt_lcno,Ppartyid)
                  {
                        //alert(Llcobjectid);
                        //alert(Rrpt_lcno);
                        //alert(Ppartyid);
                        window.parent.LCPaymentBottom.location="LCPaymentBottom.php?lcobjectid="+Llcobjectid+"&Rrpt_lcno="+Rrpt_lcno+"&partyid="+Ppartyid+"";
                  }
            </script>
            <LINK href="Style/generic_form.css" type='text/css' rel='stylesheet'>
            <link rel='stylesheet' type='text/css' href='Style/eng_form.css' />
      </head>
      <body class='body_e'>
      <form name='frmLcPyment' method='post'>
            <?PHP
                  $query="select
                              mas_lc.lcobjectid as lcobjectid,
                              mas_lc.partyid as partyid,
                              mas_lc.opendate as rpt_openDT,
                              mas_lc.lcno as rpt_lcno,
                              mas_lc.lastshipmentdate as rpt_lsDT,
                              mas_lc.dateofmaturity as rpt_NDT,
                              trn_lc.rate as rpt_rate,
                              trn_lc.reqqty as rpt_reqqty,
                              mas_supplier.Company_Name as rpt_CompanyName,
                              mas_item.itemdescription as rpt_ItemDesc
                          from
                              mas_lc
                              left join trn_lc on trn_lc.lcobjectid=mas_lc.lcobjectid
                              left join mas_supplier on mas_supplier.supplier_id=mas_lc.partyid
                              left join mas_item on mas_item.itemcode=trn_lc.itemcode
                          where
                              mas_lc.lcstatus='0'
                          order by
                              mas_lc.opendate
                                    ";
                  $rs=mysql_query($query) or die("Error: ".mysql_error());

                  $RowCount=mysql_num_rows($rs);
                  if($RowCount>0)
                  {
                        echo "<table width='100%' id='table1' cellspacing='0' cellpadding='0' align='center'>
                                    <tr>
                                          <td class='top_left_curb'></td>
                                          <td colspan='8' class='header_cell_e' align='center'>LC Pamyent Information</td>
                                          <td class='top_right_curb'></td>
                                    </tr>
                                    <tr>
                                          <td class='lb' rowspan='".($RowCount+1)."'></td>
                                          <td class='title_cell_e'>LC No</td>
                                          <td class='title_cell_e'>LC Opening Date</td>
                                          <td class='title_cell_e'>Names of items</td>
                                          <td class='title_cell_e'>Rate</td>
                                          <td class='title_cell_e'>Quantity</td>
                                          <td class='title_cell_e'>Total Amount$</td>
                                          <td class='title_cell_e'>Name Of Company</td>
                                          <td class='title_cell_e'>Shipment Date</td>
                                          <td class='rb' rowspan='".($RowCount+1)."'></td>
                                    </tr>";
                        $i=0;
                        while($row=mysql_fetch_array($rs))
                        {
                              extract($row);

                              if(($i%2)==0)
                                    $class='even_td_e';
                              else
                                    $class='odd_td_e';
                                    
                              echo "<tr>
                                          <td class='$class'>$rpt_lcno</td>
                                          <td class='$class'>$rpt_openDT</td>
                                          <td class='$class'>$rpt_ItemDesc</td>
                                          <td class='$class'>$rpt_rate</td>
                                          <td class='$class'>$rpt_reqqty</td>
                                          <td class='$class'>$totalAmount</td>
                                          <td class='$class'>$rpt_CompanyName</td>
                                          <td class='$class'><input type='button' class='forms_button_e' name='btnpost[$i]' value='Post' onclick=\"sendData('$lcobjectid','$rpt_lcno','$partyid')\"></td>
                                    </tr>";
                              $i++;
                                    
                                    }
                        echo "<tr>
                                    <td class='bottom_l_curb'></td>
                                    <td class='bottom_f_cell' colspan='8'></td>
                                    <td class='bottom_r_curb'></td>
                              </tr>";
                        echo "</table>";
                  }
                  else
                  {
                        drawNormalMassage("No Information Available.");
                  }
            ?>
      </form>
      </body>
</html>
