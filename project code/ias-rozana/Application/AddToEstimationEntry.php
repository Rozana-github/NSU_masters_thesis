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
                  //window.location="Mas_Bank_Entry.php?cboglcode="+cboglcode+"";
                  window.location="mas_asset_dep_setup.php?";
            }
      </script>
</head>
<form name='frmAddQuery' method='post'>
<?PHP
    /*-------------------- Developed By: MD.SHARIF UR RAHMAN ----------------------------------------*/
      //echo "<input type='hidden' name='cboglcode' value='$cboglcode'>";
      mysql_query("BEGIN") or die("Operation cant be start");
      /*
      echo "<font color='ff0000'>
           Q_Mode--$Q_Mode
      </font>";*/

      echo "<link rel='stylesheet' type='text/css' href='Style/eng_form.css'>";
          $insertmas_estimation="insert into
                                        mas_estimation
                                        (
                                                order_object_id,
                                                estimate_amount,
                                                estimate_date,
                                                layer,
                                                total_micron,
                                                total_gsm,
                                                total_gsm_kg,
                                                entry_by,
                                                entry_date
                                        )
                                        values
                                        (
                                                '".$cbojobno."',
                                                '".$txtprodquantity."',
                                                sysdate(),
                                                '".$txtlayer."',
                                                '".$txttotalmicron."',
                                                '".$txttotalgsm."',
                                                '".$txttotalgsmkg."',
                                                '".$SUserID."',
                                                sysdate()
                                        )
                                ";
            mysql_query($insertmas_estimation)or die("error in mas_estimation:".mysql_error());

            $querylastid="select last_insert_id() as estimateid from mas_estimation";
            $rslastid=mysql_query($querylastid)or die(mysql_error());
            while($rowlastid=mysql_fetch_array($rslastid))
            {
                extract($rowlastid);
            }
            $queryfindestimation="select max(estimation_number) as no_of_estimation from mas_prod_estimation where order_object_id='".$cbojobno."'" ;
            $rsestimation=mysql_query($queryfindestimation)or die(mysql_error());
            while($rowestimation=mysql_fetch_array($rsestimation))
            {
                extract($rowestimation);
            }
            for($i=0;$i<$sptotal;$i++)
            {
                $insertmas_prod_estimation="insert into
                                                mas_prod_estimation
                                                (
                                                        estimate_id,
                                                        order_object_id,
                                                        prod_object_id,
                                                        micron,
                                                        gsm,
                                                        gsm_kg,
                                                        estimation_date,
                                                        estimation_number,
                                                        entyr_by,
                                                        entyr_date
                                                )
                                                values
                                                (
                                                        '".$estimateid."',
                                                        '".$cbojobno."',
                                                        '".$txtprodobjectid[$i]."',
                                                        '".$txtmicron[$i]."',
                                                        '".$txtgsm[$i]."',
                                                        '".$txtgsmkg[$i]."',
                                                        sysdate(),
                                                        '".$no_of_estimation."',
                                                        '".$SUserID."',
                                                        sysdate()
                                                )
                                        ";
                 mysql_query($insertmas_prod_estimation)or die(mysql_error());
                if($txtlayerstatus[$i]==1)
                {
                 $inserttrn_prod_estimation="insert into
                                trn_prod_estimation
                                (
                                        estimation_id,
                                        prod_item_object_id,
                                        qty_gsm,
                                        amount_kg,
                                        entry_by,
                                        entry_date
                                )
                                values
                                (
                                        '".$estimateid."',
                                        '".$txtprodobjectid[$i]."',
                                        '".$txtrqqty[$i]."',
                                        '".$txtamount[$i]."',
                                        '".$SUserID."',
                                        sysdate()

                                )

                        ";
                        mysql_query($inserttrn_prod_estimation)or die(mysql_error());
                }
            }
            
            $inserttrn_prod_estimation="insert into
                                trn_prod_estimation
                                (
                                        estimation_id,
                                        prod_item_object_id,
                                        qty_gsm,
                                        amount_kg,
                                        adhesive_rate,
                                        entry_by,
                                        entry_date
                                )
                                values
                                (
                                        '".$estimateid."',
                                        '".$txtadhesive1."',
                                        '".$txtinkrqqty."',
                                        '".$txtinkamount."',
                                        '".$txtinkrate."',
                                        '".$SUserID."',
                                        sysdate()

                                )

                        ";

          mysql_query($inserttrn_prod_estimation)or die(mysql_error());
          $inserttrn_prod_estimation="insert into
                                trn_prod_estimation
                                (
                                        estimation_id,
                                        prod_item_object_id,
                                        qty_gsm,
                                        amount_kg,
                                        adhesive_rate,
                                        entry_by,
                                        entry_date
                                )
                                values
                                (
                                        '".$estimateid."',
                                        '".$txtadhesive2."',
                                        '".$txtbopprqqty."',
                                        '".$txtboppamount."',
                                        '".$txtboppadrate."',
                                        '".$SUserID."',
                                        sysdate()

                                )

                        ";

          mysql_query($inserttrn_prod_estimation)or die(mysql_error());
          $inserttrn_prod_estimation="insert into
                                trn_prod_estimation
                                (
                                        estimation_id,
                                        prod_item_object_id,
                                        qty_gsm,
                                        amount_kg,
                                        adhesive_rate,
                                        entry_by,
                                        entry_date
                                )
                                values
                                (
                                        '".$estimateid."',
                                        '".$txtadhesive3."',
                                        '".$txtadhesiverqqty."',
                                        '".$txtadhesiveamount."',
                                        '".$txtadhesiverate."',
                                        '".$SUserID."',
                                        sysdate()

                                )

                        ";

          mysql_query($inserttrn_prod_estimation)or die(mysql_error());
          $inserttrn_prod_estimation="insert into
                                trn_prod_estimation
                                (
                                        estimation_id,
                                        prod_item_object_id,
                                        qty_gsm,
                                        amount_kg,
                                        adhesive_rate,
                                        entry_by,
                                        entry_date
                                )
                                values
                                (
                                        '".$estimateid."',
                                        '".$txtadhesive4."',
                                        '".$txtinksolventrqqty."',
                                        '".$$txtinksolventamount."',
                                        '".$txtinksolventrate."',
                                        '".$SUserID."',
                                        sysdate()

                                )

                        ";

          mysql_query($inserttrn_prod_estimation)or die(mysql_error());
          $inserttrn_prod_estimation="insert into
                                trn_prod_estimation
                                (
                                        estimation_id,
                                        prod_item_object_id,
                                        qty_gsm,
                                        amount_kg,
                                        adhesive_rate,
                                        entry_by,
                                        entry_date
                                )
                                values
                                (
                                        '".$estimateid."',
                                        '".$txtadhesive5."',
                                        '".$txtadhesivesolventrqqty."',
                                        '".$txtadhesivesolventamount."',
                                        '".$txtadhesivesolventrate."',
                                        '".$SUserID."',
                                        sysdate()

                                )

                        ";

          mysql_query($inserttrn_prod_estimation)or die(mysql_error());
          
         ;
         $inserttrn_prod_estimation="insert into
                                trn_prod_estimation
                                (
                                        estimation_id,
                                        prod_item_object_id,
                                        qty_gsm,
                                        amount_kg,
                                        adhesive_rate,
                                        entry_by,
                                        entry_date
                                )
                                values
                                (
                                        '".$estimateid."',
                                        '".$txtadhesive6."',
                                        '".$txtwast."',
                                        '".$txtwast."',
                                        '".$txtwastagerate."',
                                        '".$SUserID."',
                                        sysdate()

                                )

                        ";

          mysql_query($inserttrn_prod_estimation)or die(mysql_error());


          

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

