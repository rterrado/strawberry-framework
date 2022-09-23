<?php

namespace Kenjiefx\StrawberryFramework\App\Controllers;

use Kenjiefx\StrawberryFramework\App\Models\ThemeModel;
use Kenjiefx\StrawberryFramework\App\Controllers\ThemeController;

class WidgetController extends ThemeController
{

    protected ThemeModel $ThemeModel;

    public function getWidgetPath()
    {
        return $this->ThemeModel->getThemeDir().'/widgets';
    }

    public function getCssWidgetPath()
    {
        return $this->getWidgetPath().'/css';
    }

    public function getAllCssJsonpaths()
    {
        return $this->getByFileType('json');
    }

    public function getAllCsspaths()
    {
        return $this->getByFileType('css');
    }

    private function getByFileType(
        string $fileType
        )
    {
        $result = [];
        foreach (scandir($this->getCssWidgetPath()) as $file) {
            if($file==='.'||$file==='..') continue;
            $fileDetails = explode('.',$file);
            if (end($fileDetails)===$fileType) {
                array_push($result,$this->getCssWidgetPath().'/'.$file);
            }
        }
        return $result;
    }

}
