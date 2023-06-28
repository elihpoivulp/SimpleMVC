<?php

namespace Simplemvc\Core;

use Exception;

class Helper
{
    /**
     * @throws Exception
     */
    public static function loadHelper(string $helperFileName): void
    {
        $helperFileName = str_contains($helperFileName, '.php') ?: $helperFileName . '.php';
        $file = HELPER_PATH . DS . $helperFileName;
        if (!file_exists($file)) throw new Exception('Helper files does not exist', 500);
        require_once $file;
    }
}