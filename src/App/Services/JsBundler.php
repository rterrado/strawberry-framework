<?php

namespace Kenjiefx\StrawberryFramework\App\Services;

use Kenjiefx\StrawberryFramework\App\Models\AppConfig;
use Kenjiefx\StrawberryFramework\App\Models\ThemeModel;
use Kenjiefx\StrawberryFramework\App\Services\JSMinifier;
use Kenjiefx\StrawberryFramework\App\Cache\ComponentCache;
use Kenjiefx\StrawberryFramework\App\Factories\ContainerFactory;
use Kenjiefx\StrawberryFramework\App\Controllers\WidgetController;
use Kenjiefx\StrawberryFramework\App\Controllers\ComponentController;

class JsBundler
{
    public function __construct(
        private ComponentCache $ComponentCache,
        private ThemeModel $ThemeModel,
        private AppConfig $AppConfig,
        private WidgetController $WidgetController
        )
    {
        $this->ThemeModel->setName((new AppConfig)('theme')['name']);
        $this->WidgetController->setTheme($this->ThemeModel);
    }

    public function getMain()
    {
        return file_get_contents($this->WidgetController->getJsMainPath());
    }

    public function bundleFactories()
    {
        $js = '';
        $path = $this->WidgetController->getJsFactoriesPath();
        foreach(scandir($path) as $file) {
            if ($file==='.'||$file==='..') continue;
            $filePath = $path.'/'.$file;
            $js .= (new JSMinifier(file_get_contents($filePath))
            )->minify();
        }
        return $js;
    }

    public function bundleServices()
    {
        $js = '';
        $path = $this->WidgetController->getJsServicesPath();
        foreach(scandir($path) as $file) {
            if ($file==='.'||$file==='..') continue;
            $filePath = $path.'/'.$file;
            $js .= (new JSMinifier(file_get_contents($filePath))
            )->minify();
        }
        return $js;
    }

    public function bundleComponents()
    {
        $js= '';
        $componentNames = $this->ComponentCache->loadItem();
        foreach ($componentNames as $componentName) {
            $component = ContainerFactory::create()->get(ComponentController::class);
            $component->setTheme($this->ThemeModel);
            $component->setComponentName($componentName);
            $componentJsPath = $component->getJsPath();
            $componentJsContents = file_get_contents($componentJsPath);
            if (trim($componentJsContents)==='') continue;
            $compiled = (new JSImporter(
                $componentJsContents,
                $component->getComponentDir().'/classes'
            ))->import();
            $js .= (new JSMinifier(trim($compiled)))->minify();
        }
        return $js;
    }



    
}
