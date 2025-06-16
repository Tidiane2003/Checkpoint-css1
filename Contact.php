<?php
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  echo json_encode(['success' => false, 'message' => 'Méthode invalide.']);
  exit;
}

$name = htmlspecialchars($_POST['name'] ?? '');
$email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
$destination = htmlspecialchars($_POST['destination'] ?? '');
$message = htmlspecialchars($_POST['message'] ?? '');

if (empty($name) || !filter_var($email, FILTER_VALIDATE_EMAIL) || empty($message)) {
  echo json_encode(['success' => false, 'message' => 'Veuillez remplir tous les champs correctement.']);
  exit;
}

// Configure ton adresse ici :
$to = 'mbowtidiane013@gmail.com';
$subject = "Contact - DakarUniversAgence";
$body = "Nom : $name\nDestination : $destination\nE‑mail : $email\n\nMessage :\n$message";
$headers = "From: $email\r\nReply-To: $email";

$sent = mail($to, $subject, $body, $headers);

if ($sent) {
  echo json_encode(['success' => true, 'message' => 'Message envoyé avec succès !']);
} else {
  echo json_encode(['success' => false, 'message' => 'Échec de l’envoi. Réessayez.']);
}
