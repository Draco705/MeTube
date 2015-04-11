<html>
<body>

<?php
session_start();

include_once "function.php";

$name = $_SESSION['username'];

?>

<h1> Message Inbox </h1>	

<?php

	$query = "SELECT * from messages WHERE sendto='$name' order by messageid desc"; 
	$result = mysql_query( $query );
	if (!$result){
	   die ("Could not query the media table in the database: <br />". mysql_error());
	}
?>	

<table width="50%" cellpadding="0" cellspacing="0" border="3">
    
	<tr>
		<td align="center"><h4> id </h4></td>
		<td align="center"><h4> Subject </h4></td>
		<td align="center"><h4> Message </h4></td>
		<td align="center"><h4> From user </h4></td>
		<td align="center"><h4> Time </h4></td>
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

