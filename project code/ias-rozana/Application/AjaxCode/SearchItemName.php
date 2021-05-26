<?PHP

    include_once("../Library/dbconnect.php");
    //include "../dbconnect.php";

     //search Item name
              $searchItemName="select
                                     itemcode,
                                     itemdescription
                                from
                                     mas_item
                               where
                                    parent_itemcode='".$GLID."'
                              order by itemdescription
                               ";

              $resultItemName=mysql_query($searchItemName) or die(mysql_error());

             echo"<select name='cboItem'>
                        <option value='-1'>select Sub-Item</option>
                   ";

              if(mysql_num_rows($resultItemName)>0)
                 {

                     while($rowItemName=mysql_fetch_array($resultItemName))
                      {
                           extract($rowItemName);
                           echo"<option value='".$itemcode."'>$itemdescription</option>";


                      }

                 }
            echo"</select>";

?>


