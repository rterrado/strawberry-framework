<?php

namespace Kenjiefx\StrawberryFramework\App\Models;

class BuildInstance
{

    private static int $instanceId;

    public static function id()
    {
        if (!isset(static::$instanceId)) {
            static::$instanceId = time();
        }
        return static::$instanceId;
    }

    public static function setId(
        int $id
    )
    {
        static::$instanceId = $id;
    }
}
