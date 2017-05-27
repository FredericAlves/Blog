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
            }
        }
        return $app['twig']->render('article.html.twig', array(
            'article' => $article,
            'comments' => $comments,
            'childrenComments' => $childrenComments,
            'childrenCommentsLevel2' => $childrenCommentsLevel2,
            'commentForm' => $commentFormView
        ));
    }


}