<?PHP
      function getGLCode($id)
      {
            $query="select cost_code from mas_cost_center where id='$id'";
            $rs=mysql_query($query) or die("Error: ".mysql_error());

            if(mysql_num_rows($rs)>0)
            {
                  while($row=mysql_fetch_array($rs))
                  {
                        extract($row);
                  }
                  return $cost_code;
            }
            else
            {
                  die("Invalid CC Tree ID");
            }
      }
?>
<?PHP
      function getNewGLCode($GLCode)
      {
            $FirstSegment=substr($GLCode,0,1);
            $SecondSegment=substr($GLCode,1,2);
            $ThirdSegment=substr($GLCode,3,2);

            $FS=intval($FirstSegment);
            $SS=intval($SecondSegment);
            $TS=intval($ThirdSegment);


            if($FS==0 && $SS==0 && $TS==0)
            {
                  $FirstSegment=getFirstLevelGLCode($FirstSegment,$SecondSegment,$ThirdSegment);
                  return $FirstSegment.$SecondSegment.$ThirdSegment;
            }
            else if($FS!=0 && $SS==0 && $TS==0)
            {
                  $SecondSegment=getSecondLevelGLCode($FirstSegment,$SecondSegment,$ThirdSegment);
                  return $FirstSegment.$SecondSegment.$ThirdSegment;
            }
            else if($FS!=0 && $SS!=0 && $TS==0)
            {
                  $ThirdSegment=getThirdLevelGLCode($FirstSegment,$SecondSegment,$ThirdSegment);
                  return $FirstSegment.$SecondSegment.$ThirdSegment;
            }
            else
            {
                  die("Invalid Input CC Code");
            }
      }
      function getThirdLevelGLCode($FirstSegment,$SecondSegment,$ThirdSegment)
      {
            $query="SELECT
                        MAX(CAST(SUBSTRING(cost_code,4,2) AS UNSIGNED)) as TS
                    from
                        mas_cost_center 
                    where
                        SUBSTRING(cost_code,1,1)='$FirstSegment' AND
                        SUBSTRING(cost_code,2,2)='$SecondSegment'";

            $rs=mysql_query($query) or die("Error: ".mysql_error());

            if(mysql_num_rows($rs)>0)
            {
                  while($row=mysql_fetch_array($rs))
                  {
                        extract($row);
                  }
                  if($TS>=99)
                        die("Error: Second Level CC Code");
                  else
                  {
                        $TS++;
                        return str_pad ("$TS",2,0,STR_PAD_LEFT);
                  }
            }
            else
                  die("Error: Third Level CC Code");
      }
      function getSecondLevelGLCode($FirstSegment,$SecondSegment,$ThirdSegment)
      {
            $query="SELECT
                        MAX(CAST(SUBSTRING(cost_code,2,2) AS UNSIGNED)) as SS
                    from
                        mas_cost_center 
                    where
                        SUBSTRING(cost_code,1,1)='$FirstSegment' AND
                        SUBSTRING(cost_code,4,2)='$ThirdSegment'";

            $rs=mysql_query($query) or die("Error: ".mysql_error());

            if(mysql_num_rows($rs)>0)
            {
                  while($row=mysql_fetch_array($rs))
                  {
                        extract($row);
                  }
                  if($SS>=99)
                        die("Error: Second Level CC Code");
                  else
                  {
                        $SS++;
                        return str_pad ("$SS",2,0,STR_PAD_LEFT);
                  }
            }
            else
                  die("Error: Second Level CC Code");
      }
      function getFirstLevelGLCode($FirstSegment,$SecondSegment,$ThirdSegment)
      {
            $query="SELECT MAX(CAST(SUBSTRING(cost_code,1,1) AS UNSIGNED)) as FS from mas_cost_center ";

            $rs=mysql_query($query) or die("Error: ".mysql_error());

            if(mysql_num_rows($rs)>0)
            {
                  while($row=mysql_fetch_array($rs))
                  {
                        extract($row);
                  }
                  if($FS>=9)
                        die("Error: First Level CC Code");
                  else
                  {
                        $FS++;
                        return $FS;
                  }
            }
            else
                  die("Error: First Level CC Code");
      }
?>

