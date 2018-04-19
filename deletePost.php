<?php
// Koppla upp mot databasen
require('check_login.php');

require_once('dbConn.php');

// Ta hand om formulärets element
$postId = htmlentities(trim($_POST['postId']));
$active = $_POST['active'] == '1' ? 0 : 1;
$mess ="";
// Bygg upp SQL-satsen
$sql = "UPDATE post SET active = :active WHERE postId = :postId;";

// Kör SQL-satsen mot databasen
$stm = $pdo->prepare($sql);
$stm->execute(array('active'=>$active, 'postId'=>$postId));



# Om lastInsertId = 0 så har något gått fel.
if($pdo->lastInsertId()==0){
} else {
    $mess = "inlägg med id: ".$pdo->lastInsertId()." uppdaterades.";
}


// Skicka vidare till admin.php?postId=X
header("location: admin.php?&mess=$mess");
?> 