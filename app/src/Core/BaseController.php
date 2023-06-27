<?php

namespace Simplemvc\Core;

abstract class BaseController
{
    public function __construct(protected Request $request)
    {
    }

    public function __toString(): string
    {
        return static::class;
    }
}