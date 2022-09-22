<?php

namespace Kenjiefx\StrawberryFramework\App\Models;

class ComponentModel
{
    private string $name;
    public const DIR = '/components';

    public function __construct()
    {

    }

    public function setName(
        string $name
        )
    {
        $this->name = $name;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }


}
