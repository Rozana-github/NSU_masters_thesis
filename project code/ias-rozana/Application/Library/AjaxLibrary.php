<?PHP
        include_once "dbconnect.php";
?>

<?PHP
        if($_POST['FunctionName']=="createCombo")
            call_user_func("createCombo",$_POST['ComboName'],$_POST['SelectA'],$_POST['TableName'],$_POST['ID'],$_POST['Name'],stripslashes($_POST['Condition']),$_POST['selectedValue'],stripslashes($_POST['OnChangeEvent']));
        else if($_POST['FunctionName']=="pick")
            call_user_func("pick",$_POST['TableName'],$_POST['FieldName'],stripslashes($_POST['Condition']));
        else if($_POST['FunctionName']=="pickdouble")
            call_user_func("pick",$_POST['TableName'],$_POST['FieldName'],stripslashes($_POST['Condition']));

?>
<?PHP
        function createCombo($ComboName,$SelectA,$TableName,$ID,$Name,$Condition,$selectedValue,$OnChangeEvent,$CSSClass='select_e')
        {
                //echo "selected Valu->$selectedValue";

                $query="select
                                $ID as ID,
                                $Name as Name
                        FROM
                                $TableName ".$Condition;

                //echo $query;


                $ResultSet= mysql_query($query) or die("Invalid query: " . mysql_error());

                $str="<select size=\"1\" name=\"$ComboName\" class='$CSSClass' $OnChangeEvent>";
                $str.="<option value='-1'>Select a $SelectA</option>\n";
                while ($qry_row=mysql_fetch_array($ResultSet))
                {
                        $ID=$qry_row["ID"];
                        $Name=$qry_row["Name"];
                        
                        if($ID==$selectedValue)
                              $str.="<option value='$ID' selected>$Name</option>\n";
                        else
                              $str.="<option value='$ID'>$Name</option>\n";
                }
                $str.="</select>";
                echo $str;

        }

        function pick($TableName,$FieldName,$Condition)
        {
            if($Condition==null)
            {
                  $query="Select $FieldName from $TableName";
            }
            else
            {
                  $query="Select $FieldName from $TableName $Condition";
                  //echo "<font color='ff0000'>$query</font>";
            }

            //echo $query;

            $ResultSet= mysql_query($query) or die("Invalid query: " . mysql_error());

            while ($qry_row=mysql_fetch_array($ResultSet))
            {
                  if($tt==null)
                  {
                        $tt=$qry_row[0];
                  }
                  else
                  {
                        $tt=$tt.'<BR>'.$qry_row[0];
                  }
            }
      //$tt="Select $field from $table where $cond";
            echo $tt;
      }

        
?>
<?PHP
        mysql_close();
?>
