<?php

	require ('connect.php');
    $id = filter_input(INPUT_GET, 'categoryid', FILTER_SANITIZE_NUMBER_INT);
    $query = "DELETE FROM category WHERE categoryid = :categoryid";
    $statement = $db->prepare($query);
    $statement->bindValue(':categoryid', $id, PDO::PARAM_INT);
    $statement->execute();
    
    header('Location:homepage.php');
    
?>

