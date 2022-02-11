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
     * @return void
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function index()
    {
        $postModel = new PostsModel();
        $posts = $postModel->getAllPostWithAuthorName();

        $this->twigRender('frontoffice/blogView.twig', ['posts' => $posts]);
    }

    /**
     * @param $postID
     *
     * @return void
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function post($postID)
    {
        $postModel = new PostsModel();
        $post = $postModel->getPostWithAuthorName($postID);
        $postModel->hydrate($post);


        $Parsedown = new ParsedownExtra();
        $postModel->setContent($Parsedown->text($postModel->getContent()));

        $commentsModel = new CommentsModel();
        $comments = $commentsModel->getCommentWithAuthorName($postID);

        $this->twigRender(
            'frontoffice/postView.twig',
            array('post' => $postModel, 'comments' => $comments)
        );
    }

    /**
     * @param $postID
     *
     * @return void
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function editPost($postID)
    {
        if ($this->checkPathPrivilege('admin')) {
            $postModel = new PostsModel();
            $post = $postModel->find($postID);

            $this->twigRender(
                'backoffice/editPostView.twig',
                array('post' => $post)
            );
        } else {
            header('Location: /');
        }
    }

    /**
     * @return void
     */
    public function updatePost()
    {
        if ($this->checkPathPrivilege('admin') && isset($_POST['post'])) {
            $data = $_POST['post'];
            $data['modificationDate'] = date('Y-m-d H:i:s');

            $postModel = new PostsModel();
            $post = $postModel->hydrate($data);

            $post->update();

            header('Location: /blog/post/' . $post->getId());
        } else {
            header('Location: /');
        }
    }

    /**
     * @return void
     */
    public function addPost()
    {
        if ($this->checkPathPrivilege('admin')) {
            // Récuperer les informations du post
            if (isset($_POST['post'])) {
                $data = $_POST['post'];
                $data['publicationDate'] = date('Y-m-d H:i:s');
                $data['authorId'] = $_SESSION['user']['id'];

                $postModel = new PostsModel();
                $post = $postModel->hydrate($data);

                $post->create();

                header('Location: /blog');
            }
        } else {
            header('Location: /');
        }
    }

    /**
     * @param $postID
     *
     * @return void
     */
    public function deletePost($postID)
    {
        if ($this->checkPathPrivilege('admin')) {
            $postModel = new PostsModel();
            $postModel->deletePostByID($postID);


            header('Location: /users/adminDashboard');
        } else {
            header('Location: /');
        }
    }

    /**
     * @param $postID
     *
     * @return void
     */
    public function addComment($postID)
    {
        if ($this->checkPathPrivilege('admin')) {
            if (isset($_POST['comment'])) {
                $data = array(
                    'authorId' => $_SESSION['user']['id'],
                    'postId' => (int)$postID,
                    'isApproved' => 1,
                    'comment' => $_POST['comment'],
                    'commentDate' => date('Y-m-d H:i:s'),
                );


                $commentModel = new CommentsModel();
                $comment = $commentModel->hydrate($data);

                $comment->create();
            }
        } elseif ($this->checkPathPrivilege('user')) {
            if (isset($_POST['comment'])) {
                $data = array(
                    'authorId' => $_SESSION['user']['id'],
                    'postId' => (int)$postID,
                    'isApproved' => 0,
                    'comment' => $_POST['comment'],
                    'commentDate' => date('Y-m-d H:i:s'),
                );


                $commentModel = new CommentsModel();
                $comment = $commentModel->hydrate($data);

                $comment->create();
            }
        } else {
            header('Location: /');
        }
        header('Location: /blog/post/' . $postID);
    }
}
