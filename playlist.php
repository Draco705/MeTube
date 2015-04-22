<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/default.css">
</head>
<body>


<?php


session_start();

include_once "function.php";

if(!isset($_SESSION['username'])) {
	echo "User not available";
header('Refresh :0;index.php');
?>
<form action="index.php" method="post">
	<input type="image" src="home.png" width="30px" height="30px" VALUE = "Home" >
	</form></p>
	<?php
exit;
}

$username = $_SESSION['username'];

?>

<form action="browse.php" method="post">
	<input type="image" src="home.png" width="30px" height="30px" VALUE = "Home" >
	</form></p>

<h1> <?php echo $username; ?> MeTube Playlist  </h1>
<br>


<form action="playlist.php" method="post">
    <input name="playname" type="text" placeholder="Enter new playlist name" required>
	<input name="playsubmit" type="submit" class="button"  VALUE = "Create" >
</form></p> 



<?php
  if(isset($register_error))
   {  echo "<div id='passwd_result'> register_error:".$register_error."</div>";
}

if(isset($_POST['playsubmit'])) {
	
	$check = playlist_exist_check($username, $_POST['playname']);		
		if($check == 1){
			//echo "Rigister succeeds";
			//header('Location: playlist.php');
			echo "Playlist successfully created!";
		}
		else if($check == 2){
			echo "Playlist already exists! Please chose a different name";
			$register_error = "Playlist already exists. Please user a different Playlist name.";
		}

}
?>

<?php
$query = mysql_query("SELECT * FROM playlist WHERE username='$username'"); // Run your query
?>
<form action="" method="post" >
<?php
echo "Playlist: ".'<select name="playdropdown">';

while ($row = mysql_fetch_array($query)) {
   echo "<option  value='" . $row[1] . "'  >" . $row[1] . "</option>"; 
}
echo '</select>';
?>
&nbsp;&nbsp;
<input name="viewsubmit" type="submit" class="button"  VALUE = "View Playlist" >
</form>

<?php
	if(isset($_POST['viewsubmit'])) {
	  //$mediaid = $_GET['id'];
	  $playname = $_POST['playdropdown'];
			$result = mysql_query("SELECT * FROM playlist WHERE username='$username' and name='$playname'");
		
	if (!$result){
	   die ("Could not query the media table in the database: <br />". mysql_error());
	}
?>	

  <table width="50%" cellpadding="0" cellspacing="0">
	
		<?php
			while ($result_row = mysql_fetch_row($result)) //filename, username, type, mediaid, path
			{ 
				$playlist_id = $result_row[0];
				$playname = $result_row[1];
		?>
        	 <tr valign="top">			
			<td>
					<?php 
						//echo "Playlist: ".$playname;
						
					?>
			</td>
			<?php
			$query1 = "SELECT * FROM playlist_media WHERE username='$username' and playlist_name='$playname'"; 
			$result1 = mysql_query( $query1 );
	
	$i=0;
                     while ($result_row = mysql_fetch_row($result1)) //filename, username, type, mediaid, path 
					 {    $i++;
						 $play_media_id = $result_row[0];
						 $play_media_title = $result_row[4];
						 $play_media_path = $result_row[6];
						 $media_id = $result_row[7];
						 ?>
						 <tr valign="top">
						 
						 <td>
						 <?php
						 echo $i;
						 ?>
						 </td>
							<td>
								
									
									 <a href="media.php?id=<?php echo $media_id;?>" ><?php echo $play_media_title;?></a>
								
							</td>
							</tr>
							<?php
					 }
					 ?>
		</tr>
        	<?php
			}

		?>
	</table>
	<?php
	}
	?>
	
	
</body>
</html>
