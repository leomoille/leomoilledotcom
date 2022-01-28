<?php

namespace App\Models;

class PostsModel extends Model
{
    public int $authorId;
    protected int $id;
    protected string $authorName;
    protected string $title;
    protected string $preContent;
    protected string $content;
    protected string $publicationDate;
    protected ?string $modificationDate;

    public function __construct()
    {
        $this->table = 'posts';
    }

    /**
     * @return array|false
     */
    public function getAllPostWithAuthorName()
    {
        return $this->customQuery(
            'SELECT posts.*, users.name AS authorName
                    FROM posts
                    LEFT JOIN users ON posts.authorId = users.id'
        )->fetchAll();
    }

    /**
     * @param int $limit
     * @return array|false
     */
    public function getLimitPostWithAuthorName(int $limit)
    {
        return $this->customQuery(
            "SELECT posts.*, users.name AS authorName
                    FROM posts
                    LEFT JOIN users ON posts.authorId = users.id
                    LIMIT $limit"
        )->fetchAll();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getPostWithAuthorName($id)
    {
        return $this->customQuery(
            'SELECT posts.*, users.name AS authorName
                    FROM posts
                    LEFT JOIN users ON posts.authorId = users.id
                    WHERE posts.id = ?',
            [$id]
        )->fetch();
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
     * @return int
     */
    public function getAuthorId(): int
    {
        return $this->authorId;
    }

    /**
     * @param $authorId
     *
     * @return $this
     */
    public function setAuthorId($authorId): PostsModel
    {
        $this->authorId = $authorId;

        return $this;
    }

    /**
     * @return string
     */
    public function getAuthorName(): string
    {
        return $this->authorName;
    }

    /**
     * @param $authorName
     *
     * @return $this
     */
    public function setAuthorName($authorName): PostsModel
    {
        $this->authorName = $authorName;

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
        return $this->preContent;
    }

    /**
     * @param $preContent
     *
     * @return $this
     */
    public function setPreContent($preContent): PostsModel
    {
        $this->preContent = $preContent;

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
        return $this->publicationDate;
    }

    /**
     * @param $publicationDate
     *
     * @return $this
     */
    public function setPublicationDate($publicationDate): PostsModel
    {
        $this->publicationDate = $publicationDate;

        return $this;
    }


    public function getModificationDate(): ?string
    {
        return $this->modificationDate;
    }

    /**
     * @param $modificationDate
     *
     * @return $this
     */
    public function setModificationDate($modificationDate): PostsModel
    {
        $this->modificationDate = $modificationDate;

        return $this;
    }
}
