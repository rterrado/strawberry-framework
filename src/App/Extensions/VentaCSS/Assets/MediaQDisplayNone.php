<?php

namespace Kenjiefx\StrawberryFramework\App\Extensions\VentaCSS\Assets;

use Kenjiefx\StrawberryFramework\App\Extensions\VentaCSS\Services\VentaDashboard;
use Kenjiefx\StrawberryFramework\App\Extensions\VentaCSS\Services\MediaQueryManager;

class MediaQDisplayNone
{
    public static function assign(
        MediaQueryManager $MediaQueryManager,
        VentaDashboard $VentaDashboard
        )
    {
        foreach ($MediaQueryManager->getRegistry() as $widthQueryClause => $registryItem) {
            $MediaQueryManager->addItemToSelectorListRegistry(
                $widthQueryClause, 'display-none-'.$registryItem['selector_clause'], 'display:none;'
            );
        }
    }
}
