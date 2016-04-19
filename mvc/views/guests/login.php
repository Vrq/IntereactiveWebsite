<?php 
	
	
	
	if(!empty($_SESSION['loggedin']) && !empty($_SESSION['username'])):
?>
	<p>You are logged in.</p>

	
<?php 
	elseif(!empty($_POST['username']) && !empty($_POST['password'])):
		require_once('models/guest.php');
		require_once ('connection.php');
		$guest = new Guest();
		if($guest->accountLogin() === TRUE):
			echo "<meta http-equiv='refresh' content='0;'>";
			exit;
		else:
?>
		    <h2>Login Failed&mdash;Try Again?</h2>
        <form method="post" action="views/guests/login.php" name="loginform" id="loginform">
            <div>
                <input type="text" name="username" id="username" />
                <label for="username">Email</label>
                <br /><br />
                <input type="password" name="password" id="password" />
                <label for="password">Password</label>
                <br /><br />
                <input type="submit" name="login" id="login" value="Login" class="button" />
            </div>
        </form>
        
<?php
		endif;
		
	else:
	
?>
	<h2>Login here:</h2>
        <form method="post" action="?controller=guests&action=login" name="loginform" id="loginform">
            <div>
                <input type="text" name="username" id="username" />
                <label for="username">Email</label>
                <br /><br />
                <input type="password" name="password" id="password" />
                <label for="password">Password</label>
                <br /><br />
                <input type="submit" name="login" id="login" value="Login" class="button" />
            </div>
        </form><br /><br />
	
<?php
    endif;
?>
 
        <div style="clear: both;"></div>