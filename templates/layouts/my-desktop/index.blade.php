@php
use Deljdlx\WPTaverne\Models\Character;
use Deljdlx\WPTaverne\Models\Place;
use Deljdlx\WPForge\Models\Post;





// load all posts of type 'character'

if(!isset($authorId)) {
    $authorId = null;
}

$characters = [];
$places = [];

$types = [
    'characters' => [
        'type' => 'tav_character',
        'instance' => Character::class,
    ],
    'places' => [
        'type' => 'tav_place',
        'instance' => Place::class,
    ],
];

foreach($types as $index => $type) {
    $options = [
        'post_type' => $type,
        'numberposts' => -1,
        'orderby' => 'title',
        'order' => 'ASC',
        'author' => $authorId,
        'post_status' => 'any',
    ];
    // if user is admin, get all posts
    if(current_user_can('administrator')) {
        unset($options['author']);
    }

    $className = $type['instance'];

    $$index = $className::getByOptions($options);
}


// foreach($places as $place) {
//     dump($place->getTitle());
// }

foreach($characters as $character) {
    // dump($character);
}

foreach($characters as $character) {
    // dump($character);

    // $test = $character->find(210);

    // dump($test);
    // dump($test->ID);

    // dump($character->getTitle());
    // dump($character->ID);
    // echo '<hr/>';
}

@endphp


@extends('layouts/common/with-right-column')
@section('page-title')
    Mon bureau
@endsection

@section('page-content')

    <section>
        <a class="btn btn-neutral" href="{{ home_url() }}/my-dektop/calendar">Calendrier</a>
        <a class="btn btn-neutral" href="{{home_url('/my-desktop/character-edit')}}">Créer un nouveau personnage</a>
        <a class="btn btn-neutral" href="{{home_url('/my-desktop/place-edit')}}">Créer un nouveau lieu</a>
    </section>


    <section>
        <h1>Mes Personnages</h1>
        <div class="list characters-list">
            @foreach($characters as $character)

                {{-- @dump($character) --}}

                <div class="card card-character">
                    @php
                        $canEdit = current_user_can('administrator') || $character->getAuthor()->getId() == get_current_user_id();
                        if($canEdit) {
                            echo '<a class="edit-button" href="'.home_url('/my-desktop/character-edit?id='.$character->getId()).'"><i class="fas fa-pencil-alt"></i></a>';
                        }
                    @endphp
                    <a href="{{$character->getPermalink()}}">
                        @if($character->getField('illustration'))
                            <div class="illustration" style="background-image: url({{$character->getField('illustration')['url']}})"></div>
                        @else
                            <div class="illustration" style="background-image: url({{get_theme_file_uri('assets/images/portrait-default.jpg')}})"></div>
                        @endif
                        <span class="content">
                            {{$character->getTitle()}}
                        </span>
                    </a>
                </div>
            @endforeach
        </div>
    </section>

    <section>
        <h1>Mes lieux</h1>
        <div class="list places-list">
            @foreach($places as $place)
                <div class="card card-place">
                    @php
                        $canEdit = current_user_can('administrator') || $place->getAuthor()->getId() == get_current_user_id();
                        if($canEdit) {
                            echo '<a class="edit-button" href="'.home_url('/my-desktop/place-edit?id='.$place->getId()).'"><i class="fas fa-pencil-alt"></i></a>';
                        }
                    @endphp

                    <a href="{{$place->getPermalink()}}">
                        @if($place->getField('illustration'))
                            <div class="illustration" style="background-image: url({{$place->getField('illustration')['url']}})"></div>
                        @else
                            <div class="illustration" style="background-image: url({{get_theme_file_uri('assets/images/place-default.webp')}})"></div>
                        @endif
                        <span class="content">
                            {{$place->getTitle()}}
                        </span>
                    </a>
                </div>
            @endforeach
        </div>


    </section>


    <section>
        <h1>Mes notes</h1>
    </section>

@endsection
