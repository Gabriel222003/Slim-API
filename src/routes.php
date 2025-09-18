<?php

use Slim\App;
use App\Controllers\OfertaController;

// GET /ofertas. Onde será chamado a Controller para gerenciar os dados apresentados 
return function (App $app){
    $app->get('/ofertas', [OfertaController::class, 'getOfertas']);
};
