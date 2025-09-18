<?php

namespace App\Helpers;

class Format{
    //Faz a formatação dos itens do array
    public static function formatOferta(array $oferta): array{
        
        //Verifica qual o formato do curso para fazer a formatação
        if($oferta["kind"] == "presencial"){
            $oferta["kind"] = "Presencial 🏫";
        }
        else if($oferta["kind"]  == "ead"){
            $oferta["kind"] = "EaD 🏠";
        }


        //Verifica o level e substitui para a formatação adequada
        switch($oferta["level"]){
            case "bacharelado":
                $oferta["level"] = "Graduação (bacharelado) 🎓";
                break;
            case "tecnologo":
                $oferta["level"] = "Graduação (tecnólogo) 🎓";
                break;
            case "licenciatura":
                $oferta["level"] = "Graduação (licenciatura) 🎓";
                break;

        }
        
        //Formatação do preço para real
        $oferta["fullPrice"] = 'R$ ' . number_format($oferta["fullPrice"], 2, ',', '.');
        $oferta["offeredPrice"] ='R$ ' . number_format($oferta["offeredPrice"], 2, ',', '.');
        


        //Lógica de desconto
        //Retira elementos da string antes de converte a string um valor float
        $valorNormal = floatval(str_replace(["R$",",", "."], "", $oferta["fullPrice"]));
        $valorDesconto = floatval(str_replace(["R$",",", "."], "", $oferta["offeredPrice"]));
        //Valida se valorNomal é maoir que 0
        if($valorNormal > 0){
            $desconto = round((1 - ($valorDesconto / $valorNormal)) * 100);
            $oferta["discount"] =  $desconto . "% 📉";
        } else{
            $oferta["discount"] = "0% 📉";
        }

        return $oferta;
    }
}