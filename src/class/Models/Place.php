<?php
namespace Deljdlx\WPTaverne\Models;

use Deljdlx\WPForge\Models\Post;

class Place extends TavEntity
{
    public static $POST_TYPE = 'tav_place';

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
        'characters' => [
            'label' => 'Characters',
            'type' => 'post-object',
            'post_type' => 'character',
            'multiple' => true,
        ],
        'scenarios' => [
            'label' => 'Scenario',
            'type' => 'post-object',
            'post_type' => 'jdlx_tav_scenario',
            'multiple' => true,
        ],
        'gallery' => [
            'label' => 'Gallery',
            'type' => 'photo_gallery',
        ],
    ];


    public static function saveFromForm()
    {
        $title = $_POST['name'];
        $content = $_POST['description'];
        $post_id = $_POST['post_id'];

        if(!$post_id) {
            $post_id = wp_insert_post([
                'post_title' => $title,
                'post_type' => self::$POST_TYPE,
                'post_content' => $content,
                'post_status' => 'draft',
            ]);
            $post = get_post($post_id);
        }


        $post = get_post($post_id);
        // update title
        wp_update_post([
            'ID' => $post_id,
            'post_title' => $title,
            'post_content' => $content,
        ]);


        $place = new self();
        $place->loadFromWpPost($post);

        // update acf field address
        update_field('address', $_POST['acf']['address'], $place->getId());

        // update characters acf field
        if(!isset($_POST['characters'])) {
            $_POST['characters'] = [];
        }
        $characterIds = $_POST['characters'];
        update_field('characters', $characterIds, $place->getId());

        if(!isset($_POST['scenarios'])) {
            $_POST['scenarios'] = [];
        }
        $scenarioIds = $_POST['scenarios'];
        update_field('scenarios', $scenarioIds, $place->getId());



        if(isset($_FILES['illustration'])) {
            $place->savePostAttachment('illustration');
        }

        return $place;
    }


    public static function register()
    {
        add_action(
            'init',
            function() {

                self::registerPostType(
                    static::$POST_TYPE,
                    'Places',
                    [
                        'title',
                        'editor',
                        'thumbnail',
                    ],
                    false,
                );

                self::registerFields(
                    static::$POST_TYPE,
                    static::$POST_TYPE . '-fields-0',
                    'Article\'s informations',
                    self::$fields,
                );
            }

        );
    }
}

