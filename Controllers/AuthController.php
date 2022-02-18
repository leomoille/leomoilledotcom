<?php

namespace App\Controllers;

use App\Core\FormChecker;
use App\Models\UsersModel;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class AuthController extends Controller
{
    public function __construct()
    {
        if (isset($_SESSION['user'])) {
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
    public function login()
    {
        $error = null;

        if (FormChecker::validate($_POST, ['email', 'password'])) {
            // Clean email to prevent XSS
            $email = strip_tags($_POST['email']);

            $userModel = new UsersModel();
            $user = $userModel->findOneBy(array('email' => $email));
            $checkPass = false;

            if ($user) {
                $checkPass = password_verify(
                    $_POST['password'],
                    $user->password
                );
            }

            if ($checkPass === true) {
                $loggedUser = [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
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
     * @return void
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
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
            $name = strip_tags($_POST['name']); // Clean name to prevent XSS
            $email = strip_tags(
                $_POST['email']
            ); // Clean email to prevent XSS
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

            $userModel = new UsersModel();
            $emailIsUsed = $userModel->findBy(['email' => $email]);

            if (empty($emailIsUsed)) {
                $user = new UsersModel();

                $user->setName($name)
                    ->setEmail($email)
                    ->setPassword($password)
                    ->setIsAdmin(0);

                $user->create();
                header('Location: /auth/login');
            } else {
                echo 'Cet email est déjà utilisé';
            }
        }
        $this->twigRender('frontoffice/signInView.twig');
    }
}
