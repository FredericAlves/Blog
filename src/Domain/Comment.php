<?php

namespace Blog\Domain;

class Comment
{
    /**
     * Comment id.
     *
     * @var integer
     */
    private $id;

    /**
     * Associated article.
     *
     * @var \Blog\Domain\Article
     */
    private $article_id;

    /**
     * Associated comment.
     *
     * @var \Blog\Domain\Comment
     */
    private $parent_id;

    /**
     * Comment level.
     *
     * @var integer
     */
    private $level;

    /**
     * Comment date
     *
     * @var \DateTime
     */
    private $date_add;

    /**
     * Comment date of last edit
     *
     * @var \DateTime
     */

    private $date_last_edit;

    /**
     * Comment author.
     *
     * @var
     *
    private $author;
     */

    /**
     * Comment author email.
     *
     * @var string
     */
    private $email;

    /**
     * Comment content.
     *
     * @var string
     */
    private $content;

    /**
     * Comment report.
     *
     * @var integer
     */
    private $report;



    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function getArticleId() {
        return $this->article_id;
    }

    public function setArticleId(Article $article_id) {
        $this->article_id = $article_id;
        return $this;
    }

    public function getParentId() {
        return $this->parent_id;
    }

    public function setParentId(Comment $parent_id) {
        $this->parent_id = $parent_id;
        return $this;
    }

    public function getLevel() {
        return $this->level;
    }

    public function setLevel($level) {
        $this->level = $level;
        return $this;
    }

    public function getDateAdd() {
        return $this->date_add;
    }

    public function setDateAdd($date_add) {
        $this->date_add = $date_add;
        return $this;
    }

    public function getDateLastEdit() {
        return $this->date_last_edit;
    }

    public function setDateLastEdit($date_last_edit) {
        $this->date_last_edit = $date_last_edit;
        return $this;
    }

    /*
    public function getAuthor() {
        return $this->author;
    }

    public function setAuthor(User $author) {
        $this->author = $author;
        return $this;
    }
    */

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
        return $this;
    }

    public function getContent() {
        return $this->content;
    }

    public function setContent($content) {
        $this->content = $content;
        return $this;
    }

    public function getReport() {
        return $this->report;
    }

    public function setReport($report) {
        $this->report = $report;
        return $this;
    }



}