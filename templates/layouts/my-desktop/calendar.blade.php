@php

// load all posts of type jdlx_tav_event
$posts = get_posts([
    'post_type' => 'jdlx_tav_event',
    'numberposts' => -1,
    'post_status' => 'publish',
    'orderby' => 'date',
    'order' => 'ASC',
]);

$events = [];
foreach ($posts as $post) {
    $fields = get_fields($post->ID);

    // dump($fields);
    $date = $fields['date'];

    if(!isset($events[$date])) {
        $events[$date] = [];
    }

    $events[$date][] = [
        'title' => $post->post_title,
        'content' => $post->post_content,
    ];
}

krsort($events);


$scenarios = get_posts([
    'post_type' => 'jdlx_tav_scenario',
    'numberposts' => -1,
    'post_status' => 'publish',
    'orderby' => 'date',
    'order' => 'DESC',
]);

@endphp

@extends('layouts/common/default')
@section('page-title')
    Mon bureau
@endsection

@section('page-content')

@php
// if user connected

$canEdit = is_user_logged_in();

if ($canEdit) {
    echo '<input id="can-edit" type="hidden" value="1"/>';
}
else {
    echo '<input id="can-edit" type="hidden" value="0"/>';
}

@endphp


    <dialog id="modal_form" class="modal" style="">
        <div class="modal-box">

            <form method="dialog" class="">
                <button class="btn btn-sm btn-circle absolute right-2 top-2">✕</button>
            </form>

            <div id="modal_main__content">

                <h1 class="title"></h1>

                <div role="tablist" class="tabs tabs tabs-boxed">
                    <input type="radio" name="my_tabs_2" role="tab" class="tab" aria-label="Evénements" checked="checked" />
                    <div role="tabpanel" class="tab-content border-base-300 rounded-box">
                        <ul class="events-list"></ul>
                    </div>
            


                    @if($canEdit)

                        <input type="radio" name="my_tabs_2" role="tab" class="tab" aria-label="Nouveau"/>
                        <div role="tabpanel" class="tab-content border-base-300 rounded-box">
                            <form id="form-event" method="POST">
                                <input id="event-id" type="hidden"/>
                                <input id="event-title" type="text" placeholder="Titre de l'événement" class="input input-bordered input-primary w-full max-w-xs" />
                                <input id="event-date" type="date" class="input input-bordered input-primary w-full max-w-xs" />


                                <select id="event-scenario" class="select select-bordered w-full max-w-xs">
                                    <option disabled selected value="0">Scénarios</option>
                                    <option value="0">Aucun</option>
                                    @php
                                        foreach ($scenarios as $scenario) {
                                            echo '<option value="'.$scenario->ID.'">'.$scenario->post_title.'</option>';
                                        }
                                    @endphp
                                </select>

                                @php
                                    $content = '';
                                    $editor_id = 'event-content';
                                    $settings = [
                                        'textarea_name' => 'event-content',
                                        'textarea_rows' => 10,
                                    ];
                                    wp_editor($content, $editor_id, $settings);
                                @endphp
                                <button class="btn btn-accent">Enregistrer</button>
                            </form>
                        </div>

                    @endif
                </div>
            </div>
        </div>
    </dialog>

    <section>
        <h1>Calendrier</h1>

        <div id="calendar"></div>
    </section>

@endsection
