<?php

namespace Simplemvc\Controllers;

use Simplemvc\Core\BaseController;

class Home extends BaseController
{
    public function index(): void
    {
        echo 'Hello from home/index!';
    }

    public function about(): void
    {
        echo 'about';
    }
}