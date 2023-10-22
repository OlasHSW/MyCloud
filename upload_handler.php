<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
<head>
    <title>Wojciechowski</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<BODY>
    <?php
    session_start(); // zapewnia dostęp do zmienny sesyjnych w danym pliku
    if (!isset($_SESSION['username'])) {
        header('Refresh:0; url=logowanie.php');
        exit();
    }
    if(isset($_FILES['uploaded_file']) && isset($_POST['current_directory'])) {
        $errors = [];
        $current_directory = $_POST['current_directory'];
        $file_name = $_FILES['uploaded_file']['name'];
        $file_size = $_FILES['uploaded_file']['size'];
        $file_tmp = $_FILES['uploaded_file']['tmp_name'];
        $file_type = $_FILES['uploaded_file']['type'];
        $file_name_parts = explode('.', $_FILES['uploaded_file']['name']);
        $file_ext = strtolower(end($file_name_parts));
        $allowed_extensions = ['txt', 'jpg', 'png', 'gif', 'pdf', 'docx', 'doc', 'mp3', 'wav', 'mp4']; // Dopuszczalne rozszerzenia
        if(!in_array($file_ext, $allowed_extensions)) {
            $errors[] = "Ten typ pliku nie jest akceptowany. Proszę wybrać plik z rozszerzeniem: " . implode(', ', $allowed_extensions);
            echo "<script>setTimeout(function(){window.history.back();},2000);</script>";
        }
        /*if($file_size > 2097152) {
            $errors[] = 'Rozmiar pliku musi być mniejszy niż 2 MB';
            echo "<script>setTimeout(function(){window.history.back();},2000);</script>";
        }*/
        if(empty($errors) == true) {
            move_uploaded_file($file_tmp, $current_directory . "/" . $file_name);
            echo "Plik został przesłany pomyślnie!";
            echo "<script>setTimeout(function(){window.history.back();},2000); // 2000 milisekund = 2 sekundy </script>";
        } else {
            print_r($errors);
            echo "<script>setTimeout(function(){window.history.back();},5000);</script>";
        }
    }
    ?>
</BODY>
</HTML>