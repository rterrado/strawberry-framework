<?php

namespace Kenjiefx\StrawberryFramework\App\Cache;

use Kenjiefx\StrawberryFramework\App\Models\BuildInstance;

class ComponentCache
{

    private int $buildId;

    public function __construct(
        private BuildInstance $BuildInstance
        )
    {
        $this->buildId = $BuildInstance::id();
    }

    
}
