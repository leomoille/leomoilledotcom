<?php

function getPosts()
{
    $db  = dbConnect();
    $req = $db->query(
        'SELECT id, author, title, pre_content, content, DATE_FORMAT(publication_date, \'%d/%m/%Y à %Hh%imin\') AS publication_date, DATE_FORMAT(modification_date, \'%d/%m/%Y à %Hh%imin\') AS modification_date FROM articles ORDER BY publication_date DESC LIMIT 0, 5'
    );
    
    return $req;
}

function getPost($postId)
{
    $db  = dbConnect();
    $req = $db->prepare(
        'SELECT id, author, title, pre_content, content, DATE_FORMAT(publication_date, \'%d/%m/%Y à %Hh%imin\') AS publication_date, DATE_FORMAT(modification_date, \'%d/%m/%Y à %Hh%imin\') AS modification_date FROM articles WHERE id = ?'
    );
    $req->execute(array($postId));
    $post = $req->fetch();
    
    return $post;
}

function getComments($postId)
{
    $db       = dbConnect();
    $comments = $db->prepare(
        'SELECT id, author, comment, DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%imin\') AS comment_date FROM comments WHERE post_id = ? ORDER BY comment_date DESC'
    );
    $comments->execute(array($postId));
    
    return $comments;
}

// Nouvelle fonction qui nous permet d'éviter de répéter du code
function dbConnect()
{
    try {
        $db = new PDO('mysql:host=localhost;dbname=leomoilledotcom;charset=utf8', 'root', '');
        
        return $db;
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
}
