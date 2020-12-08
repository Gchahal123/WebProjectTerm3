

<?php
	require('connect.php');
	session_start();

	if(!isset($_SESSION['user']))
    {
        header('location: login.php');
    }

    $message = ' ';
    

    if (isset($_POST['upload'])) 
    {
        $animalname = $_POST['animalname'];
        $description = $_POST['description'];
        $username = $_SESSION['user'];
        
        if($_FILES['image'] && $_FILES['image']['error']==0)
        {
            $image= $_FILES['image']['name'];
            $image_type =$_FILES['image']['type'];
            $image_size = $_FILES['image']['size'];
            $image_tem_location = $_FILES['image']['tmp_name'];
            $image_stored_location = "images/".$image;

            $allowed_extension = array('gif','jpeg','jpg','png', 'jfif');
            $file_extension = pathinfo($image,PATHINFO_EXTENSION);

            if(!in_array($file_extension,$allowed_extension)){
                $message = "Only Images are Accepted !";
            }

            else
            {

	            move_uploaded_file($image_tem_location,$image_stored_location);

            $query = "INSERT INTO animals (animalname, description, image, username) VALUES (:animalname, :description, :image, :username)";

            $statement = $db->prepare($query);
            $statement->bindValue(':animalname', $animalname);        
            $statement->bindValue(':description', $description);
            $statement->bindValue(':image', $image_stored_location);
            $statement->bindValue(':username', $username);
            $insert_id = $db->lastInsertId();
            
            if( $statement->execute())
            {
                $message = "Animal added";
            }
            else
            {
                $message = "Animal not added";
            }
        }}
    }

   $query = "SELECT * FROM animals ";
    $state = $db->prepare($query);
    $state->execute();
    $post = $state->fetchAll();
    $error = "";
    if (empty($post)) 
    {
        $error = "<p>No Data found </p>";   
    }
    
?>
   

<!DOCTYPE html>
<html>
<head>
	<title>animal</title>
</head>
<body>

   
    <form method="post">
    <h4> Add a new animal </h4>
    <input type="text" name="animalname"><br>
	<textarea name="description" id="description" rows="5" cols="45" placeholder="Add a new animal and write some description about it."></textarea><br>
	<label>Upload Image:</label><br>
	<input type="file" name="image" ><br>

    <button name="upload">Uplaod</button>

    <?php echo $message ?>
    <h2> Animals: </h2>
    <?php foreach ($post as $posts): ?>
        <p> <?= $posts['animalname']; ?> </p>
        <p> <?= $posts['description']; ?> </p>
        <p> Posted By: <?= $posts['username']; ?> </p>
        <p> Posted On: <?= $posts['timestamp']; ?> </p>
    <?php endforeach; ?>
</form>

</body>
</html>
