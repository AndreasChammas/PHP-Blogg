<?php

//läser in databaskopplingen
require_once('dbConn.php');

//Tar hand om eventuellt meddelande till sidan
$mess = isset($_GET['mess']) ? "<p class='mess'>".$_GET['mess']."</p>" : "";

//ta hand om postId
$postId = $_GET['postId'];

// Bygger upp SQL-satsen och hämtar resultatet från databasen
$sql = " SELECT p.title, p.content, p.dateTime, u.fullName FROM post as p INNER JOIN user as u ON u.userId = p.userId WHERE p.active = 1 AND p.postId = :postId;";
$stm = $pdo->prepare($sql);
$stm->execute(array('postId' => $postId));
$row = $stm->fetch(PDO::FETCH_ASSOC);

//Skapar en variabel för att skriva ut alla bloggposter
$output = "";
//Looper igenom resultatet och bygger utskrift
//foreach ($res as $row) {
    $output .= "<div>";
    $output .= "<h2>".$row['title']."</h2>";
    $output .= "<p>".nl2br($row['content'])."</p>";  // nl2br - ny rad -> <br>
    $output .= "<p><strong>".$row['fullName'].", ".$row['dateTime']."</strong></p>";
//}

$output .= "<h3>Kommentarer</h3>";

// Skapa SQL-sats för alla kommentarer
// Bygger upp SQL-satsen och hämtar resultatet från databasen
$sql = " SELECT content, author, dateTime FROM comment WHERE postId = :postId AND active = 1;";
$stm = $pdo->prepare($sql);
$stm->execute(array('postId' => $postId));
$res = $stm->fetchALL(PDO::FETCH_ASSOC);

// Loopa igenom kommentarer lägg i output
foreach ($res as $row) {
    $output .= "<div>";
    $output .= "<p>".nl2br($row['content'])."</p>";  // nl2br - ny rad -> <br>
    $output .= "<p><strong>".$row['author'].", ".$row['dateTime']."</strong></p>";
    $output .= "</div>";
}

$output .= "<h3>Skriv en kommentar</h3>";

$output .= <<<EOD
<form action="insertComment.php" method="post">
<input type="hidden" name="postId" value="$postId">
<p>Kommentar<br>
<textarea name="content" cols="30" rows="10" required></textarea>
<p>Ditt namn<br>
<input type="text" name="author" required> <br>
<input type="submit" value="Skriv kommentar">

EOD;







?>

<!DOCTYPE html>
<html>
    <head>
         <meta charset="UTF-8">
            <title>
                Blogg
        </title>

            <section>
                </section>
            <head>
    </head>
              <form action="login.php" method="post">
                <fieldset>
                <legend>
                Logga in
                </legend>
                    <p>Användarnamn <br>
                    <input type="text" name="username" value=""></p>
                    <p>Lösernord <br>
                    <input type="password" name="password" value=""></p>
                    <p><input type="submit" name="submit" value="Logga in"></p>
                </fieldset>
              </form>
            <article>
              <?php echo $mess;
                  echo $output;

                  //echo "<pre>";
                  //var_dump($res);
                  //echo "</pre>";
              ?>
            </article>
        </header>
        </div>
    </body>
