<?php 

	session_start();
	require ('connect.php');
    
    if(!isset($_SESSION['admin']))
    {
        header('location: admin.php');
    }

	$query = "SELECT * FROM users WHERE id = {$_GET['id']}";
 	$statement = $db->prepare($query);
 	$statement->execute();
 	$user = $statement->fetchAll();
 	$id = $_GET['id'];

 	if (isset($_POST['submit']))
 	{
 		$user = $_POST['username'];
 		$email = $_POST['email'];
 		
 		$query = "UPDATE users SET username = :username, email = :email WHERE id = :id";  
	    $statement = $db->prepare($query);

	    $statement->bindValue(':username', $user);        
	    $statement->bindValue(':email', $email);
	    $statement->bindValue(':id', $id, PDO::PARAM_INT);

	    $statement->execute();
	    header('Location:adminauthority.php?id='.$id);
 	}
 	
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
	<title>Edit php</title>
	<!-- <link rel="stylesheet" type="text/css" href="edit.css"> -->
</head>
<body>
	<form method="post">
		<input type="text" name="username" id="username" value="<?= $user[0]['username']?>"><br>
		<input type="text" name="email" id="email" value="<?= $user[0]['email']?>"><br>
		<button type="submit" name="submit" value="submit">Update</button>
	</form>
</body>
</html>