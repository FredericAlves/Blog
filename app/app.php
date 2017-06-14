<?php
/**
 * Frédéric - Projet 3 - Formation OpenClassrooms - 14/06/17 16:39
 *
 * configuration file of the application
 *
 */

use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\Debug\ExceptionHandler;

// Register global error and exception handlers
ErrorHandler::register();
ExceptionHandler::register();

// Register service providers.

// Register Doctrine Service Provider
$app->register(new Silex\Provider\DoctrineServiceProvider());

// Register Twig Service Provider
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'debug'=>true,
    'twig.path' => __DIR__.'/../views',
));

// setting Twig extension
$app['twig'] = $app->extend('twig', function(Twig_Environment $twig, $app) {
    $twig->addExtension(new Twig_Extensions_Extension_Text());
    $twig->addExtension(new \Twig_Extension_Debug());
    return $twig;
});

// Register Validator Service Provider
$app->register(new Silex\Provider\ValidatorServiceProvider());

// Register Asset Service Provider
$app->register(new Silex\Provider\AssetServiceProvider(), array(
    'assets.version' => 'v1'
));

// Register Session Service Provider
$app->register(new Silex\Provider\SessionServiceProvider());


// setting Security Service
$app->register(new Silex\Provider\SecurityServiceProvider(), array(
    'security.firewalls' => array(
        'secured' => array(
            'pattern' => '^/',
            'anonymous' => true,
            'logout' => true,
            'form' => array('login_path' => '/login', 'check_path' => '/login_check'),
            'users' => function () use ($app) {
                return new Blog\DAO\UserDAO($app['db']);
            },
        ),
    ),
    'security.role_hierarchy' => array(
        'ROLE_ADMIN' => array('ROLE_USER'),
    ),
    'security.access_rules' => array(
        array('^/admin', 'ROLE_ADMIN'),
    ),
));



// Initialize the data object access

// for the class Article
$app['dao.article'] = function ($app) {
    return new Blog\DAO\ArticleDAO($app['db']);
};

// for the class Comment
$app['dao.comment'] = function ($app) {
    $commentDAO = new Blog\DAO\CommentDAO($app['db']);
    return $commentDAO;
};

// for the class User
$app['dao.user'] = function ($app) {
    return new Blog\DAO\UserDAO($app['db']);
};