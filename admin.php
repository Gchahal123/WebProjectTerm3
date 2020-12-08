<?php

// //Initialize the session.
session_start();

require('connect.php');
error_reporting(E_ALL ^ E_NOTICE);

$error = [];

if(isset($_POST['username']) AND isset($_POST['password'])){

    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);

    $query = "SELECT password FROM admin WHERE admin = '$username' ";
    
    $prepare = $db->prepare($query);

    if($prepare->execute())
        {
            $pass = $prepare->fetch();
            
            
            if($prepare->rowCount()==1 && $password = $pass[0])
            {
                $_SESSION['admin'] = $username;
                 $var = "You are now logged in";
                 header('location: adminauthority.php');              
             }
            
            else{
                $var = "Invalid Username/password combination.";
            }

        }
    }
    


?>

<!DOCTYPE html>
<html>
<head>
    <title>User Login</title>
    <link rel="stylesheet" type="text/css" href="loginforms.css">
</head>
<body id="yuhu">

    <div class="login">
        <form id="event" method="post" action="admin.php">
            <h1>Admin Login</h1>
            <fieldset>
                <ol>
                    <li>
                        <label for="username"></label>
                        <input type="text" name="username" id="username" placeholder="Username" autocomplete="off">
                    </li>
                    <li>
                        <label for="password"></label>
                        <input type="password" name="password" id="password" placeholder="Password" autocomplete="off"> 
                    </li>
                    <li>
                        <button type="submit" class="btn" name="login_user">Login</button>
                    </li>
                    <li>
                        <?php echo $var ?>
                    </li>
                </ol>
            </fieldset>
    </form>

    </div>

</body>
</html>