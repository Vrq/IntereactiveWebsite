<?php
 
    session_start();
 
	if(empty($_SESSION['loggedin']) && empty($_SESSION['username'])) {
		echo "<p>You have successfully logged out</p>";
	}
	else {
		unset($_SESSION['loggedin']);
		unset($_SESSION['username']);
		echo "<meta http-equiv='refresh' content='0;'>";
		exit;
	}
	
?>