<?php
$serverinimi='localhost';
$kasutajanimi='danil2';
$parool='123456';
$andmebaasinimi='danilakulin';
$yhendus=new mysqli($serverinimi, $kasutajanimi, $parool, $andmebaasinimi);
$yhendus->set_charset('utf8');
/*CREATE TABLE konkurss(
    id int primary key AUTO_INCREMENT,
    nimi varchar(50),
    pilt text,
    lisamisaeg datetime,
    punktid int default 0,
    kommentaar text,
    avalik int default 1)*/
?>