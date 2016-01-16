<?php
//checks to see user is logged in
session_start();
if(!isset($_SESSION["username"]))
{
   header('Location: login.php');
   exit;
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Search the Database</title>
</head>
<body>
<a href="logout.php">logout</a>
<h2>Search</h2>
<table>
<form action="search.php" method="post">
<tr><td>Chapter: </td><td><input type="text" name="chapter" /></td><td><select name="chapter_search"><option value="contains">Contains</option><option value="matches">Match Exactly</option></select></td></tr>
<tr><td>Incipit: </td><td><input type="text" name="incipit" /></td><td><select name="incipit_search"><option value="contains">Contains</option><option value="matches">Match Exactly</option></select></td></tr>
<tr><td>Country: </td><td><input type="text" name="country" /></td><td><select name="country_search"><option value="contains">Contains</option><option value="matches">Match Exactly</option></select></td></tr>
<tr><td>Title: </td><td><input type="text" name="title" /></td><td><select name="title_search"><option value="contains">Contains</option><option value="matches">Match Exactly</option></select></td></tr>
<tr><td>Context: </td><td><input type="text" name="context" /></td><td><select name="context_search"><option value="contains">Contains</option><option value="matches">Match Exactly</option></select></td></tr>
<tr><td>Manuscript: </td><td><input type="text" name="manuscript" /></td><td><select name="manuscript_search"><option value="contains">Contains</option><option value="matches">Match Exactly</option></select></td></tr>
<tr><td>Owner: </td><td><input type="text" name="owner" /></td><td><select name="owner_search"><option value="contains">Contains</option><option value="matches">Match Exactly</option></select></td></tr>
<tr><td>Provenance: </td><td><input type="text" name="provenance" /></td><td><select name="provenance_search"><option value="contains">Contains</option><option value="matches">Match Exactly</option></select></td></tr>
<tr><td>Rubric: </td><td><input type="text" name="rubric" /></td><td><select name="rubric_search"><option value="contains">Contains</option><option value="matches">Match Exactly</option></select></td></tr>
<tr><td>Scribe: </td><td><input type="text" name="scribe" /></td><td><select name="scribe_search"><option value="contains">Contains</option><option value="matches">Match Exactly</option></select></td></tr>
<tr><td>Topic: </td><td><input type="text" name="topic" /></td><td><select name="topic_search"><option value="contains">Contains</option><option value="matches">Match Exactly</option></select></td></tr>
<tr><td colspan="3"><h3>Ordering</h3></td></tr>
<tr><td>Primary sort: </td><td colspan="2"><select name="primary_order"><option value="default">Default</option><option value="chapter">Chapter</option><option value="title">Title</option><option value="country">Country</option><option value="incipit">Incipit</option></select></td></tr>
<tr><td>Secondary sort: </td><td colspan="2"><select name="secondary_order"><option value="default">Default</option><option value="chapter">Chapter</option><option value="title">Title</option><option value="country">Country</option><option value="incipit">Incipit</option></select></td></tr>
<tr><td><input type="submit" name="submit" value="Search" /></td></tr>
</form>
</table>
</body>
</html>
