<?php
// starta sessionen
session_start();

require_once('dbConn.php');

// ta emot variablerna från formuläret och tvätta dem
$username = trim($_POST['username']);
$password = sha1(trim($_POST['password']));



// Bygger upp SQL-satsen och hämtar resultatet från databasen

$sql = "SELECT userID FROM user WHERE username = :username AND password = :password AND active = 1;";
$stm = $pdo->prepare($sql);
$stm->execute(array('username' => $username, 'password' => $password));

$row = $stm->fetch(PDO::FETCH_ASSOC);

//echo "<pre>";
//print_r(get_defined_vars());
//echo "</pre>";
//exit;

if(isset($row['userID'])){
    // skapa en session-variabel             
    $_SESSION['username'] = $username;
    $_SESSION['userId'] = $row['userID'];

	// och skicka till admin.php
	header('location: admin.php');
} else{
	// annars skicka till index.php med meddelande
	header('location: index.php?mess=Du har angivit ett felaktigt användarnamn eller lösenord.');
}
?>