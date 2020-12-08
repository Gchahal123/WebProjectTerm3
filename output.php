<?php
	require ('connect.php');
	
	$id = filter_input(INPUT_GET, 'categoryid', FILTER_SANITIZE_NUMBER_INT);
    
	// Build the parameterized SQL query and bind the sanitized values to the parameters
	$query = "SELECT * FROM category WHERE categoryid = :categoryid";
 	$statement = $db->prepare($query);
 	$statement->bindValue(':categoryid', $id, PDO::PARAM_INT);
 	//Execute the INSERT.
 	$statement->execute();

 	$animal = $statement->fetchAll();


?>
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
	<title>PDO output</title>

</head>
<body>
	<?php foreach ($animal as $animals): ?>
		<h2><?= $animals['categoryname']; ?></h2>
		<p><?= $animals['image']?></p>
	<?php endforeach; ?>
	
</body>
</html>