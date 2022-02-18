<?php

namespace App\Controllers;

use App\Models\CommentsModel;
use App\Models\PostsModel;
use App\Models\UsersModel;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class AdminController extends Controller
{
    /**
     * to check if user as admin privileges
     */
    public function __construct()
    {
        if (!isset($_SESSION['user']['isAdmin']) && $_SESSION['user']['isAdmin'] === '1') {
            header('Location: /');
        }
    }

    /**
     * Display admindashboard view (/admin/dashboard)
     *
     * @return void
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function dashboard()
    {
        $postsModel = new PostsModel();
        $posts = $postsModel->findAll();

        $commentsModel = new CommentsModel();
        $comments = $commentsModel->getAllCommentWithAuthorName();

        $userModel = new UsersModel();
        $users = $userModel->findBy(array('isAdmin' => 0));

        $this->twigRender(
            'backoffice/adminDashboardView.twig',
            array(
                'posts' => $posts,
                'users' => $users,
                'comments' => $comments,
            )
        );
    }

    /**
     * @param $commentID
     *
     * @return void
     */
    public function approveComment($commentID)
    {
        $commentModel = new CommentsModel();
        $comment = $commentModel->findOneBy(array('id' => $commentID));
        $commentModel->setId($comment->id)
            ->setAuthorId($comment->authorId)
            ->setPostId($comment->postId)
            ->setIsApproved(1)
            ->setComment($comment->comment)
            ->setCommentDate($comment->commentDate);
        $commentModel->update();
        header('Location: /blog/post/' . $commentModel->getPostId());
    }

    /**
     * @param $commentID
     *
     * @return void
     */
    public function deleteComment($commentID)
    {
        $commentModel = new CommentsModel();
        $commentModel->delete($commentID);

        header('Location: /user/dashboard');
    }

    /**
     * @param $userID
     *
     * @return void
     */
    public function deleteUser($userID)
    {
        $userModel = new UsersModel();
        $user = $userModel->findOneBy(['id' => $userID]);

        if (intval($user->isAdmin) !== 1) {
            $userModel->delete($userID);
        }
        header('Location: /user/dashboard');
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
        $postModel = new PostsModel();
        $post = $postModel->find($postID);

        $this->twigRender(
            'backoffice/editPostView.twig',
            array('post' => $post)
        );
    }

    /**
     * @return void
     */
    public function updatePost()
    {
        $data = $_POST['post'];
        $data['modificationDate'] = date('Y-m-d H:i:s');

        $postModel = new PostsModel();
        $post = $postModel->hydrate($data);

        $post->update();

        header('Location: /blog/post/' . $post->getId());
    }

    /**
     * @return void
     */
    public function addPost()
    {
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
    }

    /**
     * @param $postID
     *
     * @return void
     */
    public function deletePost($postID)
    {
        $postModel = new PostsModel();
        $postModel->deletePostByID($postID);

        header('Location: /user/dashboard');
    }
}
