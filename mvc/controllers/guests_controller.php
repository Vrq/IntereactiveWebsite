<?php
  class GuestsController {
    public function all_guests() {
      // we store all the posts in a variable
      $guests = Guest::all();
      require_once('views/guests/all_guests.php');
    }
    
    public function stats() {
       $stats = Guest::getStats();
       require_once('views/guests/stats.php');
    }
    
    public function home() {
       $stats = Guest::getStats();
       require_once('views/guests/home.php');
    }

    public function show() {
      // we expect a url of form ?controller=posts&action=show&id=x
      // without an id we just redirect to the error page as we need the post id to find it in the database
      if (!isset($_GET['id']))
        return call('pages', 'error');

      // we use the given id to get the right post
      $guest = Guest::find($_GET['id']);
      require_once('views/guests/show.php');
    }
	
	public function register() {
	  //$guest = new Guest();
	  require_once('views/guests/register.php');
	}
	
	public function verify() {
		require_once('views/guests/verifyaccount.php');
	}
	
	public function login() {
		require_once('views/guests/login.php');
	}
	
	public function logout() {
		require_once('views/guests/logout.php');
	}
	
	public function bunny() {
		require_once('views/guests/bunny.php');
	}
	
	public function add_guest() {
		require_once('views/guests/add_guest.php');
	}
}
?>