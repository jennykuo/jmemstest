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
       alert('You do not have Administrative Privileges to Manage Images'); 
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

	if (isset($HTTP_POST_VARS['action']) && ($HTTP_POST_VARS['action'] == 'processDeleteImages')) {
		$files = split('@',$HTTP_POST_VARS["imagesToDelete"]);
		foreach($files as $file) {
		  $image_query = tep_db_query("SELECT * FROM images WHERE ID='" . $file . "'");
		  $image = tep_db_fetch_array($image_query); 			
		  unlink('../' . DIR_WS_COVER_IMAGES . $image['Filename']);
		  tep_db_query("DELETE FROM images WHERE ID='" . $file . "'");
		}						
	}
	
	if (isset($HTTP_POST_VARS['action']) && ($HTTP_POST_VARS['action'] == 'processEditImage')) {
		$file = $HTTP_POST_VARS["imageToEdit"];
		$caption = $HTTP_POST_VARS["imageCaption"];
		tep_db_query("UPDATE images SET Caption='" . $caption . "' WHERE ID='" . $file . "'");
	}
	
	if(sizeof($HTTP_POST_FILES)) {
		// uploaded a file
		if ($HTTP_POST_FILES['imageFile']['name'] != '' && $HTTP_POST_FILES["imageFile"]['size'] >= 1) {
			$uploadfile = '../' . DIR_WS_COVER_IMAGES . basename($HTTP_POST_FILES['imageFile']['name']);
			move_uploaded_file($HTTP_POST_FILES['imageFile']['tmp_name'], $uploadfile);
		}
		tep_db_query("INSERT INTO images (Filename) VALUES('" . basename($HTTP_POST_FILES['imageFile']['name']) . "')");
	}	
	
  $imagesArray = array();
  $imageArray_query = tep_db_query("SELECT * FROM images where ID>0 ORDER BY Filename ASC");
  while($image = tep_db_fetch_array($imageArray_query)) {
  		array_push($imagesArray, $image);
  }
	  // #############   END PHP  ####################
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<HEAD>
  <META NAME="GENERATOR" CONTENT="JMEMS Journal of Medieval and Early Modern Studies Duke University">
  <TITLE>JMEMS Homepage</TITLE>
  <link href="../style/index.css" rel="stylesheet" type="text/css">
  <script src="../scripts/setupPage.js" language="JavaScript" type="text/javascript"></script>
<script language="javascript">

  var images = new Array;
  
  function loadImage(id)
  {
  		document.getElementById('Left').innerHTML = '<a href="#" onmouseover="return makeTrue(domTT_activate(this, event, \'statusText\', \'\', \'content\', \'' + images[id]['Caption'] + '\', \'trail\', true));"><img src="../<?php echo DIR_WS_COVER_IMAGES;?>' + images[id]['Filename'] + '"></a>';
  		document.getElementById('imageCaption').value = images[id]['CaptionText'];
  }
  
  function editSelectedCaption()
  {
  		var sel = document.getElementById('imageSelect');
  		document.getElementById('imagesToEditDiv').innerHTML = '<input name="imageToEdit" type="hidden" value="' + sel.options[sel.selectedIndex].value + '"/><input name="imageCaption" type="hidden" value="' + document.getElementById('imageCaption').value + '"/>';
  		document.getElementById('edit_image').submit();		
  }
  
  function deleteSelectedImages()
  {
 	var mySelect = document.getElementById('imageSelect');
	var div = document.getElementById('imagesToDeleteDiv');
	var imagesToDelete = '';
	for(var i=0; i < mySelect.options.length; i++)
	{
		if(mySelect.options[i].selected) imagesToDelete += mySelect.options[i].value + "@";
	}
	if(imagesToDelete != '')
	{
		imagesToDelete = imagesToDelete.substr(0,imagesToDelete.length-1);
		div.innerHTML = div.innerHTML + '<input name="imagesToDelete" type="hidden" value="' + imagesToDelete + '"/>';
		document.getElementById('delete_images').submit();
	} 
  }
  </script>
<script language="javascript">
  var Level = 0;
  </script>
        <style>
