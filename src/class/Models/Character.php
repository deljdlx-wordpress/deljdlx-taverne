<?php
namespace Deljdlx\WPTaverne\Models;

use Deljdlx\WPForge\Models\Post;

class Character extends TavEntity
{

    public static $POST_TYPE = 'tav_character';

    private static $fields = [
        'ai_chat_id' => [
            'label' => 'AI chat id',
            'type' => 'text',
        ],

        'mbti' => [
            'label' => 'MBTI profile',
            'type' => 'text',
        ],


        'name' => [
            'label' => 'Name',
            'type' => 'text',
        ],
        'is_npc' => [
            'label' => 'Is NPC',
            'type' => 'true_false',
        ],
        'illustration' => [
            'label' => 'Illustration',
            'type' => 'image',
        ],
        'birth' => [
            'label' => 'Birth',
            'type' => 'text',
        ],
        'job' => [
            'label' => 'Job',
            'type' => 'text',
        ],
        'address' => [
            'label' => 'Address',
            'type' => 'open_street_map',
            'return_format' => 'raw',
        ],
        'description' => [
            'label' => 'Description',
            'type' => 'wysiwyg',
        ],
        'background' => [
            'label' => 'Background',
            'type' => 'wywsiwyg',
            'sub_fields' => [
                [
                    'key' => 'background_title',
                    'label' => 'Title',
                    'name' => 'title',
                    'type' => 'text',
                ],
                [
                    'key' => 'background_content',
                    'label' => 'Content',
                    'name' => 'content',
                    'type' => 'wysiwyg',
                ],
            ]
        ],
        'communication' => [
            'label' => 'Façon de communiquer',
            'type' => 'wysiwyg',
        ],
        'typical-sentences' => [
            'label' => 'Phrases typiques',
            'type' => 'wysiwyg',
        ],
        'home' => [
            'label' => 'Lieu de vie',
            'type' => 'wysiwyg',
        ],
        'work' => [
            'label' => 'Lieu de travail',
            'type' => 'wysiwyg',
        ],
        'astral_sign' => [
            'label' => 'Signe astrologique',
            'type' => 'text',
        ],
        'typical-items' => [
            'label' => 'Objets typiques',
            'type' => 'wysiwyg',
        ],
        'draft' => [
            'label' => 'Brouillons et notes',
            'type' => 'wysiwyg',
        ],

        'json' => [
            'label' => 'JSON',
            'type' => 'textarea',
        ],

        // 'misc' => [
        //     // repeatable fields title/content
        //     'label' => 'Misc',
        //     'type' => 'repeater',
        //     'sub_fields' => [
        //         [
        //             'key' => 'misc_title',
        //             'label' => 'Title',
        //             'name' => 'title',
        //             'type' => 'text',
        //         ],
        //         [
        //             'key' => 'misc_content',
        //             'label' => 'Content',
        //             'name' => 'content',
        //             'type' => 'wysiwyg',
        //         ],
        //     ],
        // ]
    ];



    public static function register()
    {

        add_action(
            'init',
            function() {

                self::registerPostType(
                    static::$POST_TYPE,
                    'Character',
                    [
                        'title',
                        // 'editor',
                        'thumbnail',
                    ],
                    true,
                );


                self::registerFields(
                    static::$POST_TYPE,
                    static::$POST_TYPE . '-fields-0',
                    'Character\'s informations',
                    self::$fields
                );
            }

        );
    }


    public static function create(string $title)
    {
        // create a new post of type character
        $post_id = wp_insert_post([
            'post_title' => $title,
            'post_type' => 'character',
            'post_status' => 'draft',
        ]);
        $post = get_post($post_id);

        dump($post);

        return $post;
    }

    public static function saveFromForm()
    {
        $name = $_POST['name'];

        if(!isset($_POST['post_id']) || !$_POST['post_id']) {

            $post = self::create($name);
            $_POST['post_id'] = $post->ID;
        }

        $post_id = $_POST['post_id'];

        $character = Character::find($post_id);


        $post = get_post($post_id);

        $job = $_POST['job'];
        $description = $_POST['description'];
        $is_npc = $_POST['is_npc'] ?? 0;
        $background = $_POST['background'];
        $communication = $_POST['communication'];
        $home = $_POST['home'];
        $work = $_POST['work'];
        $birth = $_POST['birth'];

        // $address = $_POST['address'];
        $address = $_POST['acf']['address'];



        $typical_sentences = $_POST['typical-sentences'];
        $astral_sign = $_POST['astral_sign'];
        $typical_items = $_POST['typical-items'];
        $draft = $_POST['draft'];


        update_field('is_npc', $is_npc, $post_id);
        update_field('name', $name, $post_id);
        update_field('job', $job, $post_id);
        update_field('description', $description, $post_id);
        update_field('background', $background, $post_id);
        update_field('communication', $communication, $post_id);
        update_field('home', $home, $post_id);
        update_field('work', $work, $post_id);
        update_field('birth', $birth, $post_id);
        update_field('address', $address, $post_id);
        update_field('typical-sentences', $typical_sentences, $post_id);
        update_field('astral_sign', $astral_sign, $post_id);
        update_field('typical-items', $typical_items, $post_id);
        update_field('draft', $draft, $post_id);


        $ai_chat_id = $_POST['ai_chat_id'];
        update_field('ai_chat_id', $ai_chat_id, $post_id);

        $mbti = $_POST['mbti'];
        update_field('mbti', $mbti, $post_id);


        if(!isset($_POST['places'])) {
            $_POST['places'] = [];
        }
        $placesIds = $_POST['places'];
        $character->removeRelations('jdlx_tav_place');
        foreach($placesIds as $id) {
            $character->addRelation($id, 'jdlx_tav_place');
        }


        if(!isset($_POST['characters'])) {
            $_POST['characters'] = [];
        }
        $charactersIds = $_POST['characters'];
        $character->removeRelations('character');

        foreach($charactersIds as $id) {
            $character->addRelation($id, 'character');
        }


        if($_FILES['illustration'] && !empty($_FILES['illustration']['name'])) {
            $illustration = $_FILES['illustration'];
            $upload = wp_upload_bits($illustration['name'], null, file_get_contents($illustration['tmp_name']));

            $attachment = [
                'post_title' => $illustration['name'],
                'post_content' => '',
                'post_status' => 'inherit',
                'post_mime_type' => $illustration['type'],
                'guid' => $upload['url'],
            ];

            $attach_id = wp_insert_attachment($attachment, $upload['file'], $post_id);
            update_field('illustration', $attach_id, $post_id);
        }

        wp_update_post($post);

        return $post;
    }

    public function hasSheet() {
        $json = $this->getField('json');
        if($json) {
            $json = json_decode($json);
            if(isset($json)) {
                return true;
            }
        }

        return false;
    }

    public function getSheetJson() {
        $json = $this->getField('json');
        if($json) {
            $object = json_decode($json);
            if($object !== null) {
                return $json;
            }
        }

        return null;
    }

    public function getSheetAttributes() {
        $sheet = $this->getSheetJson();

        if(!$sheet) {
            return null;
        }
        $sheet = json_decode($sheet, true);

        return $sheet['attributes'];
    }
}
