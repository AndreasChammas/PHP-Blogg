<?php
session_start();			// öppnar sessionen
session_unset();			// tömmer sessionen
session_destroy();		// förstör sessionen

// skicka användaren vidare till index med meddelande
header('location: index.php?mess=Du har blivit utloggad!');
?>