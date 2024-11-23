<?php
namespace Deljdlx\WPTaverne\Models;

use Deljdlx\WPForge\Models\Post;

class SkillTree extends Post
{
    public static $POST_TYPE = 'tav_skilltree';

    private static $fields = [
        'illustration' => [
            'label' => 'Illustration',
            'type' => 'image',
        ],
        'json' => [
            'label' => 'JSON',
            'type' => 'textarea',
        ],
    ];


    public static function saveFromForm()
    {

    }


    public static function register()
    {
        add_action(
            'init',
            function() {

                self::registerPostType(
                    static::$POST_TYPE,
                    'Skill tree',
                    [
                        'title',
                    ],
                    false,
                );

                self::registerFields(
                    static::$POST_TYPE,
                    static::$POST_TYPE . '-fields-0',
                    'Skills tree informations',
                    self::$fields,
                );
            }

        );
    }
}

