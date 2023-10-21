<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
<head>
    <title>Wojciechowski</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<BODY>
    <?php
    session_start(); // zapewnia dostęp do zmienny sesyjnych w danym pliku
    if (isset($_SESSION['loggedin']))
    {
        header('Refresh:0; url=sesja.php');
        exit();
    }
    ?>
Formularz logowania
    <form method="post" action="weryfikuj.php">
        Login:<input type="text" name="user" maxlength="20" size="20"><br>
        Hasło:<input type="password" name="pass" maxlength="20" size="20"><br>
        <input type="submit" value="Zaloguj"/>
    </form>
    <a href ="rejestruj.php">Utwórz konto</a><br />
    <a href =".">Powrót</a><br />
</BODY>
</HTML>