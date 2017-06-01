<?php

// Home page
$app->get('/',"Blog\Controller\FrontController::homeAction")
    ->bind('home');


// Article details with comments
$app->match('/article/{id}', "Blog\Controller\FrontController::articleAction")
    ->bind('article');

// add a comment
$app->match('/article/{id}/add_comment', "Blog\Controller\FrontController::addComment")
    ->bind('add-comment');

// Report a comment
$app->match('/comment/{id}/report', "Blog\Controller\FrontController::reportAction")
    ->bind('report_comment');

// Login form
$app->get('/login', "Blog\Controller\FrontController::loginAction")
    ->bind('login');

// Admin home page
$app->get('/admin', "Blog\Controller\AdminController::indexAction")
    ->bind('admin');

// Page to add a new article
$app->get('/admin/new_article/',function () use ($app) {
    return $app['twig']->render('article_form.html.twig', array('title' => 'Nouveau billet'));
})->bind('new-article');

// save a new article
$app->match('/admin/article/add', "Blog\Controller\AdminController::saveArticle")
    ->bind('save-article');

// edit an article
$app->match('/admin/article/{id}/edit', "Blog\Controller\AdminController::editArticle")
    ->bind('edit-article');

// del an article
$app->get('/admin/article/{id}/delete', "Blog\Controller\AdminController::deleteArticle")
    ->bind('admin_article_delete');

