<DOCTYPE html>
<html>
  <head>
	
	<title>Really Smooth</title>

	    <?php 
		session_start();
		
		require_once('models/guest.php');
		$stats = Guest::getStats();
        if ($stats === "iPhone" || $stats === "Android" || $stats === "Blackberry" || $stats === "Mobile" || $stats === "iPad") {
            echo '<link id="usedCSS" rel="stylesheet" type="text/css" href="views/css/MobileCSS.css">';
		}
		
        else {
            echo '<link id="usedCSS" rel="stylesheet" type="text/css" href="views/css/FirstCSS.css">';
			
		}
     ?>    
	<script>
	function horizontalMenu() {
		document.getElementById('buttons').style.float='left';
	}
	function verticalMenu() {
		document.getElementById('buttons').style.float='none';
	}

	function changeStylesheet(sheetName){
		document.getElementById('usedCSS').setAttribute('href', sheetName);
	}
	</script>
    <?php
        $cookie_name = "user";
        $cookie_value = "John Doe";
        setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
    ?>
  </head>

  <body>
    <header>
    </header>

    
	<div id="mainContainer">
		 <div id="pasekMenu">
			 <ul class="buttons">
				  <a href='http://student.agh.edu.pl/~jtveiro/mvc'><li>Home</li></a>
				  
				  <li>Guestbook
					<ul id="dropdown">
						<a href='?controller=guests&action=all_guests'><li>All guests</li></a>
						
					</ul>
					
				  </li>
				  
				  <li>Movies
					<ul id="dropdown">
						 <a href='?controller=guests&action=bunny'><li>Funny Bunny</li></a>
					</ul>
				  </li>
				  
				  <li>Your stats
					<ul id="dropdown">
						 <a href='?controller=guests&action=stats'><li>Technical</li></a>
					</ul>
				  </li>
				  
				  <a href='?controller=guests&action=register'><li id="register_button">Get Access</li></a>
			</ul> 
			
			
			
			
		</div>
		
		<div id="logButtons">	
				 <?php 
					
					if($_SESSION['loggedin']) {
						echo '<p><strong>Logged in</strong></p>' . '<p><a href="?controller=guests&action=logout" style="background-color:orange">Log out</a></p>';
					}
					else {
						echo '<p style="color:orange"><strong>Logged out</strong></p>' . '<p><a href="?controller=guests&action=login">Log in</a></p>';
					}
				?>
		</div>
	
		
		<!--cool stuff: controller routing -->
		
		<div id="bodyContainer"><center><?php require_once('routes.php'); ?></center></div>
	
	<!--
		<ul id="optionsMenu">
			<li><input type="button" onclick="horizontalMenu()" value="Make horizontal"></li>
			<li><input type="button" onclick="verticalMenu()" value="Make vertical"></li>

			<li><input type="button" onclick="changeStylesheet('views/css/FirstCSS.css')" value="First layotout"></li>
			<li><input type="button" onclick="changeStylesheet('views/css/SecondCSS.css')" value="Second layout"></li>
		</ul>
	-->
		<div id="footer">
			<footer>
			  <i>Janusz Tomasik JTV&trade;</i>
			</footer>
		</div>
	</div>
	
  <body>
<html>
