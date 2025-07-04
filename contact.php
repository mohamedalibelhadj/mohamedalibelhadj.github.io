<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $sujet = strip_tags(trim($_POST["sujet"]));
    $message = trim($_POST["message"]);

    // Vérification des données
    if (empty($name) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo "Veuillez remplir le formulaire correctement.";
        exit;
    }

    // Destinataire
    $recipient = "carteat22@gmail.com";
    
    // Sujet
    $subject = "Nouveau contact de $name: $sujet";

    // Contenu du mail
    $email_content = "Nom: $name\n";
    $email_content .= "Email: $email\n\n";
    $email_content .= "Sujet: $sujet\n\n";
    $email_content .= "Message:\n$message\n";

    // Entêtes
    $email_headers = "From: $name <$email>";

    // Envoi du mail
    if (mail($recipient, $subject, $email_content, $email_headers)) {
        http_response_code(200);
        echo "Merci! Votre message a été envoyé.";
    } else {
        http_response_code(500);
        echo "Oops! Une erreur s'est produite, le message n'a pas pu être envoyé.";
    }
} else {
    http_response_code(403);
    echo "Il y a eu un problème avec votre soumission, veuillez réessayer.";
}
?>