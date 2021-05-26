<?PHP
       session_start();
       include_once("Library/dbconnect.php");
       include "Library.php";
?>
<html>

<head>
<title>Company Entry</title>
<link rel="stylesheet" type="text/css" href="css/Apperance_1.css">

<script language='Javascript'>


</script>

</head>

<body>
<form name='Form1' method='post' action=''>

<?PHP

       if($cboLC>0)
        {
              //update mas_lc
              $updatemaslc="update mas_lc set
                                   partyid='".$cboParty."',
                                   lcno='".$txtLCNo."',
                                   lcvalue='".$txtLCValue."',
                                   opendate=STR_TO_DATE('$txtOpenDate','%d-%m-%Y'),
                                   lastshipmentdate=STR_TO_DATE('$txtShipmentDate','%d-%m-%Y'),
                                   dateofmaturity=STR_TO_DATE('$txtMaturityDate','%d-%m-%Y'),
                                   remarks='".$txtRemarks."',
                                   name_cf_agent='".$txtCFagent."',
                                   doc_receivedate=STR_TO_DATE('$txtDRecivedDate','%d-%m-%Y'),
                                   barthingdate=STR_TO_DATE('$txtBirthDate','%d-%m-%Y'),
                                   amend_date=STR_TO_DATE('$txtAmendmentDate','%d-%m-%Y'),
                                   amend_neg_date=STR_TO_DATE('$txtAmendmentNegotiationDate','%d-%m-%Y'),
                                   
                                   nameofcompany='$txtNofCompany',
                                   lcvaluetaka='$txtLcValTK',
                                   arrivaldate=STR_TO_DATE('$txtAriavalDT','%d-%m-%Y'),
                                   bankid='$cboBank',
                                   accountno='$cboBanKAccount',
                                   countryorigin='$txtCountry',
                                   update_by='$SUserName',
                                   update_date=now()
                            where
                                   lcobjectid='".$cboLC."'
                           ";
                           //echo $updatemaslc;
            $resultmaslc=mysql_query($updatemaslc) or die(mysql_error());
        }
        else
        {
            // entry mas_lc
           $insertintomaslc="insert into mas_lc
                                    (
                                      partyid,
                                      lcno,
                                      lcvalue,
                                      opendate,
                                      lastshipmentdate,
                                      dateofmaturity,
                                      remarks,

                                      name_cf_agent,
                                      doc_receivedate,
                                      barthingdate,
                                      amend_date,
                                      amend_neg_date,
                                      
                                      nameofcompany,
                                      lcvaluetaka,
                                      arrivaldate,
                                      bankid,
                                      accountno,
                                      countryorigin,
                                      entry_by,
                                      entry_date
                                    )
                                    values
                                    (
                                     '$cboParty',
                                     '$txtLCNo',
                                     '$txtLCValue',
                                      STR_TO_DATE('$txtOpenDate','%d-%m-%Y'),
                                      STR_TO_DATE('$txtShipmentDate','%d-%m-%Y'),
                                      STR_TO_DATE('$txtMaturityDate','%d-%m-%Y'),
                                     '$txtRemarks',
                                     
                                     '$txtCFagent',
                                     STR_TO_DATE('$txtDRecivedDate','%d-%m-%Y'),
                                     STR_TO_DATE('$txtBirthDate','%d-%m-%Y'),
                                     STR_TO_DATE('$txtAmendmentDate','%d-%m-%Y'),
                                     STR_TO_DATE('$txtAmendmentNegotiationDate','%d-%m-%Y'),
                                     
                                     '$txtNofCompany',
                                     '$txtLcValTK',
                                     STR_TO_DATE('$txtAriavalDT','%d-%m-%Y'),
                                     '$cboBank',
                                     '$cboBanKAccount',
                                     '$txtCountry',
                                     '$SUserName',
                                     now()
                                    )
                            ";
           $resultmaslc=mysql_query($insertintomaslc) or die(mysql_error());

                //search max LCOBJECTID from  mas_lc
                         $searchmaxLCid="select
                                               LAST_INSERT_ID() as cboLC
                                         from
                                               mas_lc
                                        ";
                          $resultmaxLCID=mysql_query($searchmaxLCid) or die(mysql_error());
                          while($rowmaxLCId=mysql_fetch_array($resultmaxLCID))
                                {
                                    extract($rowmaxLCId);
                                }

        }


      for($i=0;$i<$txtIndex;$i++)
        {
             //echo "<script language='javascript'> alert(\"".$ProfileID[$i]."\"); </script>";

               if($TrnOnjectID[$i]==-1)
                   {
                       //echo "<script language='javascript'> alert(\"".$ItemID[$i]."\"); </script>";



                       //insert Machine Profile information
                          $InsertTRnProfile="insert into trn_lc
                                                             (
                                                                lcobjectid,
                                                                itemcode,
                                                                unitid,
                                                                rate,
                                                                reqqty,
                                                                remarks
                                                            )
                                                            values
                                                            (
                                                                '".$cboLC."',
                                                                '".$ItemID[$i]."',
                                                                '".$ItemUnitValue[$i]."',
                                                                '".$Rate[$i]."',
                                                                '".$RequiredQuanity[$i]."',
                                                                '".$Remarks[$i]."'
                                                           )
                                                ";
                              $resultTRnProfile=mysql_query($InsertTRnProfile) or die(mysql_error());

                   }
                   else
                   {
                               //update Machine Profile information
                                $UpdateRnProfile="update trn_lc set
                                                                lcobjectid='".$cboLC."',
                                                                itemcode='".$ItemID[$i]."',
                                                                unitid='".$ItemUnitValue[$i]."',
                                                                rate='".$Rate[$i]."',
                                                                reqqty='".$RequiredQuanity[$i]."',
                                                                remarks='".$Remarks[$i]."'
                                                         where
                                                                lcobjectdetailid='".$TrnOnjectID[$i]."'


                                                ";
                          //echo $UpdateMachineProfile;
                              $resultUpdateRnProfile=mysql_query($UpdateRnProfile) or die(mysql_error());

                   }

         }

    if($txtDeleteIndex>0)
        {
            for($j=0;$j<$txtDeleteIndex;$j++)
                {
                   $deleteTrnProfile="delete
                                          from
                                              trn_lc
                                          where
                                              lcobjectdetailid='".$DelTrnOnjectID[$j]."'
                                          ";
                   $resultdeleteTrnProfile=mysql_query($deleteTrnProfile) or die(mysql_error());

                }
       }




                 echo    "<table border='0' width='50%' align='center' bordercolor='#111111' bgcolor=''>
                                <tr>
                                        <td align='center' width='100%' class='Header_Cell'>
                                        <b><font size='2'>
                                            Information save Successfully
                                        </b></font>
                                        </td>
                                </tr>
                                <tr>
                                        <td align='center' width='100%'>
                                             <input type='button' name='btnBack' value='Back' onClick=\"window.location.href='StoreLCEntry.php'\";
                                        </td>
                                </tr>
                        </table>";


?>



</form>


</body>

</html>

