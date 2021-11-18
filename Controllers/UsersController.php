<?php

namespace App\Controllers;

use App\Core\FormChecker;
use App\Models\CommentsModel;
use App\Models\PostsModel;
use App\Models\UsersModel;

class UsersController extends Controller
{
    public function login()
    {
        $error = null;

        if (FormChecker::validate($_POST, ['email', 'password'])) {
            // Clean email to prevent XSS
            $email = strip_tags($_POST['email']);

            $userModel = new UsersModel();
            $user = $userModel->findOneBy(array('email' => $email));


            $checkPass = password_verify($_POST['password'], $user->password);

            if ($checkPass === true) {
                $loggedUser = [
                    'name' => $user->name,
                    'email' => $user->email,
                    'isAdmin' => $user->is_admin,
                ];
                $_SESSION['user'] = $loggedUser;
                header("Location: /");
            } else {
                $error = 'Vérifiez votre saisie.';
            }
        }

        $this->twigRender('frontoffice/loginView.twig', array('error' => $error));
    }

    public function signIn()
    {
        if (
            FormChecker::validate($_POST, ['name', 'email', 'emailCheck', 'password', 'passwordCheck'])
            && $_POST['email'] === $_POST['emailCheck']
            && $_POST['password'] === $_POST['passwordCheck']
        ) {
            $name = strip_tags($_POST['name']); // Clean name to prevent XSS
            $email = strip_tags($_POST['email']); // Clean email to prevent XSS
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

            $userModel = new UsersModel();
            $emailIsUsed = $userModel->findBy(['email' => $email]);

            if (empty($emailIsUsed)) {
                $user = new UsersModel();
                $user->setName($name)
                    ->setEmail($email)
                    ->setPassword($password)
                    ->setIsAdmin(0);


                // ======
                echo 'OK';
                $loggedUser = [
                    'name' => $user->getName(),
                    'email' => $user->getEmail(),
                    'password' => $user->getPassword(),
                    'isAdmin' => $user->getIsAdmin(),
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

    public function adminDashboard()
    {
        // FIXME: Proteger la route pour les utilisateurs non administrateur
        $postsModel = new PostsModel();
        $posts = $postsModel->findAll();

        $commentsModel = new CommentsModel();
        $comments = $commentsModel->findBy(['is_approved' => 0]);
        // TODO: Faire une jointure pour récuperer le nom des utilisateurs ayant posté un commentaire

        $userModel = new UsersModel();
        $users = $userModel->findBy(array('is_admin' => 0));

        $this->twigRender(
            'backoffice/adminDashboardView.twig',
            array('posts' => $posts, 'users' => $users, 'comments' => $comments)
        );
    }

    public function userDashboard()
    {
        // FIXME: Proteger la route pour les utilisateurs non connecté
        $postsModel = new PostsModel();
        $posts = $postsModel->findAll();

        $commentsModel = new CommentsModel();
        $comments = $commentsModel->findAll();

        $userModel = new UsersModel();
        $users = $userModel->findBy(array('is_admin' => 0));

        $this->twigRender(
            'backoffice/userDashboardView.twig',
            array('posts' => $posts, 'users' => $users, 'comments' => $comments)
        );
    }

    public function deleteUser($id)
    {
        //FIXME: Proteger la route pour les utilisateurs non admin
        $userModel = new UsersModel();
        $user = $userModel->findOneBy(['id' => $id]);

        if (intval($user->is_admin) === 1) {
            header('Location: /users/adminDashboard');
        } else {
            $userModel->delete($id);
        }
    }
}
