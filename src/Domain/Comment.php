<?php

namespace Blog\Domain;

class Comment
{
    /**
     * Comment id.
     *
     * @var int
     */
    private $id;

    /**
     * Associated id article.
     *
     * @var int
     */
    private $article_id;

    /**
     * Associated comment.
     *
     * @var int
     */
    private $parent_id;


    /**
     * Comment add date
     *
     * @var \DateTime
     */
    private $date;


    /**
     * Comment author.
     *
     * @var string
     *
     */
    private $author;


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
     * @var boolean
     */
    private $report;

    /**
     * title of associated article
     *
     * @return string
     */
    private $article_title;

    /**
     * @return string
     */
    public function getArticle_Title()
    {
        return $this->article_title;
    }

    /**
     * @param string $article_title
     */
    public function setArticleTitle($article_title)
    {
        $this->article_title = $article_title;
        return $this;
    }

    /**
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }
    /**
     * @return int
     */
    public function getArticleId() {
        return $this->article_id;
    }

    /**
     * @param int $article_id
     */
    public function setArticleId($article_id) {
        $this->article_id = $article_id;
        return $this;
    }

    /**
     * @return int
     */
    public function getParentId() {
        return $this->parent_id;
    }

    /**
     * @param int $parent_id
     */
    public function setParentId($parent_id) {
        $this->parent_id = $parent_id;
        return $this;
    }

    /**
     * @return /DateTime
     */
    public function getDate() {
        return $this->date;
    }

    /**
     * @param /DateTime $date
     */
    public function setDate($date) {
        $this->date = $date;
        return $this;
    }

    /**
     * @return string
     */
     public function getAuthor() {
        return $this->author;
    }

    /**
     * @param string $author
     */
    public function setAuthor($author) {
        $this->author = $author;
        return $this;
    }

    /**
     * @return  string
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email) {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getContent() {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent($content) {
        $this->content = $content;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getReport() {
        return $this->report;
    }

    /**
     * @param boolean $report
     */
    public function setReport($report) {
        $this->report = $report;
        return $this;
    }



}