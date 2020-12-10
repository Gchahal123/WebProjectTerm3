<?php 

    require ('connect.php');
     session_start();
    

    if(!isset($_SESSION['user'])){

        header('location: login.php');
    }

    $query = "SELECT * FROM animal WHERE id = {$_GET['id']}";
    $statement = $db->prepare($query);
    $statement->execute();
    $animal = $statement->fetchAll();
    $id = $_GET['id'];

    if (isset($_POST['update'])) {
        
        $animalname = $_POST['animal'];
        $description = $_POST['description'];
    
        $query = "UPDATE animal SET animal = :animal, description = :description WHERE id = :id";  
        $statement = $db->prepare($query);
        $statement->bindValue(':animal', $animalname);        
        $statement->bindValue(':description', $description);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);

        $statement->execute();
        header('Location:homepage.php');
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Edit php</title>
    <link rel="stylesheet" type="text/css" href="all.css">
</head>
<body>
    <form method="post">
        <input type="text" name="animal" id="animal" value="<?= $animal[0]['animal']?>"><br>
        <input type="text" name="description" id="description" value="<?= $animal[0]['description']?>"><br>
        <button type="submit" name="update" value="submit">Update</button>
    </form>

</body>
</html>