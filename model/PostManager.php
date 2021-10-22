<?php

namespace App\Model;

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
           DATE_FORMAT(publication_date, \'%d/%m/%Y à %Hh%imin\') AS publication_date,
           DATE_FORMAT(modification_date, \'%d/%m/%Y à %Hh%imin\') AS modification_date
    FROM posts ORDER BY publication_date DESC LIMIT 0, 3
    '
        );
        
        return $req;
    }
    
    public function getPosts()
    {
        $db  = $this->dbConnect();
        $req = $db->query(
            'SELECT id,
           author,
           title,
           pre_content,
           content,
           DATE_FORMAT(publication_date, \'%d/%m/%Y à %Hh%imin\') AS publication_date,
           DATE_FORMAT(modification_date, \'%d/%m/%Y à %Hh%imin\') AS modification_date
    FROM posts ORDER BY publication_date DESC
    '
        );
        
        return $req;
    }
    
    public function getPost($postId)
    {
        $db  = $this->dbConnect();
        $req = $db->prepare(
            'SELECT id, author, title, pre_content, content, DATE_FORMAT(publication_date, \'%d/%m/%Y à %Hh%imin%ss\')
    AS publication_date,
       DATE_FORMAT(modification_date, \'%d/%m/%Y à %Hh%imin\') AS modification_date FROM posts WHERE id = ?'
        );
        $req->execute(array($postId));
        $post = $req->fetch();
        
        return $post;
    }
}
