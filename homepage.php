<?php 
	require('connect.php');
	$error=[];

	$query = "SELECT * FROM category ORDER BY categoryname";

 	$prepare = $db->prepare($query);

 	$prepare->execute();

 	$category = $prepare->fetchAll();

 	if (empty($category)) {
 		$error = "<p>No category found</p>"; 	
 	}

 	if(isset($_POST['submit']))
    {

        $find = $_POST['name'];

	    if(empty($find)){
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


?> 

<!DOCTYPE html>
<html>
<head>
	<title>Homepage</title>
	<link rel="stylesheet" type="text/css" href="homestyle.css?7">
	<link href='http://fonts.googleapis.com/css?family=Cinzel' rel='stylesheet' type='text/css'>
</head>
<body id="homepage">
	<img class="logo" src="photos/pk.png" alt="Chattbir Zoo">
	<form method = "post" >
    <input type="text" name ="name" class="search">
	    <button name="submit" id="search">Search</button>
    </form>

        <div class="first-nav">
            <ul>
				<li><a href="login.php">Login</a></li>
				<li><a href="register.php">Register</a></li>
				<li><a href="admin.php">Admin Login</a></li>
				<li><a href="logout.php">Logout</a></li>
				<li><a href="contact.html">Contact Us</a></li>
			</ul>
        </div>

        <div class="imagetext">
        <img class="headerbackground" src="photos/pk.jpg" alt="headerBackground">
        	<div class="Chhatbir">Chhatbir Zoo</div>
        	<div class="Zoo">The Zoo is currently open to the public. In response to COVID-19, we’ve made some essential changes to ensure a safe and enjoyable experience for all.</div>
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

		<h1> Our Mission!! </h1>
		<p> Our Chhatbir Zoo - Connecting people, animals and conservation science to fight extinction. </p>

		<h1> Our Vision!! </h1>
		<p> A world where wildlife and wild spaces thrive. </p>
		
		<div id="meet">
			<h2> Meet our Animals </h2>
			<p> <a href="category.php"> <button> Add new category </button> </a> </p>
		</div>

		<?php foreach ($category as $categories): ?>

			<h3 id="ctg"> <?= $categories['categoryname']; ?> </h3>
			<p id="upld"> 

				<a href="animals.php"> <img src="<?= $categories['image']; ?>"> </a> 
				<a href="Comment.php?categoryid=<?= $categories['categoryid']; ?>"><button>Add your comments </button></a>
				<a href="edit.php?categoryid=<?= $categories['categoryid']; ?>"><button> Edit</button> </a>
				<a href="delete.php?categoryid=<?= $categories['categoryid']; ?>"><button onclick="return confirm('Are you sure?')"> Delete</button> </a>

			</p>

		<?php endforeach; ?>




			<!-- <h3> Mammals </h3>
			<ul>
				<li class="first"> 
					<a href="mammals.php"><img src="photos/lion.jpg" alt="Lion"/></a> -->
					<!-- <a href="mammals.php">Lion</a> -->
				<!-- </li> -->
				<!-- <li>
					<a href="gallery.html"><img src="photos/tiger.jpg" alt="Tiger"/></a>
					<a href="gallery.html">Tiger</a>
				</li>
				<li>
					<a href="gallery.html"><img src="photos/leopard.jpg" alt="Leopard"/></a>
					<a href="gallery.html">Leopard</a>
				</li>
				<li>
					<a href="gallery.html"><img src="photos/panda.jpg" alt="Panda"/></a>
					<a href="gallery.html">Giant Panda</a>
				</li>
				<li>
					<a href="gallery.html"><img src="photos/giraffe.jpg" alt="Giraffe"/></a>
					<a href="gallery.html">Giraffe</a>
				</li>
				<li>
					<a href="gallery.html"><img src="photos/bears.jpg" alt="Bears"/></a>
					<a href="gallery.html">Bears</a>
				</li>
				<li>
					<a href="gallery.html"><img src="photos/koala.jpg" alt="Koala"/></a>
					<a href="gallery.html">Koala</a>
				</li>
				<li class="last">
					<a href="gallery.html"><img src="photos/mammals.jpg" alt="Gallery"/></a>
					<a href="gallery.html">Gallery</a>
				</li> -->
			<!-- </ul>
		
			<h3> Birds </h3>
			<ul>
				<li> 
					<a href="birds.php"><img src="photos/parrots.jpg" alt="Parrots"/></a> -->
					<!-- <a href="birds.php">Parrots</a> -->
				<!-- </li> -->
				<!-- <li>
					<a href="gallery.html"><img src="photos/owls.jpg" alt="Owls"/></a>
					<a href="gallery.html">Owls</a>
				</li>
				<li>
					<a href="gallery.html"><img src="photos/peacock.jpg" alt="Peacock"/></a>
					<a href="gallery.html">Peacock</a>
				</li>
				<li>
					<a href="gallery.html"><img src="photos/eagle.jpg" alt="Eagle"/></a>
					<a href="gallery.html">Eagle</a>
				</li>
				<li>
					<a href="gallery.html"><img src="photos/americanflamingo.jpg" alt="American Flamingo"/></a>
					<a href="gallery.html">American Flamingo</a>
				</li>
				<li>
					<a href="gallery.html"><img src="photos/woodpecker.jpg" alt="Woodpecker"/></a>
					<a href="gallery.html">Woodpecker</a>
				</li>
				<li>
					<a href="gallery.html"><img src="photos/lovebird.jpg" alt="Lovebird"/></a>
					<a href="gallery.html">Lovebird</a>
				</li>
				<li class="last">
					<a href="gallery.html"><img src="photos/birds.jpg" alt="Gallery"/></a>
					<a href="gallery.html">Gallery</a>
				</li> -->
			<!-- </ul>
		
			<h3> Reptiles </h3>
			<ul>
				<li> 
					<a href="reptiles.php"><img src="photos/snake.jpg" alt="Snake"/></a> -->
					<!-- <a href="reptiles.php">Snake</a> -->
				<!-- </li> -->
				<!-- <li>
					<a href="gallery.html"><img src="photos/turtle.jpg" alt="Turtle"/></a>
					<a href="gallery.html">Turtle</a>
				</li>
				<li>
					<a href="gallery.html"><img src="photos/tortoise.jpg" alt="Tortoise"/></a>
					<a href="gallery.html">Tortoise</a>
				</li>
				<li>
					<a href="gallery.html"><img src="photos/lizard.jpg" alt="Lizard"/></a>
					<a href="gallery.html">Lizard</a>
				</li>
				<li>
					<a href="gallery.html"><img src="photos/crocodile.jpg" alt="Crocodile"/></a>
					<a href="gallery.html">Crocodile</a>
				</li>
				<li>
					<a href="gallery.html"><img src="photos/chameleons.jpg" alt="Chameleons"/></a>
					<a href="gallery.html">Chameleons</a>
				</li>
				<li>
					<a href="gallery.html"><img src="photos/viper.jpg" alt="Viper"/></a>
					<a href="gallery.html">Viper</a>
				</li>
				<li class="last">
					<a href="gallery.html"><img src="photos/reptiles.jpg" alt="Gallery"/></a>
					<a href="gallery.html">Gallery</a>
				</li> -->
			<!-- </ul>
		
			<h3> Insects </h3>
			<ul>
				<li> 
					<a href="insects.php"><img src="photos/butterfly.jpg" alt="Butterfly"/></a> --> 
					<!-- <a href="insects.php">Butterfly</a> -->
				<!-- </li> -->
				<!-- <li>
					<a href="gallery.html"><img src="photos/cockroach.jpg" alt="Cockroach"/></a>
					<a href="gallery.html">Cockroach</a>
				</li>
				<li>
					<a href="gallery.html"><img src="photos/beetle.jpg" alt="Beetle"/></a>
					<a href="gallery.html">Beetle</a>
				</li>
				<li>
					<a href="gallery.html"><img src="photos/ants.jpg" alt="Ants"/></a>
					<a href="gallery.html">Ants</a>
				</li>
				<li>
					<a href="gallery.html"><img src="photos/grasshopper.jpg" alt="Grasshopper"/></a>
					<a href="gallery.html">Grasshopper</a>
				</li>
				<li>
					<a href="gallery.html"><img src="photos/crickets.jpg" alt="Crickets"/></a>
					<a href="gallery.html">Crickets</a>
				</li>
				<li>
					<a href="gallery.html"><img src="photos/wasp.jpg" alt="Wasp"/></a>
					<a href="gallery.html">Wasp</a>
				</li>
				<li class="last">
					<a href="gallery.html"><img src="photos/insects.jpg" alt="Gallery"/></a>
					<a href="gallery.html">Gallery</a>
				</li> -->
			<!-- </ul>
	</div>
</section> -->
<!-- 
	<footer>
		<a href="index.html" class="logo"><img src="photos/zoo.jpg" alt="Chattbir Zoo"/></a>
		
			<p>Chhatbir Zoo</p>
			<span>Zoo Helpline No. +916239526008</span>
			<span>Email: mczpchhatbir@gmail.com</span>
	
		<p>Copyright &#169; 2020. All Rights Reserved.</p>
	</footer>
 -->
</body>
</html>

