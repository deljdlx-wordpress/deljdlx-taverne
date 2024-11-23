<?php

namespace Deljdlx\WPTaverne\Controllers;

use Deljdlx\WPTaverne\Models\Character;
use Deljdlx\WPTaverne\Models\Place;
use Deljdlx\WPTaverne\Models\SkillTree;
use Deljdlx\WPTaverne\Models\TavEntity;

class MyDesktop extends Base
{

    public function index()
    {

        if (!isset($authorId)) {
            $authorId = null;
        }

        $characters = [];
        $places = [];

        $types = [
            'characters' => [
                'type' => 'tav_character',
                'instance' => Character::class,
            ],
            'places' => [
                'type' => 'tav_place',
                'instance' => Place::class,
            ],
            'skilltrees' => [
                'type' => 'tav_skilltree',
                'instance' => SkillTree::class,
            ],
        ];

        foreach ($types as $index => $type) {
            $options = [
                'post_type' => $type,
                'numberposts' => -1,
                'orderby' => 'title',
                'order' => 'ASC',
                'author' => $authorId,
                'post_status' => 'any',
            ];
            // if user is admin, get all posts
            if (current_user_can('administrator')) {
                unset($options['author']);
            }

            $className = $type['instance'];
            $$index = $className::getByOptions($options);
        }


        $buffer = $this->renderTemplate('layouts.my-desktop.index', [
            'authorId' => get_current_user_id(),
            'characters' => $characters,
            'places' => $places,
            'skilltrees' => $skilltrees,
        ]);

        return $buffer;
    }
}
