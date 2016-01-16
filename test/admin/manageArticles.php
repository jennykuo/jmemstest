<?php


	  // #############   START PHP  ####################


/*
  Copyright (c) 2004 Duke University
  Author: Justin Leonard
  Released under the GNU General Public License
*/

  require('includes/application_top.php');
  require('includes/database.php');
  session_start();
 function assert_handler($file, $line, $code)
  {
  ?>
  <html> 
   <head> 
   <script language="JavaScript"> 
   <!-- 
       alert('You do not have Administrative Privileges to Manage Articles'); 
       history.back(); 
   //--> 
   </script> 
   </head> 
   <body>
	</body> 
   </html> 
   <?php 
   exit; 
  }
  assert_options(ASSERT_CALLBACK, 'assert_handler');
  assert($_SESSION["sessionUser"] == SITE_MANAGEMENT_USERNAME); 
  
	$issue_query = tep_db_query("SELECT * FROM issues WHERE ID='" . $_GET["issue"] . "'");
	$issueForArticles = tep_db_fetch_array($issue_query);  
  
	$patterns = array ("/~/","/'/");
	$replacement = array ("\"","'");  
  
  if (isset($HTTP_POST_VARS['action']) && ($HTTP_POST_VARS['action'] == 'processDeleteArticles')) {
		$ArticleIDs = split('@',$HTTP_POST_VARS["ArticlesToDelete"]);
		foreach($ArticleIDs as $ArticleID)
			tep_db_query("DELETE FROM articles WHERE ID='" . $ArticleID . "'");						
  }
  
  if (isset($HTTP_POST_VARS['action']) && ($HTTP_POST_VARS['action'] == 'processEditArticle')) {
		$Article = split('@',$HTTP_POST_VARS["ArticleToEdit"]);
		$ArticleID = $Article[0];	  
		$ArticleStartPage = $Article[1];
		$ArticleEndPage = $Article[2]; 
		$ArticleTitle = preg_replace($patterns,$replacement,$Article[3]); 		
		$ArticleAuthor = preg_replace($patterns,$replacement,$Article[4]); 
		$ArticleAbstract = preg_replace($patterns,$replacement,$Article[5]); 
		tep_db_query("UPDATE articles Set Startpage='" . $ArticleStartPage . "', EndPage='" . $ArticleEndPage . "', Title='" . $ArticleTitle . "', Author='" . $ArticleAuthor . "', Abstract='" . $ArticleAbstract . "' WHERE ID='" . $ArticleID . "'");		
	}
	
  if (isset($HTTP_POST_VARS['action']) && ($HTTP_POST_VARS['action'] == 'processAddArticle')) {
		$Article = split('@',$HTTP_POST_VARS["ArticleToAdd"]);  
		$IssueID = $Article[0];
		$ArticleStartPage = $Article[1];
		$ArticleEndPage = $Article[2]; 
		$ArticleTitle = preg_replace($patterns,$replacement,$Article[3]); 		
		$ArticleAuthor = preg_replace($patterns,$replacement,$Article[4]); 
		$ArticleAbstract = preg_replace($patterns,$replacement,$Article[5]); 
		tep_db_query("INSERT INTO articles (IssueID,StartPage,EndPage,Title,Author,Abstract) VALUES('" . $IssueID . "','" . $ArticleStartPage . "','" . $ArticleEndPage . "','" . $ArticleTitle . "','" . $ArticleAuthor . "','" . $ArticleAbstract . "')");
	}	


	  // #############   END PHP  ####################


?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<HEAD>
  <META NAME="GENERATOR" CONTENT="JMEMS Journal of Medieval and Early Modern Studies Duke University">
  <TITLE>JMEMS Homepage</TITLE>
	<link href="../style/stylesheet.css" rel="stylesheet" type="text/css">
<script language="javascript">
var Articles = new Array();
var selectedArticleID = 0;
var issueID = <?php echo $_GET["issue"];?>;

