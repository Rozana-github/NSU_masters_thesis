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
                  window.location="Requisitionlist.php";
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
      $RequiredDate=$txtRYear."-".$txtRMonth."-".$txtRDay;
      $Date=$txtYear."-".$txtMonth."-".$txtDay;

                  
                $masinsert="update
                                mas_material_req
                              set
                                    requisition_number='$Requisitno',
                                    requisition_date='$Date',
                                    requisition_job='$txtjobno',
                                    requisition_item='$cboitem',
                                    required_date='$RequiredDate',
                                    job_quantity='$Jobquantity'
                              where
                                    mas_requisition_id='$txtmasrequisition'";
                  //echo $masinsert."<br>";
                  
                  mysql_query($masinsert) or die(mysql_error());
                  
                  /*$querymaslastid="select last_insert_id() as mas_req_id from mas_material_req";
                  $rs=mysql_query($querymaslastid)or die(mysql_error());
                  while($row=mysql_fetch_array($rs))
                  {
                        extract($row);
                        
                  } */
                  //echo $mas_req_id."<br>";
                  
                  $delettrn="delete from trn_material_req where mas_requisition_id='$txtmasrequisition'";
                  mysql_query($delettrn) or die(mysql_error());
                  
                  for($i=0;$i<$TotalIndex;$i++)
                  {
                        $trninsert="insert into
                                          trn_material_req
                                          (
                                                itemcode,
                                                mas_requisition_id,
                                                req_quantity,
                                                remarks,
                                                unitid
                                          )
                                          values
                                          (
                                                '".$txtitem[$i]."',
                                                '$txtmasrequisition',
                                                '".$txtquantities[$i]."',
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

