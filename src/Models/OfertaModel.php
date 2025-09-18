<?php
namespace App\Models;

class OfertaModel{
    public function getAll() : array{
        //Fazendo a leitura do arquivo data.json
        $data = file_get_contents(__DIR__ . "/../../data.json");
        //Transforma o JSON em um array associativo 
        $json = json_decode($data, true);
        return $json['offers']?? [];
    }
}