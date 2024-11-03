<?php
namespace Deljdlx\WPTaverne\Controllers;

use Deljdlx\WPTaverne\Models\Scenario;
use Deljdlx\WPTaverne\Models\ScenarioEvent;

class Timeline extends Base
{
    public function index()
    {
        $request = $this->getRequest();
        $events = ScenarioEvent::getAll();
        $pageTitle = 'Evénements';


        $filtered = [];

        if($request->input('scenario')) {
            $selectedScenario = Scenario::find($request->input('scenario'));

            if($selectedScenario) {
                $pageTitle = 'Evénements liés au scénario "' . $selectedScenario->post_title;
                foreach($events as $event) {
                    $scenarios = $event->getScenarios();
                    foreach($scenarios as $scenario) {
                        if($scenario->ID == $request->input('scenario')) {
                            $filtered[] = $event;
                        }
                    }
                }
                $events = $filtered;
            }
        }

        $sorted = [];

        foreach ($events as $event) {

            $fields = $event->getFields();
            $date = $fields['date'];

            if(!isset($events[$date])) {
                $events[$date] = [];
            }

            $sorted[$date][] = [
                'title' => $event->post_title,
                'content' => $event->post_content,
                'order' => $fields['order'] ?? 0,
            ];
        }

        // sort events by order
        foreach ($sorted as $date => $event) {
            usort($sorted[$date], function($a, $b) {
                return $a['order'] - $b['order'];
            });
        }

        krsort($sorted);

        return $this->view->render('layouts.timeline', [
            'sortedEvents' => $sorted,
            'pageTitle' => $pageTitle,
        ]);
        return $buffer;

    }
}
