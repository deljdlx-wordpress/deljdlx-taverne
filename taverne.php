<?php
/*
Plugin Name: JDLX_Taverne
Version: 1
*/


namespace Deljdlx\WPTaverne;

use Analog\Analog;
use Analog\Handler\PDO as HandlerPDO;
use Deljdlx\WPForge\Container;
use Deljdlx\WPForge\Theme\Theme;
use Deljdlx\WPForge\View;
use Deljdlx\WPTaverne\Models\Article;
use Deljdlx\WPTaverne\Models\Character as ModelsCharacter;
use Deljdlx\WPTaverne\Models\Organization;
use Deljdlx\WPTaverne\Models\Place as ModelsPlace;
use Deljdlx\WPTaverne\Models\Resource;
use Deljdlx\WPTaverne\Models\Scenario as ModelsScenario;
use Deljdlx\WPTaverne\Models\ScenarioEvent;
use Deljdlx\WPTaverne\Plugins\Api;
use Deljdlx\WPTaverne\Plugins\Character;
use Deljdlx\WPTaverne\Plugins\Place;
use Deljdlx\WPTaverne\Plugins\Scenario;
use Deljdlx\WPTaverne\Plugins\Taverne;
use Illuminate\Config\Repository;
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
require_once __DIR__ . '/embedded-plugins/kirki/kirki.php';


// ===========================================================

function container() {
    static $container;

    if($container) {
        return $container;
    }

    $container = new Container();
    $cachePath = __DIR__ . '/cache';

    if(!is_dir($cachePath)) {
        mkdir($cachePath);
    }

    $container->bindIf('config', function () use ($cachePath) {
        return new Repository([
            'view' => [
                'paths' => [
                    get_template_directory() . '/templates',
                    __DIR__ . '/templates',
                ],
                'compiled' => $cachePath,
            ]
        ]);
    }, true);

    $container->bindIf(View::class, function () use ($container) {
        $view = new View(
            $container,
        );

        $view->loadComponentsFromFolder(
            __DIR__ . '/src/class/Components/',
            'Deljdlx\WPTaverne\\Components\\',
        );

        return $view;

    }, true);

    $container->bindIf(Theme::class, function ($container) {
        $theme = new Theme(
            $container
        );

        return $theme;

    }, true);

    return $container;
}

// ===========================================================
// configure analog
$dsn = 'mysql:host='.DB_HOST.';dbname='.DB_NAME;
$username = DB_USER;
$password = DB_PASSWORD;

$pdo = new PDO($dsn, $username, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
Analog::handler(HandlerPDO::init($pdo, $wpdb->prefix.'tav_logs'));
// ===========================================================


$container = container();


ModelsCharacter::register();
ModelsPlace::register();
Resource::register();
Article::register();
ModelsScenario::register();
ScenarioEvent::register();
Organization::register();


$taverne = new Taverne($container, __FILE__);
$api = new Api($container, __FILE__);




require_once __DIR__ . '/redux.php';



