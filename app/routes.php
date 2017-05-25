<?php

// Home page
$app->get('/', function () use ($app) {
    $articles = $app['dao.article']->findAll();
    return $app['twig']->render('index.html.twig', array('articles' => $articles));
})->bind('home');

// Article details with comments
$app->get('/article/{id}', function ($id) use ($app) {
    $article = $app['dao.article']->find($id);
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
        ));
})->bind('article');