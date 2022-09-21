<?php

namespace Kenjiefx\StrawberryFramework\App\Services;

use Kenjiefx\StrawberryFramework\App\Models\AppConfig;
use Kenjiefx\StrawberryFramework\App\Models\ThemeModel;
use Kenjiefx\StrawberryFramework\App\Models\BuildInstance;
use Kenjiefx\StrawberryFramework\App\Controllers\JsController;
use Kenjiefx\StrawberryFramework\App\Controllers\CssController;
use Kenjiefx\StrawberryFramework\App\Controllers\ComponentController;

class Builder
{

    public function __construct(
        private AppConfig $Config,
        private ThemeModel $ThemeModel,
        private ComponentController $Component,
        private JsController $Js,
        private CssController $Css 
        )
    {
        BuildInstance::id();
        $this->ThemeModel->setName($Config('theme')['name']);
    }

    public function component()
    {
        $this->Component->setTheme($this->ThemeModel);
        $this->Component->compile();
        return $this->ThemeModel->getRawHTML();
    }



}
