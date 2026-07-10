<?php
// Sécurité : n'accepter que les requêtes POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: contact.html');
    exit;
}

// Honeypot anti-spam
if (!empty($_POST['website'])) {
    exit;
}

// Nettoyage des données
function clean($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

$nom       = clean($_POST['Nom'] ?? '');
$prenom    = clean($_POST['Prénom'] ?? '');
$email     = filter_var($_POST['Email'] ?? '', FILTER_SANITIZE_EMAIL);
$telephone = clean($_POST['Téléphone'] ?? '');
$ville     = clean($_POST['Ville'] ?? '');
$type      = clean($_POST['Type'] ?? '');
$message   = nl2br(clean($_POST['Message'] ?? ''));

// Validation
if (empty($nom) || empty($prenom) || empty($email) || empty($message)) {
    header('Location: contact.html?erreur=champs-manquants');
    exit;
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('Location: contact.html?erreur=email-invalide');
    exit;
}

$destinataire = 'contact@xpertise-depannage.fr';
$sujet        = '=?UTF-8?B?' . base64_encode('[Xpertise Dépannage] Nouvelle demande — ' . $type . ' — ' . $ville) . '?=';
$date         = date('d/m/Y à H:i');

// Email HTML
$html = '<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body style="margin:0;padding:0;background:#f5f5f5;font-family:Arial,sans-serif;">
  <table width="100%" cellpadding="0" cellspacing="0" style="background:#f5f5f5;padding:30px 0;">
    <tr><td align="center">
      <table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff;border-radius:8px;overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,0.08);">

        <!-- En-tête -->
        <tr>
          <td style="background:#1A2E4A;padding:24px 32px;">
            <p style="margin:0;color:#ffffff;font-size:20px;font-weight:bold;letter-spacing:1px;">
              XPERTISE <span style="color:#E05C30;">DÉPANNAGE</span>
            </p>
            <p style="margin:4px 0 0;color:#aab4c0;font-size:13px;">Nouvelle demande de contact</p>
          </td>
        </tr>

        <!-- Bandeau type intervention -->
        <tr>
          <td style="background:#E05C30;padding:12px 32px;">
            <p style="margin:0;color:#ffffff;font-size:15px;font-weight:bold;">
              🔧 ' . $type . ' — ' . $ville . '
            </p>
          </td>
        </tr>

        <!-- Contenu -->
        <tr>
          <td style="padding:32px;">

            <table width="100%" cellpadding="0" cellspacing="0">
              <tr>
                <td style="padding-bottom:20px;">
                  <p style="margin:0 0 16px;font-size:15px;color:#333;font-weight:bold;">Coordonnées du demandeur</p>
                  <table width="100%" cellpadding="6" cellspacing="0" style="border-collapse:collapse;">
                    <tr style="background:#f9f9f9;">
                      <td style="padding:10px 14px;color:#666;font-size:14px;width:130px;border-bottom:1px solid #eee;">Nom</td>
                      <td style="padding:10px 14px;color:#222;font-size:14px;font-weight:bold;border-bottom:1px solid #eee;">' . $nom . ' ' . $prenom . '</td>
                    </tr>
                    <tr>
                      <td style="padding:10px 14px;color:#666;font-size:14px;border-bottom:1px solid #eee;">Email</td>
                      <td style="padding:10px 14px;font-size:14px;border-bottom:1px solid #eee;"><a href="mailto:' . $email . '" style="color:#E05C30;">' . $email . '</a></td>
                    </tr>
                    <tr style="background:#f9f9f9;">
                      <td style="padding:10px 14px;color:#666;font-size:14px;border-bottom:1px solid #eee;">Téléphone</td>
                      <td style="padding:10px 14px;font-size:14px;border-bottom:1px solid #eee;"><a href="tel:' . preg_replace('/\s+/', '', $telephone) . '" style="color:#E05C30;">' . $telephone . '</a></td>
                    </tr>
                    <tr>
                      <td style="padding:10px 14px;color:#666;font-size:14px;">Ville</td>
                      <td style="padding:10px 14px;color:#222;font-size:14px;">' . $ville . '</td>
                    </tr>
                  </table>
                </td>
              </tr>

              <!-- Message -->
              <tr>
                <td>
                  <p style="margin:0 0 10px;font-size:15px;color:#333;font-weight:bold;">Message</p>
                  <div style="background:#f9f9f9;border-left:4px solid #E05C30;padding:16px 20px;border-radius:4px;font-size:14px;color:#444;line-height:1.6;">
                    ' . $message . '
                  </div>
                </td>
              </tr>
            </table>

          </td>
        </tr>

        <!-- Bouton répondre -->
        <tr>
          <td style="padding:0 32px 32px;">
            <a href="mailto:' . $email . '" style="display:inline-block;background:#E05C30;color:#ffffff;text-decoration:none;padding:12px 28px;border-radius:6px;font-size:14px;font-weight:bold;">
              Répondre à ' . $prenom . '
            </a>
          </td>
        </tr>

        <!-- Pied de page -->
        <tr>
          <td style="background:#f0f0f0;padding:16px 32px;border-top:1px solid #e0e0e0;">
            <p style="margin:0;font-size:12px;color:#999;">
              Reçu le ' . $date . ' · Formulaire xpertise-depannage.fr
            </p>
          </td>
        </tr>

      </table>
    </td></tr>
  </table>
</body>
</html>';

// En-têtes MIME HTML
$boundary = md5(time());
$headers  = "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
$headers .= "From: Xpertise Dépannage <contact@xpertise-depannage.fr>\r\n";
$headers .= "Reply-To: $prenom $nom <$email>\r\n";
$headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";

// Envoi
$envoye = mail($destinataire, $sujet, $html, $headers);

if ($envoye) {
    header('Location: contact.html?envoi=ok');
} else {
    header('Location: contact.html?erreur=envoi-echoue');
}
exit;
