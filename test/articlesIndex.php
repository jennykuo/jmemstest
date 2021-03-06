<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<HEAD>
  <META NAME="GENERATOR" CONTENT="JMEMS Journal of Medieval and Early Modern Studies Duke University">
  <TITLE>JMEMS Homepage</TITLE>
  <link href="style/stylesheet.css" rel="stylesheet" type="text/css">
  <link href="style/pastIssues.css" rel="stylesheet" type="text/css">
  <script src="scripts/setupPage.js" language="JavaScript" type="text/javascript"></script>
  <script>
  var Level = 2;
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
	  	<div id="LinkHeader"><a href="issuesIndex.php"><div id="MainTextHead">Past Issues</div></a></div>
	  	<div id="IndentedLeft"><div id="IndentedTop">
			<TABLE WIDTH="650" BORDER="0" CELLSPACING="0" CELLPADDING="10">
					<?php require('articlesOutput.php');?>
			</TABLE>
		</div></div>
	  </div>
    </div>
  </div>
</div>
</body>
</html>
</HTML>