@import url(../style/domTT.css);
    </style>
    <script type="text/javascript" language="javascript" src="../scripts/domLib.js"></script>
    <script type="text/javascript" language="javascript" src="../scripts/domTT.js"></script>
    <script type="text/javascript" language="javascript">
var domTT_mouseHeight = domLib_isIE ? 17 : 20;
var domTT_offsetX = domLib_isIE ? -2 : 0;
var domTT_classPrefix = 'domTTClassic';
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
  <div id="Left"></div>
  <div id="ContentPane"> 
    <div id="Main"> 
      <div id="MainText"> 
        <!-- body //-->
        <!-- body_text //-->
        <table>
		  <tr>
			<td><A HREF="index.php"><IMG SRC="../images/buttons/button_menu.gif" border="0"/></A></td>		  
		  </tr>
          <tr> 
            <td><b>Manage Images</b> - 148x677 preferred</td>
          </tr>
		  <tr>
		  	<td><b>Image</b></td>
			<td><b>Caption</b></td>
		  </tr>
		  <form ID="imagesForm">
		  <tr>
		  	<td>
				
				  <SELECT ID="imageSelect" NAME="imageSelect" SIZE="10"
						MULTIPLE WIDTH=150 STYLE="width: 150px" onChange="loadImage(this.options[this.selectedIndex].value)">
				<?php 
			  
			  
			  // #############   START PHP  ####################
			  			$imageToLoad = -1;
						foreach($imagesArray as $imageIndex => $imageInfo) {
							echo '<option value="' . $imageInfo['ID'] . '"' . ($imageIndex==0 ? ' SELECTED' : '') . '>' . $imageInfo['Filename'] . '<br/>';
							if($imageIndex==0) $imageToLoad = $imageInfo['ID'];
						?>
							<script>
							images[<?php echo $imageInfo['ID'];?>] = new Array;
							images[<?php echo $imageInfo['ID'];?>]['Filename'] = "<?php echo $imageInfo['Filename'];?>";
							images[<?php echo $imageInfo['ID'];?>]['Caption'] = "<?php echo preg_replace("/\r\n/","<br>",$imageInfo['Caption']);?>";
							images[<?php echo $imageInfo['ID'];?>]['CaptionText'] = "<?php echo preg_replace("/\r\n/","\\n",$imageInfo['Caption']);?>";
							</script>
						<?php
						}				
						
			  // #############   END PHP  ####################				
										
						
					?>
				  </SELECT>
							
			</td>
			<td>
				<textarea name="imageCaption" wrap="y" cols="25" rows="10" id="imageCaption"></textarea>
			</td>
			
		  </tr>
		  </form>
		 <script>
		 <?php if($imageToLoad > -1) echo 'loadImage(' . $imageToLoad . ');'; ?>
		 </script>
		  <tr>
		  	<td><A HREF="javascript:deleteSelectedImages()"><IMG SRC="../images/buttons/button_remove.gif" border="0"/></A></td>
		  	<td><A HREF="javascript:editSelectedCaption()"><IMG SRC="../images/buttons/button_edit.gif" border="0"/></td>
		  </tr>
		</table>
		<form name="add_image" id="add_image" enctype="multipart/form-data" action="manageImages.php" method="post">
			<input type="file" id="imageFile" name="imageFile" size="18">
			<input type="hidden" name="MAX_FILE_SIZE" value="50000">
			<br><input type="image" src="../images/buttons/button_new.gif" border="0" alt="Add Image" title="Add Image">
		</form>
        <form name="delete_images" id="delete_images" action="manageImages.php" method="post">
          <input type="hidden" name="action" value="processDeleteImages">
          <div id="imagesToDeleteDiv"> </div>
        </form>
        <form name="edit_image" id="edit_image" action="manageImages.php" method="post">
          <input type="hidden" name="action" value="processEditImage">
          <div id="imagesToEditDiv"> </div>
        </form>		
			<form name="logout" action="index.php" method="post" id=login><input type="hidden" name="action" value="processLogout">
			<input type="image" src="../images/buttons/button_logout.gif" border="0" alt="Logout" title="Logout">
			</form>				
      </div>
    </div>
  </div>
</div>
<!-- body_eof //-->
</html>
