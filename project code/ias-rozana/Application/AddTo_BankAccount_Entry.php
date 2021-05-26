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
                  var BankID=document.frmAddQuery.BankID.value;
                  window.location="Mas_BankAccount_Entry.php?BankID="+BankID+"";
                  //window.location="Mas_BankAccount_Entry.php?";
            }
      </script>
</head>
<form name='frmAddQuery' method='post'>
<?PHP
    /*-------------------- Developed By: MD.SHARIF UR RAHMAN ----------------------------------------*/
      echo "<input type='hidden' name='BankID' value='$txtBankName'>";
      mysql_query("BEGIN") or die("Operation cant be start");
      /*
      echo "<font color='ff0000'>
           Q_Mode--$Q_Mode
      </font>";*/

      echo "<link rel='stylesheet' type='text/css' href='Style/eng_form.css'>";

                  
                  if($Q_Mode==1)
                  {
                        $TrnQuery="
                                    update
                                          trn_bank
                                    set
                                          account_no='$txtAccountNo',
                                          branch='$txtBranceNam',
                                          contract_person='$txtContactP',
                                          address1='$txtAddress1',
                                          address2='$txtAddress2',
                                          phone='$txtPhone'
                                    where
                                          account_object_id='$AccountObjID'
                                    ";
                  }
                  else
                  {
                        $TrnQuery="insert into trn_bank
                                    (
                                          bank_id,
                                          account_no,
                                          branch,
                                          contract_person,
                                          address1,
                                          address2,
                                          phone
                                    )
                                    values
                                    (
                                          '$txtBankName',
                                          '$txtAccountNo',
                                          '$txtBranceNam',
                                          '$txtContactP',
                                          '$txtAddress1',
                                          '$txtAddress2',
                                          '$txtPhone'
                                          
                                    )";
                   }
                  $resultTrnQuery=mysql_query($TrnQuery) or die(mysql_error());



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

