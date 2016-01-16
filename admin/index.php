<?php
/*
  Copyright (c) 2004 Duke University
  Author: Justin Leonard, Matthew Territo
  Released under the GNU General Public License
*/

	  // #############   START PHP  ####################
	  
  require('includes/application_top.php');
  require('includes/database.php');
  session_start();
   if (isset($_POST['action']) && ($_POST['action'] == 'processLogin')) {
		if($_POST['login'] == SITE_MANAGEMENT_USERNAME && $_POST['password'] == SITE_MANAGEMENT_PASSWORD) {
			$_SESSION["sessionUser"] = $_POST['login'];
		}
	}

   if (isset($_POST['action']) && ($_POST['action'] == 'processLogout')) {
		session_unregister('sessionUser');
  		session_destroy();
	}
	
	
	  // #############   END PHP  ####################
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<HEAD>
  <META NAME="GENERATOR" CONTENT="JMEMS Journal of Medieval and Early Modern Studies Duke University">
  <TITLE>JMEMS Homepage</TITLE>
	<link href="../style/stylesheet.css" rel="stylesheet" type="text/css">
 <script>
 function editOnEnter(e,obj){ //e is event object passed from function invocation
	var characterCode = (document.layers) ? keyStroke.which : event.keyCode;
	if(characterCode == 13){ //if generated character code is equal to ascii 13 (if enter key)
		login() //edit
		return false 
	}
	else{
		return true 
	}
}

function login()
{
	document.getElementById('login').submit();
}
</script>
  <script src="../scripts/setupPage.js" language="JavaScript" type="text/javascript"></script>
  <script>
  var Level = 0;
  </script>
</HEAD>
<body onLoad="sizePage();setMainColor(Level)" onResize="sizePage()">
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
      <div id="MainText">
<?php

	  // #############   START PHP  ####################
if(!@$_SESSION["sessionUser"]) {

	  // #############   END PHP  ####################
?>
        <table>
          <tr> 
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td><b>Login</b></td>
          </tr>
        </table>
		<form name="login" action="index.php" method="post" id=login><input type="hidden" name="action" value="processLogin"> 
         
        <table cellspacing="5">
	      <tr> 
            <td class="leftSide">Login</td>
            <td class="rightSide"><input type="text" name="login" id="login" onKeyPress="editOnEnter(event,this.form)"></td>
		  </tr>		  
		  <tr>
			<td class="leftSide">Password</td>
			<td class="rightSide"><input type="password" name="password" id="password" onKeyPress="editOnEnter(event,this.form)"></td>
		  </tr>
		  <tr> 
            <td></td>
            <td class="rightSide"><input type="image" src="../images/buttons/button_login.gif" border="0" alt="Login" title=" Login"></td>
          </tr>
		</table></form>
<?php

	  // #############   START PHP  ####################
} else {

	  // #############   END PHP  ####################
?>
        <table cellpadding="5" cellspacing="5">
          <tr> 
            <td><b><a href="manageIssues.php">Manage Issues</a></b></td>
          </tr>
          <tr> 
            <td><b><a href="manageImages.php">Manage Images</a></b></td>
          </tr>
			<form name="logout" action="index.php" method="post" id=login><input type="hidden" name="action" value="processLogout">
			<input type="image" src="../images/buttons/button_logout.gif" border="0" alt="Logout" title="Logout">
			</form> 
		  </table>
<?php

	  // #############   START PHP  ####################
}

	  // #############   END PHP  ####################
?>
	</div>
  </div>	
</div>
</body>
</html>
