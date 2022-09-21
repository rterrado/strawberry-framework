<?php

namespace Kenjiefx\StrawberryFramework\App\Services;

use Kenjiefx\StrawberryFramework\App\Services\Router;
use Kenjiefx\StrawberryFramework\App\Services\Container;

class Server
{
    public function __construct(
        private Router $Router,
        private Container $Container
        )
    {

    }

    public function register()
    {
        $this->Container->register();
        $this->Router->register();
    }

    public function serve()
    {
        $this->Router->route();
    }
}
