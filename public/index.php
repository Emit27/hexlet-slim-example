<?php

namespace SHR;

use Slim\Factory\AppFactory;
use DI\Container;

require __DIR__ . '/../vendor/autoload.php';

$users = \SHR\Gen\Generator::generate(100);

$container = new Container();
$container->set('renderer', function () {
    return new \Slim\Views\PhpRenderer(__DIR__ . '/../templates');
});
//print_r($users);
AppFactory::setContainer($container);
$app = AppFactory::create();
$app->addErrorMiddleware(true, true, true);

$app->get('/', function ($request, $response) {
    return $this->get('renderer')->render($response, 'index.phtml');
});

// BEGIN (write your solution here)
$app->get('/users', function ($request, $response, $args) use ($users) {
        $params = ['users' => $users];
        return $this->get('renderer')->render($response, 'users/index.phtml', $params);
});
//collect($companies)->firstWhere('id', $id);
$app->get('/users/{id:[0-9]+}', function ($request, $response, $args) use ($users) {
    $params = ['user' => collect($users) -> firstWhere('id', $args['id'])];
    return $this->get('renderer')->render($response, 'users/show.phtml', $params);
});
// END

$app->run();
