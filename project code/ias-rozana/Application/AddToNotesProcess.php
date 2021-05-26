<?PHP
session_start();
        include_once("Library/dbconnect.php");
        include_once("Library/Library.php");

        mysql_query("BEGIN") or die("Operation can't be open");
?>

<html>

<head>

<meta http-equiv='Content-Language' content='en-us'>
<meta http-equiv='Content-Type' content='text/html; charset=windows-1252'>
<title>Supplier Entry Form</title>
<link rel='stylesheet' type='text/css' href='css/interface_styles.css' />

</head>

<body>
<form name='Form1' method='post'  action=''>

<?PHP

        //echo "dddd".$totalrows;

                for($i=0;$i<$totalrows;$i++)
                {
                  //echo  $txttolalamount[$i];
                  if($txttolalamount[$i]!=0)
                  {
                        if($txtStartglcode[$i]==10400)
                              $noteno=2;
                        else if($txtStartglcode[$i]==10300)
                              $noteno=3;
                        else if($txtStartglcode[$i]==10600)
                              $noteno=4;
                        else if($txtStartglcode[$i]==10200)
                              $noteno=5;
                        else if($txtStartglcode[$i]==20500)
                              $noteno=7;
                          //Insert into mas_ytd_balance
                        $insertMas_Ytd_Balance="replace into mas_ytd_balance
                                                (
                                                      proc_year,
                                                      proc_month,
                                                      glcode,
                                                      note_no,
                                                      trn_amount
                                                )
                                                values
                                                (
                                                      '$txtyear',
                                                      '$txtMonth',
                                                      '".$txtStartglcode[$i]."',
                                                      '$noteno',
                                                      '".$txttolalamount[$i]."'
                                                      
                                                )";

                 //echo $insertMasEmployee;
                 //echo   $insertMas_Ytd_Balance;
                        mysql_query($insertMas_Ytd_Balance) or die(mysql_error());
                        
                          //Insert into mas_ytd_note
                          //echo $totalsubrow[$i];
                        for($j=0;$j<$totalsubrow[$i];$j++)
                        {
                             $insertmas_ytd_note="replace into mas_ytd_note
                                                (
                                                      proc_year,
                                                      proc_month,
                                                      glcode,
                                                      note_no,
                                                      trn_amount
                                                )
                                                values
                                                (
                                                      '$txtyear',
                                                      '$txtMonth',
                                                      '".$txttrnglcode[$j]."',
                                                      '$noteno',
                                                      '".$txttrnbalance[$j]."'

                                                )";
                              mysql_query($insertmas_ytd_note) or die(mysql_error());
                        }

                  }

                }



               //------search invoice recent id-----------




?>


<?PHP
        if(mysql_query("COMMIT"))
        {
                drawMassage("Data Saved Succssfully","");
        }
        else
        {
                drawMassage("Data Saved Error","");

        }
?>

</form>
</body>

</html>

