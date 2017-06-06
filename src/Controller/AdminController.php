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

    public function editArticleAction($id, Application $app)
    {
        $article = $app['dao.article']->find($id);

        return $app['twig']->render('article_form_edit.html.twig', array('article'=>$article));


    }

    // Del an article
    public function deleteArticleAction($id, Application $app)
    {
        $app['dao.comment']->deleteAllByArticle($id);
        $app['dao.article']->delete($id);
        $app['session']->getFlashBag()->add('success', 'L\'article a été supprimé ainsi que tous les commentaires associés');
        // Redirection page d'accueil administration
        return $app->redirect($app['url_generator']->generate('admin'));
    }



    public function editCommentAction($id, Application $app)
    {
        $comment = $app['dao.comment']->find($id);

        return $app['twig']->render('comment_form_edit.html.twig', array('comment'=>$comment));


    }

    //update a comment
    public function saveCommentAction(Application $app)
    {
        $comment=new comment();
        if (isset($_POST['id']) and$_POST['id']!='') {
            $comment->setId($_POST['id']);
        }
        $comment->setArticleId($_POST['article_id']);
        $comment->setAuthor($_POST['author']);
        $comment->setReport($_POST['report']);
        $comment->setContent($_POST['content']);

        $app['dao.comment']->save($comment);
        $app['session']->getFlashBag()->add('success', 'Le commentaire a bien été publié.');


        return $app->redirect($app['url_generator']->generate('admin'));


    }

    // Delete a comment
    public function deleteCommentAction($id, Application $app)
    {
        $app['dao.comment']->delete($id);
        $app['session']->getFlashBag()->add('success', 'Le commentaire a bien été supprimé');
        // Redirection to admin home page
        return $app->redirect($app['url_generator']->generate('admin'));
    }

    // Delete comment report
    public function reportCommentAction($id, Application $app)
    {
        $comment = $app['dao.comment']->find($id);
        $app['dao.comment']->unreportComment($comment);
        $app['session']->getFlashBag()->add('success', 'Le signalement a bien été supprimé.');
        // Redirection to admin home page
        return $app->redirect($app['url_generator']->generate('admin'));
    }

// Edit an user
    public function editUserAction($id, Application $app)
    {
        $user = $app['dao.user']->find($id);

        return $app['twig']->render('user_form_edit.html.twig', array('title' => 'Modification compte utilisateur','user'=>$user));


    }


// Save an user
    public function saveUserAction(Application $app)
    {

        $user = new User();
        if (isset($_POST['id']) and$_POST['id']!='') {
            $user->setId($_POST['id']);
        }
        $user->setUsername($_POST['username']);
        $user->setName($_POST['name']);
        $user->setRole($_POST['role']);
        $salt = substr(md5(time()), 0, 23);
        $user->setSalt($salt);
        $plainPassword = ($_POST['password']);
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
