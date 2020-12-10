<?php

require ('connect.php');

$username = "";
$email    = "";
$errors = []; 

if (isset($_POST['reg_user'])) 
{
	$username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING);
	$email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_STRING);
	$password_1 = filter_input(INPUT_POST, "password_1", FILTER_SANITIZE_STRING);
	$password_2 = filter_input(INPUT_POST, "password_2", FILTER_SANITIZE_STRING);

	if (empty($username)) { $errors[] =  "Username is required"; }
	if (empty($email)) { $errors[] = "Email is required"; }
	if (empty($password_1)) { $errors[] =  "Password is required"; }
	if ($password_1 != $password_2) 
  {
	  $errors[] = "The two passwords do not match";

    if(strlen(trim($_POST['password_1'])) < 6)
    {
      $errors = "Paswords must have atleast 6 characters.";
    }

  }

  $querycheck = "SELECT * FROM users WHERE username='$username' OR email='$email'";
  $prepare = $db->prepare($querycheck);

  if($prepare->execute())
  {
    if($prepare->rowCount()==1)
    {
      $errors[] = "This Username is already taken.";
    }
    else
    {
    	echo "Successfully registered";
    }
  }

  if (count($errors) == 0) 
  {
  	$password = password_hash($password_1, PASSWORD_DEFAULT);
  	$query = "INSERT INTO users (username, email, password) VALUES('$username', '$email', '$password')";
  	$statement = $db->prepare($query);

  	$statement->bindValue(':username', $username);        
    $statement->bindValue(':email', $email);
    $statement->bindValue(':password', $password);
    $statement->execute();

  	$insert_id = $db->lastInsertId();

  }
}

?>


<!DOCTYPE html>
<html>
<head>
	<title>Register User</title>
	<link rel="stylesheet" type="text/css" href="loginforms.css">
</head>
<body id="yippie">
	<div class="login">
		<form id="event" method="post" action="register.php">
  			<h1>Register</h1>
  			<fieldset>
  				<ol>
  					<li>
  						<label for="username"></label>
	  	  				<input type="text" name="username" id="username" placeholder="Username" autocomplete="off">
  					</li>
  					<li>
  						<label for="email"></label>
	  	  				<input type="email" name="email" id="email" placeholder="Email" autocomplete="off">
  					</li>
  					<li>
  						<label for="password_1"></label>
	  	  				<input type="password" name="password_1" id="password_1" placeholder="Password">
  					</li>
  					<li>
  						<label for="password_2"></label>
	  	  				<input type="password" name="password_2" id="password_2" placeholder="Confirm Password">
  					</li>
  					<li>
  						<button type="submit" class="btn" name="reg_user">Register</button>
  					</li>
  					<?php if(!empty($errors)):?>
			        <h3>Please fill the required information.</h3>
			        <ul>
			            <?php foreach ($errors as $error): ?>
			            <li><?= $error ?></li>
			            <?php endforeach ?>
			        </ul>
			        <?php endif ?>
  					<li>
  						<p>Already a member?</p> <a href="login.php">Sign in</a>
  					</li>
  				</ol>
  			</fieldset>
 	 	</form>
 	 </div>
</body>
</html>