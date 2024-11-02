<?php

namespace Deljdlx\WPTaverne\Plugins;

use Deljdlx\WPForge\Plugin;
use Gemini;
use WP_REST_Request;

class Api extends Plugin
{
    /**
     * @var string
     */
    protected $baseURI;

    protected $apiRoot = 'taverne/v1';

    public function __construct()
    {
        // init hooks
        add_action('rest_api_init', [$this, 'registerRoutes']);
    }


    public function registerRoutes()
    {
        register_rest_route(
            $this->apiRoot,
            '/info',
            [
                'permission_callback' => '__return_true',
                'methods' => ['GET',],
                'callback' => function() {
                    return [
                        'test' => 'ok',
                    ];
                }
            ]
        );

        register_rest_route(
            $this->apiRoot,
            '/event',
            [
                'permission_callback' => '__return_true',
                'methods' => ['POST', 'GET',],
                'callback' => function($request) {
                    if ($request->get_method() === 'POST') {
                        return $this->saveEvent($request);
                    }
                    return [
                        'test' => 'ok',
                    ];
                }
            ],
        );

        register_rest_route(
            $this->apiRoot,
            '/events',
            [
                'permission_callback' => '__return_true',
                'methods' => ['GET',],
                'callback' => function($request) {

                    return [
                        'events' => $this->getEvents(),
                    ];
                }
            ],
        );

        register_rest_route(
            $this->apiRoot,
            '/scenarios',
            [
                'permission_callback' => '__return_true',
                'methods' => ['GET',],
                'callback' => function($request) {
                    $args = [
                        'post_type' => 'jdlx_tav_scenario',
                        'posts_per_page' => -1,
                    ];
                    $query = new \WP_Query($args);
                    $scenarios = [];
                    foreach ($query->posts as $post) {
                        $scenarios[] = [
                            'id' => $post->ID,
                            'title' => $post->post_title,
                        ];
                    }

                    return [
                        'scenarios' => $scenarios,
                    ];

                }
            ],
        );

        register_rest_route(
            $this->apiRoot,
            '/events/set-order',
            [
                'permission_callback' => '__return_true',
                'methods' => ['POST',],
                'callback' => function(WP_REST_Request $request) {
                    $eventIds = $request->get_param('eventIds');
                    foreach ($eventIds as $index => $eventId) {
                        update_field('order', $index, $eventId);
                    }

                    return [
                        'events' => $this->getEvents(),
                    ];
                }
            ],
        );


        register_rest_route(
            $this->apiRoot,
            '/character/generate-all',
            [
                'permission_callback' => '__return_true',
                'methods' => ['POST','GET'],
                'callback' => function(WP_REST_Request $request) {


                    // $response = json_decode(file_get_contents(__DIR__ . '/mock.json'), true);
                    // $characterData = json_decode($response['response'], true);
                    // $response['characterData'] = $characterData;
                    // return $response;

                    // prepare a post request to http://51.159.55.26:9501/character/create-all

                    $key = $request->get_param('key');

                    if(!$key) {
                        $key = uniqid();
                    }

                    $data = [
                        'key' => $key,
                        'job' => $request->get_param('job'),
                    ];

                    // post query with curl to 'http://51.159.55.26:9501/character/create-all'
                    $curl = curl_init('http://51.159.55.26:9501/character/create-all');
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($curl, CURLOPT_POST, true);
                    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
                    curl_setopt($curl, CURLOPT_HTTPHEADER, [
                        'Content-Type: application/json',
                    ]);

                    $response = curl_exec($curl);
                    curl_close($curl);

                    $response =  json_decode($response, true);

                    $characterData = json_decode($response['response'], true);
                    $response['characterData'] = $characterData;

                    return $response;

                }
            ],
        );


        register_rest_route(
            $this->apiRoot,
            '/character/generate-description',
            [
                'permission_callback' => '__return_true',
                'methods' => ['POST','GET'],
                'callback' => function(WP_REST_Request $request) {

                    $key = $request->get_param('key');
                    $job = $request->get_param('job');
                    $name = $request->get_param('name');

                    if(!$key) {
                        $key = uniqid();
                    }

                    $data = [
                        'key' => $key,
                        'job' => $job,
                        'name' => $name,
                    ];

                    $response =  $this->sendToAiBot($data);

                    $response['description'] = $response['response'];

                    return $response;

                }
            ],
        );

        register_rest_route(
            $this->apiRoot,
            '/character/generate-background',
            [
                'permission_callback' => '__return_true',
                'methods' => ['POST','GET'],
                'callback' => function(WP_REST_Request $request) {

                    $key = $request->get_param('key');
                    $job = $request->get_param('job');
                    $name = $request->get_param('name');
                    $description = $request->get_param('description');
                    $communication = $request->get_param('communication');

                    if(!$key) {
                        $key = uniqid();
                    }

                    $data = [
                        'key' => $key,
                        'job' => $job,
                        'name' => $name,
                        'description' => $description,
                        'communication' => $communication,
                    ];

                    $response =  $this->sendToAiBot($data);

                    $response['background'] = $response['response'];

                    return $response;

                }
            ],
        );

        register_rest_route(
            $this->apiRoot,
            '/character/generate-variable',
            [
                'permission_callback' => '__return_true',
                'methods' => ['POST','GET'],
                'callback' => function(WP_REST_Request $request) {

                    // return json_decode(
                    //     file_get_contents(__DIR__ . '/mock2.json'),
                    // );

                    $key = $request->get_param('key');
                    $job = $request->get_param('job');
                    $name = $request->get_param('name');
                    $description = $request->get_param('description');
                    $communication = $request->get_param('communication');
                    $mbti = $request->get_param('mbti');
                    $birth = $request->get_param('birth');
                    $custom_prompt = $request->get_param('custom_prompt');

                    $context = "
                        Le cadre de la discussion est la création d'un personnage fictif vivant dans les année 1920.
                        Ce personnage servira dans le cadre d'un jeu de rôle.
                    ";


                    $variable = $request->get_param('variable');

                    if(!$key) {
                        $key = uniqid();
                    }

                    $data = [
                        '__context' => $context,
                        'variable' => $variable,
                        'key' => $key,
                        'custom_prompt' => $custom_prompt,
                        'job' => $job,
                        'name' => $name,
                        'description' => $description,
                        'communication' => $communication,
                        'mbti' => $mbti,
                        'birth' => $birth,
                    ];

                    $response =  $this->sendToAiBot($data);

                    $response[$variable] = $response['response'];

                    return $response;

                }
            ],
        );


    }

