<?php 

	require ('connect.php');
	 session_start();
    

    if(!isset($_SESSION['user'])){

        header('location: login.php');
    }

	$query = "SELECT * FROM category WHERE categoryid = {$_GET['categoryid']}";

 	$statement = $db->prepare($query);

 	$statement->execute();

 	$animal = $statement->fetchAll();

 	$id = $_GET['categoryid'];

 	if (isset($_POST['submit'])) {
 		
 		$categoryname = $_POST['categoryname'];
 		// $image= $_FILES['image']['name'];
   //      $image_type =$_FILES['image']['type'];
   //      $image_size = $_FILES['image']['size'];
   //      $image_tem_location = $_FILES['image']['tmp_name'];
   //      $image_stored_location = "images/";

   //      // unlink($image_stored_location.);
            
   //      move_uploaded_file($image_tem_location,$image_stored_location.$image);

    	// Build the parameterized SQL query and bind the sanitized values to the parameters
 		$query = "UPDATE category SET categoryname = :categoryname WHERE categoryid = :id";  
	    $statement = $db->prepare($query);

	    //Bind values to the parameters.
	    $statement->bindValue(':categoryname', $categoryname);  
	    // $statement->bindValue(':image', $image_stored_location.$image);
	    $statement->bindValue(':categoryid', $id, PDO::PARAM_INT);

	  	
	  	//This statement is now executed.
	    $statement->execute();
	    header('Location:homepage.php?categoryid='.$id);
 	}

 	if (isset($_POST['delete'])) {

 		header('Location:delete.php?categoryid='.$id);
 	}
 	
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
	<title>Edit php</title>
	<link rel="stylesheet" type="text/css" href="edit.css">
</head>
<body>
	<form method="post">

		<input type="text" name="categoryname" id="categoryname" value="<?= $animal[0]['categoryname']?>"><br>

		<!-- <input type="file" name="image" id="image" value="<?= $animal[0]['image'] ?>"> -->

		<button type="submit" name="submit" value="submit">Update</button>

		<button type="submit" name="delete" value="Delete" onclick="return confirm('Are you sure?')">Delete</button> 

	</form>

</body>
</html>