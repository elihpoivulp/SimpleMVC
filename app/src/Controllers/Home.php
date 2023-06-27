<?php

namespace Simplemvc\Controllers;

use Simplemvc\Core\BaseController;

class Home extends BaseController
{
    public function index(): void
    {
        echo 'Hello from home/index!<br>';
        echo '<strong>GET params</strong>';
        echo '<pre>';
        print_r($this->request->getParams);
        echo '</pre>';
    }

    public function about(): void
    {
        echo 'about';
    }
}