    // ===========================================================

    public function getEvents() {
        $args = [
            'post_type' => 'jdlx_tav_event',
            'posts_per_page' => -1,
        ];
        $query = new \WP_Query($args);
        $events = [];

        // header('Content-Type: text/html');
        foreach ($query->posts as $post) {

            $date = get_field('date', $post->ID);
            $order = get_field('order', $post->ID);
            $scenarios = get_field('scenario', $post->ID);

            // dump($scenarios);

            if(!isset($events[$date])) {
                $events[$date] = [];
            }


            $content = apply_filters('the_content', $post->post_content);

            $events[$date][] = [
                'id' => $post->ID,
                'title' => $post->post_title,
                'content' => $content,
                'date' => $date,
                'scenario' => $scenarios ? $scenarios[0] : null,
                'order' => (int) $order,
            ];
        }

        // sort by order
        foreach ($events as $date => $eventList) {
            usort($eventList, function($a, $b) {
                return $a['order'] - $b['order'];
            });
            $events[$date] = $eventList;
        }

        krsort($events);

        return $events;
    }


    public function saveEvent($request) {
        $title = $request->get_param('title');
        $content = $request->get_param('content');
        $date = $request->get_param('date');
        $scenarioId = $request->get_param('scenario');
        $eventId = $request->get_param('id');

        if($eventId) {
            $post_id = wp_update_post([
                'ID' => $eventId,
                'post_title' => $title,
                'post_content' => $content,
                'post_status' => 'publish',
                'post_type' => 'jdlx_tav_event',
            ]);

            update_field('date', $date, $post_id);
            update_field('scenario', [$scenarioId], $post_id);

            return [
                'request' => $request->get_params(),
                'post' => get_post($post_id),
            ];
        }

        $post_id = wp_insert_post([
            'post_title' => $title,
            'post_content' => $content,
            'post_status' => 'publish',
            'post_type' => 'jdlx_tav_event',
        ]);

        update_field('date', $date, $post_id);
        update_field('scenario', [$scenarioId], $post_id);

        // return [
        //     'request' => $request->get_params(),
        // ];

        return [
            'request' => $request->get_params(),
            'post' => get_post($post_id),
        ];
    }

    private function sendToAiBot($data){
        // post query with curl to 'http://51.159.55.26:9501/character/create-all'
        $curl = curl_init('http://51.159.55.26:9501/character/generate-variable');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        $response =  json_decode($response, true);
        return $response;
    }
}
