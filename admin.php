<?php
//läs in check_login.php
require('check_login.php');

$mess = isset($_GET['mess']) ? "<p class='mess'>".$_GET['mess']."</p>" : "";

//läser in datakoppling
require_once('dbConn.php');

//bygger upp sql satsen och hämtar ruslutat ifrån databasen
$sql = "SELECT p.postId, p.title, p.content, p.dateTime, u.fullName, p.active
FROM post as p INNER JOIN user as u ON u.userId = p.userId;";
$stm = $pdo->prepare($sql);
$stm->execute();
$res = $stm->fetchAll(PDO::FETCH_ASSOC);


$output = "<h2>Alla inlägg</h2><table>";
$output .= "<tr><th>inlägg</th><th>författare</th><th>Datum</th><th>Aktiv</th></tr>";




foreach ($res as $row) {
$output .= "<tr>";
$postId = $row['postId'];
$output .= "<td><a href='editPost.php?postId=$postId'>".$row['title']."</a></td>";
$output .= "<td class='center'>".$row['fullName']."</td>";
$output .= "<td  class='center'>".$row['dateTime']."</td>";
$output .= "<td class='center'>".$row['active']."</td>";
$output .= "</tr>";
}
$output .="</table>";

//    echo "<pre>";
//print_r(get_defined_vars());
//echo "</pre>";
//exit;

?>

<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css" type="text/css">
    <title>Adminsystemet</title>
</head>
<body>
    <main>
    <header>Inloggad användare: <?php echo $_SESSION['username'];?></header>
    <aside>
        <p><a href="logout.php">Logga ut</a></p>
        </aside>
        <article>
        <?php echo $mess;?>
        <h2>Skapa ett inlägg</h2>
        <form action="insertPost.php" method="post">
            <fieldset>
                <p><strong>Rubrik</strong><br>
                <input type="text" name="title" required> </p>
                <p><strong>Inlägg</strong><br>
                <textarea name="content" cols="80" rows="20"                required></textarea></p>
                <p><input type="submit" value="Lagra"></p>
            </fieldset>
            </form>
        <?php
        // listar blogginläggen
            echo $output;
        ?>
        </article>
        <footer>Skapad av Andreas Chammas</footer>
    </main>
</body>
</html>
