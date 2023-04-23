<?php

const ROOT_DIR = __DIR__;

define('AUTOLOAD_PATH', join(DIRECTORY_SEPARATOR, [ROOT_DIR, 'vendor', 'autoload.php']));

if (file_exists(AUTOLOAD_PATH)) {
    require_once AUTOLOAD_PATH;
}