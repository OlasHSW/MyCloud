<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
<head>
    <title>Wojciechowski</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<BODY>
    <?php
    session_start();
    function blockLoginForMinute() {
        $_SESSION["login_blocked"] = time() + 60; // Blokada na 1 minutę
        $_SESSION['login_attempts'] = 0; // Zresetuj licznik prób logowania
    }
    function isLoginBlocked() {
        return isset($_SESSION["login_blocked"]) && $_SESSION["login_blocked"] > time();
    }
    $ipaddress = $_SERVER['REMOTE_ADDR'];
    $successful = '';
    $user = htmlentities ($_POST['user'], ENT_QUOTES, "UTF-8"); // rozbrojenie potencjalnej bomby w zmiennej $user
    $pass = htmlentities ($_POST['pass'], ENT_QUOTES, "UTF-8"); // rozbrojenie potencjalnej bomby w zmiennej $pass   
    $link = mysqli_connect('sql303.infinityfree.com', 'if0_34773873', 'HaxC1Htjx2epk', 'if0_34773873_z4'); // połączenie z BD – wpisać swoje dane
    if(!$link) { echo"Błąd: ". mysqli_connect_errno()." ".mysqli_connect_error(); } // obsługa błędu połączenia z BD
    mysqli_query($link, "SET NAMES 'utf8'"); // ustawienie polskich znaków
    $result = mysqli_query($link, "SELECT * FROM users WHERE username='$user'"); // wiersza, w którym login=login z formularza
    $rekord = mysqli_fetch_array($result); // wiersza z BD, struktura zmiennej jak w BD
    $break = mysqli_query($link, "SELECT * FROM break_ins WHERE username='$user' AND showed='Nie'");
    if(!$rekord) /*Jeśli brak, to nie ma użytkownika o podanym loginie*/ {
        mysqli_close($link); // zamknięcie połączenia z BD
        echo "Brak użytkownika o takim loginie !"; // UWAGA nie wyświetlamy takich podpowiedzi dla hakerów
        header('Refresh:2; url=logowanie.php');
    } else {
        if (isLoginBlocked()) {   
            mysqli_close($link);
            echo "Logowanie zablokowane. Spróbuj za chwilę.";
            header('Refresh:2; url=logowanie.php');
            exit;
        } if($rekord['password']==$pass) /*czy hasło zgadza się z BD*/ {
            $_SESSION ['loggedin'] = true;
            $_SESSION['username'] = $user;
            $successful = 'Tak';
            mysqli_query($link,"INSERT INTO goscieportalu (username, successful) VALUES ('$user','$successful')");
            echo "Logowanie Ok. User: {$rekord['username']}. Hasło: {$rekord['password']}";
            if(mysqli_num_rows($break) == 0) {
                header('Refresh:2; url=sesja.php');
            } else {
                header('Refresh:2; url=incorrect_login_message.php');
            }
        } else {
            echo "Błąd w haśle !"; // UWAGA nie wyświetlamy takich podpowiedzi dla hakerów
            $_SESSION['login_attempts'] = isset($_SESSION['login_attempts']) ? $_SESSION['login_attempts'] + 1 : 1;
            if ($_SESSION['login_attempts'] >= 3) {
                blockLoginForMinute();
                mysqli_query($link,"INSERT INTO break_ins (username, ipaddress, showed) VALUES ('$user','$ipaddress','Nie')");
            }
            $successful = 'Nie';
            mysqli_query($link,"INSERT INTO goscieportalu (username, successful) VALUES ('$user','$successful')");
            mysqli_close($link);
            header('Refresh:2; url=logowanie.php');
        }
    }
    ?>
</BODY>
</HTML>