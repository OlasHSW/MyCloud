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
        header('Refresh:0; url=logowanie.php');
        exit();
    }
    $user = $_SESSION['username'];
    $link = mysqli_connect('sql303.infinityfree.com', 'if0_34773873', 'HaxC1Htjx2epk', 'if0_34773873_z4');
    if(!$link) { echo"Błąd: ". mysqli_connect_errno()." ".mysqli_connect_error(); }
    mysqli_query($link, "SET NAMES 'utf8'");
    $folder = mysqli_query($link, "SELECT user_directory FROM users WHERE username='$user'");
    echo "<b>Jesteś zalogowany" . "<br/>" . "Oto Twoja lista katalogów i plików:" . "</b><br/>";
    $row = mysqli_fetch_assoc($folder);
    $user_directory = $row['user_directory'];
    $directories = [];
    $files = [];
    if (is_dir($user_directory)) {
        if ($dh = opendir($user_directory)) {
            while (($file = readdir($dh)) !== false) {
                if ($file != "." && $file != "..") {
                    $filePath = $user_directory . '/' . $file;
                    if (is_dir($filePath)) {
                        $directories[] = $file;
                    } else {
                        $files[] = $file;
                    }
                }
            }
            closedir($dh);
        } else {
            echo "Nie udało się otworzyć katalogu.";
        }
    } else {
        echo "Katalog macierzysty nie istnieje.";
    }
    sort($directories);
    sort($files);
    foreach ($directories as $dir) {
        $dirPath = $user_directory . '/' . $dir;
        echo "<a href='view_directory.php?directory=$dir'>$dir</a>";
        echo "<a href='delete.php?path=$dirPath'><img src='delete_icon.png' alt='Usuń' style='width: auto; height: 16px;'></a><br>";
    }
    foreach ($files as $file) {
        $filePath = $user_directory . '/' . $file;
        echo "<a href='view_file.php?file=$filePath'>$file</a>";
        echo "<a href='delete.php?path=$filePath'><img src='delete_icon.png' alt='Usuń' style='width: auto; height: 16px;'></a>";
        echo "<a href='$filePath' download='$file'><img src='download_icon.png' alt='Pobierz' style='width: auto; height: 16px;'></a><br>";
    }
    ?>
    <br/><form id="createDirForm">
    <input type="text" id="dirName" required>
    <button type="submit">Stwórz Katalog</button>
    </form>
    <form action="upload_handler.php" method="post" enctype="multipart/form-data">
    Przesyłanie: <br/>
    <input type="file" name="uploaded_file" id="uploaded_file" accept=".txt, .jpg, .png, .gif, .pdf, .docx, .doc, .mp3, .wav, .mp4">
    <input type="hidden" name="current_directory" value="<?php echo $user_directory; ?>"><br/>
    <input type="submit" value="Prześlij Plik" name="submit">
    </form>
    <br/><a href ="logout.php">Wyloguj</a><br/>
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