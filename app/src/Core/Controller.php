<?php

namespace Simplemvc\Core;

use Exception;
use Simplemvc\Config\Config;

class Controller
{
    public function __construct(protected Request $request)
    {
    }

    public function __toString(): string
    {
        return static::class;
    }

    /**
     * @throws Exception
     * Loads a model.
     */
    protected function loadModel(string $model)
    {
        if (!hasNamespacePresence($model)) {
            $model = (Config::$defaultModelNamespace . '\\' . $model);
            if (!class_exists($model)) throw new Exception("Model: $model does not exist.");
        }

        return new $model();
    }
}