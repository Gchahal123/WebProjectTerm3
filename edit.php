<?php
    
    session_start();
    require ('connect.php');

    if(!isset($_SESSION['user']))
    {
        header('location: login.php');
    }

    $query = "SELECT * FROM category WHERE categoryid = {$_GET['categoryid']}";
    $state = $db->prepare($query);
    $state->execute();
    $post = $state->fetchAll();
    $id = $_GET['categoryid'];
    $message = " ";

    if (isset($_POST['update']))
    {
        $categoryname = filter_input(INPUT_POST, "categoryname", FILTER_SANITIZE_STRING);
        $old_image = filter_input(INPUT_POST, "old_image", FILTER_SANITIZE_STRING);
        $new_image = $_FILES['image']['name'];
        $image_stored_location = "images/".$new_image;
        $image_tem_location = $_FILES['image']['tmp_name'];

        if($_FILES['image']['name'] != '')
        {
            $image_stored_location = "images/".$new_image;
        }
        else
        {
            $image_stored_location = $old_image;
            $query = "UPDATE category SET categoryname = :categoryname WHERE categoryid = :categoryid";

            $statement = $db->prepare($query);
            $statement->bindValue(':categoryname', $categoryname);  
            $statement->bindValue(':categoryid', $id, PDO::PARAM_INT);
            $statement->execute();
            header('Location:homepage.php?categoryid='.$id);
        }

        if(!(file_exists($image_stored_location)))
        {
            $query = "UPDATE category SET categoryname = :categoryname, images = :images WHERE categoryid = :categoryid";  

            $statement = $db->prepare($query);
            $statement->bindValue(':categoryname', $categoryname);
            $statement->bindValue(':images', $image_stored_location);   
            $statement->bindValue(':categoryid', $id, PDO::PARAM_INT);
            
            $statement->execute();
            move_uploaded_file($image_tem_location,$image_stored_location);
        }
        else
        {
            $query = "UPDATE category SET categoryname = :categoryname, images = :images WHERE categoryid = :categoryid"; 
            $statement = $db->prepare($query);
            $statement->bindValue(':categoryname', $categoryname);
            $statement->bindValue(':images', $image_stored_location);
            $statement->bindValue(':categoryid', $id, PDO::PARAM_INT);
        
           if($statement->execute())
           {
             if($_FILES['image']['name'] != '')
             {
                move_uploaded_file($image_tem_location,$image_stored_location);
             }

             $message = " Congrats! Your data is updated.";
           }

           else
           {
             $message = "The file could not updated.";
           }
        }
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
        <input type="text" name="categoryname" id="categoryname" value="<?= $post[0]['categoryname']?>"><br>
        <img src="<?= $post[0]['image'];?>" width="200">
        
        <label>Upload new image: </label><br>
        <input type="text" name="old_image" id="image" value="<?= $post[0]['image'] ?>">
        <input type="file" name="image">
        <button type="submit" name="update" value="submit">Update</button>
    </form>
</body>
</html>