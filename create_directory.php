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
        http_response_code(403); // Zwracamy 403 Forbidden jeśli użytkownik nie jest zalogowany
        exit();
    }
    $user = $_SESSION['username'];
    $userDirectory = 'uploads/' . $user;
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $dirName = $_POST['dirName'];
        $newDirPath = $userDirectory . '/' . $dirName;
        if (!is_dir($newDirPath)) {
            if (mkdir($newDirPath, 0755, true)) {
                http_response_code(200);
                exit();
            }
        }
    }
    http_response_code(500); // Zwracamy 500 Internal Server Error w przypadku błędu
    ?>
</BODY>
</HTML>