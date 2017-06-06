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
    private $date;


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

    private $image;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function getDate() {
        return $this->date;
    }

    public function setDate($date) {
        $this->date = $date;
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

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image)
    {
        $this->image = $image;
        return $this;
    }


}