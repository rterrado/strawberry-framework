<?php

declare(strict_types=1);
namespace Kenjiefx\StrawberryFramework\App\Extensions\VentaCSS\Services;
use Kenjiefx\StrawberryFramework\App\Models\AppConfig;
use Kenjiefx\StrawberryFramework\App\Models\ThemeModel;
use Kenjiefx\StrawberryFramework\App\Cache\ComponentCache;
use Kenjiefx\StrawberryFramework\App\Factories\ContainerFactory;
use Kenjiefx\StrawberryFramework\App\Controllers\ComponentController;
use Kenjiefx\StrawberryFramework\App\Factories\ComponentControllerFactory;

class GroupedAssetsManager {

    public function __construct(
        private ComponentCache $ComponentCache,
        private AppConfig $AppConfig,
        private ThemeModel $ThemeModel
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



            $groupedSelectors = json_decode(
                file_get_contents($component->getCssJsonPath()),TRUE
            );

            foreach ($groupedSelectors as $groupedSelector) {

                foreach ($groupedSelector as $groupedSelectorName => $groupedSelectorMembers) {

                    $groups[$groupedSelectorName] = explode(' ',$groupedSelectorMembers);

                }
            }
        }

        return $groups;
    }

}
