<?php

// //Initialize the session.
session_start();

require('connect.php');
error_reporting(E_ALL ^ E_NOTICE);

$error = [];

if(isset($_POST['username']) AND isset($_POST['password'])){

	$username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING);
	$password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);
	//$spassword = password_hash($password, PASSWORD_BCRYPT);

	$query = "SELECT password FROM users WHERE username = '$username' ";
	

	// if($count == 1){
	// 	echo "You are now logged in";
	// }
	$prepare = $db->prepare($query);

 	if($prepare->execute())
        {
        	$pass = $prepare->fetch();
        	$secret = $pass["password"];
        	
            if($prepare->rowCount()==1 && password_verify($password, $secret))
           	{
           		$_SESSION['user'] = $username;
                 $var = "You are now logged in";
                 header('location: homepage.php');           	
             }
           	
           	else{
				$var = "Invalid Username/password combination.";
		    }

        }
    }
    


?>

<!DOCTYPE html>
<html>
<head>
	<title>User Login</title>
	<link rel="stylesheet" type="text/css" href="loginforms.css">
</head>
<body id="yuhu">

	<div class="login">
		<form id="event" method="post" action="login.php">
			<h1>Login</h1>
			<fieldset>
				<ol>
					<li>
						<label for="username"></label>
						<input type="text" name="username" id="username" placeholder="Username" autocomplete="off">
					</li>
					<li>
						<label for="password"></label>
						<input type="password" name="password" id="password" placeholder="Password" autocomplete="off"> 
					</li>
					<li>
						<button type="submit" class="btn" name="login_user">Login</button>
					</li>
					<li>
						<?php echo $var ?>
					</li>
					<li>
						<p>Not yet a member?</p> <a href="register.php"> Sign up </a>
					</li>
				</ol>
			</fieldset>
  	</form>

	</div>

</body>
</html>