<?php

declare(strict_types=1);

use App\Controller\IndexController;

require __DIR__ . '/../src/Controller/IndexController.php';

$requestUri = $_SERVER['REQUEST_URI'];
$controller = new IndexController();

if ($requestUri === '/images/afsrv-ranking.png') {
    $controller->image();
}

if ($requestUri === '/counter') {
    $controller->counter();
}

if ($requestUri === '/counter/reset') {
    $controller->counterReset();
}

if ($requestUri === '/ping') {
    $controller->counterReset();
}

$controller->home();
