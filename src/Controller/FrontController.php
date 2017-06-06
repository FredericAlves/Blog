<?php
namespace Blog\Controller;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Blog\Domain\Comment;





class FrontController {

    // Home page
    public function homeAction(Application $app) {
        $articles = $app['dao.article']->findAll();
        return $app['twig']->render('index.html.twig', array('articles' => $articles));
    }



    // Article details with comments
    public function articleAction($id, Application $app) {
      $article = $app['dao.article']->find($id);
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
        ));
    }

    // add comment function
    public function addComment($id, Application $app)
    {
        $comment = new Comment();
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
        $app['dao.comment']->save($comment);
        $app['session']->getFlashBag()->add('success', 'Votre commentaire a bien été ajouté.');

        return $this->articleAction($id,$app);

    }

    // report a comment
    public function reportAction(  $id,  Application $app)
    {
        $comment = $app['dao.comment']->find($id);
        $app['dao.comment']->reportComment($comment);
        $app['session']->getFlashBag()->add('success', 'Le commentaire a été signalé au modérateur.');
        return $this->articleAction(($comment->getArticleId($id)),$app);
    }

    // Login page
    public function loginAction(Request $request, Application $app) {
        return $app['twig']->render('login.html.twig', array(
            'error'         => $app['security.last_error']($request),
            'last_username' => $app['session']->get('_security.last_username'),
        ));
    }

}