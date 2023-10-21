<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rozdzielczoscEkranu = $_POST['rozdzielczoscEkranu'];
    $rozdzielczoscPrzegladarki = $_POST['rozdzielczoscPrzegladarki'];
    $iloscKolorow = $_POST['iloscKolorow'];
    $cookiesEnabled = $_POST['cookiesEnabled'];
    $javaEnabled = $_POST['javaEnabled'];
    $jezykPrzegladarki = $_POST['jezykPrzegladarki'];
    $ipaddress = $_SERVER["REMOTE_ADDR"];
    function ip_details($ip) {
    $json = file_get_contents ("http://ipinfo.io/{$ip}?token=99a2ba483fc93b");
    $details = json_decode ($json);
    return $details;
    }
    $ua = $_SERVER['HTTP_USER_AGENT'];
    function get_browser_name($user_agent) {
        $browser_name = "Unknown";
        if (preg_match('/MSIE/i', $user_agent) && !preg_match('/Opera/i', $user_agent)) {
            $browser_name = 'Internet Explorer';
        } elseif (preg_match('/Firefox/i', $user_agent)) {
            $browser_name = 'Mozilla Firefox';
        } elseif (preg_match('/Chrome/i', $user_agent)) {
            $browser_name = 'Google Chrome';
        } elseif (preg_match('/Safari/i', $user_agent) && !preg_match('/Chrome/i', $user_agent)) {
            $browser_name = 'Apple Safari';
        } elseif (preg_match('/Opera/i', $user_agent)) {
            $browser_name = 'Opera';
        } elseif (preg_match('/Netscape/i', $user_agent)) {
            $browser_name = 'Netscape';
        }
        return $browser_name;
    }
    $browser = get_browser_name($ua);
    $details = ip_details($ipaddress);
    $link = mysqli_connect('sql303.infinityfree.com', 'if0_34773873', 'HaxC1Htjx2epk', 'if0_34773873_z4');
    if(!$link) { 
        echo "Błąd: " . mysqli_connect_errno() . " " . mysqli_connect_error(); 
        exit();
    }
    mysqli_query($link, "SET NAMES 'utf8'");
    $sql = "INSERT INTO goscieportalu (ipaddress,) 
            VALUES ('$ipaddress',)";
    if(mysqli_query($link, $sql)) {
        echo "Dane zostały pomyślnie zapisane w bazie danych.";
    } else {
        echo "Błąd podczas zapisywania danych: " . mysqli_error($link);
    }
    mysqli_close($link);
}
?>
