<?php
namespace Deljdlx\WPTaverne\Controllers;

use Deljdlx\WPForge\Container;
use Deljdlx\WPForge\Router;
use Deljdlx\WPForge\Theme\Theme;
use Deljdlx\WPForge\View;
use Illuminate\Http\Request;

class Base
{

    public static $prependJs = [];
    public static $appendJs = [];

    protected Container $container;
    protected View $view;
    protected Theme $theme;

    protected ?Request $request = null;

    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->view = $container->get(View::class);
        $this->theme = $container->get(Theme::class);
    }

    public function addJs(array|string $js, $prepend = false)
    {
        $this->container->get(Theme::class)->addJs($js, $prepend);
    }

    public function getCurrentUserId()
    {
        return get_current_user_id();
    }

    public function getRequest(): Request
    {
        if(!$this->request) {
            $this->request = Router::getRequest();
        }

        return $this->request;
    }


    public function renderTemplate($templateName, $variables = [])
    {

        foreach(static::$prependJs as $js) {
            $this->addJs($js, true);
        }
        foreach(static::$appendJs as $js) {
            $this->addJs($js, false);
        }

        return $this->view->render($templateName, $variables);
    }

}

