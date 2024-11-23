<?php
namespace Deljdlx\WPTaverne\Models;

use Deljdlx\WPForge\Models\Post;

class Scenario extends TavEntity
{

    public static $POST_TYPE = 'tav_scenario';

    private static $fields = [
        'illustration' => [
            'label' => 'Illustration',
            'type' => 'image',
        ],
        'characters' => [
            'label' => 'Characters',
            'type' => 'relationship',
            'post_type' => 'character',
            'filters' => [
                'search',
                'post_type',
            ],
        ],
        'places' => [
            'label' => 'Places',
            'type' => 'relationship',
            'post_type' => 'jdlx_tav_place',
            'filters' => [
                'search',
                'post_type',
            ],
        ],
        'resources' => [
            'label' => 'Resources',
            'type' => 'relationship',
            'post_type' => 'jdlx_tav_resource',
            'filters' => [
                'search',
                'post_type',
            ],
        ],
        'acts' => [
            // repeatable field
            'label' => 'Acts',
            'type' => 'repeater',
            'sub_fields' => [
                'title' => [
                    'label' => 'Title',
                    'type' => 'text',
                ],
                'description' => [
                    'label' => 'Description',
                    'type' => 'wysiwyg',
                ],
            ],
        ]
    ];



    public static function register()
    {

        add_action(
            'init',
            function() {

                self::registerPostType(
                    static::$POST_TYPE,
                    'Scenario',
                    [
                        'title',
                        'editor',
                    ],
                    false,
                );


                self::registerFields(
                    static::$POST_TYPE,
                    static::$POST_TYPE . '-0',
                    'Scenario\'s informations',
                    self::$fields
                );
            }

        );
    }

    // public function getPlaces() {

    //     $this->places = [];

    //     // get all posts of type jdlx_tav_place
    //     $places = get_posts([
    //         'post_type' => 'jdlx_tav_place',
    //         'numberposts' => -1,
    //     ]);

    //     $registeredPlaces = [];

    //     foreach($places as $place) {
    //         if(!isset($registeredPlaces[$place->ID])) {
    //             $registeredPlaces[$place->ID] = $place;
    //             $characters = get_field('characters', $place->ID);
    //             foreach($characters as $character) {
    //                 if($character->ID === $this->ID) {
    //                     $placeModel = new Place();
    //                     $placeModel->loadFromWpPost($place);
    //                     $this->places[] = $placeModel;
    //                 }
    //             }
    //         }
    //     }


    //     return $this->places;
    // }
}
