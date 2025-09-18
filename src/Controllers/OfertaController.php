<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Services\OfertaService;

class OfertaController{
    private $service;

    //Na isntância da Controller, vou instânciar OfertaService 
    public function __construct(){
        
        $this->service = new OfertaService();
    }

    //Apresenta oa dados na tela e obtem parametros passados na URL
    public function getOfertas(Request $request, Response $response): Response {
        //Obtem os parametros passado na URL
        $params = $request->getQueryParams();

        //Chama o método de busca de OfertaServicel, passado os parametros capiturados
        $resultado = $this->service->buscarOfertas($params);


        //Formatação do Json a ser apresentado na tela
        $response->getBody()->write(json_encode($resultado, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
        return $response->withHeader('Content-Type', 'application/json');
    }


}