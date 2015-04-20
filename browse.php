<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php



	session_start();
	include_once "function.php";
	
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Media browse</title>
<link rel="stylesheet" type="text/css" href="css/default.css" />
<script type="text/javascript" src="js/jquery-latest.pack.js"></script>
<script type="text/javascript">
function saveDownload(id)
{
	$.post("media_download_process.php",
	{
       id: id,
	},
	function(message) 
    { }
 	);
} 
</script>
</head>
<?php
 
if(!isset($_SESSION['username'])) {
	echo "User not available";
header('Refresh :2;index.php');
?>
<form action="index.php" method="post">
	<input type="image" src="home.png" width="30px" height="30px" VALUE = "Home" >
	</form></p>
	<?php
exit;
}
?>

<body>
<img src="metube.jpg" alt="MeTube" style="width:340px;height:128px">
<h1>Welcome <?php echo $_SESSION['username'];?> </h1>

<form action="browse.php" method="post">
	<input type="image" src="home.png" width="30px" height="30px" VALUE = "Home" >
	</form></p> 

<div id="nav">
<form action="update.php" method="post">
	<input type="submit" class="button"  VALUE = "Update Info" >
</form></p>

<br>

<form action="message.php" method="post">
	<input type="submit" class="button"  VALUE = "Send Message" >
</form></p>

<br>


<form action="logout.php" method="post">
	<input type="submit" class="button"  VALUE = "Logout" >
</form></p>


<br>

<form action="receive_msg.php" method="post">
	<input type="submit" class="button"  VALUE = "Message Inbox" >
</form></p> <br>


<?php
$username = $_SESSION['username'];
$query = mysql_query("SELECT * FROM account"); // Run your query
?>
<form action="" method="post" >
<?php
echo "<b>Channel: </b>".'<select name="channeldropdown">';
echo "<option value='None'>".None."</option>"; 
while ($row = mysql_fetch_array($query)) {
   echo "<option value='" . $row[1] . "'>" . $row[1] . "</option>"; 
}
echo '</select>';
?>
&nbsp;&nbsp;
<input name="channelsubmit" type="submit" class="button"  VALUE = "View Channel" >
</form>

<br>

<form action="playlist.php" method="post">
	<input type="submit" class="button"  VALUE = "My Playlist" >
</form></p> <br>


<form action="browse.php" method="post">
	<input name="fav" type="submit" class="button"  VALUE = "Favorite list" >
</form></p> <br>


</div>
<a href='media_upload.php'  style="color:#839cd7;">Upload File</a>
<div id='upload_result'>
<?php 
	if(isset($_REQUEST['result']) && $_REQUEST['result']!=0)
	{		
		echo upload_error($_REQUEST['result']);
	}
?>
</div>
<br/><br/>

<div id="medias">
<form action="browse.php" method="post">
    Search:  <input type="text" name="search" style="width: 500px" placeholder="media....";>
	<input name="submit" type="submit" class="button" value="Search"> <br><br>
</form>

 <div style="background:#DF0101;color:#FFFFFF; width:200px;"> <h2>MeTube Media<h2>
 </div> 
 <img src="media.jpg" alt="Media" style="width:100px;height:100px">
	
	<form action="browse.php" method="post">
	Category: <select name="dropdown">
  <option value="all" selected="selected"> All </option>
  <option value="audio">Audio</option>
  <option value="video">Video</option>
  <option value="image">Image</option>
  <option value="other">Other</option>
</select>
<input name="submit" type="submit" class="button" value="Submit">
</form>




<?php

if(isset($_POST['fav'])) {
	$username = $_SESSION['username'];
	$query = "SELECT * FROM favorites WHERE username = '$username'";
	$result = mysql_query($query);
	
	?>
	
	 <table width="50%" cellpadding="0" cellspacing="0">
	<br>
	
		<?php
			while ($result_row = mysql_fetch_row($result)) //filename, username, type, mediaid, path
			{ 
				$mediaid = $result_row[2];
				$titlename = $result_row[3];
				$filenpath = $result_row[5];
				$filetype = $result_row[6];
		?>
        	 <tr valign="top">			
			<td>
					<?php 
						//echo $mediaid;  //mediaid
						if(substr($filetype,0,5) == 'image'){
							?>
							<img src="picture.png" alt="Image" style="width:34px;height:28px">
							<?php
						}
						else if(substr($filetype,0,5) == 'audio') {
							?>
							<img src="audio.png" alt="Image" style="width:34px;height:28px">
							<?php
						}
						else if(substr($filetype,0,5) == 'video'){
							?>
							<img src="video.png" alt="Image" style="width:34px;height:28px">
							<?php
						}
						else {
							?>
							<img src="file.png" alt="Other" style="width:34px;height:28px">
							<?php
						}
					?>	
			</td>
                        <td>
            	            <a href="media.php?id=<?php echo $mediaid;?>" target="_self" ><?php echo $titlename;?></a> 
                        </td>
                        <td>
            	            <a href="<?php echo $filenpath;?>" download>Download</a>
                        </td>
		</tr>
        	<?php
			}
		?>
	</table>

<?php	
}

