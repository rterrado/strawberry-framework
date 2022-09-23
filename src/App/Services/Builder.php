<?php

namespace Kenjiefx\StrawberryFramework\App\Services;

use Kenjiefx\StrawberryFramework\App\Models\AppConfig;
use Kenjiefx\StrawberryFramework\App\Models\ThemeModel;
use Kenjiefx\StrawberryFramework\App\Models\BuildInstance;
use Kenjiefx\StrawberryFramework\App\Controllers\JsController;
use Kenjiefx\StrawberryFramework\App\Controllers\CssController;
use Kenjiefx\StrawberryFramework\App\Controllers\ThemeController;

class Builder
{

    public function __construct(
        private AppConfig $Config,
        private ThemeModel $ThemeModel,
        private ThemeController $ThemeController,
        private JsController $Js,
        private CssController $Css 
        )
    {
        BuildInstance::id();
        $this->ThemeModel->setName($Config('theme')['name']);
    }

    public function theme()
    {
        $this->ThemeController->setTheme($this->ThemeModel);
        $this->ThemeController->compile();
        $this->Css->setTheme($this->ThemeModel);
        $this->Css->setRawHtml($this->ThemeModel->getRawHTML());
        $this->Css->process();
        return $this->Css->getProcessedHTML();
    }





}
