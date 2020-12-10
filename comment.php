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
        $comment = filter_input(INPUT_POST, "comment", FILTER_SANITIZE_STRING);
        $captcha = filter_input(INPUT_POST, "captcha", FILTER_SANITIZE_STRING);
        $user = $_SESSION['user'];
        if($captcha != $_SESSION["vercode"])
        {
            echo "verification failed.";
        }

        else
        {
            $query = "INSERT INTO comments (comment, user, categoryid) VALUES (:comment, :user, :categoryid)";

            $statement = $db->prepare($query);
            $statement->bindValue(':comment', $comment);        
            $statement->bindValue(':user', $user);
            $statement->bindValue(':categoryid', $id);
            $insert_id = $db->lastInsertId();
            
            if( $statement->execute())
            {
                $message = "Comment is uploaded !";
            }
            else
            {
                $message = "Comment is not uploaded";
            }
        }
    }

    $query = "SELECT * FROM comments WHERE categoryid = {$_GET['categoryid']}";
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
<body>

    <?php foreach ($post as $posts): ?>
        <p> <?= $posts['categoryname']; ?> </p>
        <P> <?= $posts['image']; ?> </P>
    <?php endforeach; ?>

    <form method="post">
        <h2> Please write down your perception. </h2>
    	<textarea name="comment" id="comment" rows="5" cols="45" placeholder="what do you think?"></textarea><br>
        <label><img src="captchas.php"></label>
        <input type="text" name="captcha"><br>
        <button name="upload">Uplaod</button>

        <?php echo $message ?>
        <h2> Your Comments: </h2>
        <?php foreach ($p as $comments): ?>
            <p> <?= $comments['comment']; ?> </p>
            <P> Posted By: <?= $comments['user']; ?> </P>
        <?php endforeach; ?>
    </form>

</body>
</html>