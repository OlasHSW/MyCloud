<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
<head>
    <title>Wojciechowski</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<BODY>
    <?php
    session_start();
    if (!isset($_SESSION['username'])) {
        header('Location: logowanie.php');
        exit();
    }
    $user = $_SESSION['username'];
    $link = mysqli_connect('sql303.infinityfree.com', 'if0_34773873', 'HaxC1Htjx2epk', 'if0_34773873_z4');
    if(!$link) { echo"Błąd: ". mysqli_connect_errno()." ".mysqli_connect_error(); }
    mysqli_query($link, "SET NAMES 'utf8'");
    $result = mysqli_query($link, "SELECT user_directory FROM users WHERE username='$user'");
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $parentDirectory = $row['user_directory'];
        // Sprawdź, czy katalog istnieje
        if (is_dir($parentDirectory)) {
            // Sprawdź, czy został przekazany parametr 'directory' w URL
            if (isset($_GET['directory'])) {
                $subDirectory = $_GET['directory'];
                // Utwórz pełną ścieżkę do podkatalogu
                $subDirectoryPath = $parentDirectory . '/' . $subDirectory;
                // Sprawdź, czy podkatalog istnieje
                if (is_dir($subDirectoryPath)) {
                    // Otwórz podkatalog
                    if ($dh = opendir($subDirectoryPath)) {
                        // Wyświetl pliki i podkatalogi
                        while (($file = readdir($dh)) !== false) {
                            if ($file != "." && $file != "..") {
                                echo "<a href='view_directory.php?directory=$subDirectory/$file'>$file</a><br>";
                            }
                        }
                        closedir($dh);
                    } else {
                        echo "Nie udało się otworzyć katalogu.";
                    }
                } else {
                    echo "Podkatalog nie istnieje.";
                }
            } else {
                echo "Brak wybranego podkatalogu.";
            }
        } else {
            echo "Katalog macierzysty nie istnieje.";
        }
    } else {
        echo "Błąd zapytania: " . mysqli_error($link);
    }
    mysqli_close($link);
    ?>
    <br/><form id="createDirForm">
    <input type="text" id="dirName" required>
    <button type="submit">Stwórz Katalog</button>
    </form><br/><a href ="sesja.php">Powrót do głównego katalogu</a><br/>
    <script>
    document.getElementById('createDirForm').addEventListener('submit', function(event) {
        event.preventDefault();
        var dirName = document.getElementById('dirName').value;
        createDirectory(dirName);
    });
    function createDirectory(dirName) {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    alert('Katalog został pomyślnie utworzony.');
                    window.location.reload();
                } else {
                    alert('Wystąpił błąd podczas tworzenia katalogu.');
                }
            }
        };
        xhr.open('POST', 'create_directory.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send('dirName=' + dirName);
    }
</script>
</BODY>
</HTML>