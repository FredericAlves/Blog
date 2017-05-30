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

// Login form
$app->get('/login', "Blog\Controller\FrontController::loginAction")
    ->bind('login');

// Admin home page
$app->get('/admin', "Blog\Controller\AdminController::indexAction")
    ->bind('admin');

// add a new article
$app->match('/admin/article/add', "Blog\Controller\AdminController::addArticle")
    ->bind('add-article');