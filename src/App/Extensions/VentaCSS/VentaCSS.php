<?php

declare(strict_types=1);
namespace Kenjiefx\StrawberryFramework\App\Extensions\VentaCSS;
use Kenjiefx\StrawberryFramework\App\Services\Cache\CSSCacheManager;
use Kenjiefx\StrawberryFramework\App\Extensions\VentaCSS\VentaConfig;
use Kenjiefx\StrawberryFramework\App\Extensions\VentaCSS\Factories\VentaConfigFactory;
use Kenjiefx\StrawberryFramework\App\Extensions\VentaCSS\Services\ClassParser;
use Kenjiefx\StrawberryFramework\App\Extensions\VentaCSS\Services\AssetsManager;
use Kenjiefx\StrawberryFramework\App\Extensions\VentaCSS\Services\SelectorStructure;
use Kenjiefx\StrawberryFramework\App\Extensions\VentaCSS\Services\ClassNameMinifier;
use Kenjiefx\StrawberryFramework\App\Extensions\VentaCSS\Services\GroupedAssetsManager;


class VentaCSS  {

    /**
     * @var string $PreProcessedHTML - The HTML document
     *             before CSS file has been processed
     */
    private string $PreProcessedHTML = '';

    /**
     * @var string $PostProcessedHTML - The HTML document
     *             after CSS file has been processed
     */
    private string $PostProcessedHTML = '';

    /**
     * @var array $ClassRegistry - Contains all the class attributes
     *            that can be found in the source the HTML document
     */
    private array $ClassRegistry = [];

    /**
     * @var array $ListOfUtilityClasses - All Utility classes generated
     *            by the AssetsManager object
     */
    private array $ListOfUtilityClasses = [];

    /**
     * @var array $UsedUtilityClasses - All Utility classes that were
     *            being used, already minified
     */
    private array $UsedUtilityClasses = [];

    /**
     * @var array $ListOfMediaQueryBreakPoints - All media breakpoints
     *            and their Utility classes generated and listed by
     *            the MediaQueryManager object
     */
    private array $ListOfMediaQueryBreakPoints = [];

    /**
     * @var array $UsedMediaQueryBreakpoints - All media breakpoints
     *            and their Utility Classes being used
     */
    private array $UsedMediaQueryBreakpoints = [];


    private VentaConfig $VentaConfig;


    public function __construct(
        private VentaConfigFactory $VentaConfigFactory,
        private ClassParser $ClassParser,
        private AssetsManager $AssetsManager,
        private GroupedAssetsManager $GroupedAssetsManager,
        private ClassNameMinifier $ClassNameMinifier
        )
    {
        $this->VentaConfig = VentaConfigFactory::create();
    }

    public function setPreProcessedHTML(
        string $html
        )
    {
        $this->PreProcessedHTML = $html;
        $this->ClassParser->setHTMLSource($html);
    }

    public function run()
    {
        $this->registerClasses();
        $this->compileGroupedUtilityClasses();
        $this->compileUtilityClasses();
        //$this->exportUsableCSS();
        $this->generatePostProcessHTML();
    }

    private function registerClasses()
    {
        foreach ($this->ClassParser->parse() as $classStatememt => $classParsingData) {
            $this->ClassRegistry[$classStatememt] = $classParsingData;
        }
        return $this;
    }

    private function compileGroupedUtilityClasses()
    {
        foreach ($this->GroupedAssetsManager->compileAssets() as $groupName => $members) {

            foreach ($this->ClassRegistry as $classStatement => $classDetails) {

                $classList = [];

                foreach ($classDetails['classList'] as $class) {

                    if ($class===$groupName) {

                        foreach ($members as $member) {
                            array_push($classList,$member);
                        }

                    } else {
                        array_push($classList,$class);
                    }

                }

                $this->ClassRegistry[$classStatement]['classList'] = $classList;

            }
        }
    }

    private function compileUtilityClasses()
    {
        foreach ($this->AssetsManager->compileAssets() as $selector => $rules) {

            $this->ListOfUtilityClasses[$selector] = $rules;

            $minifiedClassName = $this->ClassNameMinifier->create();

            foreach ($this->ClassRegistry as $classStatement => $classDetails) {

                if (in_array($selector,$classDetails['classList'])) {

                    array_push($this->ClassRegistry[$classStatement]['minifiedClassNames'],$minifiedClassName);

                    $this->UsedUtilityClasses[$minifiedClassName] = $rules;

                }

            }
        }
    }

    public function exportUsableCSS()
    {
        return $this->stringifyAllUsedCSS();
    }

    private function stringifyAllUsedCSS()
    {
        $css = '';
        foreach ($this->UsedUtilityClasses as $selector => $rules) {
            $css .= '.'.$selector.'{'.$rules.'}';
        }
        return $css;
    }

    private function generatePostProcessHTML()
    {

        $this->PostProcessedHTML = $this->PreProcessedHTML;

        foreach ($this->ClassRegistry as $classStatement => $classDetails) {

            $classAttributeMinified = 'class="'.implode(' ',$classDetails['minifiedClassNames']).'"';

            $this->PostProcessedHTML = str_replace($classStatement,$classAttributeMinified,$this->PostProcessedHTML);

        }
    }

    public function getPostProcessedHTML()
    {
        return $this->PostProcessedHTML;
    }

    public function getDashboard()
    {
        ob_start();
        include __dir__.'/Dashboard/dashboard.php';
        $dashboard = ob_get_contents();
        ob_end_clean();
        return $dashboard;
    }

}
