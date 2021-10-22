<?php

use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

require('controller/frontend.php');
require('vendor/autoload.php');

session_start();


$loader = new FilesystemLoader('view');
$twig   = new Environment($loader, [
    //    'cache' => 'tmp',
    'debug' => true,
]);
$twig->addExtension(new DebugExtension());

if (isset($_GET['action'])) {
    // Home page
    if ($_GET['action'] == 'home') {
        try {
            home($twig);
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
        // User login
    } elseif ($_GET['action'] == 'login') {
        $data = $_POST['login'];
        try {
            loginAccount($data['email'], $data['password']);
        } catch (Exception $e) {
            echo $e;
        }
        // User logout
    } elseif ($_GET['action'] == 'logout') {
        logoutAccount();
        // User sign up
    } elseif ($_GET['action'] == 'signup') {
        $data = $_POST['signup'];
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
            home($twig);
        } catch (Exception $e) {
            echo $e;
        }
    }
} else {
    try {
        home($twig);
    } catch (Exception $e) {
        echo $e;
    }
}
