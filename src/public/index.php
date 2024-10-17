<?php

require_once './../Core/Autoload.php';

use Core\App;
use Core\Autoload;

Autoload::registrate(__DIR__ . '/../');

$index = new App();
$index->run();