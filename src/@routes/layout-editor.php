<?php

use Deljdlx\WPTaverne\Controllers\LayoutEditor;

$router->get('/layout-editor/edit', function () {
    $controller = new LayoutEditor($this->container);
    return $controller->edit();
});

$router->get('/layout-editor/view', function () {
    $controller = new LayoutEditor($this->container);
    return $controller->view();
});