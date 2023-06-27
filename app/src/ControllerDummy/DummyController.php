<?php

namespace Simplemvc\ControllerDummy;

use Simplemvc\Core\BaseController;

class DummyController extends BaseController
{
    public function index(): void
    {
        echo 'DummyController index';
    }

    public function testPage($welcome): void
    {
        echo 'DummyController testPage says: ' . $welcome;
    }
}