<?php
session_start();
include_once('database.php');
include_once('functies.php');

$tijdLinkGeldig = 14400;

if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])) {
    $masterPW = "test";
    $meegevenHash = $_GET['hash'];
    $email = $_GET['email'];
    $gegevenTijd = hash('sha256',$_GET['tijd']);
    $hash = hash('sha256', $email . $masterPW);
    if($hash == $meegevenHash && time() - $gegevenTijd < $tijdLinkGeldig){
        $_SESSION['Emailadres'] = $email;
        header("Location: http://localhost/EenmaalAndermaal/registratie_pagina.php");
    } elseif(time() - $gegevenTijd > $tijdLinkGeldig){
        $_SESSION['foutmelding'] = "Deze link is niet meer geldig, laat een nieuwe mail naar je versturen";
    }else{
        $_SESSION['foutmelding'] = "De opgegeven link is invalide, gebruik de link die is opgestuurd";
    }
} else{
    $_SESSION['foutmelding'] = "Dit is geen valide adres, gebruik de link die is opgestuurd";
}

?>