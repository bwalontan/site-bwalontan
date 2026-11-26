<?php
/*
 * Traitement du formulaire de contact — Bwa Lontan
 * Prévu pour un hébergement PHP (o2switch). Envoie la demande à contact@bwalontan.re
 * puis renvoie le visiteur vers la page d'accueil avec un message de confirmation.
 */

$destinataire = 'contact@bwalontan.re';
$expediteur   = 'site@bwalontan.re'; // adresse du domaine, pour éviter le classement en spam

function retour($etat) {
    header('Location: /?envoi=' . $etat . '#contact', true, 303);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    retour('erreur');
}

// Champ piège anti-robots : s'il est rempli, on fait semblant d'avoir réussi.
if (!empty($_POST['site_web'])) {
    retour('ok');
}

function champ($nom, $max = 200) {
    $v = isset($_POST[$nom]) ? trim((string) $_POST[$nom]) : '';
    $v = str_replace(["\r", "\0"], '', $v);
    return mb_substr($v, 0, $max);
}

$nom         = champ('nom');
$structure   = champ('structure');
$email       = champ('email');
$telephone   = champ('telephone', 40);
$type        = champ('type', 30);
$lieu        = champ('lieu');
$message     = champ('message', 5000);
$consentement = !empty($_POST['consentement']);

$types = [
    'conception'     => 'Étude de conception',
    'accompagnement' => 'Suivi et accompagnement',
    'formation'      => 'Formation',
    'groupement'     => 'Appel à projets / groupement',
    'autre'          => 'Autre',
];

if ($nom === '' || $message === '' || !$consentement
    || !filter_var($email, FILTER_VALIDATE_EMAIL)
    || !isset($types[$type])) {
    retour('erreur');
}

// Pas de saut de ligne dans les en-têtes (protection contre l'injection d'en-têtes)
$nom_entete = preg_replace('/[\r\n]+/', ' ', $nom);

$sujet = '[Site] ' . $types[$type] . ' — ' . $nom_entete;
$corps = "Nouvelle demande depuis le site bwalontan.re\n\n"
       . "Type de demande : {$types[$type]}\n"
       . "Nom : {$nom}\n"
       . "Structure : " . ($structure ?: '—') . "\n"
       . "E-mail : {$email}\n"
       . "Téléphone : " . ($telephone ?: '—') . "\n"
       . "Lieu du projet : " . ($lieu ?: '—') . "\n\n"
       . "Message :\n{$message}\n\n"
       . "Consentement au traitement des données : oui\n"
       . "Date : " . date('d/m/Y H:i') . "\n";

$entetes = [
    'From: Site Bwa Lontan <' . $expediteur . '>',
    'Reply-To: ' . $nom_entete . ' <' . $email . '>',
    'Content-Type: text/plain; charset=UTF-8',
    'Content-Transfer-Encoding: 8bit',
];

$ok = mail($destinataire, '=?UTF-8?B?' . base64_encode($sujet) . '?=', $corps, implode("\r\n", $entetes), "-f site@bwalontan.re");

retour($ok ? 'ok' : 'erreur');
