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

// Router
if (isset($_GET['page'])) {
    if ($_GET['page'] == 'home') { // Home page
        try {
            home($twig);
        } catch (Exception $e) {
            echo $e;
        }
    } elseif ($_GET['page'] == 'post') { // Single post page
        if (isset($_GET['id']) && $_GET['id'] > 0) {
            try {
                post($twig);
            } catch (Exception $e) {
                echo $e;
            }
        } else {
            echo 'Erreur : aucun identifiant de billet envoyé';
        }
    } elseif ($_GET['page'] == 'blog') { // Blog page
        try {
            blog($twig);
        } catch (Exception $e) {
            echo $e;
        }
    } elseif ($_GET['page'] == 'connexion') { // Login/SignUp page
        if (!isset($_GET['action'])) {
            try {
                connexion($twig);
            } catch (Exception $e) {
                echo $e;
            }
        }
        if (isset($_GET['action']) && $_GET['action'] == 'login') { // Login action
            $data = $_POST['login'];
            try {
                loginAccount($data['email'], $data['password']);
            } catch (Exception $e) {
                echo $e;
            }
        } elseif (isset($_GET['action']) && $_GET['action'] == 'signup') { // Signup action
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
        }
    } elseif ($_GET['page'] == 'logout') { // Logout action
        logoutAccount();
    } elseif ($_GET['page'] == 'accountManagement') { // Account page
        try {
            manageAccount($twig);
        } catch (Exception $e) {
            echo $e;
        }
    } elseif ($_GET['page'] == 'websiteManagement') { // Administration dashboard
        if (!isset($_GET['action'])) {
            try {
                manageSite($twig);
            } catch (Exception $e) {
                echo $e;
            }
        }
        if (isset($_GET['action']) && $_GET['action'] === 'addPost') {
            $data = $_POST['post'];
            try {
                addPost($data['title'], $data['pre_content'], $data['content']);
            } catch (Exception $e) {
                echo $e;
            }
        } elseif (
            (isset($_GET['action']) && $_GET['action'] === 'editPost')
            && (isset($_GET['id']) && $_GET['id'] > 0)
        ) {
            try {
                editPost($twig);
            } catch (Exception $e) {
            }
        } elseif (
            (isset($_GET['action']) && $_GET['action'] === 'updatePost')
            && (isset($_GET['id']) && $_GET['id'] > 0)
        ) {
            try {
                updatePost();
            } catch (Exception $e) {
            }
        } elseif (
            (isset($_GET['action']) && $_GET['action'] === 'deletePost')
            && (isset($_GET['id']) && $_GET['id'] > 0)
        ) {
            try {
                echo 'OK';
                deletePost();
            } catch (Exception $e) {
            }
        }
    } else { // 404 to Home
        try {
            home($twig);
        } catch (Exception $e) {
            echo $e;
        }
    }
} else { // 404 to Home
    try {
        home($twig);
    } catch (Exception $e) {
        echo $e;
    }
}
