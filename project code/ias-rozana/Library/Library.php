<?PHP

      function drawCompanyInformation($ReportName)
      {
        echo "<table align='center' border='0' cellspacing='0' cennpadding='0'>";
        echo "<tr><td align='center'><font size='4px'><b>Persona</b><font></td></tr>";
        echo "<tr><td align='center'><font size='2px'>House# 121 D, Read# 44, Gulshan# 2, Dhaka.</td></tr>";
        echo "<tr><td>&nbsp;</td></tr>";
        echo "<tr><td align='center'><font size='3px'><b>$ReportName</b><font></td></tr>";
        echo "</table>";
        echo "<br>";
      }

      function drawMassage($Massage,$Event)
      {
            if($Event=="")
                $Event="onClick='javascript:history.go(-1);'";
            echo "<br><br><br>".
                 "<table border='0' align='center' top='500' cellpadding='0' cellspacing='0' width='41%' height='94' style=\"border: 1px solid #000000\">".
                 "    <tr><td width='100%' align='center' valign='middle' height='67'><p>&nbsp;$Massage</td></tr>".
                 "    <tr><td class='Button_cell' width='100%' height='26' align='center'><input class='forms_Button' type='button' value='Back' name='B3' $Event></td></tr>".
                 "</table>";
      }
      function drawBack($Massage,$Event)
      {
            if($Event=="")
                $Event="onClick='javascript:history.go(-1);'";
            echo "<br><br><br>".
                 "<table border='0' align='center' cellpadding='0' cellspacing='0'>".
                 "    <tr><td><input class='Minput' type='button' value='Back' name='B3' style='float: right' $Event></td></tr>".
                 "</table>";
      }
      function drawNormalMassage($Massage)
      {
            echo "<br><br><br>".
                 "<table border='1' align='center' top='500' cellpadding='0' cellspacing='0' width='41%' height='94'>".
                 "    <tr><td width='100%' align='center' valign='middle' height='67'><p>&nbsp;$Massage</td></tr>".
                 "</table>";
      }
      function creatCombo($ComboName,$TableName,$ID,$Name)
      {
                $query=" select
                                $ID as ID,
                                $Name as Name
                         FROM
                                $TableName ";

                echo    "$query";
                $ResultSet= mysql_query($query)
                        or die("Invalid query: " . mysql_error());

                print("<option>Select a $ComboName</option>\n");
                while ($qry_row=mysql_fetch_array($ResultSet))
                {
                        $ID=$qry_row["ID"];
                        $Name=$qry_row["Name"];
                        print("<option value='$ID'>$Name</option>\n");
                }
      }
      function createCombo($ComboName,$TableName,$ID,$Name,$Condition,$selectedValue)
      {
                $query=" select
                                $ID as ID,
                                $Name as Name
                         FROM
                                $TableName ".$Condition;

                $ResultSet= mysql_query($query)
                        or die("Invalid query: " . mysql_error());

                print("<option value='-1'>Select a $ComboName</option>\n");
                while ($qry_row=mysql_fetch_array($ResultSet))
                {
                        $ID=$qry_row["ID"];
                        $Name=$qry_row["Name"];
                        if($ID==$selectedValue)
                              print("<option value='$ID' selected>$Name</option>\n");
                        else
                              print("<option value='$ID'>$Name</option>\n");
                }
      }

      function creatQueryCombo($query,$ComboName)
      {
            $ResultSet= mysql_query($query)
                or die("Invalid query: " . mysql_error());

            print("<option>Select a $ComboName</option>\n");

            while ($qry_row=mysql_fetch_array($ResultSet))
            {
                $ID=$qry_row["ID"];
                $Name=$qry_row["Name"];
                print("<option value='$ID'>$Name</option>\n");
            }
      }
      function GetRandomPassword()
      {
            $keychars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789#$";
            $length = 7;
            $randkey = "";
            $max=strlen($keychars)-1;

            for ($i=0;$i<=$length;$i++)
            {
                  $randkey .= substr($keychars, rand(0, $max), 1);
            }
            return  $randkey;
      }
      function SendMail($UserName,$Password,$To)
      {
            $to = $To;
            $subject ="Transcom Online Registration Confirmation Mail";
            $message ="Your Username and Password \r\n
                       Username: $UserName \r\n
                       Password: $Password \r\n
                       currently your account is disabled to make your account active please click here \r\n
                       http://192.168.0.75/Transcom/AccountActivation.php?UserName=$UserName&Password=$Password";

            $headers ="From: transcom@bangladesh.bd \r\n
                       Reply-To: transcom@bangladesh.bd \r\n
                       X-Mailer: PHP/". phpversion();

            if(mail($to,$subject,$message,$headers))
                return true;
      }

        function comboSecond($CurDate)
        {
                $i=0;
                if($CurDate=="" || $CurDate==null)
                        $CurDate=date("s");

                if($CurDate==-1)
                        echo "<option value='' selected>s</option>";
                while($i!=60)
                {
                        echo "<option value='$i'"; if($i==intval($CurDate)) echo "selected";echo ">$i</option>";
                        $i++ ;
                }
        }
        function comboMinute($CurDate)
        {
                $i=0;
                if($CurDate=="" || $CurDate==null)
                        $CurDate=date("i");

                if($CurDate==-1)
                        echo "<option value='' selected>m</option>";
                while($i!=60)
                {
                        echo "<option value='$i'"; if($i==intval($CurDate)) echo "selected";echo ">$i</option>";
                        $i++ ;
                }
        }
        function comboHour($CurDate)
        {
                $i=0;
                if($CurDate=="" || $CurDate==null)
                        $CurDate=date("G");

                if($CurDate==-1)
                        echo "<option value='' selected>H</option>";
                while($i!=24)
                {
                        echo "<option value='$i'"; if($i==intval($CurDate)) echo "selected";echo ">$i</option>";
                        $i++ ;
                }
        }
       /*
                Use nothing for today selected.
                Use 1....31 for that day selected.
                use -1 for empty selection.
       */
        function comboDay($CurDate)
        {
                $i=1;
                if($CurDate=="" || $CurDate==null)
                        $CurDate=date("d");

                if($CurDate==-1)
                        echo "<option value='' selected>D</option>";
                while($i!=32)
                {
                        echo "<option value='$i'"; if($i==$CurDate) echo "selected";echo ">$i</option>";
                        $i++ ;
                }
        }
       /*
                Use nothing for today selected.
                Use 1....12 for that month selected.
                use -1 for empty selection.
       */
        function comboMonth($CurMon)
        {
                if($CurMon=="" || $CurMon==null)
                        $CurMon=date("m");

                if($CurMon==-1)
                        echo "<option value='' selected>M</option>";
                echo "<option value='1'"; if($CurMon==1) echo "selected";echo ">January</option>";
                echo "<option value='2'"; if($CurMon==2) echo "selected";echo ">February</option>";
                echo "<option value='3'"; if($CurMon==3) echo "selected";echo ">March</option>";
                echo "<option value='4'"; if($CurMon==4) echo "selected";echo ">April</option>";
                echo "<option value='5'"; if($CurMon==5) echo "selected";echo ">May</option>";
                echo "<option value='6'"; if($CurMon==6) echo "selected";echo ">June</option>";
                echo "<option value='7'"; if($CurMon==7) echo "selected";echo ">July</option>";
                echo "<option value='8'"; if($CurMon==8) echo "selected";echo ">August</option>";
                echo "<option value='9'"; if($CurMon==9) echo "selected";echo ">September</option>";
                echo "<option value='10'"; if($CurMon==10) echo "selected";echo ">October</option>";
                echo "<option value='11'"; if($CurMon==11) echo "selected";echo ">November</option>";
                echo "<option value='12'"; if($CurMon==12) echo "selected";echo ">December</option>";
        }
       /*
                ** Use nothing for today selected and the start year will be
                   5 years less than present year and the end year will be the 5 years
                   more than present year.

                ** Use All parameter (start,end,selected) and the last parameter will
                   be used for year selection.

                ** use only -1 for empty selection.
       */
        function comboYear($Startyear,$EndYear,$CurYear)
        {
                if($CurYear=="" || $CurYear==null)
                        $CurYear=date("Y");

                if($Startyear=="" || $Startyear==null || $EndYear=="" || $EndYear==null )
                {
                        $Startyear=date("Y")-5;
                        $EndYear=date("Y")+5;
                }
                if($CurYear==-1)
                        echo "<option value='' selected>Y</option>";
                while($Startyear!=$EndYear+1)
                {
                        echo "<option value='$Startyear'"; if($Startyear==$CurYear) echo "selected";echo ">$Startyear</option>";
                        $Startyear++;
                }
        }
        /*
                ** By this function you can lock tables.
                ** Write the query that will lock the tables and pass it as the parameter.
                ** Example:  lockTables("LOCK TABLES onlinecustomer WRITE")
                ** On Success it returns true else returns false.
        */
        function lockTables($query)
        {
                echo "<!--";
                $ResultSet= mysql_query($query);
                echo "-->";
                if($ResultSet)
                        return true;
                return false;
        }
        /*
               ** It will unlock all the tables that were locked.
               ** On Success it returns true else returns false.
        */
        function unlockTables()
        {
                if($ResultSet= mysql_query("UNLOCK TABLES"))
                        return true;
                return false;
        }



   function pick($table,$field,$cond)
   {
         if($cond==null){
            $query="Select $field from $table";
            }else{
            $query="Select $field from $table where $cond";
            }
                $ResultSet= mysql_query($query)
                        or die("Invalid query: " . mysql_error());

                while ($qry_row=mysql_fetch_array($ResultSet))
                {
         if($tt==null){
            $tt=$qry_row[0];
            }else{
            $tt=$tt.'<BR>'.$qry_row[0];
            }
                }
      //$tt="Select $field from $table where $cond";
        return $tt;
   }


   function dsum($table,$field,$cond)
   {
         if($cond==null){
            $query="Select sum($field) from $table";
            }else{
            $query="Select sum($field) from $table where $cond";
            }
                $ResultSet= mysql_query($query)
                        or die("Invalid query: " . mysql_error());

                while ($qry_row=mysql_fetch_array($ResultSet))
                {
            $tt=$qry_row[0];
                }
      //$tt="Select $field from $table where $cond";
        return $tt;
   }



   function dcount($table,$field,$cond)
   {
         if($cond==null){
            $query="Select $field from $table";
            }else{
            $query="Select $field from $table where $cond";

            }

                $ResultSet= mysql_query($query)
                        or die("Invalid query: " . mysql_error());

      $tt = mysql_num_rows($ResultSet);
        return $tt;
   }


   function dcolumn($tcol)
      {
         for ($i=1;$i<=$tcol;$i++)
            {
               $tt=$tt."<td align='center' class='Header_Cell'><b>Del. Date</b></td>
                  <td align='center' class='Header_Cell'><b>Del. Qty.</b></td>";
            }
        return $tt;
      }
 function crtCombo($ComboName,$TableName,$ID,$Name,$Condition,$selectedValue)
      {
                $query=" select
                                $ID as ID,
                                $Name as Name
                         FROM
                                $TableName ".$Condition;

                $ResultSet= mysql_query($query)
                        or die("Invalid query: " . mysql_error());

                print("<option value='-1'>Select a $ComboName</option>\n");
                while ($qry_row=mysql_fetch_array($ResultSet))
                {
                        $ID=$qry_row["ID"];
                        $Name=$qry_row["Name"];
                        if($ID==$selectedValue)
                              print("<option value='$ID' selected>[$ID][$Name]</option>\n");
                        else
                              print("<option value='$ID'>[$ID][$Name]</option>\n");
                }
      }
      
      
      
      


