<?php
namespace Deljdlx\WPTaverne\Models;

use Deljdlx\WPForge\Models\Post;

class Documentation extends TavEntity
{

    public static $POST_TYPE = 'tav_documentation';


    private static $fields = [
        'illustration' => [
            'label' => 'Illustration',
            'type' => 'image',
        ],
    ];



    public static function register()
    {

        add_action(
            'init',
            function() {

                self::registerPostType(
                    static::$POST_TYPE,
                    'Documentation',
                    [
                        'title',
                        'editor',
                    ],
                    true,
                );


                self::registerFields(
                    static::$POST_TYPE,
                    static::$POST_TYPE . '-0',
                    'Documentation\'s informations',
                    self::$fields
                );
            }

        );
    }
}
