<?php
/*
  Copyright (c) 2004 Duke University
  Author: Justin Leonard
  Released under the GNU General Public License
*/
  	require('admin/includes/application_top.php');
  	require('admin/includes/database.php');	

	$issue_query = tep_db_query("SELECT * FROM issues WHERE ID=$idGet");
	$issue = tep_db_fetch_array($issue_query);
	?>
<TR>
	<TD COLSPAN="2">
		<span class="issueHeading"><?php echo $issue['Volume'] . "." . $issue['IssueNumber'] . " (" . $issue['IssueSeason'] . " " . $issue['Year'] . ")";?></span><BR>
		<span class="issueTitle"><?php echo $issue['Title'];?></span><BR>
		<span class="issueEditors"><?php echo $issue['Editors'];?></span>
	</TD>
</TR>
<TR>
	<TD></TD>
	<TD></TD>	
</TR>		
<?php
	
	$articles = array();
	$articles_query = tep_db_query("SELECT * FROM articles WHERE IssueID=$idGet ORDER BY StartPage ASC");
	while($thisArticle = tep_db_fetch_array($articles_query))
		array_push($articles,$thisArticle);

	foreach($articles as $article)
	{ ?>
		<TR>
			<TD><span class="articlePages"><?php echo $article['StartPage'] . "-" . $article['EndPage'];?></span></TD>
			<TD><span class="articleTitle"><A HREF="<?php if($article['Abstract']) { ?>javascript:popUp('abstract.php?article=<?php echo $article['ID'];?>')<?php } else echo "#";?>"><?php echo $article['Title'];?></A></span><BR>
			<span class="articleAuthor"><?php echo $article['Author'];?></span><BR>
			</TD>
		</TR>
<?php
	}
?>
