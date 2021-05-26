<?PHP
session_start();
    include "../dbconnect.php";
?>

<?PHP
function SearchMasAO($PartyID)
        {

             echo"<select size='1' name='cmbAONo' onChange='SearchAmount(this)'>
                  <option value='-1'>Select...</option>";
                        $SAO="select
                                     AONO,
                                     AONO
                               from
                                     mas_ao
                               where
                                     PARTYID='".$PartyID."'
                              ";
                    // echo $SAO;
                    $resultAO=mysql_query($SAO)or die(mysql_error());
                    //$ss=mysql_num_rows($resultAO);
                    //echo"<script language='javascript'>alert(\"".$ss."\");</script>";
                    while($rowAO=mysql_fetch_array($resultAO))
                        {
                          extract($rowAO);
                          echo "<option value='$AONO'>$AONO</option>";
                        }
                        
             echo"</select>";

       }

function SearchAmount($AONo)
        {

                      $SAmount="select
                                     TOTALAMNT
                               from
                                     mas_ao
                               where
                                     AONO='".$AONo."'
                              ";
                    // echo $SAO;
                    $resultAmount=mysql_query($SAmount)or die(mysql_error());
                    //$ss=mysql_num_rows($resultAO);
                    //echo"<script language='javascript'>alert(\"".$ss."\");</script>";
                    while($rowAmount=mysql_fetch_array($resultAmount))
                        {
                          extract($rowAmount);
                          echo $TOTALAMNT;
                        }

      }
      
function SearchAccountNo($BID)
        {

             echo"<select size='1' name='cboAccountNo'>
                  <option value='-1'>Select...</option>";
                   $AccountNo="select
                                     AccessNo,
                                     AccessNo
                               from
                                     trn_bank
                               where
                                     BankID='".$BID."'
                              ";
                    // echo $SAO;
                    $resultAccountNo=mysql_query($AccountNo)or die(mysql_error());
                    //$ss=mysql_num_rows($resultAO);
                    //echo"<script language='javascript'>alert(\"".$ss."\");</script>";
                    while($rowAccount=mysql_fetch_array($resultAccountNo))
                        {
                          extract($rowAccount);
                          echo "<option value='$AccessNo'>$AccessNo</option>";
                        }

             echo"</select>";

       }
//call_user_func ($functionName,$UserID);
call_user_func_array($functionName,array($ID));

?>


