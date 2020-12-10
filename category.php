<?php

	session_start();
	require ('connect.php');

	if(!isset($_SESSION['admin']))
	{
        header('location: admin.php');
    }

	$message = ' ';
    if(isset($_POST['upload']))
    {
        $categoryname = filter_input(INPUT_POST, "categoryname", FILTER_SANITIZE_STRING);
        if($_FILES['image'] && $_FILES['image']['error']==0)
        {
            $image= $_FILES['image']['name'];
            $image_type =$_FILES['image']['type'];
            $image_size = $_FILES['image']['size'];
            $image_tem_location = $_FILES['image']['tmp_name'];
            $sourceProperties = getimagesize($image_tem_location);
            $fileNewName = time();
            $image_stored_location = "images/".$image;

            //$allowed_extension = array('gif','jpeg','jpg','png', 'jfif');
            $file_extension = pathinfo($image,PATHINFO_EXTENSION);
            $imageType = $sourceProperties[2];

            switch($imageType)
            {
            	case IMAGETYPE_PNG:
	                $imageResourceId = imagecreatefrompng($image_tem_location); 
	                $targetLayer = imageResize($imageResourceId,$sourceProperties[0],$sourceProperties[1]);
	                imagepng($targetLayer,$image_stored_location. $fileNewName. "_thump.". $file_extension);
	                break;


            	case IMAGETYPE_GIF:
	                $imageResourceId = imagecreatefromgif($image_tem_location); 
	                $targetLayer = imageResize($imageResourceId,$sourceProperties[0],$sourceProperties[1]);
	                imagegif($targetLayer,$image_stored_location. $fileNewName. "_thump.". $file_extension);
	                break;


	            case IMAGETYPE_JPEG:
	                $imageResourceId = imagecreatefromjpeg($image_tem_location); 
	                $targetLayer = imageResize($imageResourceId,$sourceProperties[0],$sourceProperties[1]);
	                imagejpeg($targetLayer,$image_stored_location. $fileNewName. "_thump.". $file_extension);
	                break;


	            default:
	                echo "Invalid Image type.";
	                exit;
	                break;
            }

            // if(!in_array($file_extension,$allowed_extension))
            // {
            //     $message = "Only Images are Accepted !";
            // }

	            move_uploaded_file($image_tem_location,$image_stored_location);

	            $query = "INSERT INTO category (categoryname,image) values (:categoryname,:image)";
	            $statement = $db->prepare($query);
	           
	            $statement->bindvalue(':categoryname', $categoryname);
	            $statement->bindvalue(':image',$image_stored_location);

	            $statement->execute();
	            $insert_id = $db->lastInsertId();
	            
	            $message = "Thank you so much ".$_SESSION['admin']." for adding the new category.";

	            header('Location: homepage.php');
	        

        }

        else
        { 
            $message = "So Sorry! The upload is failed."."<br>"."Please try agian"; 
        }  
    }

    function imageResize($imageResourceId,$width,$height) {
    $targetWidth =200;
    $targetHeight =200;
    $targetLayer=imagecreatetruecolor($targetWidth,$targetHeight);
    imagecopyresampled($targetLayer,$imageResourceId,0,0,0,0,$targetWidth,$targetHeight, $width,$height);
    return $targetLayer;
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