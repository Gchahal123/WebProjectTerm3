<?php

	require('connect.php');
	$query = "SELECT * FROM category WHERE categoryid = {$_GET['id']}";
 	$state = $db->prepare($query);
 	$state->execute();
    $post = $state->fetchAll();
     
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
	<title>PDO output</title>

</head>
<body>
	<?php foreach ($post as $animals): ?>
		<h2><?= $animals['categoryname']; ?></h2>
		<p><img src="<?= $animals['image']?>"></p>
	<?php endforeach; ?>
	
</body>
</html>