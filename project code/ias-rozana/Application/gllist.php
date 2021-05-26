<?PHP
    include "Library/dbconnect.php";
    include "Library/Library.php";
    include "Library/SessionValidate.php";
?>
<html>

<head>

<title>Chart of Acounts</title>
        <script language='javascript'>
            function ReportPrint()
            {
                        print();
            }
        </script>
        <LINK rel='stylesheet' type='text/css' href='Style/generic_report.css'>
        <link rel='stylesheet' type='text/css' href='Style/eng_report.css' />
        <link type='text/css' media='print' rel='stylesheet' href='Style/print.css' />
</head>

<body>


<?PHP
        echo "
        <table width='100%' id='table1' cellspacing='0' cellpadding='0' align='center'>
            <tr>
                <td align='center' HEIGHT='20'>
                    <div class='hide'>
                        <input type='button' name='btnPrint' value='Print' onclick='ReportPrint()'>
                    </div>
                </td>
            </tr>
        </table>";
        
drawCompanyInformation("Chart of Accounts");

$dbName="db_ias";
$query="SELECT gl_code, description FROM mas_gl where gl_code > 00000 order by gl_code" ;

//$result = mysql_db_query($dbName, $query);
$result = mysql_query($query);

if(!empty($result) > 0)
while ($row=mysql_fetch_array($result)){

    if (substr("$row[0]",1,4)=='0000') { ?>
        <font face="Arial" size="4" color="#FF0000"><strong>
<?PHP
    }
    elseif (substr("$row[0]",2,3)=='000') { ?>
        <font size="3" color="#000080"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?PHP
    }
    elseif (substr("$row[0]",3,2)=='00') { ?>
        <font size="2" color="#800040"><strong>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?PHP
    }
    elseif (substr("$row[0]",3,2)!='00') { ?>
        <font size="2" color="#008000"><strong><em>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
<?PHP    
	}

    echo "$row[0] " ; 
    echo "$row[1]" . "<br>" ;
}
?>
</em></strong></font>

</body>

</html>
