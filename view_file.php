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
    // Pobierz ścieżkę do pliku z parametru w URL
    $file = $_GET['file'];
    // Sprawdź, czy plik istnieje
    if (file_exists($file)) {
        // Sprawdź rozszerzenie pliku
        $fileExtension = pathinfo($file, PATHINFO_EXTENSION);
        // Definiuj typy obsługiwanych plików
        $textExtensions = array('txt');
        $imageExtensions = array('jpg', 'png', 'gif');
        $pdfExtensions = array('pdf');
        $wordExtensions = array('docx', 'doc');
        $audioExtensions = array('mp3', 'wav');
        $videoExtensions = array('mp4');
        // Sprawdź typ pliku i wyświetl odpowiednio
        if (in_array($fileExtension, $textExtensions)) {
            // Plik tekstowy
            $content = file_get_contents($file);
            echo "<pre>$content</pre>";
        } elseif (in_array($fileExtension, $imageExtensions)) {
            // Obraz
            echo "<img src='$file' alt='Obraz'>";
        } elseif (in_array($fileExtension, $pdfExtensions)) {
            // PDF
            header('Content-type: application/pdf');
            readfile($file);
        } elseif (in_array($fileExtension, $wordExtensions)) {
            // Dokument Word
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.basename($file).'"');
            readfile($file);
        } elseif (in_array($fileExtension, $audioExtensions)) {
            // Plik dźwiękowy
            //header('Content-type: audio/mpeg'); // Dla mp3
            // header('Content-type: audio/wav'); // Dla wav
            print "<TR><TD><audio controls ><source src=\"$file\" type=\"audio/$fileExtension\"></audio></TD></TR>\n";
            //readfile($file);
        } elseif (in_array($fileExtension, $videoExtensions)) {
            // Plik wideo
            //header('Content-type: video/mp4');
            print "<TR><TD><video controls height=\"480\" muted><source src=\"$file\" type=\"video/$fileExtension\"><a href=\"$file\">$fileExtension</a></video></TD></TR>\n";
            //readfile($file);
        } else {
            echo "Nieobsługiwany typ pliku.";
        }
    } else {
        echo "Plik nie istnieje.";
    }
    ?>
    <br/><br/><a href ="javascript:history.back()">Powrót do katalogu</a><br/>
</BODY>
</HTML>