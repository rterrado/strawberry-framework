<?php

namespace Kenjiefx\StrawberryFramework\App\Controllers;

use Kenjiefx\StrawberryFramework\App\Models\AppConfig;
use Kenjiefx\StrawberryFramework\App\Models\ThemeModel;
use Kenjiefx\StrawberryFramework\App\Cache\ComponentCache;
use Kenjiefx\StrawberryFramework\App\Models\ComponentModel;
use Kenjiefx\StrawberryFramework\App\Controllers\ThemeController;

class ComponentController extends ThemeController
{

    protected ThemeModel $ThemeModel;

    public function __construct(
        private AppConfig $Config,
        protected ComponentCache $ComponentCache,
        protected ComponentModel $ComponentModel
        )
    {
        
    }

    public function setComponentName(
        string $name
        )
    {
        $this->ComponentModel->setName($name);
    }

    public function getHTMLPath()
    {
        return $this->getComponentDir().
               '/'.
               $this->ComponentModel->getName().
               '.php';
    }

    public function getComponentDir()
    {
        return $this->ThemeModel->getThemeDir().
               ComponentModel::DIR.
               '/'.
               $this->ComponentModel->getName();
    }

    public function toCache()
    {
        $this->ComponentCache->addItem(
            ['name' => $this->ComponentModel->getName()]
        );
    }

    public function getCssJsonPath()
    {
        return $this->getComponentDir().
               '/'.
               $this->ComponentModel->getName().
               '.css.json';
    }

    public function getCssPath()
    {
        return $this->getComponentDir().
               '/'.
               $this->ComponentModel->getName().
               '.css';
    }

    public function getJsPath()
    {
        return $this->getComponentDir().
               '/'.
               $this->ComponentModel->getName().
               '.js';
    }




}
