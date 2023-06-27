<?php

namespace Simplemvc\Controllers;

use Simplemvc\Core\BaseController;

class PrivateController extends BaseController
{
    public function privateMethod(): void
    {
        echo 'You are in a restricted page!';
    }
}