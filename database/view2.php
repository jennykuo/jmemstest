<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>

<?php

session_start();
if(!isset($_SESSION["username"]))
{
   header('Location: login.php');
   exit;
}

include 'config.php';
include 'opendb.php';

$id = $mysqli->real_escape_string($_GET['id']);

$result = get_values(array('chapter'),'chapters NATURAL JOIN versions',$id);
print_section(array('Chapters'),$result);

$result = get_values(array('version'),'versions',$id);
print_section(array('Version'),$result);

$result = get_values(array('country'),'versions',$id);
print_section(array('Country'),$result);

$result = get_values(array('date'),'versions',$id);
print_section(array('Date'),$result);

$result = get_values(array('incipit'),'versions',$id);
print_section(array('Incipit'),$result);

$result = get_values(array('entire'),'versions',$id);
print_section(array('Entire'),$result);

$result = get_values(array('context'),'contexts',$id);
print_section(array('Contexts'),$result);

$result = get_values(array('topic'),'topics',$id);
print_section(array('Topics'),$result);

$result = get_values(array('rubric'),'rubrics',$id);
print_section(array('Rubrics'),$result);

$result = get_values(array('manuscript'),'manuscripts',$id);
print_section(array('Manuscripts'),$result);

$result = get_values(array('provenance'),'provenances',$id);
print_section(array('Provenances'),$result);

$result = get_values(array('owner'),'owners',$id);
print_section(array('Owners'),$result);

$result = get_values(array('scribe'),'scribes',$id);
print_section(array('Scribes'),$result);

function get_values($columns, $table, $id)
{
	global $mysqli;
	
	$columns = implode(",",$columns);
	$result = $mysqli->query("SELECT $columns FROM $table WHERE idVersions=$id");
	
	$result_array = array();
	
	while($row = $result->fetch_row())
	{
		$result_array[] = $row;
	}
	
	if(!count($result_array))	//no results text
	{
		$result_array[] = array("None.");
	}
	
	return $result_array;
}

function print_section($headings, $values)
{
	
	print_heading($headings);
	
	echo "<ul>";
	
	print_values($values);
	
	echo "</ul>";
	
}

function print_values($values)
{
	foreach($values as $row)
	{
		foreach($row as $val)
		{
			echo "<li>$val</li>";
		}
	}
}

function print_heading($headings)
{
	foreach($headings as $head)
	{
		echo "<h4>$head</h4>";
	}
}
		

?>

</body>
</html>
