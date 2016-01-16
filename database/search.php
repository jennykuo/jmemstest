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

include 'config.php';
include 'opendb.php';


$incipit = $_POST['incipit'];
$incipit_pred = $_POST['incipit_search'];
$country = $_POST['country'];
$country_pred = $_POST['country_search'];
$title = $_POST['title'];
$title_pred = $_POST['title_search'];
$context = $_POST['context'];
$context_pred = $_POST['context_search'];
$scribe = $_POST['scribe'];
$scribe_pred = $_POST['scribe_search'];
$provenance = $_POST['provenance'];
$provenance_pred = $_POST['provenance_search'];
$manuscript = $_POST['manuscript'];
$manuscript_pred = $_POST['manuscript_search'];
$owner = $_POST['owner'];
$owner_pred = $_POST['owner_search'];
$rubric = $_POST['rubric'];
$rubric_pred = $_POST['rubric_search'];
$chapter = $_POST['chapter'];
$chapter_pred = $_POST['chapter_search'];
$topic = $_POST['topic'];
$topic_pred = $_POST['topic_search'];

$primary_order = $_POST['primary_order'];
$secondary_order = $_POST['secondary_order'];

$tables = array();
$cond = array();
$params = array();

//gets the sorting columns as well
$col_count = 2;
$columns = get_columns($primary_order, $secondary_order);
$col_count += count($columns);
$col_string = '';

if($col_count > 2)
{
	$col_string = ',' . implode(",", $columns);
}

$query = "SELECT DISTINCT idVersions,version $col_string FROM chapters JOIN versions USING(idChapters)";

$type_string = '';

//check all the search fields
$type_string .= add_to_query('chapter', $chapter, $chapter_pred, $params, $cond);

$type_string .= add_to_query('incipit', $incipit, $incipit_pred, $params, $cond);
$type_string .= add_to_query('title', $title, $title_pred, $params, $cond);
$type_string .= add_to_query('country', $country, $country_pred, $params, $cond);

$type_string .= add_to_query_and_table('topic', $topic, $topic_pred, $params, $cond, $tables, 'topics');
$type_string .= add_to_query_and_table('rubric', $rubric, $rubric_pred, $params, $cond, $tables, 'rubrics');
$type_string .= add_to_query_and_table('owner', $owner, $owner_pred, $params, $cond, $tables, 'owners');
$type_string .= add_to_query_and_table('manuscript', $manuscript, $manuscript_pred, $params, $cond, $tables, 'manuscripts');
$type_string .= add_to_query_and_table('provenance', $provenance, $provenance_pred, $params, $cond, $tables, 'provenances');
$type_string .= add_to_query_and_table('scribe', $scribe, $scribe_pred, $params, $cond, $tables, 'scribes');
$type_string .= add_to_query_and_table('context', $context, $context_pred, $params, $cond, $tables, 'contexts');

//builds the table
if(count($tables))
{
	$query .= ' NATURAL JOIN ' . implode(' NATURAL JOIN ', $tables);
}

//builds the search clause
if(count($cond))
{
	$query .= ' WHERE ' . implode(' AND ', $cond);
}

$query .= order_by($primary_order, $secondary_order);

echo $type_string;

$stmt = perform_search($query, $type_string, $params);
print_results($stmt);

//generates a string for the ordering portion of the SQL statment
function order_by($primary, $secondary)
{
	$string = '';
	if($primary != 'default')
	{
		$primary = ucfirst($primary);
		$string = " ORDER BY untagged$primary";
		if($secondary != 'default')
		{
			$secondary = ucfirst($secondary);
			$string .= ", untagged$secondary";
		}
	}
	return $string;
}

//gets columns for the query
function get_columns($primary, $secondary)
{
	$cols = array();
	if($primary != 'default')
	{
		$cols[] = $primary;
		if($secondary != 'default' && $secondary != $primary)
		{
			$cols[] = $secondary;
		}
	}
	return $cols;
}

//performs the search query
function perform_search($query, $type_string, $params)
{
	global $mysqli;
	
	$formatted_params = array();
	$formatted_params[] = $type_string;
	
	$formatted_params = array_merge($formatted_params, $params);
	
	$stmt = $mysqli->prepare($query);
	call_user_func_array(array($stmt, 'bind_param'),$formatted_params);
	$stmt->execute();
	return $stmt;
}

//prints the search results
function print_results($stmt)
{
	//builds the associative array to hold results
	$meta = $stmt->result_metadata();
	$results = array();
	
	while($field = $meta->fetch_field())
	{
		$var = $field->name;
		$$var = null;
		$results[$var] = &$$var;
	}
	
	//exclude the id
	print_header(array_slice($results, 1));
	
	call_user_func_array(array($stmt, 'bind_result'),$results);
	
	while($stmt->fetch())
	{		
		print_row($results);
	}
	
	close_table();
}

function print_header($results)
{
	$headings = array_keys($results);
		
	echo "<table><tr>";
		
	foreach($headings as $head)
	{
		$head = ucfirst($head);
		echo "<td><h3>$head</h3></td>";
	}
	
	echo "</tr>";
}

function print_row($results)
{
	$other_results = array_slice($results, 2);

	echo "<tr>";
	
	echo "<td>" . get_link($results['idVersions'], $results['version']) . "</td>";
		
	foreach($other_results as $val)
	{
		echo "<td>$val</td>";
	}
	
	echo "</tr>";
}

function get_link($id, $text)
{
	return "<a href='view2.php?id=$id'>$text</a>";
}

function close_table()
{
	echo "</table>";
}

//adds a search term and predicate to the query
function add_to_query($field, $term, $predicate, &$params, &$cond)
{
	if (!empty($term)) {
		$term = format_term($term, $predicate);
		$predicate = get_predicate($predicate);
    	$cond[] = "untagged" . ucfirst($field) . " $predicate";
    	$params[] = $term;
		return 's';
		//if date, return something else
	}
	return false;
}

//same, but it also updates the table portion
function add_to_query_and_table($field, $term, $predicate, &$params, &$cond, &$tables, $table)
{
	if($type = add_to_query($field, $term, $predicate, $params, $cond))
	{
		$tables[] = $table;
		return $type;
	}
}

//determines type of search
function get_predicate($predicate)
{
	if($predicate == 'matches')
		return "= ?";
	else if($predicate == 'contains')
		return "LIKE ?";
}

//changes the format of the search term based on the type of match required
function format_term($term, $predicate)
{
	if($predicate == 'contains')
		return "%$term%";
	else
		return $term;
}

?>

</body>
</html>