function pickdata($table,$field,$cond,$tdtype,$tcl)
   {
         if($cond==null){
            $query="Select $field from $table";
            }else{
            $query="Select $field from $table where $cond";
            }
                $ResultSet= mysql_query($query)
                        or die("Invalid query: " . mysql_error());
            $ttt = mysql_num_rows($ResultSet);

                while ($qry_row=mysql_fetch_array($ResultSet))
                {
                   $tt=$tt."<td align='center' class='$tdtype'><b> $qry_row[0] </b></td>
                       <td align='center' class='$tdtype'><b> $qry_row[1] </b></td>";

             }

         $tcol=$tcl-$ttt;

         if($tcol>=1){
         for ($i=1;$i<=$tcol;$i++)
            {
               $tt=$tt."<td align='center' class='$tdtype'><b>&nbsp;</b></td>
                  <td align='center' class='$tdtype'><b>&nbsp;</b></td>";
            }
            }
      //$tt="Select $field from $table where $cond";
        return $tt;
   }

      function getEventImagePath()
      {
            return "../../Event_Images/";
      }
      function getArticleImagePath()
      {
            return "../../Article_Images/";
      }

      function getQLDYCImagePath()
      {
            return "../../../QL_DYC_Images/";
      }
      
      function getExtFileEngPath()
      {
            return "../../../MenuExternalFilesEng/";
      }
      function getExtFileBngPath()
      {
            return "../../../MenuExternalFilesBng/";
      }
      function getQLExtFileEngPath()
      {
            return "../../../QLExternalFilesEng/";
      }
      function getQLExtFileBngPath()
      {
            return "../../../QLExternalFilesBng/";
      }



      function formatMysqlVarChar($strInput)
        {
                $strInput=str_replace("\\","\\\\",$strInput);
                return str_replace("'","''",$strInput);
        }

?>
