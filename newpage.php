
<?php
    require ('connect.php');
    session_start();
    

    if(!isset($_SESSION['user'])){

        header('location: login.php');
    }
    
    $message = ' ';
    if(isset($_POST['upload']))
    {
        
        
        $animalname = $_POST['animalname'];
        $description = $_POST['description'];
       

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

	            $query = "INSERT INTO animals (animalname,description,image) values (:animalname,:description,:image)";

	            $statement = $db->prepare($query);
	           
	            $statement->bindvalue(':animalname', $animalname);
	            $statement ->bindvalue(':description', $description);
	            $statement->bindvalue(':image',$image_stored_location);

	            $statement->execute();
	            $insert_id = $db->lastInsertId();
	           
	            
	            $message = "Thank you so much ".$_SESSION['user']." for adding the animal";

	            header('Location: homepage.php');
	        }

        }

        else
        { 
            $message = "So Sorry! ".$_SESSION['user']." The upload is failed."."<br>"."Please try agian";
            
        }
        
        
    }


    
?>
      
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>newpost</title>

</head>
<body>
	<a href = "logout.php">Logout</a>
	<a href = "homepage.php" >Home</a>

	<form  method = "post" enctype = "multipart/form-data">
	    <h2>Add new animals</h2>

	    <label>Animal Name</label><br>
	    <input type="text" class="form-control" name="animalname" ><br>

	    <textarea  name="description" id ="description" rows="5" cols="50"  placeholder = "Description of the animal"></textarea><br>

	    <label>Upload Image if you want: </label><br>
	    <input type="file" class="form-control" name="image" ><br>

	    <button class="btn-primary" type="submit" name="upload">Upload</button>

	    

	</form> 

	<h4> <?php echo $message; ?> </h4><br>


</body>
</html>