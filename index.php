<?php

use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

require('controller/frontend.php');
require('vendor/autoload.php');

$loader = new FilesystemLoader('view');
$twig   = new Environment($loader, [
//    'cache' => 'tmp',
    'debug' => true,
]);
$twig->addExtension(new DebugExtension());

if (isset($_GET['action'])) {
    if ($_GET['action'] == 'listPosts') {
        listPosts($twig);
    } elseif ($_GET['action'] == 'post') {
        if (isset($_GET['id']) && $_GET['id'] > 0) {
            post($twig);
        } else {
            echo 'Erreur : aucun identifiant de billet envoyé';
        }
    } elseif ($_GET['action'] == 'blog') {
        blog($twig);
    } elseif ($_GET['action'] == 'connexion') {
        connexion($twig);
    } elseif ($_GET['action'] == 'account') {
        manageAccount($twig);
    } elseif ($_GET['action'] == 'manage') {
        manageSite($twig);
    } else {
        listPosts($twig);
    }
} else {
    listPosts($twig);
}
