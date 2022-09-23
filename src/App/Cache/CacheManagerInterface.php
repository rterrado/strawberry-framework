<?php

namespace Kenjiefx\StrawberryFramework\App\Cache;

interface CacheManagerInterface
{
    public function addItem(array $args);
    public function getId();
    public function doItemExist();
}
