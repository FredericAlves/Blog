<?php

namespace Blog\DAO;

use Blog\Domain\Comment;

class CommentDAO extends DAO
{
    /**
     * @var \Blog\DAO\ArticleDAO
     */
    private $articleDAO;

    public function setArticleDAO(ArticleDAO $articleDAO) {
        $this->articleDAO = $articleDAO;
    }

    /**
     * Return a list of all comments for an article, sorted by date (most recent last).
     *
     * @param integer $articleId The article id.
     *
     * @return array A list of all comments for the article.
     */
    public function findAllByArticle($articleId) {
        // The associated article is retrieved only once
        //$article = $this->articleDAO->find($articleId);

        // id is not selected by the SQL query
        // The article won't be retrieved during domain objet construction
        $sql = "select * from comment where article=? order by id";
        $result = $this->getDb()->fetchAll($sql, array($articleId));

        // Convert query result to an array of domain objects
        $comments = array();
        foreach ($result as $row) {
            $comId = $row['id'];
            $comment = $this->buildDomainObject($row);
            // The associated article is defined for the constructed comment
            //$comment->setArticleId($article);
            $comments[$comId] = $comment;
        }
        return $comments;
    }

    /**
     * Creates an Comment object based on a DB row.
     *
     * @param array $row The DB row containing Comment data.
     * @return \Blog\Domain\Comment
     */
    protected function buildDomainObject(array $row) {
        $comment = new Comment();
        $comment->setId($row['id']);
        $comment->setArticle($row['article']);
        $comment->setParent($row['parent']);
        $comment->setLevel($row['level']);
        $comment->setDateAdd($row['date_add']);
        $comment->setDateLastEdit($row['date_last_edit']);
        $comment->setAuthor($row['author']);
        $comment->setEmail($row['email']);
        $comment->setContent($row['content']);
        $comment->setReport($row['report']);


        if (array_key_exists('art_id', $row)) {
            // Find and set the associated article
            $articleId = $row['id'];
            $article = $this->articleDAO->find($articleId);
            $comment->setArticle($article);
        }

        return $comment;
    }
}