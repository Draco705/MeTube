<html>
<head>
	<title>MeTube Logout</title>
	<link rel="stylesheet" type="text/css" href="css/default.css">
</head>
<body>
	<img src="metube.jpg" alt="MeTube" style="width:340px;height:128px">
	<br><br><br><br><br><br><br>
	<h1 align="center"> You have been logged out and will be redirected </h1>
<?php
   session_start();

   session_unset();

   session_destroy();

   header('Refresh: 3;index.php');
?>
</body>
</html>
