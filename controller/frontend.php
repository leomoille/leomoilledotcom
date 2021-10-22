<?php

require_once('model/PostManager.php');
require_once('model/CommentManager.php');
require_once('model/AccountManager.php');

use App\Model\AccountManager;
use App\Model\CommentManager;
use App\Model\PostManager;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Affichage de la page d'accueil
 * contenant les derniers articles
 *
 * @param $twig Environment Display view
 *
 * @throws Exception
 */
function home(Environment $twig)
{
    $postManager = new PostManager();
    $posts       = $postManager->getLastsPosts();
    try {
        echo $twig->render('frontoffice/indexView.twig', ['posts' => $posts, 'session' => $_SESSION]);
    } catch (LoaderError | RuntimeError | SyntaxError $e) {
        throw new Exception($e);
    }
}

/**
 * Affichage de la page du blog
 * contenant tous les articles
 *
 * @param $twig Environment Display view
 *
 * @throws Exception
 */
function blog(Environment $twig)
{
    $postManager = new PostManager();
    $posts       = $postManager->getPosts();
    try {
        echo $twig->render('frontoffice/blogView.twig', ['posts' => $posts, 'session' => $_SESSION]);
    } catch (LoaderError | RuntimeError | SyntaxError $e) {
        throw new Exception($e);
    }
}

/**
 * Affichage de la page d'un article
 *
 * @param $twig Environment Display view
 *
 * @throws Exception
 */
function post(Environment $twig)
{
    $postManager    = new PostManager();
    $commentManager = new CommentManager();
    $post           = $postManager->getPost($_GET['id']);
    $comments       = $commentManager->getComments($_GET['id']);
    try {
        echo $twig->render(
            'frontoffice/postView.twig',
            ['comments' => $comments, 'post' => $post, 'session' => $_SESSION]
        );
    } catch (LoaderError | RuntimeError | SyntaxError $e) {
        throw new Exception($e);
    }
}

/**
 * @throws Exception
 */
function addPost($title, $pre_content, $content)
{
    $postManager   = new PostManager();
    $affectedLines = $postManager->addPost($title, $pre_content, $content);
    if ($affectedLines === false) {
        throw new Exception('Impossible d\'ajouter le commentaire !');
    } else {
        header('Location: index.php');
    }
}

// TODO: MAKE PUBLISH COMMENTS WORK
/**
 * Ajout d'un nouveau commentaire
 *
 * @param $postId int ID de la publication
 * @param $author string Auteur du commentaire
 * @param $comment string Texte du commentaire
 *
 * @throws Exception
 */
function addComment(int $postId, string $author, string $comment)
{
    $commentManager = new CommentManager();
    $affectedLines  = $commentManager->postComment($postId, $author, $comment);
    if ($affectedLines === false) {
        throw new Exception('Impossible d\'ajouter le commentaire !');
    } else {
        header('Location: index.php?page=post&id=' . $postId);
    }
}

/**
 * Affichage de la page de connexion/inscription
 *
 * @param $twig Environment Display view
 *
 * @throws Exception
 */
function connexion(Environment $twig)
{
    try {
        echo $twig->render('frontoffice/loginView.twig', ['session' => $_SESSION]);
    } catch (LoaderError | RuntimeError | SyntaxError $e) {
        throw new Exception($e);
    }
}

/**
 * Signup to the blog
 *
 * @throws Exception
 */
function signupAccount(string $name, string $email, string $emailCheck, string $password, string $passwordCheck)
{
    $accountManager = new AccountManager();
    if ($email !== $emailCheck || $password !== $passwordCheck) {
        throw new Exception('Vérifiez votre saisie');
    } else {
        $accountManager->signup($name, $email, $password);
        // TODO: AUTO LOGIN AFTER ACCOUNT SUCCESSFULLY CREATED
        header('Location: index.php');
    }
}

/**
 * @throws Exception
 */
function loginAccount(string $email, string $password)
{
    $accountManager = new AccountManager();
    $accountManager->login($email, $password);
    header('Location: index.php');
}

function logoutAccount()
{
    $accountManager = new AccountManager();
    $accountManager->logout();
    header('Location: index.php');
}

/**
 * Affichage de la page de gestion du compte
 *
 * @param $twig Environment Display view
 *
 * @throws Exception
 */
function manageAccount(Environment $twig)
{
    try {
        echo $twig->render('backoffice/manageAccountView.twig', ['session' => $_SESSION]);
    } catch (LoaderError | RuntimeError | SyntaxError $e) {
        throw new Exception($e);
    }
}

/**
 * Affichage de la page de gestion du site
 *
 * @param $twig Environment Display view
 *
 * @throws Exception
 */
function manageSite(Environment $twig)
{
    try {
        echo $twig->render('backoffice/manageSiteView.twig', ['session' => $_SESSION]);
    } catch (LoaderError | RuntimeError | SyntaxError $e) {
        throw new Exception($e);
    }
}
