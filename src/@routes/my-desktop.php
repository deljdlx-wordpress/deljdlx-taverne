<?php

use Deljdlx\WPTaverne\Controllers\Character;
use Illuminate\Http\Request;

$router->addRoute(['GET', 'POST'], '/my-dektop/scenario-edit', function () {
    $this->mustBeLogged();

    $buffer = $this->view->render('layouts.my-desktop.scenario-edit', [
        'authorId' => get_current_user_id(),
    ]);

    return $buffer;
});


$router->get('/my-dektop/calendar?$', function () {
    $this->mustBeLogged();
    $buffer = $this->view->render('layouts.my-desktop.calendar', [
        'authorId' => get_current_user_id(),
    ]);

    return $buffer;
});

$router->get('/my-dektop/?$', function () {
    $this->mustBeLogged();

    $buffer = $this->view->render('layouts.my-desktop.index', [
        'authorId' => get_current_user_id(),
    ]);

    return $buffer;
});



$router->addRoute(['GET', 'POST'], '/my-desktop/character-edit', function (Request $request) {
    $this->mustBeLogged();

    $controller = new Character($this->container);
    if($request->post()) {
        return $controller->save();
    }
    return $controller->pageEdit();
});


$router->addRoute(['GET', 'POST'], '/my-desktop/place-edit', function () {
    $this->mustBeLogged();

    $buffer = $this->view->render('layouts.my-desktop.place-edit', [
        'authorId' => get_current_user_id(),
    ]);

    return $buffer;
});