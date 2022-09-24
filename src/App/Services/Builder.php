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
        /**
         * This phase of the build process compiles all the used component 
         * in the theme into one string of HTML codes, saving 
         * it in the $rawHTML property of the Theme Model object.
         */
        $this->ThemeController->setTheme($this->ThemeModel);
        $this->ThemeController->compile();

        /**
         * This phase of the build process analyzes, compiles, and minifies 
         * all the used CSS in the theme
         */
        $this->Css->setTheme($this->ThemeModel);
        $this->Css->setRawHtml($this->ThemeModel->getRawHTML());
        $this->Css->process();


        $this->Js->setTheme($this->ThemeModel);
        $this->Js->process();


        return $this->Css->getProcessedHTML();
    }

    public function widget(
        string $type
    )
    {
        $mimeType = 'text/html';
        $returnContent = '';
        switch ($type) {
            case 'app.css': 
                $mimeType = 'text/css';
                $returnContent .= $this->Css->getFromCache();
                break;
            case 'app.js':
                $mimeType = 'text/javascript';
                $returnContent .= $this->Js->getFromCache();
                break;
            default: 
                break;
        }
        return [
            'type' => $mimeType,
            'content' => $returnContent
        ];
    }





}
