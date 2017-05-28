<?php
namespace Blog\Controller;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Blog\Domain\Comment;
use Blog\Form\Type\CommentType;




class FrontController {

    // Page d'accueil
    public function homeAction(Application $app) {
        $articles = $app['dao.article']->findAll();
        return $app['twig']->render('index.html.twig', array('articles' => $articles));
    }



    // Article details with comments
    public function articleAction($id, Request $request, Application $app) {
      $article = $app['dao.article']->find($id);
        /*
               $commentFormView = null;

               $comment = new Comment();
               $comment->setArticleId($id);
               $user = 'anonymous';
               $comment->setAuthor($user);

               $commentForm = $app['form.factory']->create(CommentType::class, $comment);
               $commentForm->handleRequest($request);
               if ($commentForm->isSubmitted() && $commentForm->isValid()) {
                   $app['dao.comment']->save($comment);
                   $app['session']->getFlashBag()->add('success', 'Votre commentaire a bien été ajouté.');
               }
               $commentFormView = $commentForm->createView();*/


        $comments = $app['dao.comment']->findAllByArticle($id);


        $childrenComments = [];
        $childrenCommentsLevel2 = [];


        foreach ($comments as $comment) {

            $childrenComments[$comment->getId()]= $app['dao.comment']->findAllChildren($comment);


            foreach ($childrenComments[$comment->getId()] as $children) {

                $childrenCommentsLevel2[$children->getId()]= $app['dao.comment']->findAllChildren($children);

            };
        };
        return $app['twig']->render('article.html.twig', array(
            'article' => $article,
            'comments' => $comments,
            'childrenComments' => $childrenComments,
            'childrenCommentsLevel2' => $childrenCommentsLevel2,
            //'childrenCommentsLevel3' => $childrenCommentsLevel3,
            //'commentForm' => $commentFormView
        ));
    }
    public function addComment(Application $app)
    {
        //echo $_POST['id'];
        //echo $_POST['commentId'];
        //echo $_POST['content'];
        $author = "anonymous";
        //$article = $app['dao.article']->find($id);
        $comment = new Comment();
        $comment->setArticleId($_POST['id']);
        if (isset($_POST['commentId'])) {
            $comment->setParentId($_POST['commentId']);
        };
        $comment->setContent($_POST['content']);
        $comment->setAuthor($author);
        $app['dao.comment']->save($comment);
        $app['session']->getFlashBag()->add('success', 'Votre commentaire a bien été ajouté.');

        echo header('Location: /web/index.php/article?id='.$_POST['id']);

        /*$article = $app['dao.article']->find($id);

        $commentFormView = null;

        $comment = new Comment();
        $comment->setArticleId($id);
        $user = 'anonymous';
        $comment->setAuthor($user);

        $commentForm = $app['form.factory']->create(CommentType::class, $comment);
        $commentForm->handleRequest($request);
        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            $app['dao.comment']->save($comment);
            $app['session']->getFlashBag()->add('success', 'Votre commentaire a bien été ajouté.');
        }
        $commentFormView = $commentForm->createView();


        $comments = $app['dao.comment']->findAllByArticle($id);


        $childrenComments = [];
        $childrenCommentsLevel2 = [];


        foreach ($comments as $comment) {

            $childrenComments[$comment->getId()]= $app['dao.comment']->findAllChildren($comment);


            foreach ($childrenComments[$comment->getId()] as $children) {

                $childrenCommentsLevel2[$children->getId()]= $app['dao.comment']->findAllChildren($children);

            };
        };

        return $app['twig']->render('article.html.twig', array(
            'article' => $article,
            'comments' => $comments,
            'childrenComments' => $childrenComments,
            'childrenCommentsLevel2' => $childrenCommentsLevel2,
            'commentForm' => $commentFormView
        ));
        /*$commentForm = $app['form.factory']->create(CommentType::class, $comment);
        $commentForm->handleRequest($request);
        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            $app['dao.comment']->save($comment);
            $app['session']->getFlashBag()->add('success', 'Le commentaire a été créé.');
            return $app->redirect($app['url_generator']->generate('article', ['id'=>$id]));
        }
        return $app['twig']->render('comment_form.html.twig', array(
            'article' => $article,
            'commentForm' => $commentForm->createView()));*/

    }

}