<?php
	require ('connect.php');
	session_start();

	if(!isset($_SESSION['admin'])){

        header('location: admin.php');
    }

	$message = ' ';
    if(isset($_POST['upload']))
    {
        
        $categoryname = $_POST['categoryname'];

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

	            $query = "INSERT INTO category (categoryname,image) values (:categoryname,:image)";

	            $statement = $db->prepare($query);
	           
	            $statement->bindvalue(':categoryname', $categoryname);
	            $statement->bindvalue(':image',$image_stored_location);

	            $statement->execute();
	            $insert_id = $db->lastInsertId();
	           
	            
	            $message = "Thank you so much ".$_SESSION['user']." for adding the new category.";

	            header('Location: homepage.php');
	        }

        }

        else
        { 
            $message = "So Sorry! The upload is failed."."<br>"."Please try agian"; 
        }  
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
	<title>Category of animals</title>
</head>
<body>
	<form method="post" enctype = "multipart/form-data">
		<h2> Add new category </h2>

		<label>Category Name</label><br>
		<input type="text" name="categoryname" ><br>

		<label>Upload Image realted to this category:</label><br>
	    <input type="file" name="image" ><br>

	    <button type="submit" name="upload">Upload</button>
		
	</form>

	<h4> <?php echo $message; ?> </h4><br>

</body>
</html>