function deleteOnDelete(keyStroke)// event appears to be passed by Mozilla 
{
	var characterCode = (document.layers) ? keyStroke.which : event.keyCode;
	if(characterCode == 46){ //if generated character code is equal to ascii 127 (if delete key)
		deleteSelectedArticles();
	}
}

function loadArticleForEdit()
{
	var mySelect = document.getElementById('ArticleSelect');
	selectedArticleID = mySelect.options[mySelect.selectedIndex].value;
	document.getElementById('ArticleStartPage').value = Articles[selectedArticleID]['StartPage'];
	document.getElementById('ArticleEndPage').value = Articles[selectedArticleID]['EndPage'];
	document.getElementById('ArticleTitle').value = Articles[selectedArticleID]['Title'];
	document.getElementById('ArticleAuthor').value = Articles[selectedArticleID]['Author'];
	document.getElementById('ArticleAbstract').value = Articles[selectedArticleID]['Abstract'];		
}

function editArticle()
{
	var div = document.getElementById('ArticleToEditDiv');
	div.innerHTML = div.innerHTML + '<input name="ArticleToEdit" type="hidden" value="' + selectedArticleID + '@' + document.getElementById('ArticleStartPage').value + '@' + document.getElementById('ArticleEndPage').value + '@' + codeQuotes(document.getElementById('ArticleTitle').value) + '@' + codeQuotes(document.getElementById('ArticleAuthor').value) + '@' + codeQuotes(document.getElementById('ArticleAbstract').value) + '"/>';
	document.getElementById('edit_Article_form').submit();	
}

function addArticle()
{
	var div = document.getElementById('ArticleToAddDiv');
	div.innerHTML = div.innerHTML + '<input name="ArticleToAdd" type="hidden" value="' + issueID + '@' + document.getElementById('ArticleStartPage').value + '@' + document.getElementById('ArticleEndPage').value + '@' + codeQuotes(document.getElementById('ArticleTitle').value) + '@' + codeQuotes(document.getElementById('ArticleAuthor').value) + '@' + codeQuotes(document.getElementById('ArticleAbstract').value) + '"/>';
	document.getElementById('add_Article').submit();	
}

