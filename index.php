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
    // Home page
    if ($_GET['action'] == 'listPosts') {
        try {
            listPosts($twig);
        } catch (Exception $e) {
            echo $e;
        }
        // Single post
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
        // Blog page
    } elseif ($_GET['action'] == 'blog') {
        try {
            blog($twig);
        } catch (Exception $e) {
            echo $e;
        }
        // Login / Sign Up page
    } elseif ($_GET['action'] == 'connexion') {
        try {
            connexion($twig);
        } catch (Exception $e) {
            echo $e;
        }
        // User sign up
    } elseif ($_GET['action'] == 'signup') {
        $data = $_POST['signup'];
//        echo '<pre>';
//        print_r($data);
//        echo '</pre>';
        try {
            signupAccount(
                $data['name'],
                $data['email'],
                $data['emailCheck'],
                $data['password'],
                $data['passwordCheck']
            );
        } catch (Exception $e) {
            echo $e;
        }
        // User account management page
    } elseif ($_GET['action'] == 'account') {
        try {
            manageAccount($twig);
        } catch (Exception $e) {
            echo $e;
        }
        // Administration page
    } elseif ($_GET['action'] == 'manage') {
        try {
            manageSite($twig);
        } catch (Exception $e) {
            echo $e;
        }
        // No 404 for wrong action, just return Home page
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
