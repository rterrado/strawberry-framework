<?php

declare(strict_types=1);
namespace Kenjiefx\StrawberryFramework\App\Extensions\VentaCSS\Services;
use Kenjiefx\StrawberryFramework\App\Models\AppConfig;
use Kenjiefx\StrawberryFramework\App\Models\ThemeModel;
use Kenjiefx\StrawberryFramework\App\Cache\ComponentCache;
use Kenjiefx\StrawberryFramework\App\Factories\ContainerFactory;
use Kenjiefx\StrawberryFramework\App\Controllers\WidgetController;
use Kenjiefx\StrawberryFramework\App\Controllers\ComponentController;
use Kenjiefx\StrawberryFramework\App\Factories\ComponentControllerFactory;

class GroupedAssetsManager {

    private array $groups = [];

    public function __construct(
        private ComponentCache $ComponentCache,
        private AppConfig $AppConfig,
        private ThemeModel $ThemeModel,
        private WidgetController $WidgetController
        )
    {
        $this->ThemeModel->setName((new AppConfig)('theme')['name']);
    }

    public function compileAssets()
    {
        $groups = [];

        $componentNames = $this->ComponentCache->loadItem();
        foreach ($componentNames as $componentName) {
            $component = ContainerFactory::create()->get(ComponentController::class);
            $component->setTheme($this->ThemeModel);
            $component->setComponentName($componentName);
            $this->parseGroups(
                $this->loadCssJsonFile($component->getCssJsonPath())
            );
        }

        $this->WidgetController->setTheme($this->ThemeModel);
        $widgetCssJsonPaths = $this->WidgetController->getAllCssJsonpaths();
        foreach ($widgetCssJsonPaths as $widgetCssJsonPath) {
            $this->parseGroups(
                $this->loadCssJsonFile($widgetCssJsonPath)
            );

        }

        return $this->groups;
    }

    private function parseGroups(
        array $groupedSelectors
        )
    {
        foreach ($groupedSelectors as $groupedSelector) {
            foreach ($groupedSelector as $groupedSelectorName => $groupedSelectorMembers) {
                $this->groups[$groupedSelectorName] = explode(' ',$groupedSelectorMembers);
            }
        }
    }

    private function loadCssJsonFile(
        string $filePath
        )
    {
        return json_decode(
            file_get_contents($filePath),TRUE
        );
    }

}
