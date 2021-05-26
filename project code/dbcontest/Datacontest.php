<?php
class Datacontest{
    /**
     * @assert ('localhost', 'root', "") == true
     */

    function dbserver($server, $username, $password, $link = 'db_link') {
        global $$link, $db_error;
        $db_error = false;
        if (!$server or $server=="") {
            $db_error = 'No Server selected.';
            return false;
        }
        $$link = @mysql_connect($server, $username, $password) or $db_error = mysql_error();
        return true;
    }


    /**
     * @assert ('myclasstest') == true
     */
    function db_select_db($database) {
        echo mysql_error();
        return mysql_select_db($database);
    }


    /**
     * @assert ('emp_info') == true
     */
    public function select($table, $rows = '*', $where = null, $order = null)
    {
        $q = 'SELECT '.$rows.' FROM '.$table;
        if($where != null)
            $q .= ' WHERE '.$where;
        if($order != null)
            $q .= ' ORDER BY '.$order;
        if($table)
        {
            $query = @mysql_query($q);
            if($query)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        else
            return false;
    }







}
