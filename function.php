<?php
include "mysqlClass.inc.php";


function user_exist_check ($email, $username, $password, $first, $last, $sex, $birth){
	$query = "select * from account where username='$username'";
	$result = mysql_query( $query );
	if (!$result){
		die ("user_exist_check() failed. Could not query the database: <br />". mysql_error());
	}	
	else {
		$row = mysql_fetch_assoc($result);
		if($row == 0){
			$query = "insert into account values ('$email','$username','$password')";
			echo "insert query:" . $query;
			$insert = mysql_query( $query );
			if($insert) {
				$query = "insert into account2 values ('$username','$first','$last','$sex','$birth','$password')";
			echo "insert query:".$query;
			$insert = mysql_query( $query );
			if($insert)
			return 1; }
			else
				die ("Could not insert into the database: <br />". mysql_error());		
		} 
		 
		else{
			return 2;
		}
	}
}



function user_pass_check($username, $password)
{
	
	$query = "select * from account where username='$username'";
	//echo  $query;
	$result = mysql_query( $query );
		if (!$result)
	{
	   die ("user_pass_check() failed. Could not query the database: <br />". mysql_error());
	}
		$row = mysql_fetch_row($result);
		if($row == 0){
		return 1; }
	else{
		
		if(strcmp($row[2],$password))
			return 2; //wrong password
		else 
			return 0; //Checked.
	}	
}

function updateMediaTime($mediaid)
{
	$query = "	update  media set lastaccesstime=NOW()
   						WHERE '$mediaid' = mediaid
					";
					 // Run the query created above on the database through the connection
    $result = mysql_query( $query );
	if (!$result)
	{
	   die ("updateMediaTime() failed. Could not query the database: <br />". mysql_error());
	}
}




function upload_error($result)
{
	//view erorr description in http://us2.php.net/manual/en/features.file-upload.errors.php
	switch ($result){
	case 1:
		return "UPLOAD_ERR_INI_SIZE";
	case 2:
		return "Error: File is too large";
	case 3:
		return "UPLOAD_ERR_PARTIAL";
	case 4:
		return "Error: No file present";
	case 5:
		return "Error: File has already been uploaded";
	case 6:
		return  "Error: Failed to move file from temporary directory";
	case 7:
		return  "Error: Upload file failed";
	}
} 

function update_info($email, $password1, $first, $last, $sex, $password3, $username, $birth){
	
			$query = "UPDATE account SET password='$password1', email='$email' WHERE username='$username' and password = '$password3'";
			echo "update query:" . $query;
			$update = mysql_query( $query );
	
			$query = "UPDATE account2 SET firstname='$first', lastname='$last', gender='$sex', birth='$birth' WHERE username='$username' and password = '$password3'";
			echo "update query:".$query;
			$update = mysql_query( $query );
			if($update)
			return 1; 
					
		}
		
		
function playlist_exist_check ($username, $playlist){
	$query = "select * from playlist where username='$username' and name='$playlist'";
	$result = mysql_query( $query );
	if (!$result){
		die ("playlist_exist_check() failed. Could not query the database: <br />". mysql_error());
	}	
	else {
		$row = mysql_fetch_assoc($result);
		if($row == 0){
			$query = "insert into playlist values (NULL,'$playlist','$username')";
			//echo "insert query:" . $query;
			$insert = mysql_query( $query );
			if($insert)
			return 1; 
			else
				die ("Could not insert into the database: <br />". mysql_error());		
		} 
		 
		else{
			return 2;
		}
	}
}		


	
?>
