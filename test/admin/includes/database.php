<?php
/*
  Copyright (c) 2004 Duke University
  Author: Justin Leonard
  Released under the GNU General Public License
*/

// make a connection to the database... now
  tep_db_connect() or die('Unable to connect to database server!');

  function tep_db_connect($server = DB_SERVER, $username = DB_SERVER_USERNAME, $password = DB_SERVER_PASSWORD, $database = DB_DATABASE, $link = 'db_link') {
    global $$link;
	
    if (USE_PCONNECT == 'true') $$link = mysql_pconnect($server, $username, $password);
    else $$link = mysql_connect($server, $username, $password);

    if ($$link) mysql_select_db($database);

    return $$link;
  }

  function tep_db_close($link = 'db_link') {
    global $$link;
    return mysql_close($$link);
  }

  function tep_db_error($query, $errno, $error) { 
	  echo '<font color="#000000"><b>' . $errno . ' - ' . $error . '<br/><br/>' . $query . '<br/><br/><small><font color="#ff0000">[TEP STOP]</font></small><br/><br/></b></font>';
	  die();
 }

  function tep_db_query($query, $link = 'db_link') {
    global $$link;
    $result = mysql_query($query, $$link) or tep_db_error($query, mysql_errno(), mysql_error());
    return $result;
  }

  function tep_db_fetch_array($db_query) {
    return mysql_fetch_array($db_query, MYSQL_ASSOC);
  }

  function tep_db_insert_id() {
    return mysql_insert_id();
  }
  
  function tep_sanitize_string($string) {
    return ereg_replace(' +', ' ', trim($string));
  }  

  function tep_db_prepare_input($string) {
    if (is_string($string))
      return trim(tep_sanitize_string(stripslashes($string)));
  }
?>
