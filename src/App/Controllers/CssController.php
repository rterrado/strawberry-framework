<?php

namespace Kenjiefx\StrawberryFramework\App\Controllers;

use Kenjiefx\StrawberryFramework\App\Cache\CssCache;
use Kenjiefx\StrawberryFramework\App\Services\CSSBundler;
use Kenjiefx\StrawberryFramework\App\Cache\ComponentCache;
use Kenjiefx\StrawberryFramework\App\Models\BuildInstance;
use Kenjiefx\StrawberryFramework\App\Controllers\WidgetController;
use Kenjiefx\StrawberryFramework\App\Extensions\VentaCSS\VentaCSS;

class CssController extends WidgetController
{

    private string $rawHTML;
    private string $CssData;

    public function __construct(
        private ComponentCache $ComponentCache,
        private CssCache $CssCache,
        private VentaCSS $VentaCSS,
        private CSSBundler $CSSBundler
        )
    {
        
    }

    public function setRawHTML(
        string $rawHTML
        )
    {
        $this->rawHTML = $rawHTML;
    }

    public function process()
    {
        $this->VentaCSS->setPreProcessedHTML(
            $this->rawHTML
        );
        $this->VentaCSS->run();
        $this->CssData = $this->VentaCSS->exportUsableCSS();
        $this->CssData .= $this->CSSBundler->bundleFromComponents();
        $this->CssData .= $this->CSSBundler->bundleFromWidgetCss();
        $this->CssCache->addItem([
            'content' => $this->CssData
        ]);
    }

    public function getProcessedHTML()
    {
        return $this->VentaCSS->getPostProcessedHTML();
    }

    public function getFromCache()
    {
        return $this->CssCache->loadItem();
    }



}
