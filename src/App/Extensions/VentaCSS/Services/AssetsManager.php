<?php

declare(strict_types=1);
namespace Kenjiefx\StrawberryFramework\App\Extensions\VentaCSS\Services;
use Kenjiefx\StrawberryFramework\App\Extensions\VentaCSS\VentaConfig;
use Kenjiefx\StrawberryFramework\App\Extensions\VentaCSS\Services\VentaDashboard;
use Kenjiefx\StrawberryFramework\App\Extensions\VentaCSS\Factories\VentaConfigFactory;
use Kenjiefx\StrawberryFramework\App\Extensions\VentaCSS\Assets\Width;
use Kenjiefx\StrawberryFramework\App\Extensions\VentaCSS\Assets\MaxWidth;
use Kenjiefx\StrawberryFramework\App\Extensions\VentaCSS\Assets\MinWidth;
use Kenjiefx\StrawberryFramework\App\Extensions\VentaCSS\Assets\ItemWidth;
use Kenjiefx\StrawberryFramework\App\Extensions\VentaCSS\Assets\SmallWidth;
use Kenjiefx\StrawberryFramework\App\Extensions\VentaCSS\Assets\Height;
use Kenjiefx\StrawberryFramework\App\Extensions\VentaCSS\Assets\DeviceHeight;
use Kenjiefx\StrawberryFramework\App\Extensions\VentaCSS\Assets\MinHeight;
use Kenjiefx\StrawberryFramework\App\Extensions\VentaCSS\Assets\Margin;
use Kenjiefx\StrawberryFramework\App\Extensions\VentaCSS\Assets\Padding;
use Kenjiefx\StrawberryFramework\App\Extensions\VentaCSS\Assets\Text;
use Kenjiefx\StrawberryFramework\App\Extensions\VentaCSS\Assets\LineHeight;
use Kenjiefx\StrawberryFramework\App\Extensions\VentaCSS\Assets\LetterSpacing;
use Kenjiefx\StrawberryFramework\App\Extensions\VentaCSS\Assets\FontWeight;
use Kenjiefx\StrawberryFramework\App\Extensions\VentaCSS\Assets\Border;
use Kenjiefx\StrawberryFramework\App\Extensions\VentaCSS\Assets\Color;
use Kenjiefx\StrawberryFramework\App\Extensions\VentaCSS\Assets\Flexbox;

class AssetsManager {

    private array $ListOfUtilityClasses = [];
    private VentaConfig $VentaConfig;

    public function __construct(
        private VentaConfigFactory $VentaConfigFactory,
        private VentaDashboard $VentaDashboard
        )
    {
        $this->VentaConfig = VentaConfigFactory::create();
    }

    public function compileAssets()
    {
        Width::assign($this,$this->VentaDashboard);
        MaxWidth::assign($this,$this->VentaDashboard);
        MinWidth::assign($this,$this->VentaDashboard);
        ItemWidth::assign($this,$this->VentaDashboard);
        SmallWidth::assign($this,$this->VentaDashboard);
        Height::assign($this,$this->VentaDashboard);
        DeviceHeight::assign($this,$this->VentaDashboard);
        MinHeight::assign($this,$this->VentaDashboard);
        Margin::assign($this,$this->VentaDashboard);
        Padding::assign($this,$this->VentaDashboard);
        Text::assign($this,$this->VentaDashboard);
        LineHeight::assign($this,$this->VentaDashboard);
        LetterSpacing::assign($this,$this->VentaDashboard);
        FontWeight::assign($this,$this->VentaDashboard);
        Border::assign($this,$this->VentaDashboard);
        Color::assign($this,$this->VentaDashboard);
        Flexbox::assign($this,$this->VentaDashboard);
        return $this->ListOfUtilityClasses;
    }

    public function getRaw(
        string $selector
        )
    {
        return $this->VentaConfig->getSettings($selector);
    }

    public function setRefined(
        string $key,
        string $value
        )
    {
        $this->ListOfUtilityClasses[$key] = $value;
    }

}
