<?php 

require('connect.php');

session_start();
$answer = $_SESSION["answer"];
$user_answer = $_POST["answer"];

if($answer == $user_answer){
  header('Location: homepage.php');
}

else{
  header('Location: login.php');
}

?>