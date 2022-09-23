<?php

namespace Kenjiefx\StrawberryFramework\App\Services;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Slim\App as RouteServiceProvider;
use Kenjiefx\StrawberryFramework\App\Services\Builder;
use Kenjiefx\StrawberryFramework\App\Factories\ContainerFactory;

class Router
{
    public function __construct(
        private RouteServiceProvider $RouteServiceProvider
        )
    {

    }

    public function register()
    {
        $this->RouteServiceProvider->get('/', function (Request $request, Response $response, $args) {
            $Builder = ContainerFactory::create()->get(Builder::class);
            $response->getBody()->write($Builder->theme());
            return $response;
        });
    }


    public function route()
    {
        return $this->RouteServiceProvider->run();
    }
}
