<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
	session_start();
	include_once "function.php";
	
	$username = $_SESSION['username'];
?>	
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Media</title>
<script src="Scripts/AC_ActiveX.js" type="text/javascript"></script>
<script src="Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="css/default.css">
</head>

<body>
	
<?php
if(isset($_GET['id'])) {
	$query = "SELECT * FROM media WHERE mediaid='".$_GET['id']."'";
	$result = mysql_query( $query );
	$result_row = mysql_fetch_row($result);
	
	//updateMediaTime($_GET['id']);
	
	$filename=$result_row[0];   ////0, 4, 2
	$filepath=$result_row[4]; 
	$type=$result_row[2];
	$title=$result_row[5];
	
	if(substr($type,0,5)=="image") //view image
	{
	/*	echo "Viewing Picture:";
		echo $result_row[4]; */
		echo "<img src='".$filepath."'/>";
	}
	
	else if(substr($type,0,5) == "video") //view movie
	{	
?>
	<p>Video: <?php echo $result_row[5];?></p> 
	      
    <object id="MediaPlayer" width=320 height=286 classid="CLSID:22D6f312-B0F6-11D0-94AB-0080C74C7E95" standby="Loading Windows Media Player components…" type="application/x-oleobject" codebase="http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=6,4,7,1112">

<param name="filename" value="<?php echo $result_row[4];?>">

<param name="Showcontrols" value="True">
<param name="autoStart" value="True">

	
	<video width="420" height="340" controls>
  <source src="<?php echo $filepath; ?>" type="video/mp4">
  <source src="movie.ogg" type="video/ogg">
  Your browser does not support the video tag.
</video>
</object> 
      
<?php
	}
	
	else if(substr($type,0,5) == "audio") //Listen audio
	{
		?>
		<p>Music: <?php echo $result_row[5];?></p> 
	      
    <audio controls>
	<source src="<?php echo $filepath; ?>" type="audio/mp3">
 Your browser does not support the audio element.
</audio>
<?php	
	}
	?>
	
	<?php
	$media = $_GET['id'];
	$query = "SELECT * FROM comment WHERE mediaid = '$media'";
	$result1 = mysql_query($query);
	?>
	
	<br><br>
	<form action="browse.php" method="post">
	<input type="submit" class="button"  VALUE = "Home" >
</form></p>

<form action="" method="post">
	<input name="fav" type="submit" class="button"  VALUE = "Add to favourite list" >
</form></p>
	
	<h3> Comments </h3>
	<table  cellpadding="0" cellspacing="0">
    
	<tr>
	
		<?php
			while ($result_row = mysql_fetch_row($result1)) //filename, username, type, mediaid, path
			{ 
				$id = $result_row[0];
				$comment = $result_row[1];
				$user = $result_row[2];
	            $time = $result_row[4];
		?>
        	 <tr valign="top">			
			<td>
					<?php 
						echo "<i><b>".$user." (</b></i>".$time."):&nbsp;";
					?>
			</td>
			<td>
					<?php
						echo "&nbsp".$comment;
					?>	
            </td>
            <td>
					<?php
						//echo "<i>   on  ".$time."</i>";
					?>	
            </td>
           
		</tr>
        	<?php
			}
		?>
	</table>
<?php	
}
 

else
{
	?>
  <meta http-equiv="refresh" content="10;url=browse.php"> 
<?php
 
 }

?>


<form method="post" action="" > 
<textarea rows="5" cols="50" name="comment" placeholder="Write your comments here..">
</textarea> <br>
<input value="submit" name="submit" type="submit" /> 
</form>

<?php
if(isset($_POST['submit'])) {
	  //$path = $_GET['path'];
	  $mediaid = $_GET['id'];
	  $comment = $_POST['comment'];
			$result = mysql_query("INSERT into comment values (NULL,'$comment','$username','$mediaid',NOW())");
			//$row = mysql_fetch_row($result);
			
		}
		
	
if(isset($_POST['fav'])) {
	$mediaaid = $_GET['id'];
	$result = mysql_query("INSERT into favorites values (NULL,'$filename','$mediaaid','$title','$username','$filepath')");
}
?>		

</body>
</html>
