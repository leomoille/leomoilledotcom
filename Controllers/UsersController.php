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
        $commentsApproved = $commentsModel->findBy(array(
            'authorId' => $_SESSION['user']['id'],
            'isApproved' => 1
        ));
        $commentsPending = $commentsModel->findBy(array(
            'authorId' => $_SESSION['user']['id'],
            'isApproved' => 0
        ));

        $userModel = new UsersModel();
        $users = $userModel->findBy(array('isAdmin' => 0));

        $this->twigRender(
            'backoffice/userDashboardView.twig',
            array(
                'posts' => $posts,
                'users' => $users,
                'commentsApproved' => $commentsApproved,
                'commentsPending' => $commentsPending
            )
        );
    }

    /**
     * @return void
     */
    public function deleteAccount()
    {
        if (isset($_POST['userId']) && isset($_POST['confirm'])) {
            $userId = $_SESSION['user']['id'];

            $userModel = new UsersModel();
            $user = $userModel->findOneBy(['id' => $userId]);

            if ($_POST['userId'] === $userId && intval($user->isAdmin) !== 1) {
                $_SESSION = [];
                $userModel->delete($userId);
                header('Location: /');
            }
        }
    }
}
