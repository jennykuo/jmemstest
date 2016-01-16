<?php
/*
  Copyright (c) 2004 Duke University
  Author: Justin Leonard
  Released under the GNU General Public License
*/
  	require('admin/includes/application_top.php');
 	 require('admin/includes/database.php');	
	
	$issues = array();
	$issues_query = tep_db_query("SELECT * FROM issues ORDER BY Volume DESC, IssueNumber ASC");
	while($thisIssue = tep_db_fetch_array($issues_query))
		array_push($issues,$thisIssue);

	foreach($issues as $issue)
	{ ?>
		<span class="issueHeading"><?php echo $issue['Volume'] . "." . $issue['IssueNumber'] . " (" . $issue['IssueSeason'] . " " . $issue['Year'] . ")";?></span><BR>
		<span class="issueTitle"><A HREF="articlesIndex.php?id=<?php echo $issue['ID'];?>"><?php echo $issue['Title'];?></A></span><BR>
		<span class="issueEditors"><?php echo $issue['Editors'];?></span>
		<P>
		<?php
		$nextIssue = next($issues);
		if($nextIssue != NULL && $nextIssue['Volume'] != $issue['Volume'])
		{ ?>
			<HR>
			<P>
		<?php }
	}
?>