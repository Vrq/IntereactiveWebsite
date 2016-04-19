<?php
  class Guest {

    public $id;
    public $firstname;
    public $lastname;
	public $email;
	public $comment;
	

    public function __construct($id, $firstname, $lastname, $email, $comment) {
      $this->id      = $id;
      $this->firstname  = $firstname;
      $this->lastname = $lastname;
	  $this->email = $email;
	  $this->comment = $comment;
    }

    public static function all() {
      //$list = [];
      $db = Database::getInstance();
      $req = $db->query('SELECT * FROM guestbook');

      // we create a list of Post objects from the database results
      foreach($req->fetchAll() as $guest) {
        $list[] = new Guest($guest['id'], $guest['firstname'], $guest['lastname'], $guest['email'], $guest['comment']);
      }

      return $list;
    }

    public static function find($id) {
      $db = Database::getInstance();
      // we make sure $id is an integer
      $id = intval($id);
      $req = $db->prepare('SELECT * FROM guestbook WHERE id = :id');
      // the query was prepared, now we replace :id with our actual $id value
      $req->execute(array('id' => $id));
      $guest = $req->fetch();

      return new Guest($guest['id'], $guest['firstname'], $guest['lastname'], $guest['email'], $guest['comment']);
    }
	
	// Create a new user account in the database
	public function createAccount() {
		$u = trim($_POST['username']); //username without whitespaces
		$v = sha1(time());
		$pass = trim($_POST['password']); // password without spaces
		
		$name = trim(substr($u, 0, strpos($u, '@')));
		
		$cookie_name = "user1";
        $cookie_value = $name;
        setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
		
		$db = Database::getInstance(); //get new db connection
		
		//the following code returns 'true' if the email address is already in the db:
		$sql = "SELECT COUNT(username) AS theCount FROM users WHERE username=:email";
		if($stmt = $db->prepare($sql)) {	
			$stmt->bindParam(":email", $u, PDO::PARAM_STR); //replace the email in the sql query with the submited email
			$stmt->execute();
            $row = $stmt->fetch();
            if($row['theCount']!=0) {
                return "<h2> Nice Try! </h2>"
                    . "<p> Sorry, that email is already in use. "
                    . "Please try again. </p>";
			}
			$this->sendVerificationEmail($u, $v);
			$stmt->closeCursor();
		}	
		
		
		$sql = "INSERT INTO users(username, password, ver_code) VALUES(:email, MD5(:pass), :ver)";
		if($stmt = $db->prepare($sql)) {
			$stmt->bindParam(":email", $u, PDO::PARAM_STR);
			$stmt->bindParam(":pass", $pass, PDO::PARAM_STR); 
			$stmt->bindParam(":ver", $v, PDO::PARAM_STR);
			$stmt->execute();
			$stmt->closeCursor();
			
			return "<h2> Success! </h2> </br> <h3>You have just received a message with the verification link. Click on it and start enjoying Really Smooth</h3>";
		}
	}

	//Email with an unique link inside to confirm the email address:
	private function sendVerificationEmail($email, $ver)
    {
        $e = sha1($email); // For verification purposes
        $to = trim($email);
 
        $subject = "[Smooth Site] Please Verify Your Account";
 
        $headers = 'From: Smooth Site <noreply@smoothsite.com>' . "\r\n";
		

					 
		$msg = "
You have created a new account at Smooth Site!
					 
To get started, please activate your account and choose a
password by following the link below.
					 
Your Username: $email
					 
Activate your account:http://student.agh.edu.pl/~jtveiro/mvc?controller=guests&action=verify&v=$ver&e=$e
					 
If you have any questions, please contact janusz@smoothsite.com.
					 
--
Thanks!
				 
Janusz
www.SmoothSite.com
";
 
        return mail($to, $subject, $msg, $headers);
    }

	
	//Account verification/activation:
	public function verifyAccount()	{
	
		$sql = "SELECT username FROM users WHERE ver_code =:ver AND SHA1(username)=:user AND verified=0";
		
		$db = Database::getInstance(); //get new db connection
		session_start();
		
		if($stmt = $db->prepare($sql)) {
			$stmt->bindParam(':ver', $_GET['v'], PDO::PARAM_STR);
			$stmt->bindParam(':user', $_GET['e'], PDO::PARAM_STR);
			$stmt->execute();
			$row = $stmt->fetch();
			
			if(isset($row[username])) {
				
				$sql = "UPDATE users SET verified=1 WHERE ver_code=:ver LIMIT 1";
				if($stmt = $db->prepare($sql)) {
					$stmt->bindParam(':ver', $_GET['v'], PDO::PARAM_STR);
					$stmt->execute();
				
					//activated and logged in:
					$_SESSION['username'] = $row['username'];
					$_SESSION['loggedin'] = 1;
				}	
			}
			else {
				return array(1, "<h2>Verification Error</h2>"
                    . "<p>This account has already been verified.</p>");
			}
		
			$stmt->closeCursor();
			
			return array(0, NULL);
        }
        else
        {
            return array(2, "<h2>Error</h2>n<p>Database error.</p>");
        }
	}
			
	
	
	public function accountLogin() {
	
		$sql = "SELECT username FROM users WHERE username=:user AND password=MD5(:pass) LIMIT 1";
		
		$db = Database::getInstance();
		session_start();
		
		try 
		{
			$stmt = $db->prepare($sql);
			$stmt->bindParam(':user', $_POST['username'], PDO::PARAM_STR);
			$stmt->bindParam(':pass', $_POST['password'], PDO::PARAM_STR);
			$stmt->execute();
			
			if($stmt->rowCount()==1) {
				$_SESSION['username'] = htmlentities($_POST['username'], ENT_QUOTES);
				$_SESSION['loggedin'] = 1;
				
				return TRUE;
			}
			
			else {
				return FALSE;
			}
		}
		catch (PDOException $e) {
			return FALSE;
		}
	}
	
	
	
	
	
	public static function getStats() { 

		$user_agent = $_SERVER['HTTP_USER_AGENT'];

		$os_platform    =   "Unknown OS Platform";

		$os_array       =   array(
								'/windows nt 10/i'     =>  'Windows 10',
								'/windows nt 6.3/i'     =>  'Windows 8.1',
								'/windows nt 6.2/i'     =>  'Windows 8',
								'/windows nt 6.1/i'     =>  'Windows 7',
								'/windows nt 6.0/i'     =>  'Windows Vista',
								'/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
								'/windows nt 5.1/i'     =>  'Windows XP',
								'/windows xp/i'         =>  'Windows XP',
								'/windows nt 5.0/i'     =>  'Windows 2000',
								'/windows me/i'         =>  'Windows ME',
								'/win98/i'              =>  'Windows 98',
								'/win95/i'              =>  'Windows 95',
								'/win16/i'              =>  'Windows 3.11',
								'/macintosh|mac os x/i' =>  'Mac OS X',
								'/mac_powerpc/i'        =>  'Mac OS 9',
								'/linux/i'              =>  'Linux',
								'/ubuntu/i'             =>  'Ubuntu',
								'/iphone/i'             =>  'iPhone',
								'/ipod/i'               =>  'iPod',
								'/ipad/i'               =>  'iPad',
								'/android/i'            =>  'Android',
								'/blackberry/i'         =>  'BlackBerry',
								'/webos/i'              =>  'Mobile'
							);

		foreach ($os_array as $regex => $value) { 

			if (preg_match($regex, $user_agent)) {
				$os_platform    =   $value;
			}

		}   

		return $os_platform;

	}

  }
?>