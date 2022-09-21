<?php

namespace Kenjiefx\StrawberryFramework\App\Controllers;

use Kenjiefx\StrawberryFramework\App\Models\AppConfig;
use Kenjiefx\StrawberryFramework\App\Models\ThemeModel;
use Kenjiefx\StrawberryFramework\App\Cache\ComponentCache;
use Kenjiefx\StrawberryFramework\App\Controllers\ThemeController;

class ComponentController extends ThemeController
{
    public function __construct(
        private AppConfig $Config,
        protected ThemeModel $ThemeModel,
        protected ComponentCache $ComponentCache
        )
    {
        
    }

}
