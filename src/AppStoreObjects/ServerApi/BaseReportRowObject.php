<?php

namespace AppStoreLibrary\AppStoreObjects\ServerApi;

use AppStoreLibrary\AppStoreObjects\BaseAppStoreObject;
use Illuminate\Support\Str;

abstract class BaseReportRowObject extends BaseAppStoreObject
{
    public function __construct()
    {
        $this->properties = array_combine(
            array_map(
                fn($key) => static::createKeyFromHeader($key),
                array_keys($this->properties)
            ),
            $this->properties
        );
    }

    public function set($key, $value): static
    {
        $key = static::createKeyFromHeader($key);
        return parent::set($key, $value);
    }

    public function get($key): mixed
    {
        $key = static::createKeyFromHeader($key);
        return parent::get($key);
    }

    private static function createKeyFromHeader(string $key): string
    {
        return Str::camel($key);
    }
}
