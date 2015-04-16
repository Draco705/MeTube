<html>
<body>

<?php
session_start();

include_once "function.php";

$username = $_SESSION['username'];

if(isset($_POST['submit'])) {
	    $play_name = $_POST['name'];
		$query = "INSERT INTO playlist VALUES(NULL,'$play_name','$username')";		
		$result = mysql_query($query);
		echo $play_name." successfully created!";
	}

	
?>
<form action="playlist.php" method="post">
    <h1> MeTube Playlist </h1>
    Playlist name*: <input type="text" name="name" required>  
	<input name="submit" type="submit" value="Create">
</form>

<form action="browse.php" method="post"> 
	<input name="home" type="submit" value="Home">
</form>

<?php
	$query = "SELECT * FROM playlist WHERE username = '$username'"; 
	$result = mysql_query( $query );
	if (!$result){
	die ("Could not query the media table in the database: <br />". mysql_error()); }
?>   


<table width="50%" cellpadding="0" cellspacing="0">
	
	<?php
			while ($result_row = mysql_fetch_row($result)) //filename, username, type, mediaid, path
			{ 
				$play_id = $result_row[0];
				$name1 = $result_row[1];
			
			//	$filenpath = $result_row[4];
		?>
        	 <tr valign="top">	
   <!--			 
			<td>
					<?php
						echo $play_id;  //playlist id
					?>
			</td>
  -->                      <td>
  <br>
						<?php
						
            	           echo "<b>".$name1."</b>";
						   ?>
                        </td>
     <!--                   <td>
            	            <?php
							echo $username;
							?>
         -->               </td>
		</tr>
        	<?php
			}
		?>
	</table>




<?php
  if(isset($register_error))
   {  echo "<div id='passwd_result'> register_error:".$register_error."</div>";
}

?>
	
</body>
</html>