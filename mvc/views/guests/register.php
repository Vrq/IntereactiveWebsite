<?php
	
	$pageTitle = "Register";
	if(!empty($_POST['username'])):
        require_once ('models/guest.php');
		require_once ('connection.php');
		$guest = new Guest();
        echo $guest->createAccount();
       // echo $guest->createAccount();
    else:
?>
 
       
        <form method="post" action="?controller=guests&action=register" id="registerform">
            <div>
                <label for="username">Email:</label>
                <input type="text" name="username" id="username" /><br />
				<label for="password">Password:</label>
				<input type="password" name="password" id="password" /><br />
				<label for="repassword">repeat Password:</label>
                <input type="password" name="repassword" id="repassword" /><br />
                <input type="submit" name="register" id="register" value="Let's start!" />
            </div>
        </form>
 
<?php
    endif;
?>