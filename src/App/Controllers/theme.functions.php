<?php 

use Kenjiefx\StrawberryFramework\App\Models\AppConfig;
use Kenjiefx\StrawberryFramework\App\Models\ThemeModel;
use Kenjiefx\StrawberryFramework\App\Models\ComponentModel;
use Kenjiefx\StrawberryFramework\App\Factories\ContainerFactory;
use Kenjiefx\StrawberryFramework\App\Controllers\ComponentController;

function component(
    string $name
    ) 
{
    $theme = (new ThemeModel)->setName((new AppConfig)('theme')['name']);
    $controller = ContainerFactory::create()->get(ComponentController::class);
    $controller->setTheme($theme);
    $controller->setComponentName($name);
    $pathToComponentHtml = $controller->getHTMLPath();
    if (!file_exists($pathToComponentHtml)) {
        echo 'Component not found';
        return;
    }
    $controller->toCache();
    include $pathToComponentHtml;
}