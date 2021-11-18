<?php

namespace App\Models;

use DateTime;

class CommentsModel extends Model
{
    protected int $id;
    protected int $post_id;
    protected int $author_id;
    protected int $is_approved;
    protected string $comment;
    protected DateTime $comment_date;

    public function __construct()
    {
        $this->table = 'comments';
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
        return $this->post_id;
    }

    /**
     * @param int $post_id
     *
     * @return $this
     */
    public function setPostId(int $post_id): CommentsModel
    {
        $this->post_id = $post_id;

        return $this;
    }

    /**
     * @return int
     */
    public function getAuthorId(): int
    {
        return $this->author_id;
    }

    /**
     * @param int $author_id
     *
     * @return $this
     */
    public function setAuthorId(int $author_id): CommentsModel
    {
        $this->author_id = $author_id;

        return $this;
    }

    /**
     * @return int
     */
    public function getIsApproved(): int
    {
        return $this->is_approved;
    }

    /**
     * @param int $is_approved
     *
     * @return $this
     */
    public function setIsApproved(int $is_approved): CommentsModel
    {
        $this->is_approved = $is_approved;

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
     * @return DateTime
     */
    public function getCommentDate(): DateTime
    {
        return $this->comment_date;
    }

    /**
     * @param DateTime $comment_date
     *
     * @return $this
     */
    public function setCommentDate(DateTime $comment_date): CommentsModel
    {
        $this->comment_date = $comment_date;

        return $this;
    }
}
