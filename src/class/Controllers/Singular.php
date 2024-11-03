<?php
namespace Deljdlx\WPTaverne\Controllers;

use Deljdlx\WPTaverne\Models\TavEntity;

class Singular extends Base
{

    public function index()
    {
        $post = get_post();
        $instance = new TavEntity();
        $instance->loadFromWpPost($post);

        $cpt = get_post_type();

        if($cpt === 'tav_character') {
            return $this->pageCharacter($post);
        }

        $template = 'layouts/wp-hierarchy/singular';
        if($this->view->templateExists('layouts.wp-hierarchy.singular.'.$cpt)) {
            $template = 'layouts/wp-hierarchy/singular/' . $cpt;
        }

        return $this->view->render(
            $template,
            [
                'post' => $instance,
            ]
        );
    }

    public function pageCharacter($post)
    {
        $controller = new Character($this->container);
        return $controller->index($post);

    }

}
