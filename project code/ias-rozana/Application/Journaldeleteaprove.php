<?PHP
      include "Library/dbconnect.php";
      include "Library/SessionValidate.php";

if ($rtype=='A')
	{
		$q1	= "UPDATE 	`mas_journal` SET
						`journal_status`='1',
						`update_by`='$SUserID',
                        `update_date`=CURDATE()
				WHERE mas_journal.journalid='$sjournalid'";
		$rs=mysql_query($q1) or die("Error: ".mysql_error());

	}

if ($rtype=='D')
	{
		$q1	= "UPDATE 	`mas_journal` SET
						`journal_status`='2',
						`update_by`='$SUserID',
                        `update_date`=CURDATE()
				WHERE mas_journal.journalid='$sjournalid'";
		$rs=mysql_query($q1) or die("Error: ".mysql_error());
	}

include "voucher_approval.php";

mysql_close();
?>



