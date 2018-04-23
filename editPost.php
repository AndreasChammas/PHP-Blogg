<?php
// läs in check_login.php
require('check_login.php');

require_once('functions.php');

//Ta hand om eventuallt meddelande
$mess = isset($_GET['mess']) ? "<p class='mess'>".$_GET['mess']."</p>" : "";


//variabler
$postId = $_GET['postId'];

require_once('dbConn.php');

$sql =  "SELECT title, content, active FROM post WHERE postId = :postId;";

$stm = $pdo->prepare($sql);
$stm->execute(array('postId' => $postId));
$res = $stm->fetch(PDO::FETCH_ASSOC);

$buttonName = $res['active'] == 1 ? "Inaktivera" : "Aktivera";

//kommentarer
$output = "<h3>Kommentarer</h3>";

// Skapa SQL-sats för alla kommentarer
// Bygger upp SQL-satsen och hämtar resultatet från databasen
$sql = " SELECT commentId, content, author, dateTime, active FROM comment WHERE postId = :postId;";
$stm = $pdo->prepare($sql);
$stm->execute(array('postId' => $postId));
$resComment = $stm->fetchALL(PDO::FETCH_ASSOC);

// Loopa igenom kommentarer lägg i output
foreach ($resComment as $row) {
    //skapa lokala variabler
    $content = nl2br($row['content']);
    $signature = "<p><strong>".$row['author'].", ".$row['dateTime']."</strong></p>";

    $commentId = $row['commentId'];
    $active = $row['active'];
    $commentButtonName = $active == 1 ? "Inaktivera" : "Aktivera";

$output.=<<<EOD
<div>
    $content
    $signature
    <form action="deleteComment.php" method="post">
        <input type="hidden" name="commentId" value="$commentId">
        <input type="hidden" name="active" value="$active">
        <input type="hidden" name="postId" value="$postId">
        <input type="submit" value="$commentButtonName">

    </form>
</div>
EOD;


}



?>
<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <title>Blogg</title>
    </head>
    <body>
    <main>
        <header><a href="admin.php">Inloggad användare:
            <?php echo $_SESSION['username']; ?></a></header>
        <aside>
        </aside>
        <article><?php echo $mess;?>
            <h2>Uppdatera ett inlägg</h2>


<p>Rubrik<br>
<fieldset>
<form action="updatePost.php" method="post" >
<input type="hidden" name="postId" value="<?php echo $postId;?>">
<input type="text" name="title" value="<?php echo $res['title']?>" required>
<p>Inlägg<br>
<textarea name="content" cols="80" rows="20" required><?php echo $res['content']?></textarea>
    <br><input type="submit" value="Uppdatera">
            </form>

            <form action="deletePost.php" method="post">
            <input type="hidden" name="postId" value="<?php echo $postId;?>">
            <input type="hidden" name="active" value="<?php echo $res['active'];?>">
            <input type="submit" value="<?php echo $buttonName; ?>">
            </form>
            <p><a href="logout.php">Logga ut</a></p>
            </fieldset>
            <?php
            echo $output;

            ?>

        </article>
        <footer>Skapad av Andreas Chammas</footer>
        </main>
    </body>
</html>
