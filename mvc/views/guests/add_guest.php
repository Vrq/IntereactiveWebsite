<?php
	
	$pageTitle = "Add guest";
	if(!empty($_POST['username'])):
        require_once ('models/guest.php');
		require_once ('connection.php');
		$guest = new Guest();
       // echo $guest->addGuest();
       
    else:
?>
 
       
        <form method="post" action="?controller=guests&action=add_guest" id="addguestform">
            <div>
                <label for="name">Name:</label>
                <input type="text" name="name" id="name" /><br />
				<label for="number">Random number (not 7):</label>
				<input type="text" name="number" id="number" /><br />
				<label for="comment">And something cool:</label>
                <input type="text" name="comment" id="comment" /><br />
                <input type="submit" name="addguest" id="addguest" value="Add!" />
            </div>
        </form>
 
<?php
    endif;
?>