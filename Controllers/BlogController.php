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
     */
    public function addComment($postID)
    {
        if (!isset($_SESSION['user'])) {
            header('Location: /blog/post/' . $postID);
        }

        if (isset($_POST['comment'])) {
            $data = array(
                'authorId' => $_SESSION['user']['id'],
                'postId' => (int)$postID,
                'isApproved' => $_SESSION['user']['isAdmin'] === '1' ? 1 : 0,
                'comment' => $_POST['comment'],
                'commentDate' => date('Y-m-d H:i:s'),
            );

            $commentModel = new CommentsModel();
            $comment = $commentModel->hydrate($data);

            $comment->create();
        } else {
            header('Location: /');
        }

        header('Location: /blog/post/' . $postID);
    }
}
