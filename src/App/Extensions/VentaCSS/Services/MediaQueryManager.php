<?php

namespace Kenjiefx\StrawberryFramework\App\Extensions\VentaCSS\Services;

use Kenjiefx\StrawberryFramework\App\Extensions\VentaCSS\VentaConfig;
use Kenjiefx\StrawberryFramework\App\Extensions\VentaCSS\Assets\MediaQFlexbox;
use Kenjiefx\StrawberryFramework\App\Extensions\VentaCSS\Services\VentaDashboard;
use Kenjiefx\StrawberryFramework\App\Extensions\VentaCSS\Assets\MediaQDisplayNone;
use Kenjiefx\StrawberryFramework\App\Extensions\VentaCSS\Factories\VentaConfigFactory;

class MediaQueryManager
{

    private VentaConfig $VentaConfig;
    private array $registry = [];

    public function __construct(
        private VentaConfigFactory $VentaConfigFactory,
        private VentaDashboard $VentaDashboard
        )
    {
        $this->VentaConfig = VentaConfigFactory::create();
        $this->addBreakpointsToRegistry();
    }

    private function addBreakpointsToRegistry()
    {
        $breakpoints = $this->VentaConfig->getSettings('breakpoints');
        foreach($breakpoints as $breakpoint) {

            $maxWidthQueryClause = 'max-width: '.$breakpoint['max'];
            $this->registry[$maxWidthQueryClause]['selector_clause'] = 'until-max-width-'.$breakpoint['max'].'px';
            $this->registry[$maxWidthQueryClause]['selector_list'] = [];

            $minWidthQueryClause = 'min-width: '.$breakpoint['min'];
            $this->registry[$minWidthQueryClause]['selector_clause'] = 'until-min-width-'.$breakpoint['min'].'px';
            $this->registry[$minWidthQueryClause]['selector_list'] = [];
        }
    }

    public function compileAssets()
    {
        MediaQFlexbox::assign($this,$this->VentaDashboard);
        MediaQDisplayNone::assign($this,$this->VentaDashboard);
        return $this->registry;
    }

    public function getRegistry()
    {
        return $this->registry;
    }

    public function addItemToSelectorListRegistry(
        string $widthQueryClause,
        string $selectorItemToAdd,
        string $selectorValueToAdd
        )
    {
        $this->registry[$widthQueryClause]['selector_list'][$selectorItemToAdd] = $selectorValueToAdd;
    }


}
