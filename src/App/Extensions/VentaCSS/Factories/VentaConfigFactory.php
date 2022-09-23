<?php

declare(strict_types=1);
namespace Kenjiefx\StrawberryFramework\App\Extensions\VentaCSS\Factories;
use Kenjiefx\StrawberryFramework\App\Extensions\VentaCSS\VentaConfig;

class VentaConfigFactory {

    private static $instance;

    public static function create()
    {
        if (!isset(static::$instance)) {
            static::$instance = new VentaConfig;
        }
        return static::$instance;
    }

}
