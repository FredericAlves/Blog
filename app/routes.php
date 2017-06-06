<?php

// -------------- Front ----------------

// Home page
$app->get('/',"Blog\Controller\FrontController::homeAction")
    ->bind('home');

// Article details with comments
$app->match('/article/{id}', "Blog\Controller\FrontController::articleAction")
    ->bind('article');

// add a comment
$app->match('/article/{id}/add_comment', "Blog\Controller\FrontController::addCommentAction")
    ->bind('add-comment');

// Report a comment
$app->match('/comment/{id}/report', "Blog\Controller\FrontController::reportAction")
    ->bind('report_comment');

// Login form
$app->get('/login', "Blog\Controller\FrontController::loginAction")
    ->bind('login');


// ----------- Back Office ---------------

// Admin home page
$app->get('/admin', "Blog\Controller\AdminController::indexAction")
    ->bind('admin');

// --- Article section

// Page to add a new article
$app->get('/admin/new_article/',function () use ($app) {
    return $app['twig']->render('article_form.html.twig', array('title' => 'Nouveau billet'));
})->bind('new-article');

// save a new article
$app->match('/admin/article/add', "Blog\Controller\AdminController::saveArticleAction")
    ->bind('save-article');

// edit an article
$app->match('/admin/article/{id}/edit', "Blog\Controller\AdminController::editArticleAction")
    ->bind('edit-article');

// delete an article
$app->get('/admin/article/{id}/delete', "Blog\Controller\AdminController::deleteArticleAction")
    ->bind('admin_article_delete');

// --- Comment section

// edit a comment
$app->match('/admin/comment/{id}/edit', "Blog\Controller\AdminController::editCommentAction")
    ->bind('edit-comment');

// save a comment
$app->match('/admin/comment/add', "Blog\Controller\AdminController::saveCommentAction")
    ->bind('save-comment');

// delete a comment
$app->get('/admin/comment/{id}/delete', "Blog\Controller\AdminController::deleteCommentAction")
    ->bind('admin_comment_delete');

// Delete comment report
$app->get('/admin/comment/{id}/report-off', "Blog\Controller\AdminController::reportCommentAction")
    ->bind('admin_comment_report_off');

// --- User section

// edit an user
$app->match('/admin/user/{id}/edit',"Blog\Controller\AdminController::editUserAction")
    ->bind('edit_user');

// save an user
$app->match('/admin/user/save', "Blog\Controller\AdminController::saveUserAction")
    ->bind('save_user');