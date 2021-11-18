<?php

namespace App\Models;

class PostsModel extends Model
{
    protected int $id;
    protected string $author;
    protected string $title;
    protected string $pre_content;
    protected string $content;
    protected string $publication_date;
    protected string $modification_date;

    public function __construct()
    {
        $this->table = 'posts';
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param $id
     *
     * @return $this
     */
    public function setId($id): PostsModel
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getAuthor(): string
    {
        return $this->author;
    }

    /**
     * @param $author
     *
     * @return $this
     */
    public function setAuthor($author): PostsModel
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param $title
     *
     * @return $this
     */
    public function setTitle($title): PostsModel
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getPreContent(): string
    {
        return $this->pre_content;
    }

    /**
     * @param $pre_content
     *
     * @return $this
     */
    public function setPreContent($pre_content): PostsModel
    {
        $this->pre_content = $pre_content;

        return $this;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param $content
     *
     * @return $this
     */
    public function setContent($content): PostsModel
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return string
     */
    public function getPublicationDate(): string
    {
        return $this->publication_date;
    }

    /**
     * @param $publication_date
     *
     * @return $this
     */
    public function setPublicationDate($publication_date): PostsModel
    {
        $this->publication_date = $publication_date;

        return $this;
    }

    /**
     * @return string
     */
    public function getModificationDate(): string
    {
        return $this->modification_date;
    }

    /**
     * @param $modification_date
     *
     * @return $this
     */
    public function setModificationDate($modification_date): PostsModel
    {
        $this->modification_date = $modification_date;

        return $this;
    }
}
