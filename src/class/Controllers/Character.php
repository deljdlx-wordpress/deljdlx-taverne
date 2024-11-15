<?php
namespace Deljdlx\WPTaverne\Controllers;

use Deljdlx\WPTaverne\Models\Character as ModelCharacter;
use Deljdlx\WPTaverne\Models\SkillTree;

class Character extends Base
{
    public static $prependJs = [
        'https://cdn.jsdelivr.net/npm/echarts@5.5.1/dist/echarts.min.js'
    ];

    public static $appendJs = [
        'assets/js/skilltree/SkillTree.js',
        'assets/js/skilltree/alpine.js',
        'assets/js/skilltree/viewer.js',
    ];

    public function index($post)
    {
        $character = $this->theme->loop->getPost(ModelCharacter::class);


        if(isset($_GET['sheet'])) {

            if(isset($_GET['action']) && $_GET['action'] ==='save') {
                return $this->saveSheet($character);
            }


            $postId = 612;
            if($postId) {
                $skillTree = SkillTree::find($postId);
            }
            else {
                $skillTree = new SkillTree();
            }



            return $this->renderTemplate('layouts.character-sheet', [
                'character' => $character,
                'skillTree' => $skillTree,
            ]);
        }
        else {
            return $this->renderTemplate('layouts.wp-hierarchy.singular.tav_character', [
                'character' => $character,
            ]);
        }

    }

    public function save()
    {
        $post = ModelCharacter::saveFromForm();
        return $this->renderTemplate('layouts.my-desktop.character-edit', [
            'authorId' => $this->getCurrentUserId(),
        ]);
    }

    public function pageEdit()
    {
        $character = new ModelCharacter();
        $postId = null;
        $action = '?';

        $chatId = 'character-'.uniqid();

        if(isset($_GET['id'])) {

            $character->loadById($_GET['id']);
            $action = '?id='.$postId;


            $chatId = get_field('ai_chat_id', $postId);
            if(!$chatId) {
                $chatId = 'character-'.uniqid();
            }


            if(isset($_GET['publish'])) {
                wp_update_post([
                    'ID' => $character->ID,
                    'post_status' => 'publish'
                ]);
            }
            if(isset($_GET['draft'])) {
                wp_update_post([
                    'ID' => $character->ID,
                    'post_status' => 'draft'
                ]);
            }
        }

        return $this->renderTemplate('layouts.my-desktop.character-edit', [
            'action' => $action,
            'chatId' => $chatId,
            'character' => $character,
            'authorId' => $this->getCurrentUserId(),
        ]);
    }

    private function saveSheet($character)
    {
        $post = file_get_contents('php://input');
        $data = json_decode($post);

        if(!$data) {
            return 1;
        }

        $buffer =  json_encode($data, JSON_PRETTY_PRINT);

        update_field('json', $buffer, $character->ID);
        return $buffer;
        // return;
    }
}

