<html>
<body>
	<h1 align="center"> You have been logged out and will be redirected </h1>
<?php
   session_start();

   session_unset();

   session_destroy();

   echo "Session is closed.";

   header('Refresh: 5;index.php');
?>
</body>
</html>
