<?php
namespace Deljdlx\WPTaverne\Models;

use Deljdlx\WPForge\Models\Post;

class Organization extends TavEntity
{
    public static $POST_TYPE = 'tav_organization';

    private static $fields = [
        'illustration' => [
            'label' => 'Illustration',
            'type' => 'image',
        ],
        'address' => [
            'label' => 'Address',
            'type' => 'open_street_map',
            'return_format' => 'raw',
        ],
    ];

    public static function register()
    {
        add_action(
            'init',
            function() {

                self::registerPostType(
                    static::$POST_TYPE,
                    'Organizations',
                    [
                        'title',
                        'editor',
                        'thumbnail',
                    ],
                    true,
                );

                self::registerFields(
                    static::$POST_TYPE,
                    static::$POST_TYPE . '-fields-0',
                    'Organization\'s informations',
                    self::$fields,
                );
            }

        );
    }
}

