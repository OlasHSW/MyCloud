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
    if(isset($_GET['path'])) {
        $path = $_GET['path'];
        if (is_dir($path)) {
            // Jeśli to katalog, usuń jego zawartość
            $files = glob($path . '/*');
            foreach($files as $file) {
                if(is_file($file)) {
                    unlink($file);
                }
            }
            // Usuń pusty katalog
            rmdir($path);
        } elseif (is_file($path)) {
            // Jeśli to plik, usuń go
            unlink($path);
        }
        // Przekieruj użytkownika z powrotem na stronę z listą plików
        echo "<script>window.history.back();</script>";
        exit();
    }
    ?>
</BODY>
</HTML>