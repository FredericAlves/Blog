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
     * Associated id article.
     *
     * @var integer
     */
    private $article_id;

    /**
     * Associated comment.
     *
     * @var \Blog\Domain\Comment
     */
    private $parent_id;


    /**
     * Comment date
     *
     * @var \DateTime
     */
    private $date;


    /**
     * Comment author.
     *
     * @var
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
     * title of associed article
     *
     * @return string
     */
    private $article_title;

    /**
     * @return mixed
     */
    public function getArticle_Title()
    {
        return $this->article_title;
    }

    /**
     * @param mixed $article_title
     */
    public function setArticleTitle($article_title)
    {
        $this->article_title = $article_title;
        return $this;
    }


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

    public function setArticleId($article_id) {
        $this->article_id = $article_id;
        return $this;
    }

    public function getParentId() {
        return $this->parent_id;
    }

    public function setParentId($parent_id) {
        $this->parent_id = $parent_id;
        return $this;
    }

    public function getDate() {
        return $this->date;
    }

    public function setDate($date) {
        $this->date = $date;
        return $this;
    }

     public function getAuthor() {
        return $this->author;
    }

    public function setAuthor($author) {
        $this->author = $author;
        return $this;
    }


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