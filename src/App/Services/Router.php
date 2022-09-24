<?php

namespace Kenjiefx\StrawberryFramework\App\Services;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Slim\App as RouteServiceProvider;
use Kenjiefx\StrawberryFramework\App\Services\Builder;
use Kenjiefx\StrawberryFramework\App\Models\BuildInstance;
use Kenjiefx\StrawberryFramework\App\Services\QueryParser;
use Kenjiefx\StrawberryFramework\App\Factories\ContainerFactory;
use Kenjiefx\StrawberryFramework\App\Extensions\VentaCSS\VentaCSS;
use Kenjiefx\StrawberryFramework\App\Extensions\StrawberryJS\StrawberryJS;

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

        $this->RouteServiceProvider->get('/widget/{widget}', function (Request $request, Response $response, $args) {
            $buildId = (new QueryParser())->set($request->getUri()->getQuery())->get('build');
            if (null===$buildId) return $response->withStatus(400);
            BuildInstance::setId(intval($buildId));
            $Builder = ContainerFactory::create()->get(Builder::class);
            $responseArgs = $Builder->widget($args['widget']);
            $response->getBody()->write($responseArgs['content']);
            return $response
                ->withHeader('Content-Type',$responseArgs['type'])
                ->withStatus(200);
        });

        $this->RouteServiceProvider->get('/favicon.ico', function (Request $request, Response $response, $args) {
            
            return $response;
        });

        $this->RouteServiceProvider->get('/strawberry.js', function (Request $request, Response $response, $args) {
            header('Content-type: text/javascript');
            StrawberryJS::build();
            return $response;
        });

        $this->RouteServiceProvider->get('/venta.app', function (Request $request, Response $response, $args) {
            $VentaApp = ContainerFactory::create()->get(VentaCSS::class);
            $response->getBody()->write($VentaApp->getDashboard());
            return $response;
        });
    }




    public function route()
    {
        return $this->RouteServiceProvider->run();
    }
}
