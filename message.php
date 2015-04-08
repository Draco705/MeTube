<html>
<body>

<?php
session_start();
include_once "function.php";


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

<form action="message.php" method="post">
<h1> SEND MESSAGE </h1>

  Send to(username): <input type="text" name="sendto" required> <br>
  Subject: <input type="text" name="sub"> <br><br>
  <textarea rows="5" cols="50" name="content">
Enter your message here..</textarea> <br>
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

