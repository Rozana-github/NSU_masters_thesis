<?PHP
    include "Library/SessionValidate.php";
?>
<?PHP
    include "Library/dbconnect.php";
    include "Library/Library.php";
?>




<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="author" content="Md.Sharif ur Rahman (Milon)">
<title>$HeightId=</title>
<script language='javascript'>
 function back()
 {
       window.location="ColorChartTitleList.php";
 }

</script>

</head>
<LINK href="Application/Style/Apperance_1.css" type=text/css rel=stylesheet>
<body>
<form name='frmaddToNews' method='post' target='bottomfrm'>
<?PHP
/* ---------------------------------------- Developed By MD.Sharif ur Rahman --------------------------------------- */
/* ---------------------------------------- Created Date '09/1/2008' ----------------------------------------------- */
    $TData="select
                demo_color_id,
                demo_hex_color
            from
                _nisl_chart_color
            ";
    $ExTData=mysql_query($TData) or die(mysql_error());
      while($Row1=mysql_fetch_array($ExTData))
      {
            extract($Row1);
            if($TxtColor==$demo_hex_color)
            {
                  $DataReport=1;
            }
      }

            if($OparationType==3)
            {
                  $UNews="UPDATE
                              _nisl_chart_color
                        SET
                              demo_hex_color='$TxtColor'
                        where
                              demo_color_id='$txtNews_Id'
                        ";

                  mysql_query($UNews) or die(mysql_error());

                  drawMassage("Your Segment Update Successfully","onClick=back()");
            }
            else
            {
                  if($DataReport==1)
                  {
                        drawMassage("Duplicate Data, This Color Already Exists","onClick=back()");
                  }
                  else
                  {
                        $SaveData="insert into
                                          _nisl_chart_color
                                          (
                                                demo_hex_color
                                          )
                                          values
                                          (
                                                UPPER('$TxtColor')
                                          )
                                    ";
                        mysql_query($SaveData) or die(mysql_error());
                        /*--------------------------------- Find Last Insert ID ----------------------------------*/

                        $linsertID="select
                                          LAST_INSERT_ID() as LInsertID
                                    from
                                          _nisl_chart_color
                                    ";
                        $ExLID=mysql_query($linsertID) or die(mysql_error());
                        while($RowLstID=mysql_fetch_array($ExLID))
                        {
                              extract($RowLstID);
                        }
                        /*-------------------------------- END Find Last Insert ID -----------------------------*/
                        $UpdDisRnk="UPDATE
                                          _nisl_chart_color
                                    SET
                                          display_rank='$LInsertID'
                                    where
                                          demo_color_id='$LInsertID'
                                    ";
                        mysql_query($UpdDisRnk) or die(mysql_error());
                        drawMassage("Your Segment Save Successfully","onClick=back()");
                  }

            }
/* ------------------------------------------------- END ---------------------------------------------------------- */
?>
 </form>
</body>

</html>
<?PHP
        mysql_close();
?>
