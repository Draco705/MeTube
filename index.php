<html>
<?php
	session_start();
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

<form action="login.php" method="post">
	<input type="submit" class="button"  VALUE = "Log in" >
</form>

<form action="register.php" method="post">
	<input type="submit" class="button"  VALUE = "Register" >
</form>

<br><br>

<form action="index.php" method="post">
Search:  <input type="text" name="search" style="width: 500px";>
	<input name="submit" type="submit" value="Search"> <br><br>
</form>

<?php

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
?>



<div style="background:#339900;color:#FFFFFF; width:150px;">Uploaded Media</div>

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


	<table width="50%" cellpadding="0" cellspacing="0">
	
	<td><h4> id </h4></td>
	<td><h4> Name </h4></td>
	
		<?php
			while ($result_row = mysql_fetch_row($result)) //filename, username, type, mediaid, path
			{ 
				$mediaid = $result_row[3];
				$titlename = $result_row[5];
				$filenpath = $result_row[4];
		?>
        	 <tr valign="top">			
			<td>
					<?php 
						echo $mediaid;  //mediaid
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
