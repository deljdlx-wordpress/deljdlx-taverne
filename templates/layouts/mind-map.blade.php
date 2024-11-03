@php
use Deljdlx\WPTaverne\Models\Place;
use Deljdlx\WPTaverne\Models\Character;
@endphp

@extends('layouts/common/empty')


@section('body-content')

    <div style="">
        @include('partials.site-header')
    </div>

    <div id="board" style="height: calc(100vh - 180px); filter: contrast(100%); background-color: #0001"></div>


    <div id="data" style="display: none"><?php
        $descriptor = [
            'nodes' => [],
            'categories' => [
                ['name' => 'Personnages'],
                ['name' => 'PNJ'],
                ['name' => 'Lieux'],
            ],
            'links' => [],
        ];
        foreach ($nodes as $node) {

            if($node instanceof Character) {
                $label = $node->getField('name');
            } else {
                $label = $node->getTitle();
            }

            if($node instanceof Place) {
                $category = 2;
            }
            elseif($node instanceof Character) {
                if($node->getField('is_npc')) {
                    $category = 1;
                } else {
                    $category = 0;
                }
            }

            $symbolSize = 30;
            if(isset($weight[$node->ID])) {
                $tempWeight = log(($weight[$node->ID] * $weight[$node->ID]) + 1);
                $symbolSize +=  $tempWeight * 10;
            }

            $illustration = $node->getField('illustration');
            if($illustration) {
                // check if the image is a local file

                $imagePath = WP_CONTENT_DIR . '/uploads/deljdlx-taverne/squarified-images/150/'. basename($illustration['url']);
                if(is_file($imagePath)) {
                    $illustrationURL = get_home_url() . '/wp-content/uploads/deljdlx-taverne/squarified-images/150/'. basename($illustration['url']);
                } else {
                    $illustrationURL = get_home_url() . '/image/squarify?image=' . $illustration['url'];
                }


                // $illustrationURL = get_home_url() . '/image/squarify?image=' . $illustration['url'];
            }


            $descriptor['nodes'][] = [
                'id' => (string) $node->ID,
                'name' => $label,
                'category' => $category,
                'x' => rand(0, 100),
                'y' => rand(0, 100),
                'symbol' => $illustration ? 'image://'. $illustrationURL : 'circle',
                'symbolSize' => $symbolSize,
                'illustration' => $illustration,
                'url' => $node->getPermalink(),
                'draggable' => true,
            ];
        }

        $normalizedRelations = [];

        foreach ($relations as $nodeId => $nodes) {
            foreach ($nodes as $relatedId => $related) {

                $normalizedKey = ($nodeId > $relatedId) ? $relatedId.'+' .$nodeId : $nodeId.'+' .$relatedId;

                if(!isset($normalizedRelations[$normalizedKey])) {
                    $normalizedRelations[$normalizedKey] = true;
                } else {
                    continue;
                }

                $descriptor['links'][] = [
                    'source' => (string) $nodeId,
                    'target' => (string) $relatedId,
                ];
            }
        }


        echo json_encode($descriptor);

    ?></div>

@endsection
