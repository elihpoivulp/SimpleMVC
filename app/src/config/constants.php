<?php
defined('APP_PATH') or exit('Direct script access not allowed.');

define("PUBLIC_PATH", to_dir([APP_PATH, 'public']));
define("SOURCE_PATH", to_dir([APP_PATH, 'src']));
define("CONFIG_PATH", to_dir([SOURCE_PATH, 'config']));