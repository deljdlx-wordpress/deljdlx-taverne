<?php
namespace Deljdlx\WPTaverne\Controllers;

use Deljdlx\WPTaverne\Models\Character as ModelCharacter;
use Deljdlx\WPTaverne\Models\CharacterSkills;
use Deljdlx\WPTaverne\Models\SkillTree;

class Character extends Base
{
    public static $prependJs = [
        'plugin://deljdlx-taverne/vendor/echart.js',
    ];

    public static $appendJs = [
        'plugin://deljdlx-taverne/assets/skilltree/SkillTree.js',
        'plugin://deljdlx-taverne/assets/skilltree/alpine.js',
        'plugin://deljdlx-taverne/assets/skilltree/viewer.js',
    ];

    public function index($post)
    {
        $character = $this->theme->loop->getPost(ModelCharacter::class);


        if(isset($_GET['sheet'])) {


        }
        else {
            return $this->renderTemplate('layouts.wp-hierarchy.singular.tav_character', [
                'character' => $character,
            ]);
        }
    }


    public function saveSheet()
    {
        $buffer = file_get_contents('php://input');
        $data = json_decode($buffer, true);

        $characterId = $data['characterId'];
        $skilltreeId = $data['skilltreeId'];
        $data = $data['data'];

        // find characterSkillModel by characterId and skilltreeId
        $characterSkillModel = CharacterSkills::where('character_id', $characterId)
            ->where('skilltree_id', $skilltreeId)
            ->first();

        if(!$characterSkillModel) {
            $characterSkillModel = new CharacterSkills();
            $characterSkillModel->character_id = $characterId;
            $characterSkillModel->skilltree_id = $skilltreeId;
        }

        $characterSkillModel->json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        $characterSkillModel->save();

        header('Content-type: application/json');

        return json_encode($characterSkillModel);
    }

    public function getSheetData() {
        $request = $this->getRequest();
        $characterId = $request->input('characterId');
        $skilltreeId = $request->input('skilltreeId');
        $characterSkillModel = CharacterSkills::where('character_id', $characterId)
            ->where('skilltree_id', $skilltreeId)
            ->first();

            $json = 'null';

        if($characterSkillModel) {
            $json = $characterSkillModel->json;
        }


        header('Content-type: application/json');
        return $json;



    }

    public function sheet()
    {

        $characterId = $this->getRequest()->input('id');
        $skilltreeId = $this->getRequest()->input('skilltree');

        if($skilltreeId) {
            $skilltree = SkillTree::find($skilltreeId);
        }

        $character = ModelCharacter::find($characterId);

        if(isset($_GET['action']) && $_GET['action'] ==='save') {
            return $this->saveSheet($character);
        }


        $skillTree = null;

        $skilltrees = SkillTree::getAll();

        $postId = 612;
        if($postId) {
            $skillTree = SkillTree::find($postId);
        }
        else {
            $skillTree = new SkillTree();
        }



        return $this->renderTemplate('layouts.character-sheet', [
            'skilltrees' => $skilltrees,
            'character' => $character,
            'skilltreeId' => $skilltreeId,
            'skilltree' => $skillTree,
        ]);
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

    // private function saveSheet($character)
    // {
    //     $post = file_get_contents('php://input');
    //     $data = json_decode($post);

    //     if(!$data) {
    //         return 1;
    //     }

    //     $buffer =  json_encode($data, JSON_PRETTY_PRINT);

    //     update_field('json', $buffer, $character->ID);
    //     return $buffer;
    //     // return;
    // }
}

