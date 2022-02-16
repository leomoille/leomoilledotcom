<?php

namespace App\Controllers;

use App\Models\CommentsModel;
use App\Models\PostsModel;
use App\Models\UsersModel;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class UsersController extends Controller
{

    public function __construct()
    {
        if (!isset($_SESSION['user']['isAdmin']) && $_SESSION['user']['isAdmin'] === '0') {
            header('Location: /');
        }
    }

    /**
     * @return void
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function userDashboard()
    {
        $postsModel = new PostsModel();
        $posts = $postsModel->findAll();

        $commentsModel = new CommentsModel();
        $comments = $commentsModel->findAll();

        $userModel = new UsersModel();
        $users = $userModel->findBy(array('isAdmin' => 0));

        $this->twigRender(
            'backoffice/userDashboardView.twig',
            array('posts' => $posts, 'users' => $users, 'comments' => $comments)
        );
    }
}
