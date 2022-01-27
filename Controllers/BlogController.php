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
        $posts     = $postModel->getAllPostWithAuthorName();

        // TODO: Récupérer chaque auteur pour chaque post

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
        $post      = $postModel->getPostWithAuthorName($id);
        $postModel->hydrate($post);


        $Parsedown = new ParsedownExtra();
        $postModel->setContent($Parsedown->text($postModel->getContent()));

        $commentsModel = new CommentsModel();
        $comments      = $commentsModel->getCommentWithAuthorName($id);

        $this->twigRender(
            'frontoffice/postView.twig',
            array('post' => $postModel, 'comments' => $comments)
        );
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
        $post      = $postModel->find($id);

        $this->twigRender(
            'backoffice/editPostView.twig',
            array('post' => $post)
        );
    }

    public function updatePost()
    {
        // Récuperer les informations du post
        if (isset($_POST['post'])) {
            $data                     = $_POST['post'];
            $data['modificationDate'] = date('Y-m-d H:i:s');

            $postModel = new PostsModel();
            $post      = $postModel->hydrate($data);

            $post->update();

            header('Location: /blog/post/' . $post->getId());
        }
    }

    public function addPost()
    {
        if ($this->checkPathPrivilege('admin')) {
            // Récuperer les informations du post
            if (isset($_POST['post'])) {
                $data                    = $_POST['post'];
                $data['publicationDate'] = date('Y-m-d H:i:s');
                $data['authorId']        = $_SESSION['user']['id'];

                $postModel = new PostsModel();
                $post      = $postModel->hydrate($data);

                $post->create();

                header('Location: /blog');
            }
        } else {
            echo 'Erreur';
        }
    }

    public function deletePost($id)
    {
        $postModel = new PostsModel();
        $postModel->delete($id);


        header('Location: /users/adminDashboard');
    }

    public function addComment($post_id)
    {
        if ($this->checkPathPrivilege('admin')) {
            if (isset($_POST['comment'])) {
                $data = array(
                    'authorId'    => $_SESSION['user']['id'],
                    'postId'      => (int)$post_id,
                    'isApproved'  => 1,
                    'comment'     => $_POST['comment'],
                    'commentDate' => date('Y-m-d H:i:s'),
                );


                $commentModel = new CommentsModel();
                $comment      = $commentModel->hydrate($data);

                $comment->create();
            }
        } elseif ($this->checkPathPrivilege('user')) {
            if (isset($_POST['comment'])) {
                $data = array(
                    'authorId'    => $_SESSION['user']['id'],
                    'postId'      => (int)$post_id,
                    'isApproved'  => 0,
                    'comment'     => $_POST['comment'],
                    'commentDate' => date('Y-m-d H:i:s'),
                );


                $commentModel = new CommentsModel();
                $comment      = $commentModel->hydrate($data);

                $comment->create();
            }
        } else {
            echo 'Erreur';
        }
        header('Location: /blog/post/' . $post_id);
    }
}
