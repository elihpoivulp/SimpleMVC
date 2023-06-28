<?php

namespace Simplemvc\Controllers;

use Simplemvc\Core\Controller;

class PrivateController extends Controller
{
    public function privateMethod(): void
    {
        echo 'You are in a restricted page!';
    }
}