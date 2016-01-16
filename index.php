<?php

	  // #############   START PHP  ####################

/*
  Copyright (c) 2004 Duke University
  Author: Justin Leonard
  Released under the GNU General Public License
*/
  require('admin/includes/application_top.php');
  require('admin/includes/database.php');
  
  $image_query = tep_db_query("SELECT * FROM images ORDER BY RAND() LIMIT 1");
  $image = tep_db_fetch_array($image_query);  

// to prevent caching of images so that a random image displays each time page is visited	
  header("Content-type: text/html");
  header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
  header("Cache-Control: no-store, no-cache,
          must-revalidate");
  header("Cache-Control: post-check=0, pre-check=0",
          false);
  header("Pragma: no-cache");
	
	
	
	  // #############   END PHP  ####################	
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<HEAD>
  <META NAME="GENERATOR" CONTENT="JMEMS Journal of Medieval and Early Modern Studies Duke University">
  <TITLE>JMEMS Homepage</TITLE>
  <link href="style/index.css" rel="stylesheet" type="text/css">
  <script src="scripts/setupPage.js" language="JavaScript" type="text/javascript"></script>
  <script>
  var Level = 0;
  </script>
      <style>
@import url(style/domTT.css);
    </style>
    <script type="text/javascript" language="javascript" src="scripts/domLib.js"></script>
    <script type="text/javascript" language="javascript" src="scripts/domTT.js"></script>
    <script type="text/javascript" language="javascript">
var domTT_mouseHeight = domLib_isIE ? 17 : 20;
var domTT_offsetX = domLib_isIE ? -2 : 0;
var domTT_classPrefix = 'domTTClassic';
    </script>
    <script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-25451534-28']);
  _gaq.push(['_trackPageview']);
  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>
</HEAD>
<body onLoad="sizePage();setMainColor(Level)" onResize="sizePage()">

<div id="Container" align="center"> 
  <div id="LinkHeader">  
    <div id="Header"> 
      <div id="Title"><img src="images/title.gif" border=0 align=left> </div>
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
  <div id="Left" style="background-image:url(<?php echo DIR_WS_COVER_IMAGES . $image['Filename'];?>);" onMouseOver="return makeTrue(domTT_activate(this, event, 'statusText', '', 'content', '<?php echo preg_replace("/\r\n/","<br>",$image['Caption']);?>', 'trail', true));"></div>

  <div id="ContentPane"> 
    <div id="Main"> 
      <div id="MainText"> <BR>
        Winner of the Council of Editors of Learned Journals<BR>
		 2014 Codex Award for Distinction in Medieval Studies<BR><BR>
      
        Winner of the Council of Editors of Learned Journals<BR>
        Phoenix Award for Significant Editorial Achievement</B><BR>
        <BR>
       <i> Published by <A HREF="http://jmems.dukejournals.org/"> 
        Duke University Press</A></B></i><BR>
        <BR>

	
	<table width=100%>
	<tr>
	<td valign=top align=left>
        <span class="block"> <a href="aboutJmems.html">
        About JMEMS</a></B><BR>
        <a href="callForSubmissions.html"> Call for Submissions</a></B> 
        <BR>
        <a href="contributorGuidelines.html"> Contributor 
        Guidelines</a></B> <BR>
        <a href="issuesIndex.php"> Archive</a></B> 
        <BR>
        <a href="issuesSearch.php"> Index</a></B> <BR>
        <a href="subscriptions.html"> Subscriptions</a></B><BR>
        <A HREF="advertising.html">Advertising and Permissions</A></B> <BR>
        </span> 
	</td>
	<td valign=top align=right>
	<span class="block">
	New Issue<br>
    <a href="http://jmems.dukejournals.org/content/current">The Renaissance Collage: Toward a New History of Reading</a>
    <br>
    <br>
    Forthcoming<br>
	<a href="articlesIndex.php?id=113">Medical Discourse in Premodern Europe</a>
	</span>
	</td>
	</tr>
	</table>
<BR>
        <BR>
        <BR><CENTER>
        <A HREF="http://www.celj.org/"><IMG BORDER="0" SRC="images/CELJ_logo.png"></A> 
        <P> <A HREF="http://www.celj.org/">JMEMS is a member of the Council 
          of Editors of Learned Journals</A> </B> 
        <P> <a href="../cmrs/">Duke University Center for Medieval and Renaissance 
          Studies</a><BR>
          </B> </CENTER> <BR>
      </div>
    </div>
  </div>

</div>

<!-- body_eof //-->
</body>
</html>
