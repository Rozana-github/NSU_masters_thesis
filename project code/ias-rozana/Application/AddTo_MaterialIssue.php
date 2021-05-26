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
                  var cboglcode=document.frmAddQuery.cboglcode.value;
                  window.location="PurchaseRequisit.php";
            }
        </script>
</head>
<form name='frmAddQuery' method='post'>
<?PHP


      mysql_query("BEGIN") or die("Operation cant be start");

      echo "<link rel='stylesheet' type='text/css' href='Style/eng_form.css'>";
      $IssueDate=$txtYear."-".$txtMonth."-".$txtDay;



                  for($i=0;$i<$TotalIndex;$i++)
                  {

                        if(isset($Ck[$i]))
                        {
                        $clbalance=$txtopenbalance[$i]-$txtissueqty[$i];
                        $trninsert="insert into
                                          trn_store_out
                                          (
                                                itemcode,
                                                issueditem,
                                                issue_quantity,
                                                issue_date,
                                                trn_requisition_id,
                                                unitid,
                                                opening_balance,
                                                closing_balance,
                                                entry_date_time
                                          )
                                          values
                                          (
                                                '$txtitemcode[$i]',
                                                '".$issueitem[$i]."',
                                                '$txtissueqty[$i]',
                                                '$IssueDate',
                                                '$txttrnrequisitionid[$i]',
                                                '$txtunit[$i]',
                                                '$txtopenbalance[$i]',
                                                '$clbalance',
                                                now()
                                          )";
                        echo $trninsert."<br>";
                        mysql_query($trninsert) or die(mysql_error());

                       /* $getclose="select sum(closing_balance) as clbalance from trn_store_in where itemcode='$txtitemcode[$i]'";
                        $getrs=mysql_query($getclose)or die(mysql_error());
                        while($getrow=mysql_fetch_array($getrs))
                        {
                         extract($getrow);
                        }  */
                        
                        $getrtime="select min(entry_date_time) as rtime from trn_store_in where closing_balance!='0' and itemcode='$txtitemcode[$i]' ";
                        $getrs=mysql_query($getrtime)or die(mysql_error());
                        while($getrow=mysql_fetch_array($getrs))
                        {
                         extract($getrow);
                        }
                         $updatedisburse=$txtopenbalance[$i]-$txtissueqty[$i];
                         $updatetrn_store_in="update
                                                trn_store_in
                                             set
                                                quantity_disburse = '$updatedisburse'
                                             where
                                                itemcode='".$issueitem[$i]."'
                                                and entry_date_time='$rtime'";
                        //echo $updatetrn_store_in;
                        mysql_query($updatetrn_store_in)or die(mysql_error());
                      }
                        
                        
                  }
                  $updatemasrequisition="update
                                                mas_material_req
                                          set
                                                requision_status='1'
                                          where
                                                mas_requisition_id='$requisitno'
                                          ";
                  mysql_query($updatemasrequisition) or die(mysql_error());



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

