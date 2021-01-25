<?php

namespace SHR;

use Slim\Factory\AppFactory;
use Faker\Factory;

require __DIR__ . '/../vendor/autoload.php';

$faker = Factory::create();
$faker->seed(1234);

$domains = [];
for ($i = 0; $i < 10; $i++) {
    $domains[] = $faker->domainName;
}

$phones = [];
for ($i = 0; $i < 10; $i++) {
    $phones[] = $faker->phoneNumber;
}

$app = AppFactory::create();
$app->addErrorMiddleware(true, true, true);

$app->get('/', function ($request, $response) {
    return $response->write('go to the /phones or /domains');
});

// BEGIN (write your solution here)
$app->get('/phones', function ($request, $response) use ($phones) {

    return $response->write(json_encode($phones));
});
$app->get('/domains', function ($request, $response) use ($domains) {

    return $response->write(json_encode($domains));
});
// END

$app->run();
