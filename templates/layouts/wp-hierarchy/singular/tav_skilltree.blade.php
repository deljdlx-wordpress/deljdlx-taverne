<?php
use Deljdlx\TreeEditor\Models\SkillTree;


$postId = get_the_ID();
$skillTree = SkillTree::find($postId);

$data = [
    'post' => $skillTree->getPost(),
    'data' => json_decode($skillTree->getField('json'), true),
];

//json pretty print, unicode not escaped
header('Content-Type: application/json');
echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);



