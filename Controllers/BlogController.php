<?php

namespace App\Controllers;

use App\Models\CommentsModel;
use App\Models\PostsModel;
use ParsedownExtra;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class BlogController extends Controller
{
    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function index()
    {
        $postModel = new PostsModel();
        $posts = $postModel->findAll();
        $this->twigRender('frontoffice/blogView.twig', ['posts' => $posts]);
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function post($id)
    {
        $postModel = new PostsModel();
        $post = $postModel->find($id);
        $Parsedown = new ParsedownExtra();
        $post->content = $Parsedown->text($post->content);

        $commentsModel = new CommentsModel();
        $comments = $commentsModel->findBy(['post_id' => $id, 'is_approved' => 1]);

        // TODO: Faire une jointure pour récuperer le nom des utilisateurs ayant posté un commentaire

        $this->twigRender('frontoffice/postView.twig', array('post' => $post, 'comments' => $comments));
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function editPost($id)
    {
        // FIXME: Utilisable uniquement si administrateur
        $postModel = new PostsModel();
        $post = $postModel->find($id);

        $this->twigRender('backoffice/editPostView.twig', array('post' => $post));
    }

    public function updatePost()
    {
        // Récuperer les informations du post
        if (isset($_POST['post'])) {
            $data = $_POST['post'];
            $data['modificationDate'] = date('Y-m-d H:i:s');

            $postModel = new PostsModel();
            $post = $postModel->hydrate($data);

            $post->update();

            header('Location: /blog/post/' . $post->getId());
        }
    }

    public function addPost()
    {
        // Récuperer les informations du post
        if (isset($_POST['post'])) {
            $data = $_POST['post'];
            $data['publicationDate'] = date('Y-m-d H:i:s');

            $postModel = new PostsModel();
            $post = $postModel->hydrate($data);

            $post->create();

            header('Location: /blog');
        }
    }

    public function deletePost($id)
    {
        $postModel = new PostsModel();
        $postModel->delete($id);


        header('Location: /users/adminDashboard');
    }
}
