<html>
<body>

<?php
session_start();

include_once "function.php";

if(isset($_POST['submit'])) {
	if( $_POST['password1'] != $_POST['password2']) {
		$register_error = "Passwords don't match. Try again?";
	}
	else {
		$check = user_exist_check($_POST['email'], $_POST['username'], $_POST['password1'], $_POST['first'], $_POST['last'], $_POST['sex'], $_POST['birth']);		
		if($check == 1){
			//echo "Rigister succeeds";
			$_SESSION['username']=$_POST['username'];
			header('Location: browse.php');
		}
		else if($check == 2){
			$register_error = "Username already exists. Please user a different username.";
		}
	}
}

?>
<form action="register.php" method="post">
    <h1> MeTube User Registration </h1>
	<h4> Account Information </h4>
    Email: <input type="text" name="email"> <br><br> 
	Username*: <input type="text" name="username" required> <br><br>
	Create Password*: <input  type="password" name="password1" required> <br><br>
	Confirm password*: <input type="password" name="password2" required> <br><br>
	<br>
	<h4> Personal information <h4>
	First Name: <input type="text" name="first"> <br><br> 
	Last Name: <input type="text" name="last"> <br><br>
	Gender: <input type="radio" name="sex" value="male">Male &nbsp;&nbsp;&nbsp;
            <input type="radio" name="sex" value="female">Female <br><br>
	Birth date: <input type="date" name="birth"> <br><br>
	<input name="submit" type="submit" value="Submit">
</form>

<?php
  if(isset($register_error))
   {  echo "<div id='passwd_result'> register_error:".$register_error."</div>";}
?>

</body>
</html>
