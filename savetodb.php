<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
<head>
    <title>Wojciechowski</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<BODY>
    <?php
    $ipaddress = $_SERVER["REMOTE_ADDR"];
    $username = $_POST['user'];
    $link = mysqli_connect('sql303.infinityfree.com', 'if0_34773873', 'HaxC1Htjx2epk', 'if0_34773873_z4');
    if(!$link) { 
        echo "Błąd: " . mysqli_connect_errno() . " " . mysqli_connect_error(); 
        exit();
    }
    mysqli_query($link, "SET NAMES 'utf8'");
    $sql = "INSERT INTO goscieportalu (username, successful) 
            VALUES ('$user','$successful')";
    if(mysqli_query($link, $sql)) {
        echo "Dane zostały pomyślnie zapisane w bazie danych.";
    } else {
        echo "Błąd podczas zapisywania danych: " . mysqli_error($link);
    }
    mysqli_close($link);
?>
</BODY>
</HTML>