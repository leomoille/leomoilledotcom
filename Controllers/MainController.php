<?php

namespace App\Controllers;

use App\Models\PostsModel;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class MainController extends Controller
{
    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function index()
    {
        $postsModel = new PostsModel();
        $lastPosts = $postsModel->findNum(3);
        $this->twigRender('frontoffice/indexView.twig', array('posts' => $lastPosts));
    }
}
