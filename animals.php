<?php

    session_start();
    require('connect.php');

    if(!isset($_SESSION['user']))
    {
        header('location: login.php');
    }

    $message = ' ';
    $query = "SELECT * FROM category WHERE id = {$_GET['categoryid']}";
    $state = $db->prepare($query);
    $state->execute();
    $post = $state->fetchAll();
    $id = $_GET['categoryid'];

    if (isset($_POST['upload'])) 
    {
        $animal = filter_input(INPUT_POST, "animal", FILTER_SANITIZE_STRING);
        $description = filter_input(INPUT_POST, "description", FILTER_SANITIZE_STRING);
        $user = $_SESSION['user'];
        $id = $_GET['categoryid'];

        if($_FILES['image'] && $_FILES['image']['error']==0)
        {

            $image= $_FILES['image']['name'];
            $image_type =$_FILES['image']['type'];
            $image_size = $_FILES['image']['size'];
            $image_tem_location = $_FILES['image']['tmp_name'];
            $image_stored_location = "images/".$image;

            $allowed_extension = array('gif','jpeg','jpg','png', 'jfif');
            $file_extension = pathinfo($image,PATHINFO_EXTENSION);

            if(!in_array($file_extension,$allowed_extension))
            {
                $message = "Only Images are Accepted !";
            }

            else
            {

                move_uploaded_file($image_tem_location,$image_stored_location);
        
                $query = "INSERT INTO animal (animal, description, image, user, categoryid) VALUES (:animal, :description, :image, :user, :categoryid)";

                $statement = $db->prepare($query);
                $statement->bindValue(':animal', $animal); 
                $statement->bindValue(':description', $description); 
                $statement->bindValue(':image', $image_stored_location);        
                $statement->bindValue(':user', $user);
                $statement->bindValue(':categoryid', $id);
                $insert_id = $db->lastInsertId();
                
                if( $statement->execute())
                {
                    $message = "Animal is added!";
                    
                }
                else
                {
                    $message = "Animal is not added";
                }
            }

            $query = "SELECT * FROM animal WHERE categoryid = {$_GET['categoryid']}";
            $prep = $db->prepare($query);
            $prep->execute();
            $p = $prep->fetchAll();
            $error = "";
            if (empty($p)) 
            {
                $error = "<p>No Data found </p>";   
            }
        }
    }

    
?>
   

<!DOCTYPE html>
<html>
<head>
    <title>Comment</title>
</head>
<body>

    <form method="post" enctype = "multipart/form-data" >
        <h4> Please add a new animal in this category</h4>
        <label>Animal Name:</label>
        <input type="text" name="animal">
        <textarea name="description" id="comment" rows="5" cols="45" placeholder="Details of this animal!!"></textarea><br>
        <label>Upload Image:</label><br>
        <input type="file" name="image" ><br>
        <button name="upload">Uplaod</button>

        <?php echo $message ?>
        <h2> Animals in this category: </h2>
        <?php foreach ($p as $comments): ?>
            <p> <?= $comments['animal']; ?> </p>
            <p> <?= $comments['description']; ?> </p>
            <P> Posted By: <?= $comments['user']; ?> </P>
        <?php endforeach; ?>
    </form>

</body>
</html>