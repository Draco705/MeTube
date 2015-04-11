<html>
<body>


<p> For updating information, you need to enter your user name and password </p>

<?php
session_start();

include_once "function.php";


if (isset($_SESSION['username']))
	echo "Username available";
else
	header('Refresh :0;index.php');

if(isset($_POST['submit'])) {
	if( $_POST['password1'] != $_POST['password2']) {
		$register_error = "Passwords don't match. Try again?";
	}
	else {
		
		if($_POST['last'] == ""){
			$result = mysql_query("SELECT * FROM account2 WHERE username = '".$_POST['username']."'");
			$row = mysql_fetch_row($result);
			$last = $row[2];
		}
		else
			$last = $_POST['last'];
		
		if($_POST['first'] == ""){
			$result = mysql_query("SELECT * FROM account2 WHERE username = '".$_POST['username']."'");
			$row = mysql_fetch_row($result);
			$first = $row[1];
		}
		else
			$first = $_POST['first'];
		
		if(!(isset($_POST['birth']))){
			$result = mysql_query("SELECT * FROM account2 WHERE username = '".$_POST['username']."'");
			$row = mysql_fetch_row($result);
			$birth = $row[4];
		}
		else
			$birth = $_POST['birth'];
		
		if($_POST['password1'] == ""){
			$result = mysql_query("SELECT * FROM account WHERE username = '".$_POST['username']."'");
			$row = mysql_fetch_row($result);
			$password1 = $row[2];
		}
		else
			$password1 = $_POST['password1'];
		
		if($_POST['email'] == ""){
			$result = mysql_query("SELECT * FROM account WHERE username = '".$_POST['username']."'");
			$row = mysql_fetch_row($result);
			$email = $row[0];
		}
		else
			$email = $_POST['email'];
		
		if(!(isset($_POST['sex']))){
			$result = mysql_query("SELECT * FROM account2 WHERE username = '".$_POST['username']."'");
			$row = mysql_fetch_row($result);
			$sex = $row[3];
		}
		else
			$sex = $_POST['sex'];
		
		
		
		
		$check = update_info($email, $password1, $first, $last, $sex, $_POST['password3'], $_POST['username'], $birth);	
		if($check == 1){
			//echo "Rigister succeeds";
			$_SESSION['username']=$_POST['username'];
			header('Location: browse.php');
		}
		
	}
}

?>


<form action="update.php" method="post">
    Username*:  <input type="text" name="username" required> <br>
    Current password* : <input type="password" name="password3" required> <br>
	
	<p> KEY INFORMATION </p>
    Email: <input type="text" name="email"> <br><br> 
	New Password: <input type="password" name="password1"> <br>
	Confirm Password: <input type="password" name="password2"> <br><br>

<br><br>
<p> ADDITIONAL INFORMATION (Optional) </p>
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
