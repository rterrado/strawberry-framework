<?php

namespace Kenjiefx\StrawberryFramework\App\Modules;

use Slim\Factory\AppFactory;
use Kenjiefx\StrawberryFramework\App\Services\Router;
use Kenjiefx\StrawberryFramework\App\Services\Server;
use Kenjiefx\StrawberryFramework\App\Services\Container;
use Kenjiefx\StrawberryFramework\App\Modules\ModuleInterface;
use Kenjiefx\StrawberryFramework\App\Factories\ContainerFactory;

class PreviewModule implements ModuleInterface
{

    private Server $Server;

    public function __construct()
    {
        $this->Server = new Server(
            new Router(AppFactory::create()),
            new Container(ContainerFactory::create())
        );
    }

    public function import()
    {
        $this->Server->register();
        return $this;
    }

    public function build()
    {
        $this->Server->serve();
        return $this;
    }
}
