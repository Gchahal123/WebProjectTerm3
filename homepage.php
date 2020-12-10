<?php 

	require('connect.php');
	$error=[];

	$query = "SELECT * FROM category ORDER BY categoryid desc";
 	$prepare = $db->prepare($query);
 	$prepare->execute();
 	$category = $prepare->fetchAll();

 	if (empty($category)) 
 	{
 		$error = "<p>No category found</p>"; 	
 	}

 	if(isset($_POST['submit']))
    {
    	$find = filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING);

	    if(empty($find))
	    {
	    	echo "no data found";
	    }

       	else
       	{
	        $query = "SELECT * FROM category WHERE categoryid ='$find' OR categoryname LIKE '$find%'";
	        $prep = $db->prepare($query);
	        $prep->execute();
	        $post = $prep->fetchAll();
	        $error = "";
		}
    }

    if(isset($_POST['sort']))
    {
    	$query = "SELECT * FROM category ORDER BY categoryname";
 		$prepare = $db->prepare($query);
 		$prepare->execute();
 		$category = $prepare->fetchAll();
    }

    if(isset($_POST['sorting']))
    {
    	$query = "SELECT * FROM category ORDER BY categoryid desc";
 		$prepare = $db->prepare($query);
 		$prepare->execute();
 		$category = $prepare->fetchAll();
    }
?> 

<!DOCTYPE html>
<html>
<head>
	<title>Homepage</title>
	<link rel="stylesheet" type="text/css" href="homestyle.css?11">
	<link href='http://fonts.googleapis.com/css?family=Cinzel' rel='stylesheet' type='text/css'>
</head>
<body id="homepage">
	<form method = "post" >
	    <input type="text" name ="name" class="search">
	    <button name="submit" id="search">Search</button>

	    <label>Sort by:</label>
	    <button name="sort">Category</button>
	    <button name="sorting">Category ID</button>
	</form>
    	<div class="header">
		    <h1 class="zoo">Chattbir Zoo<span>Zirakpur, India</span></h1>
		    <ul class="nav">
		      <li><a href="login.php">Login</a></li>
				<li><a href="register.php">Register</a></li>
				<li><a href="admin.php">Admin Login</a></li>
				<li><a href="logout.php">Logout</a></li>
				<li><a href="contact.html">Contact Us</a></li>
		    </ul>
		</div>

        <table class="styled-table" style="width: 50%">
        	<caption>Search results:</caption>
        	<thead>
	        	<tr>
	        		<th> Category ID </th>
	        		<th> Category Name </th>
	        	</tr>
	        </thead>
	        <tbody>
	        	<?php if(isset($post)): ?>
	        	<?php foreach ($post as $posts): ?>
	        	<tr class="active-row">
	        		<td><a href="output.php?id=<?=$posts['categoryid']; ?>"><?= $posts['categoryid']; ?></a></td>
	        		<td><?= $posts['categoryname']; ?></td>
	        	</tr>
	        	<?php endforeach; ?>
	        	<?php endif; ?>
	        </tbody>
        </table>

	<section>
		<div id="content">

			<h1> Welcome to the Zoo!!! </h1>

			<p> After closing on March 14 amid the COVID-19 pandemic, the Chhatbir Zoo has opened their gates for visiting now. The regular visitors will notice some changes. </p>

			<p> Tickets will no longer be available for purchase at the gate. Anyone looking to visit the zoo will need to first purchase their ticket online. Because the daily attendance will be capped at 1,500 people, each ticket will come with a specific entry time in an effort to ensure physical distancing and allowing the zoo to manage crowds. Only 90 tickets will be issued for every 30-minute window. </p>

			<p> Both indoor and outdoor traffic areas will be marked with signs and arrows to ensure one-way traffic is followed. Features like animal talks, rides, play structures and stroller rentals will not be available. </p>

			<div id="meet">
				<h2> Meet our Animals </h2>
				<p> <a href="category.php"> <button class="myButton"> Add new category </button> </a> </p>
			</div>
			<?php foreach ($category as $categories): ?>
				<div id="animaladd">
					<h3 id="ctg"> <?= $categories['categoryname']; ?> </h3>
					<p> <a href="animals.php?categoryid=<?= $categories['categoryid']; ?>"> <button class="myButton"> Add new animal </button> </a> </p>
				</div>
				<p id="upld"> 
					<a href="view.php?categoryid=<?= $categories['categoryid']; ?>"> <img src="<?= $categories['image']; ?>" width=200 height=200> </a><br>

					<div id="comment">
						<a href="Comment.php?categoryid=<?= $categories['categoryid']; ?>"><button>Add your comments </button></a>

						<span><a href="edit.php?categoryid=<?= $categories['categoryid']; ?>"><button id="edit"> Edit</button> </a></span>

						<span><a href="delete.php?categoryid=<?= $categories['categoryid']; ?>"><button onclick="return confirm('Are you sure?')"> Delete</button> </a></span>
					</div>
				</p>
			<?php endforeach; ?>
		</div>
	</section>
</body>
</html>

