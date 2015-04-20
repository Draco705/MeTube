<html>
<?php


	session_start();
	
	if(isset($_SESSION['username'])) {
	 session_unset();

   session_destroy();
}
	include_once "function.php";
	
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Media browse</title>
<link rel="stylesheet" type="text/css" href="css/default.css" />
<script type="text/javascript" src="js/jquery-latest.pack.js">
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
<link rel="stylesheet" type="text/css" href="css/default.css">
</head>
<body>
<img src="metube.jpg" alt="MeTube" style="width:340px;height:128px">
<br>
<form action="login.php" method="post">
	<input type="submit" class="button"  VALUE = "Log in" >
</form>

<form action="register.php" method="post">
	<input type="submit" class="button"  VALUE = "Register" >
</form>

<br><br>

<form action="index.php" method="post">
Search:  <input type="text" name="search" style="width: 500px" placeholder="media....";>
	<input name="submit" type="submit" value="Search"> <br><br>
</form>
<br>

<?php
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




 <div style="background:#DF0101;color:#FFFFFF; width:200px;"> <h2>MeTube Media<h2>
 </div> 
 <img src="media.jpg" alt="Media" style="width:100px;height:100px">

 
<form action="index.php" method="post">
	Category: <select name="dropdown">
  <option selected="selected"> All </option>
  <option value="audio">Audio</option>
  <option value="video">Video</option>
  <option value="image">Image</option>
  <option value="other">Other</option>
</select>
<input name="submit" type="submit" value="Submit">
</form>

<?php

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
	if($_POST['dropdown'] == "audio") {
		$query = "SELECT * FROM media WHERE type RLIKE 'audio'"; 
	$result = mysql_query( $query );
	if (!$result){
	   die ("Could not query the media table in the database: <br />". mysql_error());
	}
	}
	
	else if($_POST['dropdown'] == "video") {
		$query = "SELECT * FROM media WHERE type RLIKE 'video'"; 
	$result = mysql_query( $query );
	if (!$result){
	   die ("Could not query the media table in the database: <br />". mysql_error());
	}
	}
	
	else if($_POST['dropdown'] == "image") {
		$query = "SELECT * FROM media WHERE type RLIKE 'image'"; 
	$result = mysql_query( $query );
	if (!$result){
	   die ("Could not query the media table in the database: <br />". mysql_error());
	}
	}
	
	else if($_POST['dropdown'] == "other") {
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
            	            <a href="media.php?id=<?php echo $mediaid;?>" target="_blank"><?php echo $titlename;?></a> 
                        </td>
                        <td>
            	            <a href="/uploads/$filenpath" target="_blank" onclick="javascript:saveDownload(<?php echo $result_row[4];?>);">Download</a>
                        </td>
		</tr>
        	<?php
			}
		?>
	</table>
   </div>

</body>
</html>