// trouble passing double quotes (") through hidden field (b/c cuts off due to value="word"word" even if escaped with slashes, so use rare character to pass instead and then replace these with the quotes on other end
function codeQuotes(text)
{
	return text.replace(/"/g,'~');
}

 function storeCaret (textEl) {
   if (textEl.createTextRange) 
	 textEl.caretPos = document.selection.createRange().duplicate();
 }
 
 function insertAtCaret (e,textEl, text) {
	var characterCode = (document.layers) ? keyStroke.which : event.keyCode;
	if(characterCode == 13) //if generated character code is equal to ascii 13 (if enter key)
	{
		   if (textEl.createTextRange && textEl.caretPos) {
			 var caretPos = textEl.caretPos;
			 caretPos.text =
			   caretPos.text.charAt(caretPos.text.length - 1) == ' ' ?
				 text + ' ' : text;
		   }
		   else
			 textEl.value  = text;
	}   
 }


function deleteSelectedArticles()
{
	var mySelect = document.getElementById('ArticleSelect');
	var div = document.getElementById('ArticlesToDeleteDiv');
	var ArticlesToDelete = '';
	for(var i=0; i < mySelect.options.length; i++)
	{
		if(mySelect.options[i].selected) ArticlesToDelete += mySelect.options[i].value + "@";
	}
	if(ArticlesToDelete != '')
	{
		ArticlesToDelete = ArticlesToDelete.substr(0,ArticlesToDelete.length-1);
		div.innerHTML = div.innerHTML + '<input name="ArticlesToDelete" type="hidden" value="' + ArticlesToDelete + '"/>';
		document.getElementById('delete_Articles').submit();
	}
}
document.onkeyup=deleteOnDelete;

function sizePanes()
{
	document.getElementById('RightPane').style.height = document.getElementById('Main').style.height
}
</script>
  <script src="../scripts/setupPage.js" language="JavaScript" type="text/javascript"></script>
  <script>
  var Level = 0;
  </script>
  <SCRIPT>

function addSinglePartTag(tagName, prompt, defaultText)
{
  // If something is selected then just encase it in the tags
  var selection = document.selection.createRange().text;
  if(selection != "")
  {
    self.edit_Article.ArticleAbstract.focus();
    var newSelection = document.selection.createRange();
	  newSelection.text = '<'+tagName+'>'+selection+'</'+tagName+'>';
	  return;
  }

  // Nothing's selected so prompt for something to put between the tags
  var newTag = self.prompt(prompt, defaultText);
  if((newTag == null) || (newTag == defaultText))
    return;
  newTag='['+tagName+']'+stripSpaces(newTag)+'[/'+tagName+']';
  
  self.edit_Article.ArticleAbstract += newTag;
}


</SCRIPT>

</HEAD>
<body onLoad="sizePage();setMainColor(Level); sizePanes()" onResize="sizePage(); sizePanes()">
<div id="Container"> 
	<div id="LinkHeader">
	  <a href="../index.php">
	  <div id="Header">
		<div id="Title">The Journal of<br>
		  Medieval and Early Modern Studies</div>
	  </div>	  
	  </a>
	 </div>
  <div id="ContentPane"> 
  	<div id="Main">
      <div id="LeftPane"> 
        <!-- body //-->
        <!-- body_text //-->
	  <table>
		  <tr>
			<td><A HREF="manageIssues.php"><IMG SRC="../images/buttons/button_issues.gif" border="0"/></A></td>
		  </tr>	  		  
		  <tr>
			<TD>
			<?php
			
				  // #############   START PHP  ####################
				  
			
			?>&nbsp;<BR><B><?php echo $issueForArticles['Volume'] . "." . $issueForArticles['IssueNumber'] . " (" . $issueForArticles['IssueSeason'] . " " . $issueForArticles['Year'] . ")";?></B><BR>
				<B><?php echo $issueForArticles['Title'];?></B><BR>
				<EM><?php echo $issueForArticles['Editors'];?></EM>
			</TD>
		  </tr>	 		  
	 </table>
	  <?php
	$patterns = array ("/<P>/",
				"/\s/",
			   "/'/");
	$replacement = array ("<P>\\n",
			 " ",
			 "\\\'");
			 	$Articles = array();
				$Articles_query = tep_db_query("SELECT * FROM articles WHERE IssueID='" . $_GET["issue"] . "' ORDER BY StartPage ASC");
				while($thisArticle = tep_db_fetch_array($Articles_query))
					array_push($Articles,$thisArticle);
			?>
			<form ID="ArticleForm">
			<SELECT ID="ArticleSelect" NAME="ArticleSelect" SIZE="18"
				MULTIPLE WIDTH=200 STYLE="width: 200px" onChange="loadArticleForEdit()">
			<?php 
				foreach($Articles as $Article)
				{
					echo '<option value="' . $Article['ID'] . '">' . $Article['StartPage'] . " - " . $Article['EndPage'] . ' (' . $Article['Author'] . ')<br/>';
					?>
						<script>
						<?php echo "Articles['" .  $Article['ID'] . "'] = new Array();Articles['" .  $Article['ID'] . "']['StartPage'] = '" . $Article['StartPage'] . "';Articles['" . $Article['ID'] . "']['EndPage'] = '" . $Article['EndPage'] . "';Articles['" .  $Article['ID'] . "']['Title'] = '" . preg_replace($patterns,$replacement,$Article['Title']) . "';Articles['" .  $Article['ID'] . "']['Author'] = '" . preg_replace($patterns,$replacement,$Article['Author']) . "';Articles['" .  $Article['ID'] . "']['Abstract'] = '" . preg_replace($patterns,$replacement,$Article['Abstract']) . "';"; ?>
						</script>
					<?php
				}
				
				
					  // #############   END PHP  ####################
				
				
			?>
			</SELECT>
			</form>
			<form name="logout" action="index.php" method="post" id=login><input type="hidden" name="action" value="processLogout">
			<input type="image" src="../images/buttons/button_logout.gif" border="0" alt="Logout" title="Logout">
			</form> 			
		</div>
		<div id="RightPane">	
			<form name="edit_Article" action="manageArticles.php" method="post">
			<table>
				<tr>
					<td>Pages</td>
           			<td colspan="2"><input type="text" size="4" maxlength="4" name="ArticleStartPage" id="ArticleStartPage"> To <input type="text" size="4" maxlength="4" name="ArticleEndPage" id="ArticleEndPage"></td>
				</tr>
				<tr>
					<td>Title</td>
					<td colspan="2" class="rightside"><input type="text" size="55" name="ArticleTitle" id="ArticleTitle"></td>
				</tr>
				<tr>
					<td>Author</td>
           			<td colspan="2"><input type="text" size="55" name="ArticleAuthor" id="ArticleAuthor"></td>
				</tr>
				<tr>
					<td>Abstract</td>
					<td colspan="2" align="center"><INPUT TYPE="button" class="button" VALUE="Bold" onClick="addSinglePartTag('B', '', ''); edit_Article.ArticleAbstract.focus(); return true;"><INPUT TYPE="button" class="button" VALUE="Italic" onClick="addSinglePartTag('I', '', ''); edit_Article.ArticleAbstract.focus(); return true;"><INPUT TYPE="button" class="button" VALUE="Underline" onClick="addSinglePartTag('U', '', ''); edit_Article.ArticleAbstract.focus(); return true;"></td>
				</tr>
				<tr>
					<td></td>
           			<td colspan="2"><textarea name="ArticleAbstract" wrap="y" cols="43" rows="19" id="ArticleAbstract" onKeyPress="insertAtCaret(event,this.form.ArticleAbstract,'<P>\n')" ONSELECT="storeCaret(this);" ONCLICK="storeCaret(this);" ONKEYUP="storeCaret(this);"></textarea></td>
				</tr>																
			  <tr> 
				<td colspan="3"><A HREF="javascript:deleteSelectedArticles()"><IMG SRC="../images/buttons/button_remove.gif" border="0"/></A>
				<A HREF="javascript:editArticle()"><IMG SRC="../images/buttons/button_edit.gif" border="0"/></A>
				<A HREF="javascript:addArticle()"><IMG SRC="../images/buttons/button_new.gif" border="0"/></A>
				</td>
			  </tr>			  
			</table>
		</form>
		<form name="delete_Articles" id="delete_Articles" action="manageArticles.php?issue=<?php 
		
		
			  // #############   START PHP  ####################
		
		
		echo $_GET["issue"];?>" method="post"><input type="hidden" name="action" value="processDeleteArticles"> 
			<div id="ArticlesToDeleteDiv">
			</div>
		</form>
		<form name="edit_Article_form" id="edit_Article_form" action="manageArticles.php?issue=<?php echo $_GET["issue"];?>" method="post"><input type="hidden" name="action" value="processEditArticle"> 
			<div id="ArticleToEditDiv">
			</div>
		</form>
		<form name="add_Article" id="add_Article" action="manageArticles.php?issue=<?php echo $_GET["issue"];
		
		
			  // #############   END PHP  ####################
		
		
		?>" method="post"><input type="hidden" name="action" value="processAddArticle"> 		
			<div id="ArticleToAddDiv">
			</div>
		</form>
		</div>
    </div>
  </div>
</div>
<!-- body_eof //-->
</html>
