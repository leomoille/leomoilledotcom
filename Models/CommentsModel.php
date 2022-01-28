<?php

namespace App\Models;

class CommentsModel extends Model
{
    protected int $id;
    protected int $postId;
    protected int $authorId;
    protected string $authorName;
    protected int $isApproved;
    protected string $comment;
    protected string $commentDate;

    public function __construct()
    {
        $this->table = 'comments';
    }

    /**
     * @param int $postID
     *
     * @return array|false
     */
    public function getCommentWithAuthorName(int $postID)
    {
        return $this->customQuery(
            'SELECT users.name as authorName, comments.*
                    FROM comments
                    LEFT JOIN users ON comments.authorId = users.id
                    WHERE comments.postId = ? AND comments.isApproved = 1',
            [$postID]
        )->fetchAll();
    }

    /**
     * @return array|false
     */
    public function getAllCommentWithAuthorName()
    {
        return $this->customQuery(
            'SELECT users.name as authorName, comments.*
                    FROM comments
                    LEFT JOIN users ON comments.authorId = users.id'
        )->fetchAll();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return $this
     */
    public function setId(int $id): CommentsModel
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return int
     */
    public function getPostId(): int
    {
        return $this->postId;
    }

    /**
     * @param int $postId
     *
     * @return $this
     */
    public function setPostId(int $postId): CommentsModel
    {
        $this->postId = $postId;

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
     * @param int $authorId
     *
     * @return $this
     */
    public function setAuthorId(int $authorId): CommentsModel
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
     * @param string $authorName
     *
     * @return $this
     */
    public function setAuhorName(string $authorName): CommentsModel
    {
        $this->authorName = $authorName;

        return $this;
    }

    /**
     * @return int
     */
    public function getIsApproved(): int
    {
        return $this->isApproved;
    }

    /**
     * @param int $isApproved
     *
     * @return $this
     */
    public function setIsApproved(int $isApproved): CommentsModel
    {
        $this->isApproved = $isApproved;

        return $this;
    }

    /**
     * @return string
     */
    public function getComment(): string
    {
        return $this->comment;
    }

    /**
     * @param string $comment
     *
     * @return $this
     */
    public function setComment(string $comment): CommentsModel
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * @return string
     */
    public function getCommentDate(): string
    {
        return $this->commentDate;
    }

    /**
     * @param string $commentDate
     *
     * @return $this
     */
    public function setCommentDate(string $commentDate): CommentsModel
    {
        $this->commentDate = $commentDate;

        return $this;
    }
}
