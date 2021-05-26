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
    /*-------------------- Developed By: MD.SHARIF UR RAHMAN ----------------------------------------*/
      echo "<input type='hidden' name='cboglcode' value='$cboglcode'>";
      mysql_query("BEGIN") or die("Operation cant be start");
      /*
      echo "<font color='ff0000'>
           Q_Mode--$Q_Mode
      </font>";*/

      echo "<link rel='stylesheet' type='text/css' href='Style/eng_form.css'>";
      $RequisitDate=$txtVoucherYear."-".$txtVoucherMonth."-".$txtVoucherDay;

                  
                $masinsert="insert into
                              mas_purchase_req
                              (
                                    requisition_number,
                                    requisition_date
                              )
                              values
                              (
                                    '$txtrequisitionNo',
                                    '$RequisitDate'
                              )";
                 // echo $masinsert."<br>";
                  
                  mysql_query($masinsert) or die(mysql_error());
                  
                  $querymaslastid="select last_insert_id() as mas_req_id from mas_purchase_req";
                  $rs=mysql_query($querymaslastid)or die(mysql_error());
                  while($row=mysql_fetch_array($rs))
                  {
                        extract($row);
                        
                  }
                  //echo $mas_req_id."<br>";
                  for($i=0;$i<$TotalIndex;$i++)
                  {
                        $trninsert="insert into
                                          trn_purchase_req
                                          (
                                                itemcode,
                                                mas_requisition_id,
                                                specification,
                                                req_purchase_quantity,
                                                required_date,
                                                remarks,
                                                unitid
                                          )
                                          values
                                          (
                                                '".$txtitem[$i]."',
                                                '".$mas_req_id."',
                                                '".$txtspacifications[$i]."',
                                                '".$txtquantities[$i]."',
                                                STR_TO_DATE('".$txtrequireddates[$i]."','%d-%m-%Y'),
                                                '".$txtremark[$i]."',
                                                '".$txtunits[$i]."'
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

