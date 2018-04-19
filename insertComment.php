<?php
//koppla upp mot databasen
require_once('dbConn.php');

//ta hand om alla formulärens element
$postId = htmlentities($_POST['postId']);
$content = htmlentities(trim($_POST['content']));
$author = htmlentities(trim($_POST['author']));

//bygg upp sql satsen
$sql = "INSERT INTO comment (postId, content, author) VALUES (:postId, :content, :author);";

//kör sql satsen mot databasen
$stm = $pdo->prepare($sql);
$stm->execute(array('postId' => $postId, 'content' => $content, 'author' => $author));



if($pdo->lastInsertId()==0){
    $mess = "ingen kommentar lades till";
} else {
    $mess = "En kommentar är tillagd med id: ".$pdo->lastInsertId().".";
}


//skicka vidare tll post.php?postId=X
header("location: post.php?postId=$postId&mess=$mess");

//skicka vidare till news.php




//echo "<pre>";
//print_r(get_defined_vars());
?>