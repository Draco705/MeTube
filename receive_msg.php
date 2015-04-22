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

$name = $_SESSION['username'];

?>

<form action="browse.php" method="post">
	<input type="image" src="home.png" width="30px" height="30px" VALUE = "Home" >
	</form></p>

<h1> Message Inbox </h1>	
<br>



<br>
<form action="message.php" method="post">
	<input type="submit" class="button" VALUE = "New Message">
</form>
<br>
<?php

	$query = "SELECT * from messages WHERE sendto='$name' order by messageid desc"; 
	$result = mysql_query( $query );
	if (!$result){
	   die ("Could not query the media table in the database: <br />". mysql_error());
	}
?>	

<table width="100%" cellpadding="5" cellspacing="0" border="3">
    
	<tr>
		<td align="center"><h4> id </h4></td>
		<td align="center"><h4> Subject </h4></td>
		<td align="center"><h4> Message </h4></td>
		<td align="center"><h4> Sent From </h4></td>
		<td align="center"><h4> Received on </h4></td>
	</tr>
		<?php
			while ($result_row = mysql_fetch_row($result)) //filename, username, type, mediaid, path
			{ 
				$sendto = $result_row[0];
				$content = $result_row[1];
				$sentfrom = $result_row[2];
				$messageid = $result_row[3];
				$subject = $result_row[4];
				$timee = $result_row[5];
		?>
        	 <tr valign="top">			
			<td>
					<?php 
						echo $messageid;  //messageid
					?>
			</td>
			<td>
					<?php
						echo $subject;
					?>	
            </td>
            <td>
					<?php
						echo $content;
					?>	
            </td>
            <td>
            	    <?php 
						echo $sentfrom;
					?>
            </td>
			<td>
            	    <?php 
						echo $timee;
					?>
            </td>
		</tr>
        	<?php
			}
		?>
	</table>

<?php
  if(isset($register_error))
   {  echo "<div id='passwd_result'> register_error:".$register_error."</div>";}
?>

</body>
</html>

