<?php

namespace Kenjiefx\StrawberryFramework\App\Cache;

class BinManager
{

    private static $binPath = __dir__.'/bin';

    public function getFilePath(
        $fileName
        )
    {
        return $this->getNmpscPath().$fileName;
    }

    public function getNmpscPath()
    {
        return BinManager::$binPath.$this->binNmspc;
    }

    public function saveFile(
        string $fileName,
        string $data
        )
    {
        file_put_contents($this->getFilePath($fileName),$data);
    }

}
