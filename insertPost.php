<?php
// läs in check_login.php
require('check_login.php');

// koppla upp mot databasen
require_once('dbConn.php');


// ta hand om formulärets element
$userId = $_SESSION['userId'];
$title = htmlentities(trim($_POST['title']));
$content = htmlentities(trim($_POST['content']));


// bugg upp SQL-satsen
$sql = "INSERT INTO post (userId, title, content) VALUES (:userId, :title, :content);";

// kör SQL-satsen mot databasen
$stm = $pdo->prepare($sql);
$stm->execute(array('userId' => $userId, 'title' => $title, 'content' => $content));

//echo "<pre>";
//print_r(get_defined_vars());
//echo "</pre>";
//
//exit;

// Om lastInsertId == 0 så har något gått fel.
if($pdo->lastInsertId()==0){
    $mess = "Inget inlägg lades till.";
}else {
    $mess = "Ett inlägg är tillagd med id: ".$pdo->lastInsertId().".";
}

// skicka vidare till admin.php?postId=X
header("location: admin.php?mess=$mess");
?>