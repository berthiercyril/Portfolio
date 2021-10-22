<?php

    ini_set("SMTP","smtp.bbox.fr");
    ini_set("smtp_port",25);

    $entete  = 'MIME-Version: 1.0' . "\r\n";
    $entete .= 'Content-type: text/html; charset=utf-8' . "\r\n";
    $entete .= 'From: ' . $_POST['email'] . "\r\n";

    $message = '<h1>Message envoyé depuis la page Contact de mon Portfolio</h1>
    <p><b>Nom : </b>' . $_POST['nom'] . '<br>
    <b>Email : </b>' . $_POST['email'] . '<br>
    <b>Message : </b>' . $_POST['message'] . '</p>';

    $retour = mail('cyrilberthier69740@laposte.net', $_POST['Objet'], $message, $entete);
    if($retour) {
        $GLOBALS['succes'] = "Votre message a bien été envoyé";
        header('Location: index.html#contact');
    }
    else{
        header('Location: index.html#contact');
    }
?>