<?php
namespace Deljdlx\WPTaverne\Controllers;


use \Deljdlx\WPTaverne\Models\SkillTree as SkillTreeModel;

class SkillTree extends Base
{


    public static $prependJs = [
        // 'https://cdn.jsdelivr.net/npm/echarts@5.5.1/dist/echarts.min.js',
    ];

    public static $appendJs = [
        'vendor/quill/quill.js',

        'plugin://deljdlx-forge/vendor/ace-editor/src/ace.js',
        'plugin://deljdlx-forge/vendor/ace-editor/src/ext-language_tools.js',

        'assets/js/skilltree/SkillTree.js',
        'assets/js/skilltree/alpine.js',
        'assets/js/skilltree/editor.js',
    ];

    public static $appendCss = [
        'vendor/quill/quill.snow.css',
    ];


    public function index()
    {
        $postId = $this->getRequest()->input('id');

        if($postId) {
            $skillTree = SkillTreeModel::find($postId);
        }
        else {
            $skillTree = new SkillTreeModel();
        }

        $buffer = $this->renderTemplate('layouts.skilltree.editor', [
            'skillTree' => $skillTree,
            'authorId' => get_current_user_id(),
        ]);

        return $buffer;
    }

    public function save() {
        $data = file_get_contents('php://input');
        $json = json_decode($data, true);

        $tree = $json['tree'];


        $skillTreeName = $json['name'];
        if(!$skillTreeName) {
            $skillTreeName = 'New skill tree';
        }

        if(isset($json['id']) && $json['id']) {
            $postId = $json['id'];
            $skillTree = SkillTreeModel::find($postId);
        }
        else {
            $skillTree = new SkillTreeModel();
            $skillTree->setTitle($skillTreeName);
        }

        $skillTree->save();



        $cleanNodes = function($node) use (&$cleanNodes) {
            $validKeys = ['id', 'text', 'data', 'children', 'type'];

            foreach($node as $key => $value) {
                if(!in_array($key, $validKeys)) {
                    unset($node[$key]);
                }
            }

            if(is_array($node['children'])) {
                foreach($node['children'] as &$child) {
                    $child = $cleanNodes($child);
                }
            }

            return $node;
        };

        $tree = $cleanNodes($tree[0]);


        $json = json_encode($tree, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        $json = str_replace('\n', '\\\\n', $json);
        $json = str_replace('"', '\"', $json);
        $skillTree->setField('json', $json);


        $response = [
            'id' => $skillTree->getId(),
            'tree' => $tree,
            'skillTree' => $skillTree,
        ];

        return json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
}

