<?php

declare(strict_types=1);
namespace Kenjiefx\StrawberryFramework\App\Services;
use League\Container\Container as ContainerServiceProvider;
use League\Container\ReflectionContainer;

class Container {

    public function __construct(
        private ContainerServiceProvider $ContainerServiceProvider
        )
    {

    }

    public function register()
    {
        $this->ContainerServiceProvider->delegate(
            new ReflectionContainer()
        );
    }

}