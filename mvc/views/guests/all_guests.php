<p>Guests on the site since the launch:</p>

<table class="standardTab">
<?php foreach($guests as $guest) { ?>
   
    <tr>
		<td><?php echo $guest->firstname; ?></td>
		<td><a href='?controller=guests&action=show&id=<?php echo $guest->id; ?>'>Details</a></td>
	</tr>
<?php } ?>

</table>

<?php if(!empty($_SESSION['loggedin']) && !empty($_SESSION['username'])) {
	echo "<p><a href='?controller=guests&action=add_guest'><p id='addguest'>Add Yourself!</p></a></p>";
}
?>