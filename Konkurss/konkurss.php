<?php
require('conf.php');
session_start();
if (!isset($_SESSION['tuvastamine'])) {
    header('Location: loginAB.php');
    exit();
}

global $yhendus;
// punktide lisamine UPDATE
if(isset($_REQUEST['punkt'])){
    $kask=$yhendus->prepare("
UPDATE konkurss SET punktid=punktid+1 WHERE id=?");
    $kask->bind_param("i", $_REQUEST['punkt']);
    $kask->execute();
    header("Location: $_SERVER[PHP_SELF]");
}
//uue kommentaari lisamine
if(isset($_REQUEST['uus_komment'])){
    $kask=$yhendus->prepare("
UPDATE konkurss SET kommentaar=CONCAT(kommentaar, ?) WHERE id=?");
    $kommentlisa=$_REQUEST['komment']."\n";
    $kask->bind_param("si",$kommentlisa, $_REQUEST['uus_komment']);
    $kask->execute();
    header("Location: $_SERVER[PHP_SELF]");
}
?>
<!Doctype html>
<html lang="et">
<head>
    <title>Fotokonkurss</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<form action="logout.php" method="post">
    <input type="submit" value=" Logi välja" name="logout" class="b1">
    <br><br>
</form>
<nav>
    <a href="haldus.php">Administreerimise leht</a>
    <a href="konkurss.php">Kasutaja leht</a>
    <a href="https://github.com/Danil-Akulin/konkurss">Git - Hub</a>
</nav>
<h1>Fotokonkurss ""</h1>
<?php
// tabeli konkurss sisu näitamine
$kask=$yhendus->prepare("
SELECT id, nimi, pilt, kommentaar, punktid FROM konkurss WHERE avalik=1");
$kask->bind_result($id, $nimi, $pilt, $kommentaar, $punktid);
$kask->execute();
echo "<table><tr><th>Nimi</th>
<th>Pilt</th>
<th>Kommentaarid</th>
<th>Punktid</th></tr>";

while($kask->fetch()){
    echo "<tr><td>$nimi</td>";
    echo "<td><img src='$pilt' alt='pilt'></td>";
    echo "<td>".nl2br($kommentaar)."</td>";
    echo "<td>
    <form action='?'>
        <input type='hidden' name='uus_komment' value='$id'>
        <input type='text' name='komment'>
        <input type='submit' value='OK'>
</form></td>";
    echo "<td>$punktid</td>";
    echo "<td><a href='?punkt=$id'>+1punkt</a></td>";
    echo "</tr>";
}
echo "<table>";
?>

</body>
</html>

