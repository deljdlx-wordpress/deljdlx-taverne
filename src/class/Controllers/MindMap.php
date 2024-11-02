<?php
namespace Deljdlx\WPTaverne\Controllers;

use Deljdlx\WPTaverne\Models\Place;
use Deljdlx\WPTaverne\Models\Character;


class MindMap extends Base
{

    public static $prependJs = [
        'https://cdn.jsdelivr.net/npm/echarts@5.5.1/dist/echarts.min.js',
    ];

    public static $appendJs = [
        'assets/js/investigation-board.js',
    ];


    public function index()
    {
        $places = Place::getAll();
        $characters = Character::getAll();

        $nodes = [];
        $relations = [];
        $weight = [];

        foreach ($characters as $character) {
            $nodes[$character->ID] = $character;
            $weight[$character->ID] = 0;


            $relatedPlaces = $character->getPlaces();

            foreach ($relatedPlaces as $relatedPlace) {
                if (!isset($relations[$character->ID])) {
                    $relations[$character->ID] = [];
                }
                $relations[$character->ID][$relatedPlace->ID] = $relatedPlace;
                $weight[$character->ID]++;
            }

            $relatedCharacters = $character->getCharacters();
            foreach ($relatedCharacters as $relatedCharacter) {
                if (!isset($relations[$character->ID])) {
                    $relations[$character->ID] = [];
                }
                $relations[$character->ID][$relatedCharacter->ID] = $relatedCharacter;
                $weight[$character->ID]++;
            }
        }

        foreach ($places as $place) {
            $nodes[$place->ID] = $place;

            if(!isset($weight[$place->ID])) {
                $weight[$place->ID] = 0;
            }

            $relatedCharacters = $place->getCharacters();

            foreach ($relatedCharacters as $relatedCharacter) {

                $place->addRelation($relatedCharacter->ID, $relatedCharacter->post_type);


                if (!isset($relations[$relatedCharacter->ID])) {
                    $relations[$relatedCharacter->ID] = [];
                }
                $relations[$relatedCharacter->ID][$place->ID] = $place;

                $weight[$place->ID]++;
            }
        }

        $buffer = $this->renderTemplate('layouts.mind-map', [
            'nodes' => $nodes,
            'relations' => $relations,
            'weight' => $weight,
        ]);
        return $buffer;

    }
}

