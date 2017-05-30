<?php

namespace Blog\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Blog\Domain\Article;
use Blog\Domain\User;
//use Blog\Form\Type\ArticleType;
//use Blog\Form\Type\CommentType;
//use Blog\Form\Type\UserType;


class AdminController
{

    // Admin home page
    public function indexAction(Application $app)
    {

        $articles = $app['dao.article']->findAll();
        $comments = $app['dao.comment']->findAll();
        $users = $app['dao.user']->findAll();
        return $app['twig']->render('admin.html.twig', array(
            'articles' => $articles,
            'comments' => $comments,
            'users' => $users
        ));
    }

    //Add a new article
    public function addArticle(Application $app)
    {

        return $app['twig']->render('article_form.html.twig', array(
            'title' => 'New article',
            ));


    }

}
/*$comment = new Comment();
$comment->setArticleId($_POST['id']);
if (isset($_POST['commentId'])) {
    $comment->setParentId($_POST['commentId']);
};
$comment->setContent(htmlspecialchars($_POST['content']));
if (isset($_POST['author']) and $_POST['author']!='') {
    $comment->setAuthor(htmlspecialchars($_POST['author']));
} else {
    $comment->setAuthor("Anonyme");
};
$app['dao.comment']->save($comment);
$app['session']->getFlashBag()->add('success', 'Votre commentaire a bien été ajouté.');*/