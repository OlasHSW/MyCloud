<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
<head>
    <title>Wojciechowski</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<BODY>
    <?php
    session_start();
    $user = $_SESSION['username'];
    $link = mysqli_connect('sql303.infinityfree.com', 'if0_34773873', 'HaxC1Htjx2epk', 'if0_34773873_z4');
    if(!$link) { echo"Błąd: ". mysqli_connect_errno()." ".mysqli_connect_error(); }
    mysqli_query($link, "SET NAMES 'utf8'");
    $break = mysqli_query($link, "SELECT * FROM break_ins WHERE username='$user' AND showed='Nie'");
    echo "<span style='color: red;'>Wykrytko nieudane logowanie!</span><br>";
    while ($row = mysqli_fetch_assoc($break)) {
        echo "<span style='color: red;'>Godzina próby logowania: " . $row['datetime'] . ", Adress IP: " . $row['ipaddress'] . "</span><br>";
        $id = $row['idb']; // Załóżmy, że id jest przechowywane w kolumnie 'id'
        $updateQuery = "UPDATE break_ins SET showed='Tak' WHERE idb=$id"; // Zamień 'tabela' na nazwę Twojej tabeli
        mysqli_query($link, $updateQuery);
    }
    ?>
    <br />
    <a href ="sesja.php">OK</a><br />
</BODY>
</HTML>