else {
 if(isset($_POST['channelsubmit'])) {
	$username = $_POST['channeldropdown'];
	if($username == "None") {
		$query = "SELECT * FROM media";
	}
	else {
	$query = "SELECT * FROM media WHERE username = '$username'"; 
	}
	$result = mysql_query( $query );
	echo "<br>";
	
	echo "<b>".$username."'s Channel </b>";
	if (!$result){
	   die ("Could not query the media table in the database: <br />". mysql_error());
	}
	echo "<br>";
}

else {

if(isset($_POST['submit'])) {
	
	if(isset($_POST['search'])) {
		$search = $_POST['search'];
		if($search == ""){
			$query = "SELECT * FROM media"; 
	$result = mysql_query( $query );
	if (!$result){
	   die ("Could not query the media table in the database: <br />". mysql_error());
	}
	}
	
	else {
	$query = "SELECT * FROM media WHERE title RLIKE '$search'"; 
	$result = mysql_query( $query );
	if (!$result){
	   die ("Could not query the media table in the database: <br />". mysql_error());
	}
}
	}
	
	else {
		
		if($_POST['dropdown'] == "all") {
			echo "<h3> All Media </h3>";
		$query = "SELECT * FROM media"; 
	$result = mysql_query( $query );
	if (!$result){
	   die ("Could not query the media table in the database: <br />". mysql_error());
	}
	}
		
	if($_POST['dropdown'] == "audio") {
		echo "<h3> Audio </h3>";
		$query = "SELECT * FROM media WHERE type RLIKE 'audio'"; 
	$result = mysql_query( $query );
	if (!$result){
	   die ("Could not query the media table in the database: <br />". mysql_error());
	}
	}
	
	else if($_POST['dropdown'] == "video") {
		echo "<h3> Video </h3>";
		$query = "SELECT * FROM media WHERE type RLIKE 'video'"; 
	$result = mysql_query( $query );
	if (!$result){
	   die ("Could not query the media table in the database: <br />". mysql_error());
	}
	}
	
	else if($_POST['dropdown'] == "image") {
		echo "<h3> Images </h3>";
		$query = "SELECT * FROM media WHERE type RLIKE 'image'"; 
	$result = mysql_query( $query );
	if (!$result){
	   die ("Could not query the media table in the database: <br />". mysql_error());
	}
	}
	
	else if($_POST['dropdown'] == "other") {
		echo "<h3> Other </h3>";
	$query = "SELECT * FROM media WHERE type NOT RLIKE 'image' AND type NOT RLIKE 'audio' AND type NOT RLIKE 'video'"; 
	$result = mysql_query( $query );
	if (!$result){
	   die ("Could not query the media table in the database: <br />". mysql_error());
	}
	}
	}
}

else {
	$query = "SELECT * FROM media"; 
	$result = mysql_query( $query );
	if (!$result){
	   die ("Could not query the media table in the database: <br />". mysql_error());
	}
}
}
?>



    <table width="50%" cellpadding="0" cellspacing="0">
	
	<br>
		<?php
			while ($result_row = mysql_fetch_row($result)) //filename, username, type, mediaid, path
			{ 
				$mediaid = $result_row[3];
				$titlename = $result_row[5];
				$filenpath = $result_row[4];
				$filetype = $result_row[2];
		?>
        	 <tr valign="top">			
			<td>
					<?php 
						//echo $mediaid;  //mediaid
						if(substr($filetype,0,5) == 'image'){
							?>
							<img src="picture.png" alt="Image" style="width:34px;height:28px">
							<?php
						}
						else if(substr($filetype,0,5) == 'audio') {
							?>
							<img src="audio.png" alt="Image" style="width:34px;height:28px">
							<?php
						}
						else if(substr($filetype,0,5) == 'video'){
							?>
							<img src="video.png" alt="Image" style="width:34px;height:28px">
							<?php
						}
					?>
			</td>
                        <td>
            	            <a href="media.php?id=<?php echo $mediaid;?>"><?php echo $titlename;?></a> 
                        </td>
                        <td>
            	            <a href="<?php echo $filenpath;?>" target="_blank" onclick="javascript:saveDownload(<?php echo $result_row[4];?>);">Download</a>
                        </td>
		</tr>
        	<?php
			}
		?>
	</table>
	   </div>
</div>
<?php
}
?>
</body>
</html>
