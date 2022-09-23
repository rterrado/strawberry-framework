<?php

declare(strict_types=1);
namespace Kenjiefx\StrawberryFramework\App\Services;
use GuzzleHttp\Psr7\Uri;

class QueryParser {

    private array $dataset = [];

    public function __construct()
    {

    }

    public function set(
        string $query
        )
    {
        parse_str($query,$this->dataset);
        return $this;
    }

    public function get(
        string $key
        )
    {
        return $this->dataset[$key] ?? null;
    }



}
