<?php

namespace Simplemvc\Core;

abstract class BaseController
{
    public function __construct()
    {
    }

    public function __toString(): string
    {
        return static::class;
    }
}