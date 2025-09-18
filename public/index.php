<?php
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

//Local das Rotas
(require __DIR__ . '/../src/routes.php')($app);

$app->run();
