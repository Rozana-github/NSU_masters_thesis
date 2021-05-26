<?PHP
session_start();
        include_once("Library/dbconnect.php");
        include_once("Library/Library.php");
?>
<html>
<head>
       <script language='JavaScript'>
            function back()
            {
                  //var cboglcode=document.frmAddQuery.cboglcode.value;
                  window.location="localReceive.php";
            }
        </script>
</head>
<form name='frmAddQuery' method='post'>
<?PHP


      mysql_query("BEGIN") or die("Operation cant be start");

      echo "<link rel='stylesheet' type='text/css' href='Style/eng_form.css'>";
      $ReceiveDate=$txtYear."-".$txtMonth."-".$txtDay;

                 $masinsert="insert into
                                    mas_store_in
                                    (
                                          receive_no,
                                          packing_or_challan_no,
                                          receive_date,
                                          store_in_type

                                    )
                                    values
                                    (
                                          '$txtReceiveNo',
                                          '$txtpackno',
                                          '$ReceiveDate',
                                          'Local'

                                    )
                              ";
                  mysql_query($masinsert) or die(mysql_error());
                  
                  $querylastid="select last_insert_id() as mas_store_in_id from mas_store_in";
                  $rs=mysql_query($querylastid)or die(mysql_error());
                  while($row=mysql_fetch_array($rs))
                  {
                        extract($row);
                  }

                  for($i=0;$i<$index;$i++)
                  {
                        $queryopen="select
                                          sum(ifnull(quantity_disburse,0)) as openbalance
                                    from
                                          trn_store_in
                                    where
                                          itemcode='$ItemID[$i]'
                                    ";
                        $rsopen=mysql_query($queryopen)or die(mysql_error());
                        while($rowopen=mysql_fetch_array($rsopen))
                        {
                              extract($rowopen);
                        }

                        $clbalance=$RequiredQuanity[$i]+$openbalance;
                        $trninsert="insert into
                                          trn_store_in
                                          (
                                                itemcode,
                                                purchase_quantity,
                                                purchase_date,
                                                purchase_rate,
                                                unitid,
                                                mas_store_in_id,
                                                lcobjectdetailid,
                                                opening_balance,
                                                closing_balance,
                                                entry_date_time ,
                                                quantity_disburse
                                          )
                                          values
                                          (
                                                '$ItemID[$i]',
                                                '$RequiredQuanity[$i]',
                                                '$ReceiveDate',
                                                '$Rate[$i]',
                                                '$ItemUnitValue[$i]',
                                                '$mas_store_in_id',
                                                '$lcobjectdetailid[$i]',
                                                '$openbalance',
                                                '$clbalance',
                                                now(),
                                                '$RequiredQuanity[$i]'
                                          )";
                        //echo $trninsert."<br>";
                        mysql_query($trninsert) or die(mysql_error());
                        
                        
                  }



        if(mysql_query("COMMIT"))
        {
                drawMassage("Operation Done","onClick='back()'");
        }
        else
        {
                drawMassage("Operation Not Done","onClick='back()'");

        }
?>
</html>

