<?php
require('conf.php');
// функция, которая удаляет из адресной строки переменные
function clearVarsExcept($url, $varname){
    return strtok(basename($_SERVER['REQUEST_URI']), "?")."?$varname=".$_REQUEST[$varname];
}

global $yhendus;
//lisamine INSERT INTO
if(!empty($_REQUEST['loomanimi'])){
    $kask=$yhendus->prepare('INSERT INTO loomad(nimi, kirjeldus) 
VALUES (?, ?)');
// "s"- string
// $_REQUEST['loomanimi']- запрос в текстовый ящик input name="loomanimi"
    $kask->bind_param("ss", $_REQUEST['loomanimi'], $_REQUEST['kirj']);
    $kask->execute();
// изменяет адресную строку
//$_SERVER[PHP_SELF] - до имени файла
    header("Location:" .basename($_SERVER['REQUEST_URI']));
}

//tabelist kustutamine
if(isset($_REQUEST['kustuta'])){
    $kask=$yhendus->prepare('DELETE FROM loomad WHERE id=?');
    $kask->bind_param("i",$_REQUEST['kustuta']);
    $kask->execute();
}
?>

<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UdTF-8">
    <title>Andmetabelisse andmete lisamine </title>
</head>
<body>
<h1>
    Andmetabeli "Loomad" sisu näitamine
</h1>

<?php
global $yhendus;
// tabeli sisu näitamine
$kask=$yhendus->prepare("SELECT id, nimi, kirjeldus FROM loomad");
$kask->bind_result($id, $nimi, $kirjeldus);
$kask->execute();
echo "<table>";
echo "<tr>
<th>id</th>
<th>Loomanimi</th>
<th>Kirjeldus</th>
<th>Tegevus</th>
</tr>";
//fetch() - извлечение данных из набора данных
while($kask->fetch()){
    echo "<tr>";
    echo "<td>$id</td>";
    echo "<td>$nimi</td>";
    echo "<td>$kirjeldus</td>";
    echo "<td><a href='".clearVarsExcept(basename($_SERVER['REQUEST_URI']), "leht")."&kustuta=$id'>XXX</a></td>";
    echo "</tr>";
}
echo "</table>";
?>

<br><br>

<form action="<?=clearVarsExcept(basename($_SERVER['REQUEST_URI']), 'leht')?>" method="post">
    <label for="loomanimi">Loomanimi</label>
    <input type="text" name="loomanimi" id="loomanimi">
    <br>
    <label for="kirj">Kirjeldus</label>
    <input type="text" name="kirj" id="kirj">
    <br>
    <input type="submit" value="Lisa">
</form>

<?php
$yhendus->close();
?>
</body>
</html>