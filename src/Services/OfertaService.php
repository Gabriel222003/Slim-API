<?php

namespace App\Services;

use App\Models\OfertaModel;
use App\Helpers\Format;

class OfertaService{
    private $model;

    //Instância o modelo dos dados 
    public function __construct(){
        $this->model = new OfertaModel();
    }

    //Retorna o array de dados, após filtragem, páginação, ordenação e dados que devem ser retornados 
    public function buscarOfertas(array $params): array{
        //Pega todos os dados da model
        $ofertas = $this->model->getAll();
        
        //Aloca nas variaveis os parametros correspondetes da URL. Caso não esse parametro, ele é pré setado.
        $level = $params['level'] ?? null;
        $kind = $params['kind'] ?? null;
        $minPrice = isset($params['minPrice']) ? (float)$params['minPrice'] : null;
        $maxPrice = isset($params['maxPrice']) ? (float)$params['maxPrice'] : null;
        $page = isset($params['page']) && (int)$params['page'] > 0? (int)$params['page'] : 1;
        $pageLimit = isset($params['pageLimit']) && (int)$params['pageLimit'] >= 0 ? (int)$params['pageLimit'] : 10;
        $search = $params['search'] ?? null;
        $fields = isset($params['fields']) ? explode(',', $params['fields']) : null; 
        //Ordena a lista por: courseName, rating ou offeredPrice
        $sort = $params['sort'] ?? null;


        //Faz a filtragem dos dados com base nos parametors informados na URL. O método retira o elemento que retornar falso
        $ofertasFiltradas = array_filter($ofertas, function($oferta) use ($level, $kind, $minPrice, $maxPrice, $search) {

            //Verifica se o dado é null ou se ele é diferente do array de dados
            if ($level && $oferta['level'] != $level) return false;
            if ($kind && $oferta['kind'] != $kind) return false;
            if (($minPrice !== null && $oferta['offeredPrice'] < $minPrice) ||
                ($maxPrice !== null && $oferta['offeredPrice'] > $maxPrice)) return false;
            if ($search && stripos($oferta['courseName'], $search) === false) return false;

            return true;

        });


        //Ordenação dos dados com base no courseName, rating ou offeredPrice.
        if ($sort) {
            
            /* Método faz comparação de dois itens do array associativo. Se o retorno for 0 o item não muda de lugar. Se for -1, A é antes de B.
            Se for 1, B antes de A */ 
            usort($ofertasFiltradas, function($a, $b) use ($sort) {
                $valA = $a[$sort] ?? 0;
                $valB = $b[$sort] ?? 0;

                if ($valA == $valB) return 0;
                return ($valA < $valB ? -1 : 1);
            });
        }
        
        //Paginação dos itens
        $comeco = (($page - 1) * $pageLimit);
        //Método pega o array de itens e pega os elementos com base no inicil e fim passados
        $paginacao = array_slice($ofertasFiltradas, $comeco, $pageLimit);


        //Formatação com base no método formatOferta da classe Format
        $formatado = array_map([Format::class, 'formatOferta'], $paginacao);

        
        //returna os itens que devem ser retornados. Somente se fields for passado
        return array_map(function ($oferta) use($fields){
            if($fields){
                $filtered = [];
                foreach ($fields as $field){
                    if(isset($oferta[$field])){
                        $filtered[$field] = $oferta[$field];
                    }
                }
                return $filtered;
            }

            return $oferta;

        }, $formatado);
    }

}