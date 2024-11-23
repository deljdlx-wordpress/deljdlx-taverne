<?php
namespace Deljdlx\WPTaverne\Models;

use Deljdlx\WPForge\Models\Post;

class Resource extends TavEntity
{

    public static $POST_TYPE = 'tav_resource';


    private static $fields = [
        'is_md' => [
            'label' => 'Is markdown',
            'type' => 'true_false',
            'ui' => 1,

        ],
        'illustration' => [
            'label' => 'Illustration',
            'type' => 'image',
        ],
        'address' => [
            'label' => 'Address',
            'type' => 'open_street_map',
            'return_format' => 'raw',
        ],
        'scenario' => [
            'label' => 'Scenario',
            'type' => 'relationship',
            'post_type' => 'jdlx_tav_scenario',
            'filters' => [
                'search',
                'post_type',
            ],
        ],
    ];



    public static function register()
    {

        add_action(
            'init',
            function() {

                self::registerPostType(
                    static::$POST_TYPE,
                    'Resource',
                    [
                        'title',
                        'editor',
                    ],
                    false,
                );


                self::registerFields(
                    static::$POST_TYPE,
                    static::$POST_TYPE . '-0',
                    'Resource\'s informations',
                    self::$fields
                );
            }

        );
    }

    public function getPlaces() {

        $this->places = [];

        // get all posts of type jdlx_tav_place
        $places = get_posts([
            'post_type' => 'jdlx_tav_place',
            'numberposts' => -1,
        ]);

        $registeredPlaces = [];

        foreach($places as $place) {
            if(!isset($registeredPlaces[$place->ID])) {
                $registeredPlaces[$place->ID] = $place;
                $characters = get_field('characters', $place->ID);
                foreach($characters as $character) {
                    if($character->ID === $this->ID) {
                        $placeModel = new Place();
                        $placeModel->loadFromWpPost($place);
                        $this->places[] = $placeModel;
                    }
                }
            }
        }


        return $this->places;
    }
}
