<?php

namespace Src;

use Slim\Factory\AppFactory;
use DI\Container;

require __DIR__ . '/../vendor/autoload.php';

$users = \Src\Generator::generate(100);

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
$app->get('/users[/{id:[0-9]+}]', function ($request, $response, $args) use ($users) {
    if (!is_null($args['id'])) {
        $id = (int) $args['id'];
        $user = collect($users) -> firstWhere('id', $id);
        $params2 = ['user' => collect($users) -> firstWhere('id', $id)];
        return $this->get('renderer')->render($response, 'users/show.phtml', $params2);
    } else {
        $params = ['users' => $users];
        return $this->get('renderer')->render($response, 'users/index.phtml', $params);
    }
});
// END

$app->run();
