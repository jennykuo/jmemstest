<?php
$usernames = array("admin");
$passwords = array("cornett");
$page = "searchform.php";

for($i=0;$i<count($usernames);$i++)
{
  $logindata[$usernames[$i]]=$passwords[$i];
}

$found = 0;
for($i=0;$i<count($usernames);$i++)
{
   if ($usernames[$i] == $_POST["username"])
   {
   $found = 1;
   }
}
if ($found == 0)
{
   header('Location: login.php?login_error=1');
   exit;
}

if($logindata[$_POST["username"]]==$_POST["password"])
{
   session_start();
   $_SESSION["username"]=$_POST["username"];
   header('Location: '.$page);
   exit;
}
else
{
   header('Location: login.php?login_error=1');
   exit;
}
?>
