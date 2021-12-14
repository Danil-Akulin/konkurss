<?php
require_once ('conf.php');
global $yhendus;
// punktid nulliks UPDATE
if(isset($_REQUEST['punkt'])){
    $kask=$yhendus->prepare("
UPDATE konkurss SET punktid=0 WHERE id=?");
    $kask->bind_param("i", $_REQUEST['punkt']);
    $kask->execute();
    header("Location: $_SERVER[PHP_SELF]");
}

//nimi lisamine konkurssi
if(!empty($_REQUEST['nimi'])){
    $kask=$yhendus->prepare("
INSERT INTO konkurss(nimi, pilt, lisamisaeg)
VALUES (?, ?, NOW())");
    $kask->bind_param("ss", $_REQUEST['nimi'], $_REQUEST['pilt']);
    $kask->execute();
    header("Location: $_SERVER[PHP_SELF]");
}
// nimi näitamine avalik=1 UPDATE
if(isset($_REQUEST['avamine'])){
    $kask=$yhendus->prepare("
UPDATE konkurss SET avalik=1 WHERE id=?");
    $kask->bind_param("i", $_REQUEST['avamine']);
    $kask->execute();
    }
// nimi peitmine avalik=0 UPDATE
if(isset($_REQUEST['peitmine'])){
    $kask=$yhendus->prepare("
UPDATE konkurss SET avalik=0 WHERE id=?");
    $kask->bind_param("i", $_REQUEST['peitmine']);
    $kask->execute();
}
// kustutamine
if(isset($_REQUEST['kustuta'])){
    $kask=$yhendus->prepare("
DELETE FROM konkurss WHERE id=?");
    $kask->bind_param("i", $_REQUEST['kustuta']);
    $kask->execute();
}



?>
<!Doctype html>
<html lang="et">
<head>
    <title>Fotokonkurssi halduse leht </title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<form action="logout.php" method="post">
    <input type="submit" value=" Logi välja" name="logout" class="b1">
    <br><br>
</form>
<h2>Uue pilti lisamine konkurssi</h2>
<form action="?">
    <input type="text" name="nimi" placeholder="Uus nimi">
    <br>
    <textarea name="pilt">Pildi linki aadress</textarea>
    <br>
    <input type="submit" value="Lisa">
</form>
<br><br>
<nav>
    <a href="haldus.php">Administreerimise leht</a>
    <a href="konkurss.php">Kasutaja leht</a>
    <a href="https://github.com/Danil-Akulin/konkurss">Git - Hub</a>
</nav>
<h1>Fotokonkurssi halduseleht</h1>
<?php
// tabeli konkurss sisu näitamine
$kask=$yhendus->prepare("
SELECT id, nimi, pilt, lisamisaeg, punktid, avalik FROM konkurss");
$kask->bind_result($id, $nimi, $pilt, $aeg, $punktid, $avalik,);
$kask->execute();
echo "<table>";
echo "<tr>
        <th>Status</th>
        <th>ID</th>
        <th>Nimi</th>
        <th>Lisamis Aeg</th>
        <th>Pilt</th>
        <th>Kommenataar</th>
        <th>Punktikd</th>
        <th>Tegevused</th>
</tr>";
///



///
while($kask->fetch()){

    $avatekst="Ava";
    $param="avamine";
    $seisund="Peidetud";
    if ($avalik==1){
        $avatekst="Peida";
        $param="peitmine";
        $seisund="Avatud";
    }
    $txt='"Kas sa tahad kustutada seda fotod"';
    echo "<tr>";
    echo "<td>$seisund<br>";
    echo "<a href='?$param=$id'>$avatekst</a><br>";
    echo "<a href='?kustuta=$id' onclick='return confirm($txt)'>Kustuta</a></td>";
    echo "<td>$id</td>";
    echo "<td>$nimi</td>";
    echo "<td>$aeg</td>";
    echo "<td><img src='$pilt' alt='pilt'></td>";
    //echo "<td>$kom</td>";
    echo "<td>$punktid</td>";
    echo "<td><a href='?punkt=$id'>Nullita punktid</a><br>";

    echo "</tr>";
}
echo "<table>";
?>


</body>
</html>


