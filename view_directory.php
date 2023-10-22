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
    if(!$link) { echo "Błąd: ". mysqli_connect_errno()." ".mysqli_connect_error(); }
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
                    // Pobierz listę katalogów i plików
                    $directories = [];
                    $files = [];
                    if ($dh = opendir($subDirectoryPath)) {
                        while (($file = readdir($dh)) !== false) {
                            if ($file != "." && $file != "..") {
                                $filePath = $subDirectoryPath . '/' . $file;
                                if (is_dir($filePath)) {
                                    $directories[] = $file;
                                } elseif (is_file($filePath)) {
                                    $files[] = $file;
                                }
                            }
                        }
                        closedir($dh);
                    } else {
                        echo "Nie udało się otworzyć katalogu.";
                    }

                    // Sortuj katalogi i pliki alfabetycznie
                    sort($directories);
                    sort($files);

                    // Wyświetl katalogi
                    foreach ($directories as $dir) {
                        $dirPath = $subDirectoryPath . '/' . $dir;
                        echo "<a href='view_directory.php?directory=$dir'>$dir</a>";
                        echo "<a href='delete.php?path=$dirPath'><img src='delete_icon.png' alt='Usuń' style='width: auto; height: 16px;'></a><br>";
                    }

                    // Wyświetl pliki
                    foreach ($files as $file) {
                        $filePath = $subDirectoryPath . '/' . $file;
                        echo "<a href='view_file.php?file=$filePath'>$file</a>";
                        echo "<a href='delete.php?path=$filePath'><img src='delete_icon.png' alt='Usuń' style='width: auto; height: 16px;'></a>";
                        echo "<a href='$filePath' download='$file'><img src='download_icon.png' alt='Pobierz' style='width: auto; height: 16px;'></a><br>";
                    }
                } else {
                    //echo "Podkatalog nie istnieje.";
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
    <br/>
    <form action="upload_handler.php" method="post" enctype="multipart/form-data">
    Przesyłanie: <br/>
    <input type="file" name="uploaded_file" id="uploaded_file" accept=".txt, .jpg, .png, .gif, .pdf, .docx, .doc, .mp3, .wav, .mp4">
    <input type="hidden" name="current_directory" value="<?php echo $subDirectoryPath; ?>"><br/>
    <input type="submit" value="Prześlij Plik" name="submit">
    </form>
    <br/><br/><a href ="sesja.php">Powrót do głównego katalogu</a><br/>
</BODY>
</HTML>