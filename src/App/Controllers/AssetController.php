<?php

namespace Kenjiefx\StrawberryFramework\App\Controllers;

use Kenjiefx\StrawberryFramework\App\Models\AppConfig;
use Kenjiefx\StrawberryFramework\App\Models\AssetModel;
use Kenjiefx\StrawberryFramework\App\Models\ThemeModel;
use Kenjiefx\StrawberryFramework\App\Controllers\ThemeController;

class AssetController extends ThemeController
{

    protected ThemeModel $ThemeModel;
    private string $assetPointer;

    public function __construct(
        private AppConfig $Config,
        private AssetModel $AssetModel 
        )
    {

    }

    public function pointAssetTo(
        string $assetPointer
        )
    {
        $this->assetPointer = $assetPointer;
        $this->AssetModel->setPointer($assetPointer);
    }

    public function resolvePath()
    {
        return $this->ThemeModel->getThemeDir().'/'.$this->AssetModel->getPath();
    }



}
