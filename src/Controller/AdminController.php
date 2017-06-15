<?php
/**
 * Frédéric - Projet 3 - Formation OpenClassrooms - 14/06/17 19:28
 */

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
        // We collect all the articles
        $articles = $app['dao.article']->findAll();
        // We collect all the comments
        $comments = $app['dao.comment']->findAll();
        // We collect all the users
        $users = $app['dao.user']->findAll();

        // we make the page with the data
        return $app['twig']->render('admin.html.twig', array(
            'articles' => $articles,
            'comments' => $comments,
            'users' => $users
        ));
    }

    // page to edit a new article
    public function newArticleAction(Application $app)
    {
        // we make the page with the data
        return $app['twig']->render('article_form.html.twig', array('title' => 'Nouveau billet'));
    }

    //save a new article or update an article
    public function saveArticleAction(Application $app)
    {
        // new article object
        $article=new article();

        // Attribute assignment
        if (isset($_POST['id']) and$_POST['id']!='') {
            $article->setId($_POST['id']);
        }
        $article->setTitle($_POST['title']);
        $article->setContent($_POST['$content']);

        // save the article
        $app['dao.article']->save($article);
        $app['session']->getFlashBag()->add('success', 'Votre billet a bien été publié.');

        // return to the admin page
        return $app->redirect('/admin');


    }

    // edit article function
    public function editArticleAction($id, Application $app)
    {
        // we find the article with his id
        $article = $app['dao.article']->find($id);

        // we make the page with the data
        return $app['twig']->render('article_form_edit.html.twig', array('article'=>$article));


    }

    // Delete an article
    public function deleteArticleAction($id, Application $app)
    {
        // we delete all the associed comments
        $app['dao.comment']->deleteAllByArticle($id);
        // we delete the article
        $app['dao.article']->delete($id);
        $app['session']->getFlashBag()->add('success', 'L\'article a été supprimé ainsi que tous les commentaires associés');

        // return to the admin page
        return $app->redirect('/admin');
    }


    // edit comment function
    public function editCommentAction($id, Application $app)
    {
        // we find the comment with his id
        $comment = $app['dao.comment']->find($id);

        // we make the page with the data
        return $app['twig']->render('comment_form_edit.html.twig', array('comment'=>$comment));


    }

    //update a comment
    public function saveCommentAction(Application $app)
    {
        // new comment object
        $comment=new comment();

        // If the id exists, we write it
        if (isset($_POST['id']) and$_POST['id']!='') {
            $comment->setId($_POST['id']);
        }

        // Attribute assignment
        $comment->setArticleId($_POST['article_id']);
        $comment->setAuthor($_POST['author']);
        $comment->setReport($_POST['report']);
        $comment->setContent($_POST['content']);

        // save the article
        $app['dao.comment']->save($comment);
        $app['session']->getFlashBag()->add('success', 'Le commentaire a bien été publié.');

        // return to the admin page , tab comments
        return $app->redirect('/admin#comments');


    }

    // Delete a comment
    public function deleteCommentAction($id, Application $app)
    {
        // delete the comment
        $app['dao.comment']->deleteComment($id);
        $app['session']->getFlashBag()->add('success', 'Le commentaire a bien été supprimé');

        // return to the admin page , tab comments
        return $app->redirect('/admin#comments');

    }

    // delete comment report
    public function deleteReportCommentAction($id, Application $app)
    {
        // we find the comment with his id
        $comment = $app['dao.comment']->find($id);
        // we delete the report
        $app['dao.comment']->unreportComment($comment);
        $app['session']->getFlashBag()->add('success', 'Le signalement a bien été supprimé.');

        // Redirection to admin home page, tab comments
        return $app->redirect('/admin#comments');
    }

// Edit an user
    public function editUserAction($id, Application $app)
    {
        // we find the user with his id
        $user = $app['dao.user']->find($id);

        // we make the page with the data
        return $app['twig']->render('user_form_edit.html.twig', array('title' => 'Modification compte utilisateur','user'=>$user));


    }


// Save an user
    public function saveUserAction(Application $app)
    {
        // new user object
        $user = new User();

        // If the id exists, we write it
        if (isset($_POST['id']) and$_POST['id']!='') {
            $user->setId($_POST['id']);
        }

        // Attribute assignment
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

        // save the user
        $app['dao.user']->save($user);

        // Redirection to admin home page, tab users
        return $app->redirect('/admin#users');
        }




}
