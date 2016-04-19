
<?php 

if(!empty($_SESSION['loggedin']) && !empty($_SESSION['username'])):
?>
<table class="standardTab">
	<tr>
		<td><p>Your OS:</p></td>
		<td><p><?php echo $stats; ?></p></td>
	</tr>
	
	<tr>
    <td><p>Cookie info:</p></td>
	<td><p><?php echo $_COOKIE["user1"]; ?></p></td>
	</tr>
	
	<tr>
    <td><p>Your IP address:</p></td>
	<td><p><?php echo $_SERVER['REMOTE_ADDR']; ?></p></td>
	</tr>
	
	<tr>
    <td><p>Your browser:</p></td>
	<td><p><?php echo $_SERVER['HTTP_USER_AGENT']; ?></p></td>
	</tr>
	
</table>

<?php else:
?>
<p>Please login to access your stats</p>

<?php endif
?>