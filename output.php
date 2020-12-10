<?php

	require('connect.php');

	$statement = "SELECT * FROM animal WHERE categoryid = {$_GET['id']}";
    $state = $db->prepare($statement);
    $state->execute();
    $animal = $state->fetchAll();

	$query = "SELECT * FROM comments WHERE categoryid = {$_GET['id']}";
    $prep = $db->prepare($query);
    $prep->execute();
    $p = $prep->fetchAll();
    $error = "";
    if (empty($p)) 
    {
        $error = "<p>No Data found </p>";   
    }
     
?>

<!DOCTYPE html>
<html>
<head>
    <title>Comment</title>
    <link rel="stylesheet" type="text/css" href="all.css">
</head>
<body id="view">
        <h2> Animals in this category </h2>
        <?php foreach ($animal as $animals): ?>
            <h3> <?= $animals['animal']; ?> </h3>
            <p> <?= $animals['description']; ?> </p>
            <img src="<?= $animals['image']; ?>" width=200 height=200>
            <P> Posted By: <?= $animals['user']; ?> </P>
            <p> Posted on: <?= $animals['timestamp']; ?> </p>
        <?php endforeach; ?>

        <h2> Your Comments: </h2>
        <?php foreach ($p as $comments): ?>
            <p> <?= $comments['comment']; ?> </p>
            <P> Posted By: <?= $comments['user']; ?> </P>
        <?php endforeach; ?>
</body>
</html>