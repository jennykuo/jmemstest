<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?php
	//checks to see user is logged in
	session_start();
	if(!isset($_SESSION["username"]))
	{
	   header('Location: login.php');
	   exit;
	}

	require('admin/includes/config_db.php');
  	require('admin/includes/database.php');
	
	$query = tep_db_query($_POST['query']);
	if($POST_['display'] == 'yes')
	{
		$results = tep_db_fetch_array($query);
		print_r($results);
	}
?>
</body>
</html>
