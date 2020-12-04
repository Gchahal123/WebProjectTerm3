<?php
	require ('connect.php');
	
	// Build the parameterized SQL query and bind the sanitized values to the parameters
	$query = "SELECT * FROM animals WHERE id = {$_GET['id']}";
 	$statement = $db->prepare($query);

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

	<h2><?= $animal[0]['animalname']; ?></h2>

	<span><a href="edit.php?id=<?php echo $animal[0]['id']; ?>">-Edit</a></span>

	<p><?= $animal[0]['description']?></p><br>

	<p><?= $animal[0]['image']?></p>
	
</body>
</html>