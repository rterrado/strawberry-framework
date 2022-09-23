<?php

declare(strict_types=1);
namespace Kenjiefx\StrawberryFramework\App\Extensions\VentaCSS\Services;

class SelectorStructure {

    public static function generate(
        string $selector
        )
    {
        return [
            function($selector){
                return ' '.$selector.' ';
            },
            function($selector){
                return $selector.' ';
            },
            function($selector){
                return ' '.$selector;
            },
            function($selector){
                return $selector;
            },
        ];
    }

}
