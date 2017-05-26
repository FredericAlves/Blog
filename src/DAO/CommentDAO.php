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

    public function find($id)
    {
        $sql = "select * from comment where id=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));
        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("No comment matching id " . $id);
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
        $sql = "select * from comment where article_id=?  and parent_id is NULL order by id";
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

    public function findAllChildren($comment) {
        $sql = "select * from comment where parent_id=?  order by id";
        $result = $this->getDb()->fetchAll($sql, array($comment->getId()));
        // Convert query result to an array of domain objects
        $childrenComments = array();
        foreach ($result as $row) {
            $comId = $row['id'];
            $childrenComment = $this->buildDomainObject($row);

            $childrenComments[$comId] = $childrenComment;
        }
        return $childrenComments;
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
        $comment->setArticleId($row['article_id']);
        $comment->setParentId($row['parent_id']);
        $comment->setDate($row['date']);
        $comment->setAuthor($row['author']);
        $comment->setEmail($row['email']);
        $comment->setContent($row['content']);
        $comment->setReport($row['report']);

        /*
        if (array_key_exists('article_id', $row)) {
            // Find and set the associated article
            $articleId = $row['article_id'];
            $article = $this->articleDAO->find($articleId);
            $comment->setArticleId($article);
        }

        if (array_key_exists('parent_id', $row) && $row['parent_id']) {
            // Find and set the associated article
            $parentId = $row['parent_id'];
            $parent = $this->find($parentId);
            $comment->setParentId($parent);
        }
        */
        return $comment;
    }

    public function save(Comment $comment)
    {
        $commentData = array(
            'article_id' => $comment->getArticleId($comment->getId()),
            'parent_id' => $comment->getParentId($comment->getId()),
            'author' => $comment->getAuthor($comment->getId()),
            'content' => $comment->getContent()
        );

        if ($comment->getId()) {
            // The comment has already been saved : update it
            $this->getDb()->update('comment', $commentData, array('id' => $comment->getId()));
        } else {
            // The comment has never been saved : insert it
            $this->getDb()->insert('comment', $commentData);
            // Get the id of the newly created comment and set it on the entity.
            $id = $this->getDb()->lastInsertId();
            $comment->setId($id);
        }
    }
}