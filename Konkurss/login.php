<?php
require('conf.php');
// login vorm Andmebaasis salvestatud kasutajanimega ja prolliga
session_start();
if (isset($_SESSION['tuvastamine'])) {
    header('Location: konkurss.php');
    exit();
}
//login ja pass kontroll
if (!empty($_POST['login']) && !empty($_POST['pass'])){
    $login=$_POST['login'];
    $pass=$_POST['pass'];
    if ($login=='admin' && $pass=='danil'){
        $_SESSION['tuvastamine']='niilihtne';
        header('Location: konkurss.php');
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="../style/style.css">
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
<h1>Login vorm</h1>
<form action="" method="post">
    Login:
    <input type="text" name="login" placeholder="kasutaja nimi">
    <br>
    Parool:
    <input type="password" name="pass">
    <br>
    <input type="submit" value="Logi sisse">
</form>
<?php

?>
</body>
</html>