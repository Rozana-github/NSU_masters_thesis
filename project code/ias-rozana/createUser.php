<?PHP
        include "Library/SessionValidate.php";
?>
<html>

<head>
<meta http-equiv='Content-Language' content='en-us'>
<meta http-equiv='Content-Type' content='text/html; charset=windows-1252'>
<title>User Entry Form</title>
<link rel='StyleSheet' href='Application/Style/Apperance_1.css' type='text/css' />
</head>

<body>

<?PHP

include_once("Library/dbconnect.php");



$insert_query2 = "insert into _nisl_mas_user
                  (
                        Name,
                        Designation,
                        CompanyName,
                        Address,
                        Email,
                        Phone
                  )
                  values
                  (
                        '$nam',
                        '$des',
                        '$cname',
                        '$address',
                        '$email',
                        '$phone'
                  )
                  ";

mysql_query($insert_query2) or die(mysql_error());

$query="select LAST_INSERT_ID() AS USER_ID from _nisl_mas_user";
$rs=mysql_query($query) or die(mysql_error());
while($row=mysql_fetch_array($rs))
{
        extract($row);
}

$insert_query1 = "insert into _nisl_mas_member
                  (
                        User_Name,
                        User_ID,
                        Password,
                        Type
                  )
                  values
                  (
                        '$username',
                        '$USER_ID',
                        '$pass',
                        $memdrop
                  )
                  ";


mysql_query($insert_query1) or die(mysql_error());

echo " <table border='0' width='100%' cellspacing='0' cellpadding='3' >
        <tr>
                <td colspan='4' class='Header_Cell'>The following user account has been created</td>
        </tr>
        <tr>
                <td width='21%' align='right'>Name</td>
                <td width='33%' style='text-align:left;'><b>$nam</b></td>
                <td width='18%'>&nbsp;</td>
                <td width='24%'>&nbsp;</td>
        </tr>
        <tr>
                <td width='21%' align='right'>Designation</td>
                <td width='33%' style='text-align:left;'><b>$des</b></td>
                <td width='18%'>&nbsp;</td>
                <td width='24%'>&nbsp;</td>
        </tr>
        <tr>
                <td width='21%' align='right'>CompanyName</td>
                <td width='33%' style='text-align:left;'><b>$cname</b></td>
                <td width='18%'>&nbsp;</td>
                <td width='24%'>&nbsp;</td>
        </tr>
        <tr>
                <td width='21%' align='right'>Address</td>
                <td width='33%' style='text-align:left;'><b>$address</b></td>
                <td width='18%'>&nbsp;</td>
                <td width='24%'>&nbsp;</td>
        </tr>
        <tr>
                <td width='21%' align='right'>Email</td>
                <td width='33%' style='text-align:left;'><b>$email</b></td>
                <td width='18%'>&nbsp;</td>
                <td width='24%'>&nbsp;</td>
        </tr>
        <tr>
                <td width='21%' align='right'>Phone</td>
                <td width='33%' style='text-align:left;'><b>$phone</b></td>
                <td width='18%'>&nbsp;</td>
                <td width='24%'>&nbsp;</td>
        </tr>
        
        <tr>
                <td width='21%' align='right'>Member Type</td> ";
                
if($memdrop==0)
   echo  "      <td width='33%' style='text-align:left;'><b>General</b></td>";
else
   echo  "      <td width='33%' style='text-align:left;'><b>Administrator</b></td>";

echo     "      <td width='18%'>&nbsp;</td>
                <td width='24%'>&nbsp;</td>
        </tr>
        <tr>
                <td width='21%' align='right'>User Name</td>
                <td width='33%' style='text-align:left;'><b>$username</b></td>
                <td width='18%'>&nbsp;</td>
                <td width='24%'>&nbsp;</td>
        </tr>

        <tr>
                <td width='21%'>&nbsp;</td>
                <td width='33%'>&nbsp;</td>
                <td width='18%'>&nbsp;</td>
                <td width='24%'>&nbsp;</td>
        </tr>
        <tr>
                <td width='96%' colspan='4'>
                 &nbsp;
                </td>
        </tr>
  </table>  ";


?>
</body>
</html>
<?PHP
        mysql_close();
?>
