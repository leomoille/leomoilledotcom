<?php

require('model/frontend.php');

function auth($mail, $password)
{
    checkAuth($mail, $password);
}

function listPosts($twig)
{
    $articles = getLastPosts();
    echo $twig->render('frontend/indexView.twig', ['articles' => $articles]);
}

function post($twig)
{
    $article  = getPost($_GET['id']);
    $comments = getComments($_GET['id']);
    echo $twig->render('frontend/postView.twig', ['comments' => $comments, 'article' => $article]);
}

function blog($twig)
{
    $articles = getPosts();
    echo $twig->render('frontend/blogView.twig', ['articles' => $articles]);
}

function connexion($twig)
{
    echo $twig->render('frontend/loginView.twig');
}

function manageAccount($twig)
{
    echo $twig->render('backoffice/manageAccountView.twig');
}

function manageSite($twig)
{
    echo $twig->render('backoffice/manageSiteView.twig');
}
