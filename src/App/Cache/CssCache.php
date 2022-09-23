<?php

namespace Kenjiefx\StrawberryFramework\App\Cache;

use Kenjiefx\StrawberryFramework\App\Cache\BinManager;
use Kenjiefx\StrawberryFramework\App\Models\BuildInstance;
use Kenjiefx\StrawberryFramework\App\Cache\CacheManagerInterface;

class CssCache extends BinManager implements CacheManagerInterface
{
    private int $buildId;
    protected string $binNmspc = '/css/';

    public function __construct(
        private BuildInstance $BuildInstance
        )
    {
        $this->buildId = $BuildInstance::id();
    }

    public function addItem(
        array $args
        )
    {
        $this->saveItem($this->loadItem().$args['content']);
    }

    public function loadItem()
    {
        if (!$this->doItemExist()) return '';
        return file_get_contents(
            $this->getFilePath($this->getId())
        );
    }

    private function saveItem(
        string $data
        )
    {
        $this->saveFile($this->getId(),$data);
    }

    public function getId()
    {
        return $this->buildId.'.css';
    }

    public function doItemExist()
    {
        return (file_exists(
            $this->getFilePath($this->getId())
        ));
    }






}
