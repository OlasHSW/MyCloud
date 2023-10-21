<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
<head>
    <title>Wojciechowski</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<BODY>
    <?php
    function sprawdzZnaki($user) {
        $znaki = array('"', '\'', '\\', '/', ':', '|', '<', '>', '*', '?');
        foreach ($znaki as $znak) {
            if (strpos($user, $znak) !== false) {
                return true;
            }
        }
        return false;
    }
    $user = htmlentities ($_POST['user'], ENT_QUOTES, "UTF-8"); // rozbrojenie potencjalnej bomby w zmiennej $user
    $pass = htmlentities ($_POST['pass'], ENT_QUOTES, "UTF-8"); // rozbrojenie potencjalnej bomby w zmiennej $pass 
    $pass2 = htmlentities ($_POST['pass2'], ENT_QUOTES, "UTF-8"); // rozbrojenie potencjalnej bomby w zmiennej $pass2  
    $link = mysqli_connect('sql303.infinityfree.com', 'if0_34773873', 'HaxC1Htjx2epk', 'if0_34773873_z4'); // połączenie z BD – wpisać swoje dane
    if(!$link) { echo"Błąd: ". mysqli_connect_errno()." ".mysqli_connect_error(); } // obsługa błędu połączenia z BD
    mysqli_query($link, "SET NAMES 'utf8'"); // ustawienie polskich znaków
    $result = mysqli_query($link, "SELECT * FROM users WHERE username='$user'"); // wiersza, w którym login=login z formularza
    $rekord = mysqli_fetch_array($result); // wiersza z BD, struktura zmiennej jak w BD
    if (sprawdzZnaki($user)) {   
        mysqli_close($link);
        echo "Niedozwolone znaki w nazwie użytkownika!";
        header('Refresh:2; url=rejestruj.php');
        exit;
    }
    if(!$rekord) /*Jeśli brak, to nie ma użytkownika o podanym loginie*/ {
        if($pass==$pass2) /*czy hasło zgadza się z BD*/ {
            // Dodaj nowego użytkownika do bazy danych
            $sql = "INSERT INTO users (username, password) VALUES ('$user', '$pass')";
            if(mysqli_query($link, $sql)) {
                // Utwórz katalog dla użytkownika
                $user_directory = "uploads/$user"; // Tworzymy ścieżkę do katalogu użytkownika
                if (!file_exists($user_directory)) {
                    mkdir($user_directory, 0777, true);
                } // Zapisz ścieżkę do katalogu użytkownika w bazie danych
                $update_user_directory = "UPDATE users SET user_directory='$user_directory' WHERE username='$user'";
                mysqli_query($link, $update_user_directory);
                echo "Rejestracja udana. User: $user. Hasło: $pass";
                header('Refresh:2; url=logowanie.php');
            } else {
                echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
            }
            mysqli_close($link);
        }else {
            mysqli_close($link);
            echo "Podanie hasła nie są takie same!"; // UWAGA nie wyświetlamy takich podpowiedzi dla hakerów
            header('Refresh:2; url=rejestruj.php');
        }
    } else { // jeśli $rekord istnieje
        mysqli_close($link); // zamknięcie połączenia z BD
        echo "Użytkownik o takim loginie już istnieje!"; // UWAGA nie wyświetlamy takich podpowiedzi dla hakerów
        header('Refresh:2; url=rejestruj.php');
    }
    ?>
</BODY>
</HTML>