<?php

namespace Blog\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Blog\Domain\Article;
use Blog\Domain\Comment;
use Blog\Domain\User;



class AdminController
{

    // Admin home page
    public function indexAction(Application $app)
    {

        $articles = $app['dao.article']->findAll();
        $comments = $app['dao.comment']->findAll();
        $users = $app['dao.user']->findAll();

        //var_dump($comments);

        return $app['twig']->render('admin.html.twig', array(
            'articles' => $articles,
            'comments' => $comments,
            'users' => $users
        ));
    }


    //save  a new article or update an article
    public function saveArticle(Application $app)
    {
        $article=new article();
        if (isset($_POST['id']) and$_POST['id']!='') {
            $article->setId($_POST['id']);
        }
        $article->setTitle($_POST['title']);
        $article->setContent($_POST['content']);

        $app['dao.article']->save($article);
        $app['session']->getFlashBag()->add('success', 'Votre billet a bien été publié.');


        return $app->redirect($app['url_generator']->generate('admin'));


    }

    public function editArticle($id, Application $app)
    {
        $article = $app['dao.article']->find($id);

        return $app['twig']->render('article_form_edit.html.twig', array('article'=>$article));


    }

    // Del an article
    public function deleteArticle($id, Application $app)
    {
        $app['dao.comment']->deleteAllByArticle($id);
        $app['dao.article']->delete($id);
        $app['session']->getFlashBag()->add('success', 'L\'article a été supprimé ainsi que tous les commentaires associés');
        // Redirection page d'accueil administration
        return $app->redirect($app['url_generator']->generate('admin'));
    }

// Edit an user
    public function saveUserAction($id, Application $app) {
        $user = $app['dao.user']->find($id);
        $plainPassword = $user->getPassword();
        // find the encoder for the user
        $encoder = $app['security.encoder_factory']->getEncoder($user);
        // compute the encoded password
        $password = $encoder->encodePassword($plainPassword, $user->getSalt());
        $user->setPassword($password);
        $app['dao.user']->save($user);
        $app['session']->getFlashBag()->add('success', 'Le compte utilisateur a été mis à jour');
        return $app->redirect($app['url_generator']->generate('admin'));
        }




}
