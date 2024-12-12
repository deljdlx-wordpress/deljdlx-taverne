@php
use Deljdlx\WPTaverne\Models\Character;
use Deljdlx\WPTaverne\Models\Place;
use Deljdlx\WPForge\Models\Post;





@endphp


@extends('layouts/common/with-right-column')
@section('page-title')
    Mon bureau
@endsection

@section('page-content')

    <section>
        <a class="btn btn-neutral" href="{{home_url('/my-desktop/character-edit')}}">Créer un nouveau personnage</a>

        {{-- <a class="btn btn-neutral" href="{{ home_url() }}/my-desktop/calendar">Calendrier</a> --}}
        {{-- <a class="btn btn-neutral" href="{{home_url('/my-desktop/place-edit')}}">Créer un nouveau lieu</a> --}}
        {{-- <a class="btn btn-neutral" href="{{ get_home_url() }}/my-desktop/skills-editor">Créer un nouveau arbre de compétences</a> --}}
    </section>

    {{-- <section>
        <h1>Arbres de compétences</h1>

        <div class="list skilltrees-list">

            @foreach($skilltrees as $skilltree)
                <div class="card card-skilltree">
                    <a href="{{ get_home_url() }}/my-desktop/skills-editor?id={{ $skilltree->getId() }}">
                        <span class="content">
                            {{$skilltree->getTitle()}}
                        </span>
                    </a>
                </div>
            @endforeach

        </div>
    </section> --}}


    <section>
        <h1>Mes Personnages</h1>
        <div class="list characters-list grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
            @foreach($characters as $character)

                @php
                if($character->getAuthor()->getId() != @get_current_user_id() && !current_user_can('administrator')) {
                    continue;
                }
                @endphp


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
                            {{$character->getField('name')}}
                        </span>
                    </a>
                </div>
            @endforeach
        </div>
    </section>

    {{-- <section>
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
    </section> --}}

@endsection
