<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/default.css">
</head>
<body>


<form action="browse.php" method="post">
	<input type="image" src="home.png" width="30px" height="30px" VALUE = "Home" >
	</form></p>

<h1>Update Information</h1>

<p> For updating information, you need to enter your user name and password </p>

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
	if( $_POST['password1'] != $_POST['password2']) {
		$register_error = "Passwords don't match. Try again?";
	}
	else {

		if(!(isset($_POST['sex']))){
			$result = mysql_query("SELECT * FROM account2 WHERE username = '".$_POST['username']."'");
			$row = mysql_fetch_row($result);
			$sex = $row[3];
		}
		else {
		$sex = $_POST['sex']; }
		
		$email = $_POST['email'];
		$password1 = $_POST['password1'];
		$first = $_POST['first'];
		$last = $_POST['last'];
		$sex = $_POST['sex'];
		$birth = $_POST['birth'];
		
		$check = update_info($email, $password1, $first, $last, $sex, $_POST['password3'], $_POST['username'], $birth);	
		if($check == 1){
			//echo "Rigister succeeds";
			$_SESSION['username']=$_POST['username'];
			header('Location: browse.php');
		}
		
	}
}

$username = $_SESSION['username'];
$query = "SELECT * from account WHERE username = '$username'"; 
	$result = mysql_query( $query );
	$result_row = mysql_fetch_row($result);
	$auto_email = $result_row[0];
	$auto_password = $result_row[2];
	
$query1 = "SELECT * from account2 WHERE username = '$username'"; 
	$result1 = mysql_query( $query1 );
	$result_row1 = mysql_fetch_row($result1);
	$first_name = $result_row1[1];
	$last_name = $result_row1[2];
	$auto_birth = $result_row1[4];	
	?>


<form action="update.php" method="post">
    Username*: <input type="text" name="username" required> <br><br>
    Current password* : <input type="password" name="password3" required> <br><br><br>
	
	<p><h3> KEY INFORMATION </h3></p>
    Email: <input type="text" name="email" value= "<?php echo $auto_email; ?>"> <br><br> 
	New Password: <input type="password" name="password1" value= "<?php echo $auto_password; ?>"> <br><br>
	Confirm Password: <input type="password" name="password2" value= "<?php echo $auto_password; ?>"> <br><br>

<br><br>
<p> <h3>ADDITIONAL INFORMATION</h3> </p>
 First Name: <input type="text" name="first" value= "<?php echo $first_name; ?>"> <br><br> 
	Last Name: <input type="text" name="last" value= "<?php echo $last_name; ?>"> <br><br>
	Gender: <input type="radio" name="sex" value="male" >Male &nbsp;&nbsp;&nbsp;
            <input type="radio" name="sex" value="female">Female <br><br>
	Birth date: <input type="date" name="birth" value= "<?php echo $auto_birth; ?>"> <br><br>
	<input name="submit" type="submit" class="button" value="Submit">

</form>

<br>
<form action="browse.php" method="post">
	<input type="submit" class="button" VALUE="Cancel">
</form>

<?php
  if(isset($register_error))
   {  echo "<div id='passwd_result'> register_error:".$register_error."</div>";}
?>

</body>
</html>
