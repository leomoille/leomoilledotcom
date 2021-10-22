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
        try {
            listPosts($twig);
        } catch (Exception $e) {
            echo $e;
        }
    } elseif ($_GET['action'] == 'post') {
        if (isset($_GET['id']) && $_GET['id'] > 0) {
            try {
                post($twig);
            } catch (Exception $e) {
                echo $e;
            }
        } else {
            echo 'Erreur : aucun identifiant de billet envoyé';
        }
    } elseif ($_GET['action'] == 'blog') {
        try {
            blog($twig);
        } catch (Exception $e) {
            echo $e;
        }
    } elseif ($_GET['action'] == 'connexion') {
        try {
            connexion($twig);
        } catch (Exception $e) {
            echo $e;
        }
    } elseif ($_GET['action'] == 'account') {
        try {
            manageAccount($twig);
        } catch (Exception $e) {
            echo $e;
        }
    } elseif ($_GET['action'] == 'manage') {
        try {
            manageSite($twig);
        } catch (Exception $e) {
            echo $e;
        }
    } else {
        try {
            listPosts($twig);
        } catch (Exception $e) {
            echo $e;
        }
    }
} else {
    try {
        listPosts($twig);
    } catch (Exception $e) {
        echo $e;
    }
}
