<?php
/**
 * Frédéric - Projet 3 - Formation OpenClassrooms - 14/06/17 19:12
 */

namespace Blog\Controller;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Blog\Domain\Comment;





class FrontController {

    // Home page
    public function homeAction(Application $app) {
        // We collect all the articles
        $articles = $app['dao.article']->findAll();
        // we make the page with the data
        return $app['twig']->render('index.html.twig', array('articles' => $articles));
    }



    // Article details with comments
    public function articleAction($id, Application $app) {
        // we find the article with his id
        $article = $app['dao.article']->find($id);
        // we find all the comments for this article
        $comments = $app['dao.comment']->findAllByArticle($id);
        $childrenComments = [];
        $childrenCommentsLevel2 = [];
        $childrenCommentsLevel3 = [];

    // loops for the different levels of sub-comments
        foreach ($comments as $comment) {

            $childrenComments[$comment->getId()]= $app['dao.comment']->findAllChildren($comment);


            foreach ($childrenComments[$comment->getId()] as $children) {

                $childrenCommentsLevel2[$children->getId()]= $app['dao.comment']->findAllChildren($children);


                foreach ($childrenCommentsLevel2[$children->getId()] as $children2){

                    $childrenCommentsLevel3[$children2->getId()]= $app['dao.comment']->findAllChildren($children2);

                }
            };
        };

        // we make the page with the data
        return $app['twig']->render('article.html.twig', array(
            'article' => $article,
            'comments' => $comments,
            'childrenComments' => $childrenComments,
            'childrenCommentsLevel2' => $childrenCommentsLevel2,
            'childrenCommentsLevel3' => $childrenCommentsLevel3,
        ));
    }

    // add comment function
    public function addCommentAction($id, Application $app)
    {
        // new comment object
        $comment = new Comment();

        // Attribute assignment
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
        $comment->setReport('0');

        // save the comment
        $app['dao.comment']->save($comment);
        $app['session']->getFlashBag()->add('success', 'Votre commentaire a bien été ajouté.');

        // return to the article page
        return $app->redirect('/article/'.$id);

    }

    // report a comment
    public function reportAction(  $id,  Application $app)
    {
        // we find the comment with his id
        $comment = $app['dao.comment']->find($id);
        $articleId = $comment->getArticleId();
        $app['dao.comment']->reportComment($comment);
        $app['session']->getFlashBag()->add('success', 'Le commentaire a été signalé au modérateur.');

        // return to the article page
        return $app->redirect('/article/'.$articleId);
    }

    // Login page
    public function loginAction(Request $request, Application $app) {
        // we make the page with the data
        return $app['twig']->render('login.html.twig', array(
            'error'         => $app['security.last_error']($request),
            'last_username' => $app['session']->get('_security.last_username'),
        ));
    }

}