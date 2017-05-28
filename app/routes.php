<?php

use Symfony\Component\HttpFoundation\Request;
use Blog\Domain\Comment;
use Blog\Form\Type\CommentType;


// Home page
$app->get('/',"Blog\Controller\FrontController::homeAction")
    ->bind('home');


// Article details with comments
$app->match('/article/{id}', "Blog\Controller\FrontController::articleAction")
    ->bind('article');

// add a comment
$app->match('/comment/{id}/{comment_id}', "Blog\Controller\FrontController::addComment")
    ->bind('add-comment');