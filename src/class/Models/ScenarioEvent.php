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
