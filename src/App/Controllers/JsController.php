<?php

namespace Kenjiefx\StrawberryFramework\App\Controllers;

use Kenjiefx\StrawberryFramework\App\Cache\JsCache;
use Kenjiefx\StrawberryFramework\App\Services\JsBundler;
use Kenjiefx\StrawberryFramework\App\Cache\ComponentCache;
use Kenjiefx\StrawberryFramework\App\Controllers\WidgetController;

class JsController extends WidgetController
{

    public function __construct(
        private ComponentCache $ComponentCache,
        private JsCache $JsCache,
        private JsBundler $JsBundler
        )
    {
        
    }
    
    public function process()
    {
        $js = $this->JsBundler->getMain().
              $this->JsBundler->bundleFactories().
              $this->JsBundler->bundleServices().
              $this->JsBundler->bundleComponents();
        $this->JsCache->addItem([
            'content' => $js
        ]);
    }

    public function getFromCache()
    {
        return $this->JsCache->loadItem();
    }
}
