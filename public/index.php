<?php

namespace SHR;

use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$companies = \SHR\Gen\Generator::generate(100);

$app = AppFactory::create();
$app->addErrorMiddleware(true, true, true);

$app->get('/', function ($request, $response) {
    return $response->write('go to the /companies');
});

// BEGIN (write your solution here)
//print_r($companies);

$app->get('/companies', function ($request, $response) use ($companies) {
    $page = $request->getQueryParam('page', 1);
    $per = $request->getQueryParam('per', 5);
    $offset = ($page - 1) * $per;
    $companies = json_encode(array_slice($companies, $offset, $per));
    return $response->write($companies);
});

// END

$app->run();
