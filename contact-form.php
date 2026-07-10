<?php
// Sécurité : n'accepter que les requêtes POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: contact.html');
    exit;
}

// Vérification anti-spam simple (honeypot)
if (!empty($_POST['website'])) {
    exit;
}

// Récupération et nettoyage des données
function clean($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

$nom       = clean($_POST['Nom'] ?? '');
$prenom    = clean($_POST['Prénom'] ?? '');
$email     = filter_var($_POST['Email'] ?? '', FILTER_SANITIZE_EMAIL);
$telephone = clean($_POST['Téléphone'] ?? '');
$ville     = clean($_POST['Ville'] ?? '');
$type      = clean($_POST['Type'] ?? '');
$message   = clean($_POST['Message'] ?? '');

// Validation basique
if (empty($nom) || empty($prenom) || empty($email) || empty($message)) {
    header('Location: contact.html?erreur=champs-manquants');
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('Location: contact.html?erreur=email-invalide');
    exit;
}

// Destinataire
$destinataire = 'contact@xpertise-depannage.fr';
$sujet        = '[Xpertise Dépannage] Nouvelle demande — ' . $type . ' — ' . $ville;

// Corps du mail
$corps = "Nouvelle demande de contact reçue depuis xpertise-depannage.fr\n";
$corps .= "=============================================================\n\n";
$corps .= "Nom       : $nom $prenom\n";
$corps .= "Email     : $email\n";
$corps .= "Téléphone : $telephone\n";
$corps .= "Ville     : $ville\n";
$corps .= "Type      : $type\n\n";
$corps .= "Message :\n$message\n\n";
$corps .= "=============================================================\n";
$corps .= "Envoyé le : " . date('d/m/Y à H:i') . "\n";

// En-têtes
$headers  = "From: noreply@xpertise-depannage.fr\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "X-Mailer: PHP/" . phpversion();

// Envoi
$envoye = mail($destinataire, $sujet, $corps, $headers);

// Redirection selon résultat
if ($envoye) {
    header('Location: contact.html?envoi=ok');
} else {
    header('Location: contact.html?erreur=envoi-echoue');
}
exit;
