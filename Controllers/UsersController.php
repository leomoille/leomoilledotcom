<?php

namespace App\Controllers;

use App\Core\FormChecker;
use App\Models\CommentsModel;
use App\Models\PostsModel;
use App\Models\UsersModel;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class UsersController extends Controller
{
    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function login()
    {
        $error = null;

        if (FormChecker::validate($_POST, ['email', 'password'])) {
            // Clean email to prevent XSS
            $email = strip_tags($_POST['email']);

            $userModel = new UsersModel();
            $user      = $userModel->findOneBy(array('email' => $email));
            $checkPass = false;

            if ($user) {
                $checkPass = password_verify(
                    $_POST['password'],
                    $user->password
                );
            }

            if ($checkPass === true) {
                $loggedUser       = [
                    'id'      => $user->id,
                    'name'    => $user->name,
                    'email'   => $user->email,
                    'isAdmin' => $user->isAdmin,
                ];
                $_SESSION['user'] = $loggedUser;
                header("Location: /");
            } else {
                $error = 'Vérifiez votre saisie.';
            }
        }

        $this->twigRender(
            'frontoffice/loginView.twig',
            array('error' => $error)
        );
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function signIn()
    {
        if (
            FormChecker::validate(
                $_POST,
                ['name', 'email', 'emailCheck', 'password', 'passwordCheck']
            )
            && $_POST['email'] === $_POST['emailCheck']
            && $_POST['password'] === $_POST['passwordCheck']
        ) {
            $name     = strip_tags($_POST['name']); // Clean name to prevent XSS
            $email    = strip_tags(
                $_POST['email']
            ); // Clean email to prevent XSS
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

            $userModel   = new UsersModel();
            $emailIsUsed = $userModel->findBy(['email' => $email]);

            if (empty($emailIsUsed)) {
                $user = new UsersModel();

                $user->setName($name)
                     ->setEmail($email)
                     ->setPassword($password)
                     ->setIsAdmin(0);

                $loggedUser = [
                    'name'     => $user->getName(),
                    'email'    => $user->getEmail(),
                    'password' => $user->getPassword(),
                    'isAdmin'  => $user->getIsAdmin(),
                ];

                $user->create();
                $_SESSION['user'] = $loggedUser;
            } else {
                echo 'Cet email est déjà utilisé';
            }
        }
        $this->twigRender('frontoffice/signInView.twig');
    }

    public function logout()
    {
        $_SESSION = [];
        header('Location: /');
    }

    /**
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws LoaderError
     */
    public function adminDashboard()
    {
        if ($this->checkPathPrivilege('admin')) {
            $postsModel = new PostsModel();
            $posts      = $postsModel->findAll();

            $commentsModel = new CommentsModel();
            $comments      = $commentsModel->getAllCommentWithAuthorName();

            $userModel = new UsersModel();
            $users     = $userModel->findBy(array('isAdmin' => 0));

            $this->twigRender(
                'backoffice/adminDashboardView.twig',
                array(
                    'posts'    => $posts,
                    'users'    => $users,
                    'comments' => $comments,
                )
            );
        } else {
            echo 'Erreur lol';
        }
    }

    // FIXME: Proteger la route pour les utilisateurs non connecté
    public function userDashboard()
    {
        $postsModel = new PostsModel();
        $posts      = $postsModel->findAll();

        $commentsModel = new CommentsModel();
        $comments      = $commentsModel->findAll();

        $userModel = new UsersModel();
        $users     = $userModel->findBy(array('isAdmin' => 0));

        $this->twigRender(
            'backoffice/userDashboardView.twig',
            array('posts' => $posts, 'users' => $users, 'comments' => $comments)
        );
    }

    //FIXME: Proteger la route pour les utilisateurs non admin
    public function approveComment($commentID)
    {
        $commentModel = new CommentsModel();
        $comment      = $commentModel->findOneBy(array('id' => $commentID));
        $commentModel->setId($comment->id)
                     ->setAuthorId($comment->authorId)
                     ->setPostId($comment->postId)
                     ->setIsApproved(1)
                     ->setComment($comment->comment)
                     ->setCommentDate($comment->commentDate);
        $commentModel->update();
        header('Location: /blog/post/' . $commentModel->getPostId());
    }

    //FIXME: Proteger la route pour les utilisateurs non admin
    public function deleteComment($commentID)
    {
        $commentModel = new CommentsModel();
        $commentModel->delete($commentID);

        header('Location: /users/adminDashboard');
    }

    //FIXME: Proteger la route pour les utilisateurs non admin
    public function deleteUser($id)
    {
        $userModel = new UsersModel();
        $user      = $userModel->findOneBy(['id' => $id]);

        if (intval($user->isAdmin) === 1) {
            header('Location: /users/adminDashboard');
        } else {
            $userModel->delete($id);
        }
    }
}
