<?php

namespace Kenjiefx\StrawberryFramework\App\Services;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Slim\App as RouteServiceProvider;

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
            
            return $response;
        });
    }


    public function route()
    {
        return $this->RouteServiceProvider->run();
    }
}
