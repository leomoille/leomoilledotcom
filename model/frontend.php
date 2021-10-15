<?php

function dbConnect()
{
    try {
        $db = new PDO('mysql:host=localhost;dbname=leomoilledotcom;charset=utf8', 'root', '');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        
        return $db;
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
}

function getPosts()
{
    $db = dbConnect();
    
    return $db->query(
        '
    SELECT id,
           author,
           title,
           pre_content,
           content,
           DATE_FORMAT(publication_date, \'%d/%m/%Y à %Hh%imin\') AS publication_date,
           DATE_FORMAT(modification_date, \'%d/%m/%Y à %Hh%imin\') AS modification_date
    FROM articles ORDER BY publication_date
    '
    );
}

function getLastPosts()
{
    $db = dbConnect();
    
    return $db->query(
        '
    SELECT id,
           author,
           title,
           pre_content,
           content,
           DATE_FORMAT(publication_date, \'%d/%m/%Y à %Hh%imin\') AS publication_date,
           DATE_FORMAT(modification_date, \'%d/%m/%Y à %Hh%imin\') AS modification_date
    FROM articles ORDER BY publication_date DESC LIMIT 0, 3
    '
    );
}

function getPost($postId)
{
    $db  = dbConnect();
    $req = $db->prepare(
        '
    SELECT id,
           author,
           title,
           pre_content,
           content,
           DATE_FORMAT(publication_date, \'%d/%m/%Y à %Hh%imin\') AS publication_date,
           DATE_FORMAT(modification_date, \'%d/%m/%Y à %Hh%imin\') AS modification_date
    FROM articles WHERE id = ?
    '
    );
    $req->execute(array($postId));
    
    return $req->fetch();
}

function getComments($postId)
{
    $db       = dbConnect();
    $comments = $db->prepare(
        'SELECT id, author, comment, DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%imin\')
                AS comment_date FROM comments WHERE post_id = ? ORDER BY comment_date DESC'
    );
    $comments->execute(array($postId));
    
    return $comments->fetchAll();
}
