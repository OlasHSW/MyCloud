<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
<head>
    <title>Wojciechowski</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<BODY>
    <?php //declare(strict_types=1); // włączenie typowania zmiennych w PHP >=7
    session_start(); // zapewnia dostęp do zmienny sesyjnych w danym pliku
    if (!isset($_SESSION['loggedin']))
    {
        header('Refresh:0; url=logowanie.php');
        exit();
    }
    echo "Jesteś zalogowany";
    ?>
    <br />
    <a href ="showgeodb.php">Historia logowań</a><br />
    <a href ="index1.php">Posty</a><br />
    <br /><br />
    <a href ="logout.php">Wyloguj</a><br />
</BODY>
</HTML>