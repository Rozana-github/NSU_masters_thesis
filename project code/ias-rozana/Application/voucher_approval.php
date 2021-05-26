<?PHP
      include "Library/dbconnect.php";
      include "Library/Library.php";
      include "Library/SessionValidate.php";
?>
<html>

<head>
            <meta http-equiv='Content-Type' content='text/html; charset=windows-1252'>
            <title>Invoice Posting</title>
            <LINK href="Style/generic_form.css" type='text/css' rel='stylesheet'>
            <link rel='stylesheet' type='text/css' href='Style/eng_form.css' />
      </head>

<body class='body_e'>

<script language='Javascript'>

  function GoJournalEdit(jid)
  {

    window.location.href="JournalEdit.php?Jid="+jid+"";

  }

  function DeleteJournal(jid)
  {

    window.location.href="JournalDelete.php?Jid="+jid+"";


  }

</script>

<?PHP

$temp_journal_query = "select       journalid,
                                                journalno,
                                                journaltype,
                                                date_format(mas_journal.journaldate,'%d-%m-%Y') as journaldate
                       from mas_journal
                       where
                       journal_status=0
                      ";

$rset = mysql_query($temp_journal_query) or die("Error: ".mysql_error());

                        $RowCount=mysql_num_rows($rset);
                  if($RowCount>0)
                  {
                                    echo "
                                    <table border='0' id='table1' width='100%' bodercolor='black' cellspacing='0' cellpadding='1'>
                                                <tr>
                                                  <td class='top_left_curb'></td>
                                                  <td colspan='8' class='header_cell_e' align='center'>Voucher Approval Form</td>
                                                  <td class='top_right_curb'></td>
                                                </tr>

                                                <tr>
                                                            <td class='lb' rowspan='".($RowCount+1)."'></td>
                                                            <td class='title_cell_e'><b>Journal ID</b></td>
                                                            <td class='title_cell_e'><b>Journal No</b></td>
                                                            <td class='title_cell_e'><b>Journal Type</b></td>
                                                            <td class='title_cell_e'><b>Journal Date</b></td>
                                                            <td class='title_cell_e' colspan='4'>&nbsp;</td>
                                                            <td class='rb' rowspan='".($RowCount+1)."'></td>

                                                </tr>";

                                                            $i=0;
                                                             while($row = mysql_fetch_array($rset))
                                                             {

                                                                  extract($row);
                                                                  if(($i%2)==0)
                                                                         $class='even_td_e';
                                                                  else
                                                            $class='odd_td_e';

                                    echo "<tr>
                                                            <td  class='$class'>$journalid</td>
                                                            <td  class='$class'><A href=JournalPrintReport.php?sjournalid=".$journalid."&rtype=P> ".$journalno." </A></td>
                                                            <td  class='$class' >$journaltype </td>
                                                            <td  class='$class'>$journaldate</td>
                                                            <td  class='$class'><b><center><A href=Journaledit.php?sjournalid=".$journalid."&rtype=E> Edit </A></td>
                                                            <td  class='$class'><b><center><A href=JournalPrintReport.php?sjournalid=".$journalid."&rtype=P> Print </A></td>
                                                            <td  class='$class'  valign='top' ><A href=Journaldeleteaprove.php?sjournalid=".$journalid."&rtype=A> Approve </A></td>
                                                             <td class='$class' align='right'><A href=Journaldeleteaprove.php?sjournalid=".$journalid."&rtype=D> Delete </A></td>
                                                </tr>";

                                                                  $i++;
                                                              }
                                    echo "<tr>
                                                <td class='bottom_l_curb'></td>
                                                <td class='bottom_f_cell' colspan='7'></td>
                                                <td class='bottom_r_curb'></td>
                              </tr>";
                                    echo "</table>";


                          }
                  else
                  {
                        drawNormalMassage("No Information Available.");
                  }


?>




</body>

</html>
