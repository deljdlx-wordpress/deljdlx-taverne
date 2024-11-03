<?php
namespace Deljdlx\WPTaverne\Controllers;

use Deljdlx\WPTaverne\Models\TavEntity;

class Archive extends Base
{

    public function index()
    {

        // get the post type
        $cpt = get_post_type();

        $posts = TavEntity::getAll($cpt);

        $posts = array_reverse($posts);

        $template = 'layouts/wp-hierarchy/archive';

        // if($this->view->templateExists('layouts.wp-hierarchy.singular.'.$cpt)) {
        //     $template = 'layouts/wp-hierarchy/singular/' . $cpt;
        // }

        return $this->view->render(
            $template,
            [
                'posts' => $posts,
                'post_type' => $cpt,
            ]
        );
    }
}
