<?php
namespace Deljdlx\WPTaverne\Models;

use Deljdlx\WPForge\Models\Post;

class Article extends Post
{
    public static $POST_TYPE = 'tav_article_pp';

    private $places = [];

    private static $fields = [
        'illustration' => [
            'label' => 'Illustration',
            'type' => 'image',
        ],
        'title' => [
            'label' => 'Titre éditorial',
            'type' => 'text',
        ],
        'publication_subtitle' => [
            'label' => 'Sous titre de publication',
            'type' => 'text',
        ],
        'authoring' => [
            'label' => 'Authoring',
            'type' => 'text',
        ],
        'is_published' => [
            'label' => 'Is published',
            'type' => 'true_false',
            // use switch toggle
            'ui' => 1,
            'default_value' => 0,
        ],
    ];



    public static function register()
    {

        add_action(
            'init',
            function() {

                self::registerPostType(
                    static::$POST_TYPE,
                    'Articles',
                    [
                        'title',
                        'editor',
                    ],
                    false,
                );


                self::registerFields(
                    static::$POST_TYPE,
                    static::$POST_TYPE . '-0',
                    'Article\'s informations',
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
