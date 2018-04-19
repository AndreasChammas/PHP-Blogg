<?php
// dbConn.php
# Variabler
if(strcmp($_SERVER['SERVER_NAME'], "localhost") ==0){
    $host = "localhost";  // Den server där databasen ligger
    $user = "root";       // Ditt användarnamn
    $pwd  = "root";       // Ditt lösenord
    $db   = "blog";       // Databasen vi vill jobba mot

}else{
    $host = "blog-218682.mysql.binero.se";  // Den server där databasen ligger
    $user = "218682_uf85641";       // Ditt användarnamn
    $pwd  = "19980716";       // Ditt lösenord
    $db   = "218682-blog";       // Databasen vi vill jobba mot
    # url: https://application-218682.mysql.binero.se
}


    # dsn - data source name
$dsn = "mysql:host=".$host.";dbname=".$db;

# Inställningar som körs när objektet skapas
$options  = array(
  PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'",
  PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_EMULATE_PREPARES, false);

# Skapa objektet eller kasta ett fel
try {
  $pdo = new PDO($dsn, $user, $pwd, $options);
}
catch(Exception $e) {
    die('Could not connect to the database:<br/>'.$e);
}
?>
