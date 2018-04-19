<?php
// Koppla upp mot databasen
require('check_login.php');

require_once('dbConn.php');

// Ta hand om formulärets element
$postId = htmlentities(trim($_POST['postId']));
$commentId = htmlentities(trim($_POST['commentId']));
$active = $_POST['active'] == '1' ? 0 : 1;
$mess ="";
// Bygg upp SQL-satsen
$sql = "UPDATE comment SET active = :active WHERE commentId = :commentId;";

// Kör SQL-satsen mot databasen
$stm = $pdo->prepare($sql);
$stm->execute(array('active'=>$active, 'commentId'=>$commentId));


// Skicka vidare till editpost.php?postId=X
header("location: editPost.php?postId=$postId&mess=$mess");
?> 