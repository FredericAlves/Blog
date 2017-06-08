<?php

namespace Blog\DAO;

use Blog\Domain\Comment;

class CommentDAO extends DAO
{

    /**
     * Returns a comment matching the supplied id.
     *
     * @param integer $id The comment id.
     *
     * @return \Blog\Domain\Comment|throws an exception if no matching comment is found
     */
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
     * Returns a list of all comments, sorted by date (most recent first).
     *
     * @return array A list of all comments.
     */
    public function findAll() {
        $sql = "select comment.id, comment.article_id, comment.parent_id, comment.date, comment.author, comment.content, comment.report, article.title as title from comment, article where comment.article_id=article.id order by comment.report DESC, comment.id desc ";
        $result = $this->getDb()->fetchAll($sql);

        // Convert query result to an array of domain objects
        $entities = array();
        foreach ($result as $row) {
            $id = $row['id'];
            $entities[$id] = $this->buildDomainObject($row);
        }
        return $entities;
    }

    /**
     * Return a list of all comments for an article, sorted by date (most recent first).
     *
     * @param integer $articleId The article id.
     *
     * @return array A list of all comments for the article.
     */
    public function findAllByArticle($articleId) {
        $sql = "select * from comment where article_id=?  and parent_id is NULL order by id DESC ";
        $result = $this->getDb()->fetchAll($sql, array($articleId));

        // Convert query result to an array of domain objects
        $comments = array();
        foreach ($result as $row) {
            $comId = $row['id'];
            $comment = $this->buildDomainObject($row);
            $comments[$comId] = $comment;
        }
        return $comments;
    }

    /**
     * Return a list of all childrens comment for the comment, sorted by date (most recent first).
     *
     * @param integer $comment The comment id.
     *
     * @return array A list of all childrens comment for the comment.
     */
    public function findAllChildren($comment) {
        $sql = "select * from comment where parent_id=?  order by id DESC";
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

    // report a comment
    public function reportComment($comment)
    {
        $comment->setReport('1');
        $this->save($comment);
    }

    // Delete a comment report
    public function unreportComment($comment)
    {
        $comment->setReport('0');
        $this->save($comment);
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
        $comment->setContent($row['content']);
        $comment->setReport($row['report']);
        if (array_key_exists('title', $row)){
            $comment->setArticleTitle($row['title']);
        }

        return $comment;
    }

    public function save(Comment $comment)
    {
        $commentData = array(
            'article_id' => $comment->getArticleId($comment->getId()),
            'parent_id' => $comment->getParentId($comment->getId()),
            'author' => $comment->getAuthor($comment->getId()),
            'content' => $comment->getContent(),
            'report' => $comment->getReport()
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

    // Delete all comments from an article
    public function deleteAllByArticle($articleId) {
        $this->getDb()->delete('comment', array('article_id' => $articleId));
    }


    /**
     * Removes a comment from the database.
     *
     * @param integer $id The comment id.
     */
    public function delete($id) {
        // Delete the comment
        $this->getDb()->delete('comment', array('id' => $id));
    }



}