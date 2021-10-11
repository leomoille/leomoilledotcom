<?php

require('model/frontend.php');

function listPosts()
{
    $articles = getPosts();
    require('view/frontend/indexView.php');
}

function post()
{
    $article     = getPost($_GET['id']);
    $comments = getComments($_GET['id']);
    require('view/frontend/postView.php');
}

function blog()
{
    require('view/frontend/blogView.php');
}

function connexion()
{
    require('view/frontend/loginView.php');
}
