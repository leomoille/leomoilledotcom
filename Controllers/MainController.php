<?php

namespace App\Controllers;

use App\Models\PostsModel;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class MainController extends Controller
{
    /**
     * @return void
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function index()
    {
        $confirmationMessage = null;

        if (!empty($_POST['contactForm'])) {
            if (
                isset($_POST['contactForm']['name'])
                && isset($_POST['contactForm']['email'])
                && isset($_POST['contactForm']['message'])
                && isset($_POST['contactForm']['rgpd'])
            ) {
                mail(
                    'contact@leomoille.com',
                    'Nouveau message depuis leomoilledotcom',
                    $_POST['contactForm']['message'],
                    array(
                        'From' => 'Contact <contact@leomoille.com>',
                        'Reply-To' => $_POST['contactForm']['email'],
                    )
                );
                $confirmationMessage = array(
                    'valid' => true,
                    'message' => 'Votre message a bien été envoyé !'
                );
            } else {
                $confirmationMessage = array(
                    'valid' => false,
                    'message' => 'Merci de remplir tous les champs du formulaire.'
                );
            }
        }

        $postsModel = new PostsModel();
        $lastPosts = $postsModel->getLimitPostWithAuthorName(3);
        $this->twigRender(
            'frontoffice/indexView.twig',
            array(
                'posts' => $lastPosts,
                'confirmationMessage' => $confirmationMessage
            )
        );
    }
}
