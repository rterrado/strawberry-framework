<?php

declare(strict_types=1);
namespace Kenjiefx\StrawberryFramework;
use Kenjiefx\StrawberryFramework\App\Modules\CLIModule;
use Kenjiefx\StrawberryFramework\App\Modules\PreviewModule;
use Kenjiefx\StrawberryFramework\App\Modules\ModuleInterface;


class App
{

    private ModuleInterface $Module;

    public function __construct()
    {
        $this->Module = (php_sapi_name() !== 'cli') ?
            new PreviewModule() : new CLIModule();
    }

    public function run()
    {
        $this->Module->import()->build();
    }
}
