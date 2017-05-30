<?php

namespace Blog\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Blog\Domain\Article;
use Blog\Domain\Comment;
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


    //save a new article
    public function saveArticle(Application $app)
    {
        $article=new article();
        $article->setTitle(htmlspecialchars($_POST['title']));
        $article->setContent(htmlspecialchars($_POST['content']));

        $app['dao.article']->save($article);
        $app['session']->getFlashBag()->add('success', 'Votre billet a bien été publié.');

        return $this->indexAction($app);


    }

    // Del an article
    public function deleteArticle($id, Application $app)
    {

        $app['dao.article']->delete($id);
        $app['session']->getFlashBag()->add('success', 'L\'article a été supprimé');
        // Redirection page d'accueil administration
        return $app->redirect($app['url_generator']->generate('admin'));
    }


}
