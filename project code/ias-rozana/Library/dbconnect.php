<?PHP        /* This is the common database connect file, this file needs
        to be included in every PHP file willing to connect to a
        MySQL Database..just change the name of the database
        as per requirement..makes life easier !*/

        mysql_connect ("localhost","root","") or
                die ("Sorry! DBMS Connection failed!");
        mysql_select_db("braciais") or
                die ("Sorry! DB Connection failed!");

        mysql_query("SET NAMES 'utf8'");
?>
