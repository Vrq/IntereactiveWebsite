<?php
  //  require_once ('../../models/guest.php');
//	require_once ('../../connection.php');
 
    if(isset($_GET['v']) && isset($_GET['e'])){
		$guest = new Guest();
		$ret = $guest->verifyAccount();
	}
	if(isset($ret[0])) {
        echo isset($ret[1]) ? $ret[1] : NULL;
	}
	else {
		echo '<meta http-equiv="refresh" content="0;/">';
		echo "<p>Verification successfull</p>";
	}
?>