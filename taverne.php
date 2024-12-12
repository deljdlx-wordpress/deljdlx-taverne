<?php
/*
Plugin Name: JDLX_Taverne
Version: 1
*/


namespace Deljdlx\WPTaverne;

use Analog\Analog;
use Analog\Handler\PDO as HandlerPDO;
use Deljdlx\WPForge\Api\Image;
use Deljdlx\WPForge\Container;
use Deljdlx\WPForge\Theme\Theme;
use Deljdlx\WPForge\View;

use Deljdlx\WPTaverne\Plugins\Api;
use Deljdlx\WPTaverne\Plugins\Taverne;
use PDO;


if(!is_dir(__DIR__ . '/../deljdlx-forge')) {
    // display a wordpress  error message
    add_action('admin_notices', function() {
        echo '<div class="error"><p>Plugin JDLX_Taverne requires JDLX_Forge plugin to be installed and activated.</p></div>';
    });

    return;
}


require_once __DIR__ . '/../deljdlx-forge/jdlx-forge.php';
require_once __DIR__ . '/composer/autoload.php';

if(!is_dir(__DIR__ . '/cache')) {
    mkdir(__DIR__ . '/cache');
}


// ===========================================================

function container() {
    static $container;

    if($container) {
        return $container;
    }


    // $container = Container::getInstance();

    $wpContentDir = __DIR__ . '/../../';
    $cachePath = $wpContentDir . '/cache';

    if(!is_dir($cachePath)) {
        mkdir($cachePath);
    }

    $container = app();


    // FacadesView::addNamespace('custom', __DIR__ . '/templates');

    // dump($container);

    $pathes = $container->config->get('view')['paths'];
    $pathes[] = __DIR__ . '/templates';

    $container->config->set('view.paths', $pathes);

    // dump($pathes);
    // echo __FILE__.':'.__LINE__; exit();
    // FacadesView::addLocation(__DIR__ . '/templates');




    // $container->bind('config', function () use ($cachePath) {
    //     return new Repository([
    //         'view' => [
    //             'paths' => [
    //                 get_template_directory() . '/templates',
    //                 __DIR__ . '/templates',
    //             ],
    //             'compiled' => $cachePath,
    //         ]
    //     ]);
    // }, true);

    $container->bind(View::class, function () use ($container) {
        $view = View::getInstance($container,);

        $view->loadComponentsFromFolder(
            __DIR__ . '/../deljdlx-forge/src/class/Components/',
            'Deljdlx\WPForge\Components',
        );

        $view->loadComponentsFromFolder(
            __DIR__ . '/src/class/Components/',
            'Deljdlx\WPTaverne\Components',
        );

        return $view;

    }, true);

    $container->bind(Theme::class, function ($container) {
        $theme = Theme::getInstance($container);

        return $theme;

    }, true);

    return $container;
}

// ===========================================================

global $wpdb;

// configure analog
$dsn = 'mysql:host='.DB_HOST.';dbname='.DB_NAME;
$username = DB_USER;
$password = DB_PASSWORD;

$pdo = new PDO($dsn, $username, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
Analog::handler(HandlerPDO::init($pdo, $wpdb->prefix.'tav_logs'));
// ===========================================================


$container = container();





$taverne = new Taverne($container, __FILE__);

$api = new Api($container, __FILE__);

$imageApi = new Image($container, __FILE__);



require_once __DIR__ . '/redux.php';



