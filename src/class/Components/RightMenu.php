<?php
namespace Deljdlx\WPTaverne\Components;

use Deljdlx\WPTaverne\Models\Character;
use Deljdlx\WPTaverne\Models\Organization;
use Deljdlx\WPTaverne\Models\Place;
use Deljdlx\WPTaverne\Models\Scenario;
use Illuminate\View\Component;

class RightMenu extends Component
{

    public function __construct()
    {
    }

    public function render()
    {


        $characters = Character::getAll();
        $npcCharacters = [];
        $playerCharacters = [];


        foreach($characters as $character) {

            if($character->getField('is_npc')) {
                $npcCharacters[] = $character;
            }
            else {
                $playerCharacters[] = $character;
            }
        }

        $places = Place::getAll();
        $organizations = Organization::getAll();


        // $scenarios = get_posts([
        //     'post_type' => 'jdlx_tav_scenario',
        //     'numberposts' => -1,
        //     'post_status' => 'publish',
        //     'orderby' => 'date',
        //     'order' => 'DESC',
        // ]);

        $scenarios = Scenario::getAll();


        return view('components.right-menu', [
            'organizations' => $organizations,
            'places' => $places,
            'npcCharacters' => $npcCharacters,
            'playerCharacters' => $playerCharacters,
            'scenarios' => $scenarios,
        ]);
    }
}