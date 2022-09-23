<?php

namespace Kenjiefx\StrawberryFramework\App\Controllers;

use Kenjiefx\StrawberryFramework\App\Models\ThemeModel;

class ThemeController
{

    private string $theme = '';

    public function setTheme(
        ThemeModel $themeModel
        )
    {
        $this->ThemeModel = $themeModel;
    }

    public function compile()
    {
        ob_start();
        $this->build();
        $this->ThemeModel->setRawHTML(ob_get_contents());
        ob_end_clean();
    }


    private function build()
    {
        include __dir__.'/theme.functions.php';
        include $this->ThemeModel->getIndexPath();
    }

    

}


