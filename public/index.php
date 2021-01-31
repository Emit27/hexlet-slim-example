<?php

namespace Src;

use Slim\Factory\AppFactory;
use DI\Container;

require __DIR__ . '/../vendor/autoload.php';

$users = ['mike', 'mishel', 'adel', 'keks', 'kamila'];

$container = new Container();
$container->set('renderer', function () {
    return new \Slim\Views\PhpRenderer(__DIR__ . '/../templates');
});

AppFactory::setContainer($container);
$app = AppFactory::create();
$app->addErrorMiddleware(true, true, true);

/* $app->get('/users', function ($request, $response) {
    return $this->get('renderer')->render($response, 'index.phtml');
}); */

// BEGIN (write your solution here)
$app->get('/users', function ($request, $response) use ($users) {
    $term = $request->getQueryParam('term');
    $pos = array_filter($users, function ($user) use ($term) {
        return is_int(strpos($user, $term));
    });
        $params = ['users' => $pos];
        return $this->get('renderer')->render($response, 'users/index.phtml', $params);
});
// END

    $app->run();
