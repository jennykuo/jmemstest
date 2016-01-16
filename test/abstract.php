<?php
/*
  Copyright (c) 2004 Duke University
  Author: Justin Leonard
  Released under the GNU General Public License
*/
	require('admin/includes/application_top.php');
	require('admin/includes/database.php');
	$articles_query = tep_db_query("SELECT * FROM articles WHERE ID=$articleGet");
	$article = tep_db_fetch_array($articles_query);
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<HEAD>
  <META NAME="GENERATOR" CONTENT="JMEMS Journal of Medieval and Early Modern Studies Duke University">
  <TITLE>JMEMS Homepage</TITLE>
  <link href="style/pastIssues.css" rel="stylesheet" type="text/css">  
</HEAD>
<body>
<div id="abstract">
	<div id="AbstractIndentedLeft"><div id="AbstractIndentedTop">
		<div id="holderAbstract" style="width:595px">
		<span class="abstractAuthor"><?php echo $_GET["searchText"] ? eregi_replace($_GET["searchText"],"<b>" . $_GET["searchText"] . "</b>",$article['Author']) : $article['Author'];?></span> 
  <P> 	<span class="abstractTitle"><?php echo $_GET["searchText"] ? eregi_replace($_GET["searchText"],"<b>" . $_GET["searchText"] . "</b>",$article['Title']) : $article['Title'];?></span> 
  <P> 	<span class="abstractText lineSpacing"> <?php echo $_GET["searchText"] ? eregi_replace($_GET["searchText"],"<b>" . $_GET["searchText"] . "</b>",$article['Abstract']) : $article['Abstract'];?> </span>
  	</div>
  	</div></div>
</div>
</BODY>
</HTML>
