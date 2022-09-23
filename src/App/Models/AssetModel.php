<?php

namespace Kenjiefx\StrawberryFramework\App\Models;

class AssetModel
{

    private string $pointer;
    public const DIR = '/assets';

    public function setPointer(
        string $pointer
        )
    {
        $this->pointer = $pointer;
    }

    public function getPath()
    {
        return AssetModel::DIR.$this->pointer;
    }

}
