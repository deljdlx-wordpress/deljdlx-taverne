<?php

use Deljdlx\WPTaverne\Controllers\Character;
use Deljdlx\WPTaverne\Controllers\MyDesktop;
use Deljdlx\WPTaverne\Controllers\SkillTree;
use Illuminate\Http\Request;


$router->addRoute(['GET',], '/my-desktop/skills-editor', function () {
    $this->mustBeLogged();
    $controller = new SkillTree($this->container);
    return $controller->index();
}, 'skills-editor-index');


$router->addRoute(['POST'], '/my-desktop/skills-editor', function () {
    $controller = new SkillTree($this->container);
    return $controller->save();
}, 'skills-editor-save');


$router->addRoute(['GET', 'POST'], '/my-desktop/scenario-edit', function () {
    $this->mustBeLogged();

    $buffer = $this->view->render('layouts.my-desktop.scenario-edit', [
        'authorId' => get_current_user_id(),
    ]);

    return $buffer;
});


// ===========================================================

$router->get('/my-desktop/character/sheet/get-data', function () {
    $this->mustBeLogged();

    $controller = new Character($this->container);
    return $controller->getSheetData();
});


$router->post('/my-desktop/character/sheet/save', function () {
    $this->mustBeLogged();

    $controller = new Character($this->container);
    return $controller->saveSheet();
});


$router->get('/my-desktop/character/sheet', function () {
    $this->mustBeLogged();

    $controller = new Character($this->container);
    return $controller->sheet();
});

// ===========================================================




$router->get('/my-desktop/calendar?$', function () {
    $this->mustBeLogged();
    $buffer = $this->view->render('layouts.my-desktop.calendar', [
        'authorId' => get_current_user_id(),
    ]);

    return $buffer;
});

$router->get('/my-desktop/?$', function () {
    $this->mustBeLogged();

    $controller = new MyDesktop($this->container);
    return $controller->index();

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