<?php

namespace Simplemvc\ControllerDummy;

use Simplemvc\Core\Controller;

class DummyController extends Controller
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