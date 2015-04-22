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

if(isset($_POST['submit'])) {
	
		$check = send_message($_POST['sendto'], $_POST['sub'], $_POST['content'], $_SESSION['username']);	
		if($check == 1){
			echo "Message successfully sent";
		
			header('Location: browse.php');
		
			
		}
		else {
			echo "UNKNOWN";
		}
	}


?>

<form action="browse.php" method="post">
	<input type="image" src="home.png" width="30px" height="30px" VALUE = "Home" >
	</form></p>

<form action="message.php" method="post">
<h1> SEND MESSAGE </h1>

  Send to(username): <input type="text" name="sendto" required> <br>
  Subject: <input type="text" name="sub"> <br><br>
  <textarea rows="5" cols="50" name="content" placeholder="Enter your message here..">
</textarea> <br>
 <input name="submit" type="submit" value="Submit">
</form>
<br>

<?php

function send_message($username, $subject, $message, $sentfrom) {
$query = "insert into messages values ('$username', '$message', '$sentfrom','', '$subject', NOW())";
			//echo "insert query:" . $query;
			$insert = mysql_query( $query );
			if($insert) {
			return 1; }
			else {
				die ("Could not insert into the database: <br />". mysql_error());	
			}
		
}		

?>

<?php
  if(isset($register_error))
   {  echo "<div id='passwd_result'> register_error:".$register_error."</div>";}
?>

</body>
</html>

