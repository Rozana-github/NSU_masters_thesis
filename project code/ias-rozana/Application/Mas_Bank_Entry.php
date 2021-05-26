<?PHP
session_start();

        include_once("Library/dbconnect.php");
        include_once("Library/Library.php");

?>

<html xmlns:ycode>

<style>
        yCode\:combobox {behavior: url(combobox.htc); }
</style>

<head>

<link rel='stylesheet' type='text/css' href='Style/eng_form.css'>
<link rel='stylesheet' type='text/css' href='Style/generic_form.css'>

</head>

<body class='body_e'>

<?PHP/*-------------------------- Developed By: MD.SHARIF UR RAHMAN ---------------------------------------------*/?>
<form name='frmMasAssetEntry' method='post' action='AddTo_MasItem_Entry.php'>

     <?PHP
            $query="Select
                        bank_id,
                        IFNULL(bank_name,0) as bank_name
                  from
                        mas_bank
                  order by
                        bank_id desc
            ";
            $Rset=mysql_query($query)or die(mysql_error());
            if(mysql_num_rows($Rset)>0)
            {
                  echo "<table border='0' align='center' width='100%' cellpadding='0' cellspacing='0'>
                              <tr>
                                    <td class='top_l_curb'></td>
                                    <td class='top_f_cell' colspan='2'></td>
                                    <td class='top_r_curb'></td>
                              </tr>
                              <tr>
                                    <td class='lb'></td>
                                    <td class='title_cell_e' >Serial No</td>
                                    <td class='title_cell_e' >Bank Name</td>
                                    <td class='rb'></td>
                              <tr>
                       ";

                  $i=0;
                  while($row=mysql_fetch_array($Rset))
                  {
                        extract($row);
                        if($i%2==0)
                              $clss='even_td_e';
                        else
                              $clss='odd_td_e';

                        $Sl_No=$i+1;
                        echo "
                                    <tr>
                                          <td class='lb'></td>
                                          <td align='center' class='$clss'>
                                                <a href='Bank_Entry_Top.php?Optype=2&BankID=".urlencode($bank_id)."' target='topfrmForReport' title='Click for Update'>
                                                      $Sl_No
                                                </a>
                                          </td>
                                          <td align='center' class='$clss'>
                                                <a href='Bank_Entry_Top.php?Optype=2&BankID=".urlencode($bank_id)."' target='topfrmForReport' title='Click for Update'>";

                                                            echo $bank_name;
                                                echo"
                                                </a>
                                          </td>
                                          <td class='rb'></td>
                                    </tr>
                                    ";
                  $i++;
                  }
                              echo "
                                    <tr>
                                          <td class='bottom_l_curb'></td>
                                          <td class='bottom_f_cell' colspan='2'></td>
                                          <td class='bottom_r_curb'></td>
                                    </tr>
                  </table>";
            }
     ?>
</form>
</body>
</html>

