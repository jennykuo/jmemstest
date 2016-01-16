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
?>
<form action="showQuery.php" method="post" name="quick_query">
<textarea name="query" cols="" rows=""></textarea>
<input name="display" type="radio" value="yes" />
<input name="" type="submit" /></form>
</body>
</html>
