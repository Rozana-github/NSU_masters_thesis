<?PHP
if(isset($_POST['title'])){
        include "Library/dbconnect.php";

        $member_query=" Select
                                *
                        from
                                _nisl_mas_member
                        where
                                User_Name='".$_POST['title']."'";
		
        $rset = mysql_query($member_query) or die(mysql_error());
		
        $row = mysql_fetch_array($rset);

        if(!$row){
            include("login.php");
        }else{
                extract($row);
                if(($_POST['title']==$User_Name) && ($_POST['pass']==$Password) && ($Data_Status==0)){
						session_start();
						$_SESSION['SUserID'] = $User_ID;
						$_SESSION['SUserName'] = $User_Name;
						
                        include("welcome.php");
                }else
						include("login.php");
        }
		mysql_close();
}else{
	header("Location:login.php");
}
?>
