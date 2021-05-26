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
                        account_object_id,
                        IFNULL(account_no,0) as account_no,
                        IFNULL(branch,0) as branch,
                        IFNULL(contract_person,0) as contract_person,
                        IFNULL(address1,0) as address1,
                        IFNULL(address2,0) as address2,
                        IFNULL(phone,0) as phone
                  from
                        trn_bank
                  where
                        bank_id='$BankID'
                  order by
                        account_object_id desc
            ";
            $Rset=mysql_query($query)or die(mysql_error());
            if(mysql_num_rows($Rset)>0)
            {
                  echo "<table border='0' align='center' width='100%' cellpadding='0' cellspacing='0'>
                              <tr>
                                    <td class='top_l_curb'></td>
                                    <td class='top_f_cell' colspan='6'></td>
                                    <td class='top_r_curb'></td>
                              </tr>
                              <tr>
                                    <td class='lb' rowspan='2'></td>
                                    <td class='title_cell_e2' colspan='6' align='center' >Account Record</td>
                                    <td class='rb' rowspan='2'></td>
                              </tr>
                              <tr>
                                    <td class='title_cell_e' >Account No</td>
                                    <td class='title_cell_e' >Branch Name</td>
                                    <td class='title_cell_e' >Contact Person</td>
                                    <td class='title_cell_e' >Address-1</td>
                                    <td class='title_cell_e' >Address-2</td>
                                    <td class='title_cell_e' >Phone</td>
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
                                                <a href='BankAccount_Entry_Top.php?Optype=2&AccountObjID=".urlencode($account_object_id)."' target='topfrmForReport' title='Click for Update'>
                                                      $account_no
                                                </a>
                                          </td>
                                          <td align='center' class='$clss'>
                                                <a href='BankAccount_Entry_Top.php?Optype=2&AccountObjID=".urlencode($account_object_id)."' target='topfrmForReport' title='Click for Update'>";
                                                if($branch!='0')
                                                {
                                                      echo $branch;
                                                }
                                                else
                                                {
                                                      echo "&nbsp;";
                                                }

                                                echo"
                                                </a>
                                          </td>
                                          <td align='center' class='$clss'>";
                                                if($contract_person!='0')
                                                {
                                                      echo $contract_person;
                                                }
                                                else
                                                {
                                                      echo "&nbsp;";
                                                }
                                          echo "
                                          </td>
                                          <td align='center' class='$clss'>";
                                                if($address1!='0')
                                                {
                                                      echo $address1;
                                                }
                                                else
                                                {
                                                      echo "&nbsp;";
                                                }
                                          echo "
                                          </td>
                                          <td align='center' class='$clss'>";
                                                if($address2!='0')
                                                {
                                                      echo $address2;
                                                }
                                                else
                                                {
                                                      echo "&nbsp;";
                                                }
                                          echo "
                                          </td>
                                          <td align='center' class='$clss'>";
                                                if($phone!='0')
                                                {
                                                      echo $phone;
                                                }
                                                else
                                                {
                                                      echo "&nbsp;";
                                                }
                                          echo "
                                          <td class='rb'></td>
                                    </tr>
                                    ";
                  $i++;
                  }
                              echo "
                                    <tr>
                                          <td class='bottom_l_curb'></td>
                                          <td class='bottom_f_cell' colspan='6'></td>
                                          <td class='bottom_r_curb'></td>
                                    </tr>
                  </table>";
            }
     ?>
</form>
</body>
</html>

