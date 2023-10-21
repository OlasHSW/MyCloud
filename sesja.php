<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
<head>
    <title>Wojciechowski</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<BODY>
    <?php //declare(strict_types=1); // włączenie typowania zmiennych w PHP >=7
    session_start(); // zapewnia dostęp do zmienny sesyjnych w danym pliku
    if (!isset($_SESSION['username'])) {
        header('Refresh:0; url=logowanie.php');
        exit();
    }
    $user = $_SESSION['username'];
    $link = mysqli_connect('sql303.infinityfree.com', 'if0_34773873', 'HaxC1Htjx2epk', 'if0_34773873_z4');
    if(!$link) { echo"Błąd: ". mysqli_connect_errno()." ".mysqli_connect_error(); }
    mysqli_query($link, "SET NAMES 'utf8'");
    $folder = mysqli_query($link, "SELECT user_directory FROM users WHERE username='$user'");
    echo "Jesteś zalogowany" . "<br/>" . "Oto Twoja lista katalogów i plików:" . "<br/>";
    $row = mysqli_fetch_assoc($folder);
    $user_directory = $row['user_directory'];
    echo "<br />";
    if (is_dir($user_directory)) { /*Otwórz katalog*/
        if ($dh = opendir($user_directory)) { /*Wyświetl pliki i podkatalogi*/
            while (($file = readdir($dh)) !== false) {
                if ($file != "." && $file != "..") {
                    echo "<a href='view_directory.php?directory=$file'>$file</a><br>";
                }
            }
            closedir($dh);
        } else {
            echo "Nie udało się otworzyć katalogu.";
        }
    } else {
        echo "Katalog macierzysty nie istnieje.";
    }
    ?>
    <br /><br />
    <a href ="logout.php">Wyloguj</a><br/>
</BODY>
</HTML>