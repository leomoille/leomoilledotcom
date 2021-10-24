<?php

namespace App\Model;

use ParsedownExtra;

require_once('model/Manager.php');

class PostManager extends Manager
{
    public function getLastsPosts()
    {
        $db  = $this->dbConnect();
        $req = $db->query(
            '
        SELECT id,
           author,
           title,
           pre_content,
           content,
           DATE_FORMAT(publication_date, \'%d/%m/%Y à %Hh%i\') AS publication_date,
           DATE_FORMAT(modification_date, \'%d/%m/%Y à %Hh%i\') AS modification_date
    FROM posts ORDER BY publication_date DESC LIMIT 0, 3
    '
        );

        return $req;
    }

    public function getPosts()
    {
        $db = $this->dbConnect();

        return $db->query(
            'SELECT id,
           author,
           title,
           pre_content,
           content,
           DATE_FORMAT(publication_date, \'%d/%m/%Y à %Hh%i\') AS publication_date,
           DATE_FORMAT(modification_date, \'%d/%m/%Y à %Hh%i\') AS modification_date
    FROM posts ORDER BY publication_date DESC
    '
        );
    }

    public function getPost($postId)
    {
        $db  = $this->dbConnect();
        $req = $db->prepare(
            'SELECT id, author, title, pre_content, content, DATE_FORMAT(publication_date, \'%d/%m/%Y à %Hh%i\')
    AS publication_date,
       DATE_FORMAT(modification_date, \'%d/%m/%Y à %Hh%i\') AS modification_date FROM posts WHERE id = ?'
        );

        $req->execute(array($postId));
        $post            = $req->fetch();
        $Parsedown       = new ParsedownExtra();
        $post['content'] = $Parsedown->text($post['content']);

        return $post;
    }

    public function getPostMD($postId)
    {
        $db  = $this->dbConnect();
        $req = $db->prepare(
            'SELECT id, author, title, pre_content, content, DATE_FORMAT(publication_date, \'%d/%m/%Y à %Hh%i\')
    AS publication_date,
       DATE_FORMAT(modification_date, \'%d/%m/%Y à %Hh%i\') AS modification_date FROM posts WHERE id = ?'
        );

        $req->execute(array($postId));
        $post = $req->fetch();

        return $post;
    }

    public function addPost($title, $pre_content, $content): bool
    {
        $db       = $this->dbConnect();
        $comments =
            $db->prepare(
                'INSERT INTO posts(author, title, pre_content, content, publication_date) VALUES(?, ?, ?, ?, NOW())'
            );

        return $comments->execute(array('Léo', $title, $pre_content, $content));
    }

    public function updatePost($postId, $title, $pre_content, $content): bool
    {
        $db       = $this->dbConnect();
        $comments =
            $db->prepare(
                'UPDATE posts 
SET title = ?, pre_content = ?, content = ?, modification_date = NOW() 
WHERE id = ?'
            );

        return $comments->execute(array($title, $pre_content, $content, $postId));
    }

    public function deletePost($postId): bool
    {
        $db       = $this->dbConnect();
        $comments =
            $db->prepare(
                'DELETE FROM posts WHERE id = ?'
            );

        return $comments->execute(array($postId));
    }
}
