<!-- <?php 

require('connect.php');

session_start();
$answer = $_SESSION["answer"];
$user_answer = $_POST["answer"];

if($answer == $user_answer){
  header('Location: homepage.php');
}

else{
  header('Location: login.php');
}

?> -->




















<?php
    
    require './connection.php';

    $query = "SELECT * FROM uploads WHERE id = {$_GET['id']}";
    $state = $db->prepare($query);
    $state->execute();
    $post = $state->fetchAll();
    $id = $_GET['id'];
    $message = " ";

    if (isset($_POST['update']))
    {
        $topic = $_POST['topic'];
        $comment = $_POST['comment'];
        $old_image = $_POST['old_image'];
        $new_image = $_FILES['image']['name'];
        $image_stored_location = "images/".$new_image;
        $image_tem_location = $_FILES['image']['tmp_name'];

       

        if($_FILES['image']['name'] != '')
        {
            
            // $update_filename = $new_image;
            $image_stored_location = "images/".$new_image;
           
        }
        else
        {
          
            $image_stored_location = $old_image;
            
            $query = "UPDATE uploads SET 	topic = :topic, opinion = :opinion  WHERE id = :id";

            $statement = $db->prepare($query);
            $statement->bindValue(':topic', $topic);        
            $statement->bindValue(':opinion', $comment);
            $statement->bindValue(':id', $id, PDO::PARAM_INT);
        
            $statement->execute();

           
        }

        if(!(file_exists($image_stored_location)))
        {
           
            // $filename =  $_FILES['image']['name'];

            // $message = "The Image already exists: ".$filename;
            $query = "UPDATE uploads SET 	topic = :topic, opinion = :opinion , images = :images  WHERE id = :id";

            $statement = $db->prepare($query);
            $statement->bindValue(':topic', $topic);        
            $statement->bindValue(':opinion', $comment);
            $statement->bindValue(':images', $image_stored_location);
            $statement->bindValue(':id', $id, PDO::PARAM_INT);
        
            $statement->execute();
            move_uploaded_file($image_tem_location,$image_stored_location);

            
          


        }
        else
        {
            
            $query = "UPDATE uploads SET 	topic = :topic, opinion = :opinion , images = :images  WHERE id = :id";

            $statement = $db->prepare($query);
            $statement->bindValue(':topic', $topic);        
            $statement->bindValue(':opinion', $comment);
            $statement->bindValue(':images', $image_stored_location);
            $statement->bindValue(':id', $id, PDO::PARAM_INT);
        
           if($statement->execute())
           {
             if($_FILES['image']['name'] != '')
             {
                 echo $old_image;
                move_uploaded_file($image_tem_location,$image_stored_location);
                // unlink($old_image);

             }
             $message = " COngrats! Your data is updated.";
           }
           else
           {
             $message = "The file could not updated.";
           }

        }
        echo " The Data is updated.";

    }



?>