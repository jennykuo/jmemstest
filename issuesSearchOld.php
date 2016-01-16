<?php

	  // #############   START PHP  ####################

/*
  Copyright (c) 2004 Duke University
  Author: Justin Leonard
  Released under the GNU General Public License
*/

  require('admin/includes/application_top.php');
  require('admin/includes/database.php');  
  
  	$patterns = array ("'([\r\n])[\s]+'",                // Strip out white space
			 "/\s/",
			   "/'/",
			   "/\"/");
	$replacement = array ("\\n",
			 " ",
			 "'",
			 "");
  
  $searchResults = array();
  if (isset($HTTP_POST_VARS['action']) && ($HTTP_POST_VARS['action'] == 'processSearch')) {
		$searchType = mysql_real_escape_string($HTTP_POST_VARS["searchType"]);
		$searchText = $searchText = preg_replace($patterns,$replacement,$HTTP_POST_VARS["searchText"]);
		$searchText = mysql_real_escape_string($searchText);
        
                if($searchType == "keywords") {
			$result_query = tep_db_query("SELECT ID FROM issues WHERE MATCH (Title,Editors) AGAINST ('" . $searchText . "')");
			while($result = tep_db_fetch_array($result_query)) {
				$searchResults[$result['ID']] = array();
			}
			$result_query = tep_db_query("SELECT ID,IssueID FROM articles WHERE MATCH (Title,Author,Abstract) AGAINST ('" . $searchText . "')");
			while($result = tep_db_fetch_array($result_query)) {
				if(!@$searchResults[$result['IssueID']]) $searchResults[$result['IssueID']] = array();
				array_push($searchResults[$result['IssueID']],$result['ID']);
			}				
		}
		else if($searchType == "issueTitle") {
			$result_query = tep_db_query("SELECT ID FROM issues WHERE MATCH (Title) AGAINST ('" . $searchText . "')");
			while($result = tep_db_fetch_array($result_query)) {
				$searchResults[$result['ID']] = array();
			}
		}
		else if($searchType == "AuthorsEditors") {
			$result_query = tep_db_query("SELECT ID FROM issues WHERE MATCH (Editors) AGAINST ('" . $searchText . "')");
			while($result = tep_db_fetch_array($result_query)) {
				$searchResults[$result['ID']] = array();
			}
			$result_query = tep_db_query("SELECT ID,IssueID FROM articles WHERE MATCH (Author) AGAINST ('" . $searchText . "')");
			while($result = tep_db_fetch_array($result_query)) {
				if(!@$searchResults[$result['IssueID']]) $searchResults[$result['IssueID']] = array();
				array_push($searchResults[$result['IssueID']],$result['ID']);
			}				
		}		
		else {
			$result_query = tep_db_query("SELECT ID,IssueID FROM articles WHERE MATCH (" . $searchType . ") AGAINST ('" . $searchText . "')");
			while($result = tep_db_fetch_array($result_query)) {
				if(!@$searchResults[$result['IssueID']]) $searchResults[$result['IssueID']] = array();
				array_push($searchResults[$result['IssueID']],$result['ID']);
			}
		}	
		$searchText = stripslashes($HTTP_POST_VARS["searchText"]);	
	}
	
		  // #############   END PHP  ####################
?>  


<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<HEAD>
  <META NAME="GENERATOR" CONTENT="JMEMS Journal of Medieval and Early Modern Studies Duke University">
  <TITLE>JMEMS Homepage</TITLE>
  <link href="style/stylesheet.css" rel="stylesheet" type="text/css">
  <link href="style/pastIssues.css" rel="stylesheet" type="text/css">  
  <script src="scripts/setupPage.js" language="JavaScript" type="text/javascript"></script>
  <script>
  var Level = 1;
  </script>
  <script>
  function searchOnEnter()
  {
		var characterCode = (document.layers) ? keyStroke.which : event.keyCode;
		if(characterCode == 13){ //if generated character code is equal to ascii 13 (if enter key)
			document.getElementById('issuesSearch').submit();
		} 
  }
  </script>
