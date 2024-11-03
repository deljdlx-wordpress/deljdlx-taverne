<?php
namespace Deljdlx\WPTaverne\Models;

use Deljdlx\WPForge\Models\Post;

class ScenarioEvent extends TavEntity
{

    public static $POST_TYPE = 'tav_event';


    private static $fields = [
        'date' => [
            'label' => 'Date',
            'type' => 'text',
        ],
        'order' => [
            'label' => 'Order',
            'type' => 'number',
        ],
    ];



    public static function register()
    {

        add_action(
            'init',
            function() {

                self::registerPostType(
                    static::$POST_TYPE,
                    'Scenario event',
                    [
                        'title',
                        'editor',
                    ],
                    true,
                );


                self::registerFields(
                    static::$POST_TYPE,
                    static::$POST_TYPE . '-0',
                    'Scenario event\'s informations',
                    self::$fields
                );
            }

        );
    }
}
