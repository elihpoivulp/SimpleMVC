<?php

use Simplemvc\Core\Request;

define("APP_PATH", dirname(__DIR__));

require_once APP_PATH . DIRECTORY_SEPARATOR . 'bootstrap.php';

$request = Request::init();