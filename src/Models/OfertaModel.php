<?php
namespace App\Models;

class OfertaModel{
    public function getAll() : array{
        $data = file_get_contents(__DIR__ . "/../../data.json");
        $json = json_decode($data, true);
        return $json['offers']?? [];
    }
}