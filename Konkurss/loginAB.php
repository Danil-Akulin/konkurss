<?php
// login vorm Andmebaasis salvestatud kasutajanimega ja prolliga
session_start();
if (isset($_SESSION['tuvastamine'])) {
    header('Location: konkurss.php');
    exit();
}
//kontroll kas login vorm on täidetud?
if (!empty($_POST['login']) && !empty($_POST['pass'])) {
    $login = $_POST['login'];
    $pass = $_POST['pass'];


    $sool = 'vagavagatekst';
    $krypt = crypt($pass, $sool);
    //kontrolline kas andmebaasis on selline kasutaja
    require('conf.php');
    global $yhendus;
    $kask = $yhendus->prepare("SELECT nimi, parool, onAdmin, koduleht
    FROM kasutajad WHERE nimi=? AND parool=?");
    $kask->bind_param("ss", $login, $pass);
    $kask->bind_result($nimi, $onAdmin, $koduleht);
    $kask->execute();
    if ($kask->fetch()) {
        $_SESSION['tuvastamine'] = 'niilihtne';
        $_SESSION['kasutaja'] = $nimi;
        $_SESSION['onAdmin'] = $onAdmin;
        if ($nimi == "kala"){
            header('Location: kala.php');
            exit();
        }
        if (isset($koduleht)) {
            header("Location: $koduleht");
        } else {
            header('Location: konkurss.php');
            exit();
        }
    } else {
        echo "kasutaja $login või parool $pass on vale";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
<h1>Login vorm</h1>
<form action="" method="post">
    Login:
    <label>
        <input type="text" name="login" placeholder="kasutaja nimi">
    </label>
    <br>
    Parool:
    <label>
        <input type="password" name="pass">
    </label>
    <br>
    <input type="submit" value="Logi sisse">
</form>
</body>
</html>
