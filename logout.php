<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
<head>
    <title>Wojciechowski</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<BODY>
    <?php
    session_start();
    session_destroy();
    header('Refresh:3; url=logowanie.php');
    echo "Zostaniesz wylogowany w ciągu 3 sekund";
    ?>
</BODY>
</HTML>