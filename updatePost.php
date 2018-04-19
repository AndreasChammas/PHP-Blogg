<?php
// läs in check_login.php

require('check_login.php');

require_once('dbConn.php');

// Ta hand om formulärets element
$postId = htmlentities(trim($_POST['postId']));
$title = htmlentities(trim($_POST['title']));
$content = htmlentities(trim($_POST['content']));
$mess = "";

// Bygg upp SQL-satsen
//$sql = "INSERT INTO post (title, content, postId) VALUES (:title, :content, :postId);";
$sql = "UPDATE post SET title = :title, content = :content WHERE postId = :postId;";

// Kör SQL-satsen mot databasen
$stm = $pdo->prepare($sql);
$stm->execute(array('title'=>$title, 'content'=>$content,  'postId'=>$postId));

// Skicka vidare till admin.php?postId=X
header("location: admin.php?&mess=$mess");
?> 