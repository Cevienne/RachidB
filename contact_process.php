<?php

// Composer Autoloading einbinden
require 'vendor/autoload.php';

// Verwende den Namespace von PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Erstelle eine neue Instanz von PHPMailer
$mail = new PHPMailer(true);

try {
    // SMTP-Einstellungen
    $mail->isSMTP(); // Setze Mailer auf SMTP
    $mail->Host = 'smtp.ionos.de'; // Setze den SMTP-Server
    $mail->SMTPAuth = true; // Aktiviere SMTP-Authentifizierung
    $mail->Username = 'contact@rachidb.de'; // Deine E-Mail-Adresse (für SMTP-Authentifizierung)
    $mail->Password = 'dein_passwort'; // Dein Passwort (für SMTP-Authentifizierung)
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Aktiviere TLS-Verschlüsselung
    $mail->Port = 587; // TCP-Port für TLS

    // Benutzerinformationen aus dem Kontaktformular
    $from = $_REQUEST['email']; // E-Mail des Benutzers
    $name = $_REQUEST['name']; // Name des Benutzers
    $subject = $_REQUEST['subject']; // Betreff des Benutzers
    $cmessage = $_REQUEST['message']; // Nachricht des Benutzers

    // Setze Absender und Empfänger
    $mail->setFrom('contact@rachidb.de', 'Dein Name'); // Setze den Absender (deine eigene E-Mail)
    $mail->addAddress('contact@rachidb.de'); // Empfänger-E-Mail (deine E-Mail-Adresse)

    // Optional: Antwortadresse
    $mail->addReplyTo($from, $name); // Antwortadresse

    // Betreff und Inhalt der E-Mail
    $mail->isHTML(true); // Setze das E-Mail-Format auf HTML
    $mail->Subject = "Neue Nachricht von {$name} - {$subject}"; // Betreff

    // Nachricht aufbauen
    $logo = 'img/logo.png';
    $link = '#';

    $body = "<!DOCTYPE html><html lang='en'><head><meta charset='UTF-8'><title>Express Mail</title></head><body>";
    $body .= "<table style='width: 100%;'>";
    $body .= "<thead style='text-align: center;'><tr><td style='border:none;' colspan='2'>";
    $body .= "<a href='{$link}'><img src='{$logo}' alt=''></a><br><br>";
    $body .= "</td></tr></thead><tbody><tr>";
    $body .= "<td style='border:none;'><strong>Name:</strong> {$name}</td>";
    $body .= "<td style='border:none;'><strong>Email:</strong> {$from}</td>";
    $body .= "</tr>";
    $body .= "<tr><td style='border:none;'><strong>Subject:</strong> {$subject}</td></tr>";
    $body .= "<tr><td></td></tr>";
    $body .= "<tr><td colspan='2' style='border:none;'>{$cmessage}</td></tr>";
    $body .= "</tbody></table>";
    $body .= "</body></html>";

    $mail->Body = $body; // Setze den HTML-Inhalt der E-Mail

    // E-Mail senden
    if ($mail->send()) {
        echo "E-Mail wurde erfolgreich gesendet.";
    } else {
        echo "E-Mail konnte nicht gesendet werden. Fehler: {$mail->ErrorInfo}";
    }
} catch (Exception $e) {
    echo "E-Mail konnte nicht gesendet werden. Fehler: {$mail->ErrorInfo}";
}
?>
