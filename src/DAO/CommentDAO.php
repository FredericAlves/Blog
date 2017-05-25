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
        $article = $this->articleDAO->find($articleId);

        // id is not selected by the SQL query
        // The article won't be retrieved during domain objet construction
        $sql = "select id, content, author from comment where article_id=? order by id";
        $result = $this->getDb()->fetchAll($sql, array($articleId));

        // Convert query result to an array of domain objects
        $comments = array();
        foreach ($result as $row) {
            $comId = $row['id'];
            $comment = $this->buildDomainObject($row);
            // The associated article is defined for the constructed comment
            $comment->setArticleId($article);
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
        $comment->setContent($row['content']);
        $comment->setAuthor($row['author']);

        if (array_key_exists('art_id', $row)) {
            // Find and set the associated article
            $articleId = $row['id'];
            $article = $this->articleDAO->find($articleId);
            $comment->setArticleId($article);
        }

        return $comment;
    }
}