<SCRIPT LANGUAGE="JavaScript">
function popUp(URL) {
day = new Date();
id = day.getTime();
eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=1,width=640,height=450');");
}
</script>    
</HEAD>
<body onLoad="sizePage();setMainColor(Level)" onResize="sizePage()">
<div id="Container"> 
	<div id="LinkHeader">  
    <div id="Header"> 
      <div id="Title"><a href="index.php"><img src="images/title.gif" border=0 align=left></a> </div>
	<div id="Menu">
		<div id="Menuitem"><a href="aboutJmems.html"><img src="images/menu/about.gif"></a></div>
		<div id="Menuitem"><a href="callForSubmissions.html"><img src="images/menu/submissions.gif"></a></div>
		<div id="Menuitem"><a href="contributorGuidelines.html"><img src="images/menu/contribs.gif"></a></div>
		<div id="Menuitem"><a href="issuesIndex.php"><img src="images/menu/pastissues.gif"></a></div>
		<div id="Menuitem"><a href="issuesSearch.php"><img src="images/menu/index.gif"></a></div>
		<div id="Menuitem"><a href="subscriptions.html"><img src="images/menu/subscriptions.gif"></a></div>
		<div id="Menuitem"><a href="advertising.html"><img src="images/menu/permissions.gif"></a></div>	

	</div>
    </div>
     </div>
  <div id="ContentPane"> 
    <div id="Main"> 
      <div id="MainText">
	  	<div id="MainTextHead">Index</div>
	  	<div id="holder">
			<br><br>
			 <form name="issuesSearch" id="issuesSearch" action="issuesSearch.php" method="post">
			 <input type="hidden" name="action" value="processSearch">
			<table>
				<tr> 
				  <td colspan="3"><b>Search Past Issues</b></td>
				</tr>			
				<tr> 
				  <td>Search Type:</td>
				  <td>Search For:</td>
				</tr>
				<tr> 
				<?php

				  // #############   START PHP  ####################
				  
				  ?>
				  <td><select name="searchType" id="searchType">
                  <option value="keywords"<?php echo $searchType == 'keywords' ? ' SELECTED' : '';?>>Keywords</option>
                  <option value="AuthorsEditors"<?php echo $searchType == 'AuthorsEditors' ? ' SELECTED' : '';?>>Authors/Editors</option>
                  <option value="Title"<?php echo $searchType == 'Title' ? ' SELECTED' : '';?>>Article Title</option>
                  <option value="issueTitle"<?php echo $searchType == 'issueTitle' ? ' SELECTED' : '';?>>Issue Title</option>
				  <option value="Abstract"<?php echo $searchType == 'Abstract' ? ' SELECTED' : '';?>>Abstract Text</option>
                </select></td>
				  <td><input type="text" name="searchText" id="searchText" value="<?php echo $searchText;?>" size="38"></td>
				  <td><input type="image" src="images/buttons/button_go.gif" onClick="searchOnEnter();" border="0" alt="Search" title="Search"></td>				  
				</tr>				
			</table>
			</form>
			<?php
			if(isset($HTTP_POST_VARS['action']) && ($HTTP_POST_VARS['action'] == 'processSearch')) {
				if(count($searchResults) == 0)
					echo 'No Results Found: Please modify your search.';
				else {
					foreach($searchResults as $i => $articleArray) {
					$issues_query = tep_db_query("SELECT * FROM issues WHERE ID='" . $i . "'");
					$issue = tep_db_fetch_array($issues_query);
					?><TABLE BORDER="0" CELLSPACING="0">
						<tr><td><span class="issueHeading"><?php echo $issue['Volume'] . "." . $issue['IssueNumber'] . " (" . $issue['IssueSeason'] . " " . $issue['Year'] . ")";?></span></td></tr>
						<tr><td><span class="issueTitle"><A HREF="articlesIndex.php?id=<?php echo $issue['ID'];?>"><?php echo eregi_replace($searchText,"<b>" . substr($issue['Title'], max(0,strpos(strtolower($issue['Title']),strtolower($searchText))),strlen($searchText)) . "</b>",$issue['Title']);?></A></span></td></tr>
						<tr><td><span class="issueEditors"><?php echo eregi_replace($searchText,"<b>" . substr($issue['Editors'], max(0,strpos(strtolower($issue['Editors']),strtolower($searchText))),strlen($searchText)) . "</b>",$issue['Editors']);?></span></td></tr>
						</TABLE>				
					<?php
						if($articleArray != NULL && count($articleArray)) {
						?>  
          <div id="indentedLeft"> 
            <TABLE BORDER="0" CELLSPACING="0" CELLPADDING="10">
              <?php
							foreach($articleArray as $a) {
								$articles_query = tep_db_query("SELECT * FROM articles WHERE ID='" . $a . "'");
								$article = tep_db_fetch_array($articles_query);
								?>
              <TR> 
                <TD><span class="articlePages"><?php echo $article['StartPage'] . "-" . $article['EndPage'];?></span></TD>
                <TD><span class="articleTitle"><A HREF="javascript:popUp('abstract.php?article=<?php echo $article['ID'];?>&searchText=<?php echo $searchText;?>')"><?php echo eregi_replace($searchText,"<b>" . substr($article['Title'], max(0,strpos(strtolower($article['Title']),strtolower($searchText))),strlen($searchText)) . "</b>",$article['Title']);?></A></span><BR> 
                  <span class="articleAuthor"><?php echo eregi_replace($searchText,"<b>" . substr($article['Author'], max(0,strpos(strtolower($article['Author']),strtolower($searchText))),strlen($searchText)) . "</b>",$article['Author']);?></span> 
                </TD>
              </TR>
              <TR> 
                <TD colspan="2"><span class="abstractText"> 
                  <?php if(strpos(strtolower($article['Abstract']),strtolower($searchText))) echo '...' . eregi_replace($searchText,"<b>" . substr($article['Abstract'], max(0,strpos(strtolower($article['Abstract']),strtolower($searchText))),strlen($searchText)) . "</b>",substr($article['Abstract'], max(0,strpos(strtolower($article['Abstract']),strtolower($searchText)) - 115),215 - strlen($searchText))) . '...';?>
                  </span></TD>
              </TR>
              <?php
							}
						?>
            </TABLE>
          </div>
						<?php					
						}
						?> <br> <?php
					}
				}
			}
				  // #############   END PHP  ####################			
			?>
				</div>
			</div>	
		</div>
    </div>
  </div>
</div>
<!-- body_eof //-->
</body>
</html>
