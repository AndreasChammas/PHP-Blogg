<?php
// öppna sessionen
session_start();

// Kolla om $_SESSION['username'] har ett värde, annars skicka till index
if(!isset($_SESSION['username'])){
	header('location: index.php?mess=Du har inte rätt att vara här!');
}
?>
