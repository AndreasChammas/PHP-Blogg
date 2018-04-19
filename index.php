<?php
// läser in databaskopplinen
require_once('dbConn.php');
// Tar hand om eventuellt meddelanden till sidan
$mess = isset($_GET['mess']) ? "<p class='mess'>".$_GET['mess']."</p>" : "";

// Bygger upp SQL-satsen och hämtar resultset från databasen
$sql = "SELECT p.postId, p.title, p.content, p.dateTime, u.fullName FROM post as p INNER JOIN user as u ON u.userId = p.userId WHERE p.active = 1;";
$stm = $pdo->prepare($sql);
$stm->execute();
$res = $stm->fetchAll(PDO::FETCH_ASSOC);

// Skapar en variabel för att skruva ut alla bloggposter
$output = "";
// Loopar igenom resultset och bygger utskrift
foreach ($res as $row) {
	$output .= "<div>";
	$postId = $row['postId'];
	$output .= "<h2><a href='post.php?postId=$postId'>".$row['title']."</a></h2>";
	$output .= "<p>".nl2br($row['content'])."</p>";		// nl2br - ny rad -> <br>
	$output .= "<p><strong>".$row['fullName'].", ".$row['dateTime']."</strong></p>";
	$output .= "</div>";
}
?>
<!DOCTYPE html>
<html lang="sv">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="style.css" type="text/css">
	<title>Blogg</title>
</head>
<body>
	<main>
		<header>Blogg</header>
				<aside>
			<form action="login.php" method="post">
				<fieldset>
				<legend>
					Logga in
				</legend>
				<p>Användarnamn <br>
				<input type="text" name="username" value=""></p>
				<p>Lösenord <br>
				<input type="password" name="password" value=""></p>
				<p><input type="submit" value="Logga in"></p>
				</fieldset>
			</form>
			<p><a href="source.php">Källkod</a></p>
		</aside>
		<article><?php echo $mess;

		// skriver ut blogginläggen
		echo $output;

		// Används för att visa vad som kommer från databaasen i testsyfte
		// echo "<hr><pre>";
		// var_dump($res);
		// echo "</pre>";
		?>

		</article>
		<footer>Skapad av Andreas Chammas</footer>
	</main>
</body>
</html>
