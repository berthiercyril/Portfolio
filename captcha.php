<?php
ini_set("SMTP","smtp.bbox.fr");
ini_set("smtp_port",25);

// On vérifie que la méthode POST est utilisée
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    // On vérifie si le champ "recaptcha-response" contient une valeur
    if(empty($_POST['recaptcha-response'])){
        header('Location: onepage.html');
    }
    else{
        // On prépare l'URL
        $url = "https://www.google.com/recaptcha/api/siteverify?secret=6Lcm46oaAAAAAPiaaeUQlIvaq3m_yU5_EwpeZFgB&response={$_POST['recaptcha-response']}";

        // On vérifie si curl est installé
        if(function_exists('curl_version')){
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_TIMEOUT, 1);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            $response = curl_exec($curl);
        }else{
            // On utilisera file_get_contents
            $response = file_get_contents($url);
        }

        // On vérifie qu'on a une réponse
        if(empty($response) || is_null($response)){
            header('Location: onepage.html');
        }
        else{
            $entete  = 'MIME-Version: 1.0' . "\r\n";
            $entete .= 'Content-type: text/html; charset=utf-8' . "\r\n";
            $entete .= 'From: ' . $_POST['email'] . "\r\n";

            $message = '<h1>Message envoyé depuis la page Contact de mon Portfolio</h1>
            <p><b>Nom : </b>' . $_POST['nom'] . '<br>
            <b>Email : </b>' . $_POST['email'] . '<br>
            <b>Message : </b>' . $_POST['message'] . '</p>';

            $retour = mail('cyrilberthier69740@laposte.net', $_POST['Objet'], $message, $entete);
            if($retour) {
                echo '<p>Votre message a bien été envoyé.</p>';
            }
        }
    }
}
else{
    http_response_code(405);
    echo 'Méthode non autorisée';
}
?>
