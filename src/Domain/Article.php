<?php

namespace Blog\Domain;

class Article
{
    /**
     * Article id.
     *
     * @var integer
     */
    private $id;

    /**
     * Article date
     *
     * @var \DateTime
     */
    private $date_add;

    /**
     * Article date of last edit
     *
     * @var \DateTime
     */

    private $date_last_edit;

    /**
     * Article title.
     *
     * @var string
     */

    private $title;

    /**
     * Article content.
     *
     * @var string
     */
    private $content;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
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

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
        return $this;
    }

    public function getContent() {
        return $this->content;
    }

    public function setContent($content) {
        $this->content = $content;
        return $this;
    }



}