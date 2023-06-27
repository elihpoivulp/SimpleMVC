<?php
defined('APP_PATH') or exit('Direct script access not allowed.');
const DS = DIRECTORY_SEPARATOR;

function to_dir(array $items, $sep = DS): string
{
    return join($sep, $items);
}

require_once to_dir([APP_PATH, 'src', 'config', 'constants.php']);
require_once to_dir([APP_PATH, 'vendor', 'autoload.php']);